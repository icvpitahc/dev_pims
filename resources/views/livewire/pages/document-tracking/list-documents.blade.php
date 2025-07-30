<div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Document Tracking</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('module-selector') }}">Modules</a></li>
                        <li class="breadcrumb-item active">Document Tracking</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <!-- Summary Cards -->
            <div class="row">
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ $totalDocumentsCreated }}</h3>
                            <p>Total Documents Created</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $pendingDocuments }}</h3>
                            <p>Pending</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $ongoingDocuments }}<sup style="font-size: 20px">({{ $ongoingPercentage }}%)</sup></h3>
                            <p>Ongoing</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-tasks"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $completedDocuments }}<sup style="font-size: 20px">({{ $completedPercentage }}%)</sup></h3>
                            <p>Completed</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $discardedDocuments }}<sup style="font-size: 20px">({{ $discardedPercentage }}%)</sup></h3>
                            <p>Discarded</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-trash-alt"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title"><i class="fas fa-file-alt mr-2"></i>All Documents</h3>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#createSlipModal"><i class="fas fa-plus-circle mr-2"></i>Create New Slip</button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Search and Filters -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="search" class="form-control" placeholder="Search by Tracking # or Title..." wire:model.debounce.300ms="search">
                                <div class="input-group-append">
                                    <button class="btn btn-default"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="#advancedFilters" data-toggle="collapse" class="btn btn-outline-secondary">
                                <i class="fas fa-filter mr-2"></i>Advanced Filters
                            </a>
                        </div>
                    </div>

                    <div class="collapse @if($filterStatus || $filterOrigin || $filterDocumentType) show @endif" id="advancedFilters">
                        <div class="card card-body bg-light mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control" wire:model="filterStatus">
                                            <option value="">All</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Ongoing">Ongoing</option>
                                            <option value="Completed">Completed</option>
                                            <option value="Discarded">Discarded</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Office of Origin</label>
                                        <select class="form-control" wire:model="filterOrigin">
                                            <option value="">All</option>
                                            @foreach($divisions as $division)
                                                <option value="{{ $division->id }}">{{ $division->division_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Document Type</label>
                                        <select class="form-control" wire:model="filterDocumentType">
                                            <option value="">All</option>
                                            @foreach($documentTypes as $type)
                                                <option value="{{ $type->id }}">{{ $type->document_type_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Document Table -->
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th style="text-align: center">Actions</th>
                                    <th style="text-align: center">Status</th>
                                    <th style="text-align: center">Tracking #</th>
                                    <th style="text-align: center">Document Title</th>
                                    <th style="text-align: center">Document Type</th>
                                    <th style="text-align: center">Origin</th>
                                    <th style="text-align: center">Current Location</th>
                                    <th style="text-align: center">Document Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($documents as $document)
                                    <tr class="
                                        @if($document->status == 'Pending') table-info @endif
                                        @if($document->status == 'Ongoing') table-warning @endif
                                        @if($document->status == 'Completed') table-success @endif
                                        @if($document->status == 'Discarded') table-danger @endif
                                    ">
                                        <td style="text-align: center">
                                            <button class="btn btn-primary btn-sm" wire:click.prevent="viewDocument({{ $document->id }})">
                                                <i class="fas fa-search"></i>
                                            </button>
                                            <button class="btn btn-primary btn-sm" wire:click.prevent="editDocument({{ $document->id }})" @if($document->status != 'Pending') disabled @endif>
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger btn-sm" wire:click.prevent="">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                        <td style="text-align: center">{{ $document->status }}</td>
                                        <td style="text-align: center">{{ $document->document_reference_code }}</td>
                                        <td style="text-align: center">{{ $document->document_title }}</td>
                                        <td style="text-align: center">{{ $document->document_type->document_type_name }}</td>
                                        <td style="text-align: center">{{ $document->division->division_name }}</td>
                                        <td style="text-align: center">{{ $document->current_location }}</td>
                                        <td style="text-align: center">{{ $document->created_at->format('M d, Y h:i A') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No documents found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                        {{ $documents->links() }}
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
                                    <div class="col-sm-12 invoice-col">
                                        <strong>Attachments:</strong><br>
                                        {{ $selectedDocument->specify_attachments ?? '(No attachments)' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 d-flex flex-column align-items-center justify-content-center">
                                <img src="https://barcode.tec-it.com/barcode.ashx?data={{ $selectedDocument->document_reference_code }}&code=QRCode&dpi=128" alt="qrcode"/>
                                <p class="lead mt-2">Tracking #: {{ $selectedDocument->document_reference_code }}</p>
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
                                <tbody>
                                    @if ($selectedDocumentLogs)
                                        @foreach ($selectedDocumentLogs as $log)
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
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a href="{{ $selectedDocument ? route('documents.print', $selectedDocument->id) : '#' }}" target="_blank" class="btn btn-primary">Print</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Document Modal -->
    <div class="modal fade" id="editDocumentModal" tabindex="-1" role="dialog" aria-labelledby="editDocumentModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDocumentModalLabel">Update Document Status</h5>
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
                                    <div class="col-sm-12 invoice-col">
                                        <strong>Attachments:</strong><br>
                                        {{ $selectedDocument->specify_attachments ?? '(No attachments)' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 d-flex flex-column align-items-center justify-content-center">
                                <img src="https://barcode.tec-it.com/barcode.ashx?data={{ $selectedDocument->document_reference_code }}&code=QRCode&dpi=128" alt="qrcode"/>
                                <p class="lead mt-2">Tracking #: {{ $selectedDocument->document_reference_code }}</p>
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
                                <tbody>
                                    @if ($selectedDocumentLogs)
                                        @foreach ($selectedDocumentLogs as $log)
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

                        <!-- Action Form -->
                        <hr>
                        <h5 class="mt-4 mb-3">Take Action</h5>
                        <form wire:submit.prevent="updateDocument">
                            <div class="form-group">
                                <label for="selectedAction">Action</label>
                                <select class="form-control" id="selectedAction" wire:model="selectedAction">
                                    <option value="">Select Action</option>
                                    @foreach($actions as $action)
                                        <option value="{{ $action->id }}">{{ $action->action_name }}</option>
                                    @endforeach
                                </select>
                                @error('selectedAction') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            @if($selectedAction == 1) <!-- Forward -->
                                <div class="form-group">
                                    <label for="edit_to_division_id">Forward To</label>
                                    <select class="form-control" id="edit_to_division_id" wire:model="edit_to_division_id">
                                        <option value="">Select Division</option>
                                        @foreach($divisions as $division)
                                            <option value="{{ $division->id }}">{{ $division->division_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('edit_to_division_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="edit_remarks">Remarks</label>
                                <textarea class="form-control" id="edit_remarks" rows="3" wire:model="edit_remarks"></textarea>
                                @error('edit_remarks') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Create Slip Modal -->
    <div class="modal fade" id="createSlipModal" tabindex="-1" role="dialog" aria-labelledby="createSlipModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createSlipModalLabel">Create New Document Slip</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="document_type_id">Document Type</label>
                                    <select class="form-control" id="document_type_id" wire:model="document_type_id">
                                        <option value="">Select Document Type</option>
                                        @foreach($documentTypes as $type)
                                            <option value="{{ $type->id }}">{{ $type->document_type_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('document_type_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="document_sub_type_id">Document Sub-Type</label>
                                    <select class="form-control" id="document_sub_type_id" wire:model="document_sub_type_id">
                                        <option value="">Select Document Sub-Type</option>
                                        @if($documentSubTypes)
                                            @foreach($documentSubTypes as $subType)
                                                <option value="{{ $subType->id }}">{{ $subType->document_sub_type_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('document_sub_type_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="document_title">Document Title</label>
                            <input type="text" class="form-control" id="document_title" placeholder="Enter document title" wire:model="document_title">
                            @error('document_title') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="specify_attachments">Attachments</label>
                            <textarea class="form-control" id="specify_attachments" rows="3" placeholder="Specify attachments" wire:model="specify_attachments"></textarea>
                            @error('specify_attachments') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="note">Note</label>
                            <textarea class="form-control" id="note" rows="3" placeholder="Enter a note" wire:model="note"></textarea>
                            @error('note') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="to_division_id">Forward To</label>
                                    <select class="form-control" id="to_division_id" wire:model="to_division_id">
                                        <option value="">Select Division</option>
                                        @foreach($divisions as $division)
                                            <option value="{{ $division->id }}">{{ $division->division_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('to_division_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="remarks">Remarks</label>
                            <textarea class="form-control" id="remarks" rows="3" placeholder="Enter remarks" wire:model="remarks"></textarea>
                            @error('remarks') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" wire:click.prevent="store()">Save Slip</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        window.addEventListener('closeModal', event => {
            $('#createSlipModal').modal('hide');
        });

        window.addEventListener('show-view-document-modal', event => {
            $('#viewDocumentModal').modal('show');
        });

        window.addEventListener('show-edit-document-modal', event => {
            $('#editDocumentModal').modal('show');
        });
    </script>
@endpush
