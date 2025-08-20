<?php

namespace App\Http\Livewire\Pages\DocumentTracking;

use App\Models\Division;
use App\Models\Document;
use App\Models\DocumentType;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public $selectedDivision = '';
    public $selectedDocument;
    public $selectedDocumentLogs;

    public function getDivisionInitials($name)
    {
        if ($name === 'N/A') {
            return 'N/A';
        }
        preg_match_all('/[A-Z]/', $name, $matches);
        return implode('', $matches[0]);
    }

    public function viewDocument($documentId)
    {
        $this->selectedDocument = Document::with(['document_type', 'document_sub_type', 'division'])->find($documentId);
        $this->selectedDocumentLogs = \App\Models\DocumentLog::with(['fromDivision', 'toDivision', 'userCreated', 'userReceived'])->where('document_id', $documentId)->whereNotNull('action_id')->get();
        $this->dispatchBrowserEvent('show-view-document-modal');
    }

    public function render()
    {
        $divisions = Division::all();
        $query = Document::query();

        $totalDocuments = (clone $query)->count();
        $documentsInCirculation = (clone $query)->whereHas('latestLog', function ($q) {
            $q->whereNotIn('action_id', [2, 3]);
        })->count();
        $completedDocuments = (clone $query)->whereHas('latestLog', function ($q) {
            $q->where('action_id', 3);
        })->count();
        $overdueDocuments = (clone $query)->where('expected_completion_date', '<', now())->whereHas('latestLog', function ($q) {
            $q->whereNotIn('action_id', [2, 3]);
        })->count();
        $pendingDocuments = (clone $query)->whereHas('latestActiveLog', function ($q) {
            $q->whereNull('action_id');
        })->count();
        $discardedDocuments = (clone $query)->whereHas('latestLog', function ($q) {
            $q->where('action_id', 2);
        })->count();

        $documentsInCirculationPercentage = $totalDocuments > 0 ? round(($documentsInCirculation / $totalDocuments) * 100, 2) : 0;
        $completedDocumentsPercentage = $totalDocuments > 0 ? round(($completedDocuments / $totalDocuments) * 100, 2) : 0;
        $overdueDocumentsPercentage = $totalDocuments > 0 ? round(($overdueDocuments / $totalDocuments) * 100, 2) : 0;
        $pendingDocumentsPercentage = $totalDocuments > 0 ? round(($pendingDocuments / $totalDocuments) * 100, 2) : 0;
        $discardedDocumentsPercentage = $totalDocuments > 0 ? round(($discardedDocuments / $totalDocuments) * 100, 2) : 0;

        $documentsByType = (clone $query)->join('document_types', 'documents.document_type_id', '=', 'document_types.id')
            ->select('document_types.document_type_name', DB::raw('count(case when extremely_urgent_id is null then 1 end) as normal'), DB::raw('count(case when extremely_urgent_id = 1 then 1 end) as urgent'))
            ->groupBy('document_types.document_type_name')
            ->get();

        $documentVolumeByDay = (clone $query)->where('created_at', '>=', now()->subDays(30))
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as day'), DB::raw('count(case when extremely_urgent_id is null then 1 end) as normal'), DB::raw('count(case when extremely_urgent_id = 1 then 1 end) as urgent'))
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $documentsByDivision = (clone $query)->join('divisions', 'documents.division_id', '=', 'divisions.id')
            ->select('divisions.division_name', DB::raw('count(*) as total'))
            ->groupBy('divisions.division_name')
            ->pluck('total', 'division_name');

        $overdueDocumentsByDivision = (clone $query)->where('expected_completion_date', '<', now())
            ->whereHas('latestLog', function ($q) {
                $q->whereNotIn('action_id', [2, 3]);
            })
            ->join('divisions', 'documents.division_id', '=', 'divisions.id')
            ->select('divisions.division_name', DB::raw('count(*) as total'))
            ->groupBy('divisions.division_name')
            ->pluck('total', 'division_name');

        $recentActivity = (clone $query)->with(['latestLog', 'division'])->latest('updated_at')->take(10)->get();

        return view('livewire.pages.document-tracking.dashboard', [
            'divisions' => $divisions,
            'totalDocuments' => $totalDocuments,
            'documentsInCirculation' => $documentsInCirculation,
            'completedDocuments' => $completedDocuments,
            'overdueDocuments' => $overdueDocuments,
            'pendingDocuments' => $pendingDocuments,
            'discardedDocuments' => $discardedDocuments,
            'documentsInCirculationPercentage' => $documentsInCirculationPercentage,
            'completedDocumentsPercentage' => $completedDocumentsPercentage,
            'overdueDocumentsPercentage' => $overdueDocumentsPercentage,
            'pendingDocumentsPercentage' => $pendingDocumentsPercentage,
            'discardedDocumentsPercentage' => $discardedDocumentsPercentage,
            'documentsByType' => $documentsByType,
            'documentVolumeByDay' => $documentVolumeByDay,
            'documentsByDivision' => $documentsByDivision,
            'overdueDocumentsByDivision' => $overdueDocumentsByDivision,
            'recentActivity' => $recentActivity,
        ]);
    }
}
