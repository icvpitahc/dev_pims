<div>
    @php
        $activeLog = $document->latestActiveLog;
    @endphp

    <div class="text-center mt-4">
        @if ($activeLog && is_null($activeLog->received_date) && !is_null($activeLog->to_division_id))
            <button class="btn btn-primary" data-toggle="modal" data-target="#receiveDocumentModal">
                <i class="fas fa-file-import mr-2"></i>Receive Document
            </button>
        @elseif ($activeLog && is_null($activeLog->action_id))
            <button class="btn btn-success" data-toggle="modal" data-target="#takeActionModal">
                <i class="fas fa-play mr-2"></i>Take Action
            </button>
        @endif
    </div>

    <!-- Receive Document Modal -->
    <div class="modal fade" id="receiveDocumentModal" tabindex="-1" role="dialog" aria-labelledby="receiveDocumentModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form wire:submit.prevent="receive">
                    <div class="modal-header">
                        <h5 class="modal-title" id="receiveDocumentModalLabel">Receive Document</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="id_number">ID Number</label>
                            <input type="text" class="form-control" id="id_number" placeholder="Enter your ID number" wire:model.defer="id_number">
                            @error('id_number') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Take Action Modal -->
    <div class="modal fade" id="takeActionModal" tabindex="-1" role="dialog" aria-labelledby="takeActionModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form wire:submit.prevent="takeAction">
                    <div class="modal-header">
                        <h5 class="modal-title" id="takeActionModalLabel">Take Action</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="employee_number">Your Employee Number</label>
                            <input type="text" class="form-control" id="employee_number" placeholder="Enter your Employee Number to verify" wire:model.defer="employee_number">
                            @error('employee_number') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <hr>
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
                            <label for="to_division_id">Forward To</label>
                            <select class="form-control" id="to_division_id" wire:model.defer="to_division_id">
                                <option value="">Select Division</option>
                                @foreach($formDivisions as $division)
                                        <option value="{{ $division->id }}">{{ $division->division_name }}</option>
                                    @endforeach
                                </select>
                                @error('to_division_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="remarks">Remarks</label>
                            <textarea class="form-control" id="remarks" rows="3" wire:model.defer="remarks"></textarea>
                            @error('remarks') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
