<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        @media print {
            body {
                -webkit-print-color-adjust: exact;
            }
            .no-print {
                display: none;
            }
            hr {
                border-top: 1px solid black !important;
            }
            .table-bordered th,
            .table-bordered td,
            .table-bordered {
                border: 1px solid black !important;
            }
            .stamp {
                border: 3px double red !important;
                color: red !important;
                font-weight: bold !important;
                padding: 8px 20px !important;
                text-transform: uppercase !important;
                font-size: 1.5rem !important;
                display: inline-block !important;
                margin-top: 10px !important;
            }
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5>PITAHC Integrated Management System (PIMS)</h5>
                <h6>Document Tracking</h6>
                <h4><strong>DOCUMENT MONITORING SLIP</strong></h4>
            </div>
            <div>
                <img src="{{ asset('images/logo4.png') }}" alt="PITAHC Logo" style="height: 100px;">
                <img src="{{ asset('images/Bagong Pilipinas Logo.png') }}" alt="Bagong Pilipinas Logo" style="height: 125px;">
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-8">
                <div class="row invoice-info">
                    <div class="col-sm-6 invoice-col">
                        <strong>Office of Origin:</strong><br>
                        {{ $document->division->division_name }}
                    </div>
                    <div class="col-sm-6 invoice-col">
                        <strong>Document Date:</strong><br>
                        {{ $document->created_at->format('M d, Y h:i A') }}
                    </div>
                </div>
                <div class="row invoice-info">
                    <div class="col-sm-6 invoice-col">
                        <strong>Document Type:</strong><br>
                        {{ $document->document_type->document_type_name }}
                    </div>
                    <div class="col-sm-6 invoice-col">
                        <strong>Document Title:</strong><br>
                        {{ $document->document_title }}
                    </div>
                </div>
                <div class="row invoice-info">
                    <div class="col-sm-6 invoice-col">
                        <strong>Document Sub-Type:</strong><br>
                        {{ $document->document_sub_type->document_sub_type_name }}
                    </div>
                    <div class="col-sm-6 invoice-col">
                        <strong>Note:</strong><br>
                        {{ $document->note ?? '(No notes)' }}
                    </div>
                </div>
                <div class="row invoice-info">
                    <div class="col-sm-6 invoice-col">
                        <strong>Attachments:</strong><br>
                        {{ $document->specify_attachments ?? '(No attachments)' }}
                    </div>
                    <div class="col-sm-6 invoice-col">
                        <strong>Deadline:</strong><br>
                        {{ $document->expected_completion_date ? \Carbon\Carbon::parse($document->expected_completion_date)->format('M d, Y') : '(Not set)' }}
                    </div>
                </div>
                @if($document->extremely_urgent_id == 1)
                <div class="row invoice-info mt-4">
                    <div class="col-12 text-left">
                        <div class="stamp">Extremely Urgent</div>
                    </div>
                </div>
                @endif
            </div>
            <div class="col-4 d-flex flex-column align-items-center justify-content-center">
                <img src="https://barcode.tec-it.com/barcode.ashx?data={{ route('documents.public.show', ['tracking_number' => Crypt::encryptString($document->document_reference_code)]) }}&code=QRCode&dpi=96" alt="qrcode"/>
                <p class="lead mt-2">Tracking #: {{ $document->document_reference_code }}</p>
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
                <tbody id="routing-history-table-body">
                    @if ($document->logs)
                        @foreach ($document->logs->whereNotNull('action_id') as $log)
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
    </div>

    <script>
        window.onload = function() {
            // Use a slight delay to ensure all content is rendered before calculating height
            setTimeout(function() {
                const tableBody = document.getElementById('routing-history-table-body');
                const rowHeight = 38; // Approximate height of a row in pixels, adjust if necessary
                const a4Height = 1123; // A4 height in pixels at 96 DPI for portrait mode

                // Use scrollHeight on the body for a more accurate measure of total content height
                const totalHeight = document.body.scrollHeight;

                // Calculate the height of the content on the final page
                const contentOnFinalPage = totalHeight % a4Height;

                let remainingHeight;

                if (contentOnFinalPage === 0) {
                    // Content perfectly fills the pages, no rows needed.
                    remainingHeight = 0;
                } else {
                    // Calculate the empty space on the final page
                    remainingHeight = a4Height - contentOnFinalPage;
                }

                const rowsToAdd = Math.floor(remainingHeight / rowHeight);

                if (rowsToAdd > 0) {
                    for (let i = 0; i < rowsToAdd; i++) {
                        const newRow = tableBody.insertRow();
                        for (let j = 0; j < 6; j++) {
                            const newCell = newRow.insertCell();
                            newCell.innerHTML = '&nbsp;';
                        }
                    }
                }

                window.print();
            }, 100); // 100ms delay
        }
    </script>
</body>
</html>
