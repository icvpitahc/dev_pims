<?php

namespace App\Http\Livewire\Pages\DocumentTracking;

use App\Models\Action;
use App\Models\Division;
use App\Models\Document;
use App\Models\DocumentLog;
use App\Models\DocumentSubType;
use App\Models\DocumentType;
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

    public $selectedDocument;
    public $selectedDocumentLogs;
    public $selectedAction;
    public $edit_to_division_id;
    public $edit_remarks;

    public $search = '';
    public $filterStatus = '';
    public $filterOrigin = '';
    public $filterDocumentType = '';

    public $totalDocumentsCreated = 0;
    public $pendingDocuments = 0;
    public $ongoingDocuments = 0;
    public $completedDocuments = 0;
    public $discardedDocuments = 0;

    public $ongoingPercentage = 0;
    public $completedPercentage = 0;
    public $discardedPercentage = 0;

    public $documentSubTypes = [];

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
    }

    private function getDivisionInitials($name)
    {
        $words = explode(' ', $name);
        $initials = '';
        foreach ($words as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }
        return $initials;
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
        ]);

        DocumentLog::create([
            'document_id' => $document->id,
            'status_type_id' => 1, // Active
            'action_id' => 1, // Forward
            'from_division_id' => $user->division_id,
            'to_division_id' => $this->to_division_id,
            'remarks' => $this->remarks,
            'created_by' => $user->id,
        ]);

        $this->resetInputFields();

        $this->dispatchBrowserEvent('success-message', ['message' => 'Document successfully created.']);
    }

    public function editDocument($documentId)
    {
        $this->selectedDocument = Document::with(['document_type', 'document_sub_type', 'division'])->find($documentId);
        $this->selectedDocumentLogs = DocumentLog::with(['fromDivision', 'toDivision', 'userCreated'])->where('document_id', $documentId)->get();
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
        $oldLog = $this->selectedDocument->latestActiveLog;

        DocumentLog::create([
            'document_id' => $this->selectedDocument->id,
            'status_type_id' => 1, // Active
            'action_id' => $this->selectedAction,
            'from_division_id' => $user->division_id,
            'to_division_id' => $this->edit_to_division_id,
            'remarks' => $this->edit_remarks,
            'created_by' => $user->id,
        ]);

        if ($oldLog) {
            $oldLog->update(['status_type_id' => 2]); // Inactive
        }

        $this->dispatchBrowserEvent('success-message', ['message' => 'Document successfully updated.']);
    }

    public function viewDocument($documentId)
    {
        $this->selectedDocument = Document::with(['document_type', 'document_sub_type', 'division'])->find($documentId);
        $this->selectedDocumentLogs = DocumentLog::with(['fromDivision', 'toDivision', 'userCreated'])->where('document_id', $documentId)->get();
        $this->dispatchBrowserEvent('show-view-document-modal');
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

        $this->totalDocumentsCreated = Document::where('division_id', $user->division_id)->count();
        $this->pendingDocuments = Document::whereHas('latestActiveLog', fn($q) => $q->where('to_division_id', $user->division_id))->count();
        $this->ongoingDocuments = Document::where('division_id', $user->division_id)->whereDoesntHave('latestLog', fn($q) => $q->whereIn('action_id', [2, 3]))->count();
        $this->completedDocuments = Document::where('division_id', $user->division_id)->whereHas('latestLog', fn($q) => $q->where('action_id', 3))->count();
        $this->discardedDocuments = Document::where('division_id', $user->division_id)->whereHas('latestLog', fn($q) => $q->where('action_id', 2))->count();

        if ($this->totalDocumentsCreated > 0) {
            $this->ongoingPercentage = round(($this->ongoingDocuments / $this->totalDocumentsCreated) * 100, 2);
            $this->completedPercentage = round(($this->completedDocuments / $this->totalDocumentsCreated) * 100, 2);
            $this->discardedPercentage = round(($this->discardedDocuments / $this->totalDocumentsCreated) * 100, 2);
        } else {
            $this->ongoingPercentage = 0;
            $this->completedPercentage = 0;
            $this->discardedPercentage = 0;
        }

        $documentTypes = DocumentType::all();
        $documents = Document::with(['document_type', 'division', 'latestLog', 'latestActiveLog.toDivision'])
            ->where(function ($query) use ($user) {
                $query->where('created_by', $user->id)
                    ->orWhere('division_id', $user->division_id)
                    ->orWhereHas('latestActiveLog', function ($q) use ($user) {
                        $q->where('to_division_id', $user->division_id);
                    });
            })
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
                    $query->where('created_by', $user->id)
                          ->whereDoesntHave('latestLog', fn($q) => $q->whereIn('action_id', [2, 3]));
                }
            })
            ->when($this->filterOrigin, fn($q) => $q->where('division_id', $this->filterOrigin))
            ->when($this->filterDocumentType, fn($q) => $q->where('document_type_id', $this->filterDocumentType))
            ->latest()
            ->paginate(10);
        $divisions = Division::all();
        $actions = Action::all();

        return view('livewire.pages.document-tracking.list-documents', [
            'documentTypes' => $documentTypes,
            'documents' => $documents,
            'divisions' => $divisions,
            'actions' => $actions,
        ]);
    }
}
