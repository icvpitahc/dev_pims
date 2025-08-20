<?php

namespace App\Http\Livewire\Pages\IctRequest;

use App\Models\IctRequest;
use App\Models\RequestType;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $query = IctRequest::query();

        $totalRequests = (clone $query)->count();
        $pendingRequests = (clone $query)->where('request_status_type_id', 1)->count();
        $inProgressRequests = (clone $query)->where('request_status_type_id', 2)->count();
        $resolvedRequests = (clone $query)->where('request_status_type_id', 3)->count();
        $closedRequests = (clone $query)->where('request_status_type_id', 4)->count();
        $cancelledRequests = (clone $query)->where('request_status_type_id', 5)->count();

        $requestsByType = (clone $query)->join('sub_request_types', 'ict_requests.sub_request_type_id', '=', 'sub_request_types.id')
            ->select('sub_request_types.sub_request_type_name', DB::raw('count(case when request_status_type_id = 1 then 1 end) as pending'), DB::raw('count(case when request_status_type_id = 2 then 1 end) as in_progress'), DB::raw('count(case when request_status_type_id = 3 then 1 end) as resolved'), DB::raw('count(case when request_status_type_id = 4 then 1 end) as closed'), DB::raw('count(case when request_status_type_id = 5 then 1 end) as cancelled'))
            ->groupBy('sub_request_types.sub_request_type_name')
            ->get();

        $requestsByMonth = (clone $query)->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('count(case when request_type_id = 1 then 1 end) as hardware_software'), DB::raw('count(case when request_type_id = 2 then 1 end) as web_posting'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $requestsByStatus = IctRequest::join('request_status_types', 'ict_requests.request_status_type_id', '=', 'request_status_types.id')
            ->select('request_status_types.request_status_type_name', DB::raw('count(*) as total'))
            ->groupBy('request_status_types.request_status_type_name')
            ->pluck('total', 'request_status_type_name');

        $requestsByDivision = (clone $query)->join('users', 'ict_requests.created_by', '=', 'users.id')
            ->join('divisions', 'users.division_id', '=', 'divisions.id')
            ->select('divisions.division_name', DB::raw('count(*) as total'))
            ->groupBy('divisions.division_name')
            ->pluck('total', 'division_name');

        $recentActivity = (clone $query)->with('request_type')->latest('updated_at')->take(10)->get();

        return view('livewire.pages.ict-request.dashboard', [
            'totalRequests' => $totalRequests,
            'pendingRequests' => $pendingRequests,
            'inProgressRequests' => $inProgressRequests,
            'resolvedRequests' => $resolvedRequests,
            'closedRequests' => $closedRequests,
            'cancelledRequests' => $cancelledRequests,
            'requestsByType' => $requestsByType,
            'requestsByMonth' => $requestsByMonth,
            'requestsByStatus' => $requestsByStatus,
            'requestsByDivision' => $requestsByDivision,
            'recentActivity' => $recentActivity,
        ]);
    }
}
