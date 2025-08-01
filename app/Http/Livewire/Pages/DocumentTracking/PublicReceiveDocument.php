<?php

namespace App\Http\Livewire\Pages\DocumentTracking;

use App\Models\Document;
use App\Models\DocumentLog;
use App\Models\Action;
use App\Models\Division;
use App\Models\User;
use Livewire\Component;

class PublicReceiveDocument extends Component
{
    public Document $document;
    public $id_number;
    public $employee_number;

    public $selectedAction;
    public $to_division_id;
    public $remarks;

    public function receive()
    {
        $this->validate([
            'id_number' => 'required|string',
        ]);

        $user = User::where('employee_id_no', $this->id_number)->first();
        $activeLog = $this->document->latestActiveLog;

        if ($user && $activeLog && $activeLog->to_division_id == $user->division_id) {
            $activeLog->update([
                'received_date' => now(),
                'status_type_id' => 2, // Inactive
                'received_by' => $user->id,
            ]);

            DocumentLog::create([
                'document_id' => $this->document->id,
                'status_type_id' => 1, // Active
                'action_id' => null,
                'from_division_id' => $user->division_id,
                'to_division_id' => null,
                'remarks' => null,
                'created_by' => $user->id,
                'received_date' => null,
            ]);

            $this->dispatchBrowserEvent('success-message', ['message' => 'Document successfully received.']);
        } else {
            $this->dispatchBrowserEvent('error-message', ['message' => 'Invalid ID number or you are not authorized to receive this document.']);
        }
    }

    public function takeAction()
    {
        $this->validate([
            'employee_number' => 'required|string',
            'selectedAction' => 'required',
            'to_division_id' => 'required_if:selectedAction,1',
            'remarks' => 'required|string',
        ]);

        $user = User::where('employee_id_no', $this->employee_number)->first();
        $activeLog = $this->document->latestActiveLog;

        if ($user && $activeLog && $activeLog->from_division_id == $user->division_id) {
            $updateData = [
                'action_id' => $this->selectedAction,
                'to_division_id' => $this->to_division_id,
                'remarks' => $this->remarks,
                'created_by' => $user->id,
            ];

            if ($this->selectedAction == 1) { // Forward
                $updateData['forwarded_date'] = now();
                $updateData['forwarded_by'] = $user->id;
            } else { // Mark as inactive for terminal actions
                $updateData['status_type_id'] = 2;
            }

            $activeLog->update($updateData);

            $this->dispatchBrowserEvent('success-message', ['message' => 'Action successfully recorded.']);
        } else {
            $this->dispatchBrowserEvent('error-message', ['message' => 'Invalid Employee Number. You are not authorized to take action from this division.']);
        }
    }

    public function render()
    {
        // The validation in takeAction() prevents forwarding to one's own division.
        // For the public form, we will show all divisions and let the backend handle validation.
        $formDivisions = Division::all();

        return view('livewire.pages.document-tracking.public-receive-document', [
            'actions' => Action::all(),
            'formDivisions' => $formDivisions,
        ]);
    }
}
