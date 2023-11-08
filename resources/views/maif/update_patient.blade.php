<style>
#patient-code-container {
    position: relative;
}
#loading-image {
  position: absolute;
  margin-right: 50px;
  top: -8%;
  left: 50%; /* Adjust the position as needed */
  transform: translateY(-50%, -50%);
  width: 60px;
    height: 60px;
}
</style>

<form id="contractForm" method="POST" action="{{ route('patient.update') }}">
<input type="hidden" name="patient_id" value="{{ $patient->id }}">
    <div class="modal-body">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="fname">First Name</label>
                    <input type="text" class="form-control" value="{{ $patient->fname }}" id="fname" name="fname" placeholder="First Name" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="lname">Last Name</label>
                    <input type="text" class="form-control" value="{{ $patient->lname }}" id="lname" name="lname" placeholder="Last Name" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="fname">Middle Name</label>
                    <input type="text" class="form-control" value="{{ $patient->mname }}" id="mname" name="mname" placeholder="Middle Name" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="lname">Date of Birth</label>
                    <input type="date" class="form-control" value="{{ $patient->dob }}" id="dob" name="dob" placeholder="Date of Birth" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="fname">Region</label>
                    <select class="form-control" onchange="othersRegion($(this));" name="region" required>
                        <option value="">Please select region</option>
                        <option value="Region 7" @if($patient->region == 'Region 7') selected @endif>Region 7</option>
                        <option value="NCR" @if($patient->region == 'NCR') selected @endif>NCR</option>
                        <option value="CAR" @if($patient->region == 'CAR') selected @endif>CAR</option>
                        <option value="Region 1" @if($patient->region == 'Region 1') selected @endif>Region 1</option>
                        <option value="Region 2" @if($patient->region == 'Region 2') selected @endif>Region 2</option>
                        <option value="Region 3" @if($patient->region == 'Region 3') selected @endif>Region 3</option>
                        <option value="Region 4" @if($patient->region == 'Region 4') selected @endif>Region 4</option>
                        <option value="Region 5" @if($patient->region == 'Region 5') selected @endif>Region 5</option>
                        <option value="Region 6" @if($patient->region == 'Region 6') selected @endif>Region 6</option>
                        <option value="Region 8" @if($patient->region == 'Region 8') selected @endif>Region 8</option>
                        <option value="Region 9" @if($patient->region == 'Region 9') selected @endif>Region 9</option>
                        <option value="Region 10" @if($patient->region == 'Region 10') selected @endif>Region 10</option>
                        <option value="Region 11" @if($patient->region == 'Region 11') selected @endif>Region 11</option>
                        <option value="Region 12" @if($patient->region == 'Region 12') selected @endif>Region 12</option>
                        <option value="Region 13" @if($patient->region == 'Region 13') selected @endif>Region 13</option>
                        <option value="BARMM" @if($patient->region == 'BARMM') selected @endif>BARMM</option>
                    </select>
                    <script>var patientRegion = "{{$patient->region}}";</script>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="lname">Province</label>
                    <div id="province_body">
                        <select class="form-control" id="province_id" name="province_id" onchange="onchangeProvince($(this))" required>
                            <option value="">Please select province</option>
                            @foreach($provinces as $prov)
                                <option value="{{ $prov->id }}" @if($prov->id == $patient->province_id) selected @endif>{{ $prov->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            {{-- <div class="col-md-6">
                <div class="form-group">
                    <label>Facility</label>
                    <div id="facility_body">
                        <select class="js-example-basic-single w-100" id="facility_id" name="facility_id" required>
                            <option value="">Please select facility</option>
                        </select>
                    </div>
                </div>
            </div> --}}

            <div class="col-md-6">
                <div class="form-group">
                    <label for="lname">Municipality</label>
                    <div id="muncity_body">
                        <select class="js-example-basic-single w-100" id="muncity_id" name="muncity_id" onchange="onchangeMuncity($(this))" required>
                          @foreach($municipal as $municipals)   
                        <option value="{{ $municipals->id }}" {{$municipals->id == $patient->muncity_id? 'selected' : ''}}>{{ $municipals->description }}</option>
                          @endforeach   
                    </select>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="lname">Barangay</label>
                    <div id="barangay_body">
                        <select class="js-example-basic-single w-100" id="barangay_id" name="barangay_id"  required>
                           @foreach($barangay as $barangays)
                           <option value="{{ $barangays->id }}" {{$barangays->id == $patient->barangay_id? 'selected' : ''}}>{{ $barangays->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <hr>
        <strong>Fund Source</strong>
        <hr>
        <div class="row">
        <div class="col-md-6">
                <div class="form-group">
                    <label >SAA</label>
                    <select class="js-example-basic-single w-100 select2" id="fundsource_id" name="fundsource_id" onchange="onchangeFundsource($(this))" required>
                        <option value="">Please select SAA</option>
                        @foreach($fundsources as $fundsource)
                        <option value="{{ $fundsource->id }}" data-fundsource-id="{{ $fundsource->id }}" {{$patient->fundsource_id == $fundsource->id? 'selected' : ''}}>{{$fundsource->saa }}</option>                  
                       @endforeach
                     
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="fname">Proponent</label>
                    <select class="js-example-basic-single w-100 select2" id="proponent_id" name="proponent_id" onchange="onchangeProponent($(this))" required disabled>
                        @foreach($proponents as $proponent)
                          <option value="{{ $proponent->id }}" data-proponent-id="{{ $proponent->id}}" data-proponent-name="{{ $proponent->proponent}}" {{$patient->proponent_id == $proponent->id? 'selected' : ''}}>{{$proponent->proponent }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="fname">Facility</label>
                    <select class="js-example-basic-single w-100 select2" id="facility_id" name="facility_id" onchange="onchangeForPatientCode($(this))" required disabled>
                            @foreach($facility as $facilities)
                               <option value="{{ $facilities->id }}"  {{$patient->facility_id == $facilities->id? 'selected' : ''}}>{{$facilities->name }}</option>
                             @endforeach  
                    </select>
                </div>
            </div> 
                <div class="col-md-6">
                <label for="fname">Patient Code</label>
                    <div class="form-group" id="patient-code-container">
                        <input type="text" class="form-control loading-input" id="patient_code" name="patient_code" value="{{$patient->patient_code}}" placeholder="Patient Code" readonly> 
                        <img id="loading-image" src="{{ asset('images/loading.gif') }}" alt="Loading" style="display: none;">
                    </div>
                </div>

            {{-- <div class="col-md-6">  
                <div class="form-group">
                    <label for="fname">Amount</label>
                    <input type="number" step="any" class="form-control" id="amount" name="amount" placeholder="Amount" required>
                </div>
            </div> --}}
        </div>
        <hr>
        <strong>Transaction</strong>
        <hr>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="fname">Guaranteed Amount</label>
                    <input type="number" step="any" class="form-control" value="{{ $patient->fundsource? $patient->guaranteed_amount : '' }}" id="guaranteed_amount" name="guaranteed_amount" placeholder="Guaranteed Amount">
                </div>
            </div>
                
            <div class="col-md-6">
                <div class="form-group">
                    <label for="fname">Actual Amount</label>
                    <input type="number" step="any" class="form-control" id="actual_amount" name="actual_amount" placeholder="Actual Amount" readonly>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="fname">Remaining Balance</label>
                    <input type="number" step="any" class="form-control" value ="{{ $patient->fundsource? $patient->remaining_balance : ''}}" id="remaining_balance" name="remaining_balance" placeholder="Remaining Balance">
                </div>
            </div>
        </div>

    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update Patient</button>
    </div>
</form>

<script src="{{ asset('admin/js/select2.js?v=').date('His') }}"></script>
<script>
     $(document).ready(function() {
  
        if (patientRegion !== "Region 7"){
            var patientProvinceDescription = "{{ $patient->other_province }}"; 
            var patientMuncity = "{{ $patient->other_muncity }}";
            var patientBarangay = "{{$patient->other_barangay}}";
            document.getElementById("province_body").innerHTML = '<input type="text" class="form-control" id="other_province" value="' + patientProvinceDescription + '" name="other_province">';
            document.getElementById("muncity_body").innerHTML = '<input type="text" class="form-control" id="other_muncity" value="' + patientMuncity + '" name="other_muncity">';
            document.getElementById("barangay_body").innerHTML = '<input type="text" class="form-control" id="other_barangay" value="' + patientBarangay + '" name="other_barangay">';
        }
        // Show the loading image when the dropdown changes
        $('#fundsource_id').on('change', function() {
            var selectOptionText = $(this).find('option:selected').text();
            if (selectOptionText !== 'Please select SAA') {
                $('#loading-image').show();
            } 
        });

        $('#facility_id').on('change', function() {
            // Set a timeout to hide the loading-image after a specified interval (e.g., 2000 milliseconds or 2 seconds)
            if ($(this).val() !== '') {
                setTimeout(function() {
                    $('#loading-image').hide();
                }, 1000); // Change the time interval as needed
            }
        });


    });
    
</script>
