<div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">ICT Requests Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('module-selector') }}">Modules</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $totalRequests }}</h3>
                            <p>Total Requests</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $pendingRequests }}</h3>
                            <p>Pending Requests</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ $inProgressRequests }}</h3>
                            <p>In Progress</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $resolvedRequests }}</h3>
                            <p>Resolved Requests</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3>{{ $closedRequests }}</h3>
                            <p>Closed Requests</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $cancelledRequests }}</h3>
                            <p>Cancelled Requests</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Requests by Type</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="requestsByTypeChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Requests by Month</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="requestsByMonthChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Requests by Status</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="requestsByStatusChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Requests by Division</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="requestsByDivisionChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Recent Activity</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Ticket #</th>
                                        <th>Request Type</th>
                                        <th>Status</th>
                                        <th>Last Updated</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentActivity as $request)
                                        <tr>
                                            <td>{{ $request->ticket_no }}</td>
                                            <td>{{ $request->request_type->request_type_name }}</td>
                                            <td>{{ $request->request_status_type_id }}</td>
                                            <td>{{ $request->updated_at->format('M d, Y h:i A') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('livewire:load', function () {
        var requestsByTypeCtx = document.getElementById('requestsByTypeChart').getContext('2d');
        var requestsByTypeChart = new Chart(requestsByTypeCtx, {
            type: 'bar',
            data: {
                labels: @json($requestsByType->pluck('sub_request_type_name')),
                datasets: [{
                    label: 'Pending',
                    data: @json($requestsByType->pluck('pending')),
                    backgroundColor: 'rgba(255, 193, 7, 0.5)',
                    borderColor: 'rgba(255, 193, 7, 1)',
                    borderWidth: 1
                }, {
                    label: 'In Progress',
                    data: @json($requestsByType->pluck('in_progress')),
                    backgroundColor: 'rgba(0, 123, 255, 0.5)',
                    borderColor: 'rgba(0, 123, 255, 1)',
                    borderWidth: 1
                }, {
                    label: 'Resolved',
                    data: @json($requestsByType->pluck('resolved')),
                    backgroundColor: 'rgba(40, 167, 69, 0.5)',
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 1
                }, {
                    label: 'Closed',
                    data: @json($requestsByType->pluck('closed')),
                    backgroundColor: 'rgba(108, 117, 125, 0.5)',
                    borderColor: 'rgba(108, 117, 125, 1)',
                    borderWidth: 1
                }, {
                    label: 'Cancelled',
                    data: @json($requestsByType->pluck('cancelled')),
                    backgroundColor: 'rgba(220, 53, 69, 0.5)',
                    borderColor: 'rgba(220, 53, 69, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: {
                        stacked: true
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true
                    }
                },
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            footer: function(tooltipItems) {
                                let sum = 0;
                                tooltipItems.forEach(function(tooltipItem) {
                                    sum += tooltipItem.parsed.y;
                                });
                                return 'Total: ' + sum;
                            }
                        }
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        var requestsByMonthCtx = document.getElementById('requestsByMonthChart').getContext('2d');
        var requestsByMonthChart = new Chart(requestsByMonthCtx, {
            type: 'line',
            data: {
                labels: @json($requestsByMonth->pluck('month')),
                datasets: [{
                    label: 'Hardware/Software Technical Assistance',
                    data: @json($requestsByMonth->pluck('hardware_software')),
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }, {
                    label: 'Web Posting/Information System Concerns',
                    data: @json($requestsByMonth->pluck('web_posting')),
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var requestsByStatusCtx = document.getElementById('requestsByStatusChart').getContext('2d');

        // Your labels and values from backend
        var labels = @json($requestsByStatus->keys());
        var values = @json($requestsByStatus->values());

        // Define a color map for each status
        var colorMap = {
            "Pending": {
                bg: 'rgba(255, 193, 7, 0.5)',    // yellow
                border: 'rgba(255, 193, 7, 1)'
            },
            "In Progress": {
                bg: 'rgba(0, 123, 255, 0.5)',   // blue
                border: 'rgba(0, 123, 255, 1)'
            },
            "Resolved": {
                bg: 'rgba(40, 167, 69, 0.5)',   // green
                border: 'rgba(40, 167, 69, 1)'
            },
            "Closed": {
                bg: 'rgba(108, 117, 125, 0.5)', // gray
                border: 'rgba(108, 117, 125, 1)'
            },
            "Cancelled": {
                bg: 'rgba(220, 53, 69, 0.5)',   // red
                border: 'rgba(220, 53, 69, 1)'
            }
        };

        // Build background and border arrays based on labels order
        var backgroundColors = labels.map(label => colorMap[label]?.bg || 'rgba(200,200,200,0.5)');
        var borderColors = labels.map(label => colorMap[label]?.border || 'rgba(200,200,200,1)');

        var requestsByStatusChart = new Chart(requestsByStatusCtx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    label: '# of Requests',
                    data: values,
                    backgroundColor: backgroundColors,
                    borderColor: borderColors,
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        var requestsByDivisionCtx = document.getElementById('requestsByDivisionChart').getContext('2d');
        var requestsByDivisionChart = new Chart(requestsByDivisionCtx, {
            type: 'doughnut',
            data: {
                labels: @json($requestsByDivision->keys()),
                datasets: [{
                    label: '# of Requests',
                    data: @json($requestsByDivision->values()),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)',
                        'rgba(255, 159, 64, 0.5)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    });
</script>
@endpush
