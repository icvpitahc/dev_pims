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
                    <div class="col-sm-12 invoice-col">
                        <strong>Attachments:</strong><br>
                        {{ $document->specify_attachments ?? '(No attachments)' }}
                    </div>
                </div>
            </div>
            <div class="col-4 d-flex flex-column align-items-center justify-content-center">
                <img src="https://barcode.tec-it.com/barcode.ashx?data={{ $document->document_reference_code }}&code=QRCode&dpi=128" alt="qrcode"/>
                <p class="lead mt-2">Tracking #: {{ $document->document_reference_code }}</p>
            </div>
        </div>

        <hr>
        <h5 class="mt-4 mb-3">Routing History</h5>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>Date</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Action/Remarks</th>
                        <th>Name/Signature</th>
                    </tr>
                </thead>
                <tbody id="routing-history-table-body">
                    @if ($document->logs)
                        @foreach ($document->logs as $log)
                            <tr>
                                <td>{{ $log->created_at->format('M d, Y h:i A') }}</td>
                                <td>{{ $log->fromDivision->division_name }}</td>
                                <td>{{ $log->toDivision->division_name }}</td>
                                <td>{{ $log->remarks }}</td>
                                <td>{{ $log->userCreated->signature_name }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <script>
        window.onload = function() {
            const tableBody = document.getElementById('routing-history-table-body');
            const rowHeight = 38; // Approximate height of a row in pixels
            const a4Height = 1123; // A4 height in pixels at 96 DPI
            const contentHeight = 450; // Approximate height of content above the table
            const availableHeight = a4Height - contentHeight;
            const existingRows = tableBody.getElementsByTagName('tr').length;
            const maxRows = Math.floor(availableHeight / rowHeight);
            const rowsToAdd = maxRows - existingRows;

            if (rowsToAdd > 0) {
                for (let i = 0; i < rowsToAdd; i++) {
                    const newRow = tableBody.insertRow();
                    for (let j = 0; j < 5; j++) {
                        const newCell = newRow.insertCell();
                        newCell.innerHTML = '&nbsp;';
                    }
                }
            }

            window.print();
        }
    </script>
</body>
</html>
