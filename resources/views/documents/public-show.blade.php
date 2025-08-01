<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Tracking - {{ $document->document_reference_code }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji';
        }
        .timeline {
            position: relative;
            padding: 20px 0;
        }
        .timeline::before {
            content: '';
            position: absolute;
            left: 20px;
            top: 0;
            bottom: 0;
            width: 4px;
            background: #e9ecef;
        }
        .timeline-item:last-child::before {
            display: none;
        }
        .timeline-item {
            position: relative;
            margin-bottom: 20px;
            padding-left: 40px;
        }
        .timeline-icon {
            position: absolute;
            left: 8px;
            top: 0;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #007bff;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }
        .timeline-content {
            background: #fff;
            padding: 15px;
            border-radius: 6px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .timeline-content strong {
            font-weight: 600;
        }
        .header-card {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: #fff;
        }
        .bg-info-light { background-color: #e6f7ff; color: #0056b3 !important; }
        .bg-warning-light { background-color: #fffbe6; color: #8a6d3b !important; }
        .bg-success-light { background-color: #e6ffed; color: #155724 !important; }
        .bg-danger-light { background-color: #ffe6e6; color: #721c24 !important; }
        .bg-info-light .text-muted, .bg-warning-light .text-muted, .bg-success-light .text-muted, .bg-danger-light .text-muted {
            color: inherit !important;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    @livewireStyles
</head>
<body>
    <div class="container py-4">
        <div class="card shadow-sm mb-4 header-card">
            <div class="card-body text-center">
                <h2 class="h4 mb-1"><strong>{{ $document->document_title }}</strong></h2>
                <p class="mb-0">Tracking #: {{ $document->document_reference_code }}</p>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">Document Details</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Office of Origin:</strong><br>
                        {{ $document->division->division_name }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Date Created:</strong><br>
                        {{ $document->created_at->format('M d, Y, h:i A') }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Document Type:</strong><br>
                        {{ $document->document_type->document_type_name }}
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Sub-Type:</strong><br>
                        {{ $document->document_sub_type->document_sub_type_name }}
                    </div>
                    <div class="col-12 mb-3">
                        <strong>Note:</strong><br>
                        {{ $document->note ?? '(No notes)' }}
                    </div>
                    <div class="col-12">
                        <strong>Attachments:</strong><br>
                        {{ $document->specify_attachments ?? '(No attachments)' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">Routing History</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    @if ($document->logs)
                        @foreach ($document->logs as $log)
                            <div class="timeline-item @if($loop->last && ($document->status == 'Completed' || $document->status == 'Discarded')) no-line @endif">
                                <div class="timeline-icon
                                    @if ($loop->last)
                                        @if($document->status == 'Pending') bg-info @endif
                                        @if($document->status == 'Ongoing') bg-warning @endif
                                        @if($document->status == 'Completed') bg-success @endif
                                        @if($document->status == 'Discarded') bg-danger @endif
                                    @endif
                                ">
                                    @if ($loop->last)
                                        @if($document->status == 'Completed') <i class="fas fa-check"></i>
                                        @elseif($document->status == 'Discarded') <i class="fas fa-trash-alt"></i>
                                        @elseif($document->status == 'Pending') <i class="fas fa-clock"></i>
                                        @else <i class="fas fa-arrow-down"></i>
                                        @endif
                                    @else
                                        <i class="fas fa-arrow-down"></i>
                                    @endif
                                </div>
                                <div class="timeline-content
                                    @if ($loop->last)
                                        @if($document->status == 'Pending') bg-info-light text-dark @endif
                                        @if($document->status == 'Ongoing') bg-warning-light text-dark @endif
                                        @if($document->status == 'Completed') bg-success-light text-dark @endif
                                        @if($document->status == 'Discarded') bg-danger-light text-dark @endif
                                    @endif
                                ">
                                    <p class="mb-1">
                                        <strong>From:</strong> {{ $log->fromDivision->division_name }}<br>
                                        <strong>To:</strong> {{ $log->toDivision->division_name ?? '' }}
                                    </p>
                                    <p class="mb-1"><strong>Action/Remarks:</strong> {{ $log->remarks }}</p>
                                    <small class="text-muted">
                                        <i class="far fa-clock mr-1"></i>Forwarded: {{ $log->created_at->format('M d, Y, h:i A') }} by {{ $log->userCreated->signature_name }}
                                    </small>
                                    @if($log->received_date)
                                    <br>
                                    <small class="text-muted">
                                        <i class="far fa-check-circle mr-1"></i>Received: {{ $log->received_date->format('M d, Y, h:i A') }} by {{ $log->userReceived->signature_name ?? '' }}
                                    </small>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        @livewire('pages.document-tracking.public-receive-document', ['document' => $document])
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    @livewireScripts
    <script>
        $(document).ready(function() {
            var positionClass = 'toast-bottom-right';
            if (window.innerWidth < 768) {
                positionClass = 'toast-top-center';
            }
            toastr.options = {
                "positionClass": positionClass,
                "progressBar": true,
            }
            window.addEventListener('success-message', event=> {
                $('#receiveDocumentModal, #takeActionModal').modal('hide');
                toastr.success(event.detail.message, 'Success!');
            });
            window.addEventListener('error-message', event=> {
                toastr.error(event.detail.message, 'Error!');
            });
        });
    </script>
</body>
</html>
