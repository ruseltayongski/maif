<form id="contractForm" method="POST" action="{{ route('fundsource.create.save') }}">
     <input type="hidden" name="created_by" value="{{ $fundsource->id }}">
    <div class="modal-body">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label >Existing SAA</label>
                    <select class="js-example-basic-single w-100 select2" id="saa_exist" name="saa_exist" onchange="fundsourceExist($(this))">
                        <option value="">Please select SAA</option>
                        @foreach($fundsourcess as $fundsources)
                            <option value="{{ $fundsources->id }}" @if($fundsources->id == $proponent->proponentInfo->fundsource_id) selected @endif>{{ $fundsources->saa }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label >if SAA not exist, add new</label>
                    
                    <input type="text" class="form-control" id="saa" name="saa"  placeholder="SAA">
                </div>
            </div>
        </div>
        <div class="row">
        <div class="col-md-6">
                <div class="form-group">
                    <label>Proponent</label>
                    <input type="text" class="form-control" id="proponent" name="proponent" value="{{ $proponent->proponent }}" placeholder="Proponent" required>
                </div>
         </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label >Proponent Code</label>
                    <input type="text" class="form-control" id="proponent_code" name="proponent_code" placeholder="Proponent Code" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Facility</label>
                    <div id="facility_body">
                        <select class="form-control js-example-basic-single w-100" id="facility_id" name="facility_id[]" required>
                            <option value="">Please select facility</option>
                            @foreach($facility as $facilities)
                                <option value="{{ $facilities->id }}">{{ $facilities->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="alocated_funds">Allocated Fund</label>
                    <input type="number" step="any" class="form-control" id="alocated_funds" name="alocated_funds[]" placeholder="Allocated Fund" required>
                </div>
            </div>
        </div>
        <div id="transaction-container"></div><br>
        <a href="#" onclick="addTransaction()">Add</a>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update FundSource</button>
    </div>
</form>

<script src="{{ asset('admin/js/select2.js?v=').date('His') }}"></script>

<script>
    // function onchangeFundsource () {
    //     $(".select2").select2({ width: '100%' });
    // }

    function fundsourceExist(data) {
        data.val() ? $("#saa").attr('disabled','disabled') : $("#saa").removeAttr('disabled','disabled');
    }
</script>