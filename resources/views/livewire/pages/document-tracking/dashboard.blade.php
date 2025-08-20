<div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Document Tracking Dashboard</h1>
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
                            <h3>{{ $totalDocuments }}</h3>
                            <p>Total Documents</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $documentsInCirculation }}<sup style="font-size: 20px">{{ $documentsInCirculationPercentage }}%</sup></h3>
                            <p>Documents in Circulation</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-sync-alt"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ $pendingDocuments }}<sup style="font-size: 20px">{{ $pendingDocumentsPercentage }}%</sup></h3>
                            <p>Pending Documents</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $completedDocuments }}<sup style="font-size: 20px">{{ $completedDocumentsPercentage }}%</sup></h3>
                            <p>Completed Documents</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $overdueDocuments }}<sup style="font-size: 20px">{{ $overdueDocumentsPercentage }}%</sup></h3>
                            <p>Overdue Documents</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3>{{ $discardedDocuments }}<sup style="font-size: 20px">{{ $discardedDocumentsPercentage }}%</sup></h3>
                            <p>Discarded Documents</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-trash-alt"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Documents by Type</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="documentsByTypeChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Document Volume by Day</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="documentVolumeByDayChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Documents by Division</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="documentsByDivisionChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Overdue Documents by Division</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="overdueDocumentsByDivisionChart"></canvas>
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
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Tracking #</th>
                                        <th>Title</th>
                                        <th>Origin</th>
                                        <th>Status</th>
                                        <th>Last Updated</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentActivity as $document)
                                        <tr>
                                            <td>{{ $document->document_reference_code }}</td>
                                            <td><a href="#" wire:click.prevent="viewDocument({{ $document->id }})">{{ $document->document_title }}</a></td>
                                            <td>{{ $this->getDivisionInitials($document->division->division_name) }}</td>
                                            <td>{{ $document->status }}</td>
                                            <td>{{ $document->latestLog->created_at->diffForHumans() }}</td>
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

    <!-- View Document Modal -->
    <div class="modal fade" id="viewDocumentModal" tabindex="-1" role="dialog" aria-labelledby="viewDocumentModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewDocumentModalLabel">Document Monitoring Slip</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($selectedDocument)
                        <div class="row">
                            <div class="col-8">
                                <div class="row invoice-info">
                                    <div class="col-sm-6 invoice-col">
                                        <strong>Office of Origin:</strong><br>
                                        {{ $selectedDocument->division->division_name }}
                                    </div>
                                    <div class="col-sm-6 invoice-col">
                                        <strong>Document Date:</strong><br>
                                        {{ $selectedDocument->created_at->format('M d, Y h:i A') }}
                                    </div>
                                </div>
                                <div class="row invoice-info mt-3">
                                    <div class="col-sm-6 invoice-col">
                                        <strong>Document Type:</strong><br>
                                        {{ $selectedDocument->document_type->document_type_name }}
                                    </div>
                                    <div class="col-sm-6 invoice-col">
                                        <strong>Document Title:</strong><br>
                                        {{ $selectedDocument->document_title }}
                                    </div>
                                </div>
                                <div class="row invoice-info mt-3">
                                    <div class="col-sm-6 invoice-col">
                                        <strong>Document Sub-Type:</strong><br>
                                        {{ $selectedDocument->document_sub_type->document_sub_type_name }}
                                    </div>
                                    <div class="col-sm-6 invoice-col">
                                        <strong>Note:</strong><br>
                                        {{ $selectedDocument->note ?? '(No notes)' }}
                                    </div>
                                </div>
                                <div class="row invoice-info mt-3">
                                    <div class="col-sm-6 invoice-col">
                                        <strong>Attachments:</strong><br>
                                        {{ $selectedDocument->specify_attachments ?? '(No attachments)' }}
                                    </div>
                                    <div class="col-sm-6 invoice-col">
                                        <strong>Deadline:</strong><br>
                                        {{ $selectedDocument->expected_completion_date ? \Carbon\Carbon::parse($selectedDocument->expected_completion_date)->format('M d, Y') : '(Not set)' }}
                                    </div>
                                </div>
                                @if($selectedDocument->extremely_urgent_id == 1)
                                <div class="row invoice-info mt-4">
                                    <div class="col-12 text-left">
                                        <div class="stamp">Extremely Urgent</div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="col-4 d-flex flex-column align-items-center justify-content-center">
                                <img src="https://barcode.tec-it.com/barcode.ashx?data={{ route('documents.public.show', ['tracking_number' => \Crypt::encryptString($selectedDocument->document_reference_code)]) }}&code=QRCode&dpi=96" alt="qrcode"/>
                                <p class="lead mt-2">Tracking #: {{ $selectedDocument->document_reference_code }}</p>
                            </div>
                        </div>

                        <hr>
                        <h5 class="mt-4 mb-3">Routing History</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="thead-light">
                                    <tr style="text-align: center; vertical-align: middle;">
                                        <th>Date Created/Received</th>
                                        <th>Date Forwarded</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Action/Remarks</th>
                                        <th>Name/Signature</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($selectedDocumentLogs)
                                        @foreach ($selectedDocumentLogs as $log)
                                            <tr>
                                                <td>
                                                    @if ($loop->first)
                                                        Created at {{ $log->created_at->format('M d, Y h:i A') }} by {{ $log->userCreated->signature_name }}
                                                    @else
                                                        Received at {{ $log->created_at->format('M d, Y h:i A') }} by {{ $log->userCreated->signature_name ?? '' }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($log->forwarded_date)
                                                        Forwarded at {{ $log->forwarded_date->format('M d, Y h:i A') }} by {{ $log->userForwarded->signature_name ?? '' }}
                                                    @endif
                                                </td>
                                                <td>{{ $log->fromDivision->division_name }}</td>
                                                <td>{{ $log->toDivision->division_name ?? '' }}</td>
                                                <td>{{ $log->remarks }}</td>
                                                <td>{{ $log->userForwarded->signature_name ?? '' }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('livewire:load', function () {
        var documentsByTypeCtx = document.getElementById('documentsByTypeChart').getContext('2d');
        var documentsByTypeChart = new Chart(documentsByTypeCtx, {
            type: 'bar',
            data: {
                labels: @json($documentsByType->pluck('document_type_name')),
                datasets: [{
                    label: 'Extremely Urgent',
                    data: @json($documentsByType->pluck('urgent')),
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }, {
                    label: 'Normal',
                    data: @json($documentsByType->pluck('normal')),
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
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
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        var documentVolumeByDayCtx = document.getElementById('documentVolumeByDayChart').getContext('2d');
        var documentVolumeByDayChart = new Chart(documentVolumeByDayCtx, {
            type: 'line',
            data: {
                labels: @json($documentVolumeByDay->pluck('day')),
                datasets: [{
                    label: 'Normal',
                    data: @json($documentVolumeByDay->pluck('normal')),
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }, {
                    label: 'Extremely Urgent',
                    data: @json($documentVolumeByDay->pluck('urgent')),
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        var documentsByDivisionCtx = document.getElementById('documentsByDivisionChart').getContext('2d');
        var documentsByDivisionChart = new Chart(documentsByDivisionCtx, {
            type: 'doughnut',
            data: {
                labels: @json($documentsByDivision->keys()),
                datasets: [{
                    label: '# of Documents',
                    data: @json($documentsByDivision->values()),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
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

        var overdueDocumentsByDivisionCtx = document.getElementById('overdueDocumentsByDivisionChart').getContext('2d');
        var overdueDocumentsByDivisionChart = new Chart(overdueDocumentsByDivisionCtx, {
            type: 'doughnut',
            data: {
                labels: @json($overdueDocumentsByDivision->keys()),
                datasets: [{
                    label: '# of Overdue Documents',
                    data: @json($overdueDocumentsByDivision->values()),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
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

        Livewire.on('updateCharts', data => {
            documentsByTypeChart.data.labels = data[0].documentsByType.map(item => item.document_type_name);
            documentsByTypeChart.data.datasets[0].data = data[0].documentsByType.map(item => item.normal);
            documentsByTypeChart.data.datasets[1].data = data[0].documentsByType.map(item => item.urgent);
            documentsByTypeChart.update();

            documentVolumeByDayChart.data.labels = data[0].documentVolumeByDay.map(item => item.day);
            documentVolumeByDayChart.data.datasets[0].data = data[0].documentVolumeByDay.map(item => item.normal);
            documentVolumeByDayChart.data.datasets[1].data = data[0].documentVolumeByDay.map(item => item.urgent);
            documentVolumeByDayChart.update();

            documentsByDivisionChart.data.labels = Object.keys(data[0].documentsByDivision);
            documentsByDivisionChart.data.datasets[0].data = Object.values(data[0].documentsByDivision);
            documentsByDivisionChart.update();

            overdueDocumentsByDivisionChart.data.labels = Object.keys(data[0].overdueDocumentsByDivision);
            overdueDocumentsByDivisionChart.data.datasets[0].data = Object.values(data[0].overdueDocumentsByDivision);
            overdueDocumentsByDivisionChart.update();
        });

        window.addEventListener('show-view-document-modal', event => {
            $('#viewDocumentModal').modal('show');
        });
    });
</script>
@endpush
