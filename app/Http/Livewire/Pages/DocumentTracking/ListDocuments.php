<?php

namespace App\Http\Livewire\Pages\DocumentTracking;

use App\Models\Action;
use App\Models\Division;
use App\Models\Document;
use App\Models\DocumentLog;
use App\Models\DocumentSubType;
use App\Models\DocumentType;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class ListDocuments extends Component
{
    use WithPagination;
    public $document_type_id = '';
    public $document_sub_type_id = '';
    public $document_title = '';
    public $specify_attachments = '';
    public $note = '';
    public $to_division_id = '';
    public $remarks = '';
    public $extremely_urgent;
    public $expected_completion_date;

    public $selectedDocument;
    public $selectedDocumentLogs;
    public $selectedAction;
    public $edit_to_division_id;
    public $edit_remarks;

    public $search = '';
    public $filterStatus = '';
    public $filterOrigin = '';
    public $filterDocumentType = '';

    public $totalDocumentsInvolved = 0;
    public $totalDocumentsCreated = 0;
    public $pendingDocuments = 0;
    public $ongoingDocuments = 0;
    public $completedDocuments = 0;
    public $discardedDocuments = 0;

    public $ongoingPercentage = 0;
    public $completedPercentage = 0;
    public $discardedPercentage = 0;

    public $documentSubTypes = [];
    public $documentIdToDelete;
    public $password;

    private function resetInputFields()
    {
        $this->document_type_id = '';
        $this->document_sub_type_id = '';
        $this->document_title = '';
        $this->specify_attachments = '';
        $this->note = '';
        $this->to_division_id = '';
        $this->remarks = '';
        $this->documentSubTypes = [];
        $this->extremely_urgent = false;
        $this->expected_completion_date = '';
    }

    public function getDivisionInitials($name)
    {
        if ($name === 'N/A') {
            return 'N/A';
        }
        preg_match_all('/[A-Z]/', $name, $matches);
        return implode('', $matches[0]);
    }

    public function store()
    {
        $this->validate([
            'document_type_id' => 'required',
            'document_sub_type_id' => 'required',
            'document_title' => 'required|string|max:255',
            'specify_attachments' => 'nullable|string',
            'note' => 'nullable|string',
            'to_division_id' => 'required',
            'remarks' => 'required|string',
            'expected_completion_date' => 'nullable|date|after_or_equal:today',
        ]);

        $user = auth()->user();
        $year = now()->year;
        $divisionInitials = $this->getDivisionInitials($user->division->division_name);

        $sequence = Document::whereYear('created_at', $year)
                            ->where('division_id', $user->division_id)
                            ->count() + 1;

        $paddedSequence = str_pad($sequence, 3, '0', STR_PAD_LEFT);

        $documentReferenceCode = "{$year}-{$divisionInitials}-{$paddedSequence}";

        $document = Document::create([
            'document_reference_code' => $documentReferenceCode,
            'document_type_id' => $this->document_type_id,
            'document_sub_type_id' => $this->document_sub_type_id,
            'document_title' => $this->document_title,
            'specify_attachments' => $this->specify_attachments,
            'note' => $this->note,
            'division_id' => $user->division_id,
            'created_by' => $user->id,
            'extremely_urgent_id' => $this->extremely_urgent ? 1 : null,
            'expected_completion_date' => $this->expected_completion_date,
        ]);

        DocumentLog::create([
            'document_id' => $document->id,
            'status_type_id' => 1, // Active
            'action_id' => 1, // Forward
            'from_division_id' => $user->division_id,
            'to_division_id' => $this->to_division_id,
            'remarks' => $this->remarks,
            'created_by' => $user->id,
            'forwarded_date' => now(),
            'forwarded_by' => $user->id,
        ]);

        $this->resetInputFields();

        $this->dispatchBrowserEvent('success-message', ['message' => 'Document successfully created.']);
    }

    public function editDocument($documentId)
    {
        $this->selectedDocument = Document::with(['document_type', 'document_sub_type', 'division'])->find($documentId);
        $this->selectedDocumentLogs = DocumentLog::with(['fromDivision', 'toDivision', 'userCreated', 'userReceived'])->where('document_id', $documentId)->whereNotNull('action_id')->get();
        $this->dispatchBrowserEvent('show-edit-document-modal');
    }

    public function updateDocument()
    {
        $this->validate([
            'selectedAction' => 'required',
            'edit_to_division_id' => 'required_if:selectedAction,1',
            'edit_remarks' => 'required|string',
        ]);

        $user = auth()->user();
        $activeLog = $this->selectedDocument->latestActiveLog;

        if ($activeLog) {
            $updateData = [
                'action_id' => $this->selectedAction,
                'to_division_id' => $this->edit_to_division_id,
                'remarks' => $this->edit_remarks,
                'updated_by' => $user->id,
            ];

            if ($this->selectedAction == 1) { // Forward
                $updateData['forwarded_date'] = now();
                $updateData['forwarded_by'] = $user->id;
            }

            $activeLog->update($updateData);
        }

        $this->dispatchBrowserEvent('success-message', ['message' => 'Document successfully updated.']);
        $this->dispatchBrowserEvent('close-edit-modal');
    }

    public function receiveDocument()
    {
        $user = auth()->user();
        $activeLog = $this->selectedDocument->latestActiveLog;

        if ($activeLog && is_null($activeLog->received_date)) {
            $activeLog->update([
                'received_date' => now(),
                'status_type_id' => 2, // Inactive
                'received_by' => $user->id,
            ]);

            DocumentLog::create([
                'document_id' => $this->selectedDocument->id,
                'status_type_id' => 1, // Active
                'action_id' => null,
                'from_division_id' => $user->division_id,
                'to_division_id' => null,
                'remarks' => null,
                'created_by' => $user->id,
                'received_date' => null,
            ]);

        $this->dispatchBrowserEvent('success-message', ['message' => 'Document successfully received.']);
        $this->dispatchBrowserEvent('close-edit-modal');
        }
    }
    
    public function confirmDelete($documentId)
    {
        $this->documentIdToDelete = $documentId;
        $this->password = '';
        $this->dispatchBrowserEvent('show-delete-document-modal');
    }

    public function deleteDocument()
    {
        $this->validate([
            'password' => 'required',
        ]);

        if (Hash::check($this->password, auth()->user()->password)) {
            $document = Document::findOrFail($this->documentIdToDelete);
            $document->update(['deleted_by' => auth()->id()]);
            $document->delete();
            $this->dispatchBrowserEvent('success-message', ['message' => 'Document successfully deleted.']);
            $this->dispatchBrowserEvent('close-delete-document-modal');
        } else {
            $this->dispatchBrowserEvent('error-message', ['message' => 'Incorrect Password']);
        }
        $this->password = '';
    }

    public function updatedDocumentTypeId($value)
    {
        $this->documentSubTypes = DocumentSubType::where('document_type_id', $value)->get();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function updatingFilterOrigin()
    {
        $this->resetPage();
    }

    public function updatingFilterDocumentType()
    {
        $this->resetPage();
    }

    public function render()
    {
        $user = auth()->user();

        $baseDocumentQuery = Document::where(function ($query) use ($user) {
            $query->where('division_id', $user->division_id)
                ->orWhereHas('logs', function ($q) use ($user) {
                    $q->where('from_division_id', $user->division_id)
                      ->orWhere('to_division_id', $user->division_id);
                });
        });

        $this->totalDocumentsInvolved = (clone $baseDocumentQuery)->count();
        $this->totalDocumentsCreated = Document::where('division_id', $user->division_id)->count();
        $this->pendingDocuments = (clone $baseDocumentQuery)->whereHas('latestActiveLog', fn($q) => $q->where('to_division_id', $user->division_id))->count();
        $this->ongoingDocuments = (clone $baseDocumentQuery)->whereDoesntHave('latestLog', fn($q) => $q->whereIn('action_id', [2, 3]))->count();
        $this->completedDocuments = (clone $baseDocumentQuery)->whereHas('latestLog', fn($q) => $q->where('action_id', 3))->count();
        $this->discardedDocuments = (clone $baseDocumentQuery)->whereHas('latestLog', fn($q) => $q->where('action_id', 2))->count();
        
        $totalForPercentage = (clone $baseDocumentQuery)->count();
        if ($totalForPercentage > 0) {
            $this->ongoingPercentage = round(($this->ongoingDocuments / $totalForPercentage) * 100, 2);
            $this->completedPercentage = round(($this->completedDocuments / $totalForPercentage) * 100, 2);
            $this->discardedPercentage = round(($this->discardedDocuments / $totalForPercentage) * 100, 2);
        } else {
            $this->ongoingPercentage = 0;
            $this->completedPercentage = 0;
            $this->discardedPercentage = 0;
        }

        $documentTypes = DocumentType::all();
        $documents = (clone $baseDocumentQuery)->with(['document_type', 'division', 'latestLog', 'latestActiveLog.toDivision', 'logs.userReceived'])
            ->when($this->search, function ($query) {
                $query->where('document_reference_code', 'like', '%' . $this->search . '%')
                    ->orWhere('document_title', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterStatus, function ($query) use ($user) {
                if ($this->filterStatus == 'Completed') {
                    $query->whereHas('latestLog', fn($q) => $q->where('action_id', 3));
                } elseif ($this->filterStatus == 'Discarded') {
                    $query->whereHas('latestLog', fn($q) => $q->where('action_id', 2));
                } elseif ($this->filterStatus == 'Pending') {
                    $query->whereHas('latestActiveLog', fn($q) => $q->where('to_division_id', $user->division_id));
                } elseif ($this->filterStatus == 'Ongoing') {
                    $query->whereDoesntHave('latestLog', fn($q) => $q->whereIn('action_id', [2, 3]));
                }
            })
            ->when($this->filterOrigin, fn($q) => $q->where('division_id', $this->filterOrigin))
            ->when($this->filterDocumentType, fn($q) => $q->where('document_type_id', $this->filterDocumentType))
            ->latest()
            ->paginate(10);
        
        $formDivisions = Division::where('id', '!=', $user->division_id)->get();
        $filterDivisions = Division::all();
        $actions = Action::all();

        return view('livewire.pages.document-tracking.list-documents', [
            'documentTypes' => $documentTypes,
            'documents' => $documents,
            'formDivisions' => $formDivisions,
            'filterDivisions' => $filterDivisions,
            'actions' => $actions,
        ]);
        
    }
}
