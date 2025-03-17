@extends('layouts.app')
@section('content')
<?php 
    use App\Models\Proponent; 
    use App\Models\ProponentInfo; 
    use App\Models\Facility; 
?>
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <form method="GET">
                <div class="input-group float-right w-50" style="min-width: 600px;">
                    <input type="text" class="form-control" name="keyword" placeholder="PROPONENT" value="{{ $keyword }}">
                        <div class="input-group-append">
                            <button class="btn btn-sm btn-info" type="submit"><img src="\maif\public\images\icons8_search_16.png">Search</button> 
                            <button class="btn btn-sm btn-warning text-white" type="submit" name="viewAll" value="viewAll"><img src="\maif\public\images\icons8_eye_16.png">View All</button>
                        </div>
                </div>
            </form>
            <h4 class="card-title">MANAGE FUNDSOURCE: PROPONENT</h4>
            <p class="card-description">
                MAIF-IPP
            </p>
            @if(isset($data))
                <div class="row">
                    @foreach($data as $row)
                        <div class="col-md-4 mt-2 grid-margin grid-margin-md-0 stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div style ="display:flex; justify-content:space-between;">
                                        <b><h3><a href="" data-toggle="modal" class="text-success" onclick="disUtil('{{ $row['proponent']['proponent'] }}')">{{ $row['proponent']['proponent'] }}</a></h3></b>
                                        <a href="#modified_funds" data-toggle="modal" class="btn btn-sm update_saa" style="min-width:110px; cursor: pointer; text-align:center; color:white; background-color:#417524; border-radius:0;" onclick="addBalance('{{ $row['proponent']['proponent'] }}')">Manage Funds</a>                                      
                                    </div>
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <div style="width:70%;">
                                            <table style="border-collapse: collapse; width: 90%; margin: 0; padding: 0; margin-left:5%">
                                                <tr>
                                                    <td style="padding: 5px;">Allocated Funds</td>
                                                    <td style="padding: 5px; text-align: center;">:</td>
                                                    <td style="padding: 5px;"><strong>{{ !empty($row['sum']) ? number_format($row['sum'], 2, '.', ',') : '0.00' }}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 5px;">GL Total</td>
                                                    <td style="padding: 5px; text-align: center;">:</td>
                                                    <td style="padding: 5px;"><strong>{{ !empty($row['totalUtilized']) ? number_format($row['totalUtilized'], 2, '.', ',') : '0.00' }}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 5px;">Disbursement Total</td>
                                                    <td style="padding: 5px; text-align: center;">:</td>
                                                    <td style="padding: 5px;"><strong>{{ !empty($row['disbursement']) ? number_format($row['disbursement'], 2, '.', ',') : '0.00' }}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 5px;">Supplemental Funds</td>
                                                    <td style="padding: 5px; text-align: center;">:</td>
                                                    <td style="padding: 5px;">
                                                        <a href="#supp_tracking" data-backdrop="static" data-toggle="modal" onclick="supDetails('{{ $row['proponent']['proponent'] }}')">
                                                            <strong>{{ !empty($row['supp']) ? number_format($row['supp'], 2, '.', ',') : '0.00' }}</strong>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 5px;">Negative Amount</td>
                                                    <td style="padding: 5px; text-align: center;">:</td>
                                                    <td style="padding: 5px;">
                                                        <a href="#sub_tracking" data-toggle="modal" onclick="subDetails('{{ $row['proponent']['proponent'] }}')">
                                                            <strong>{{ !empty($row['sub']) ? number_format($row['sub'], 2, '.', ',') : '0.00' }}</strong>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 5px;">Remaining Funds</td>
                                                    <td style="padding: 5px; text-align: center;">:</td>
                                                    <td style="padding: 5px;"><strong>{{ !empty($row['rem']) ? number_format($row['rem'], 2, '.', ',') : '0.00' }}</strong></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-danger" role="alert" style="width: 100%;">
                <i class="typcn typcn-times menu-icon"></i>
                    <strong>No fundsource found!</strong>
                </div>
            @endif
            <div class="pl-5 pr-5 mt-5">
                {!! $data->appends(request()->query())->links('pagination::bootstrap-5') !!}
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="gl_tracking" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius:0px;">
            <div class="modal-header" style="text-align:center">
                <h4 class="text-success modal-title">
                    <i style="font-size:15px" class="typcn typcn-location-arrow menu-icon"></i>
                    PROPONENT TRACKING DETAILS (guarantee letters)
                </h4>
            </div>
            <div class="table-container budget_container" style="padding:10px">
                <div id="gl_body"></div>
            </div>
            <div class="modal-footer budget_track_footer">
                <button style="background-color:lightgray; border-radius:0px" class="btn btn-default" data-dismiss="modal">CLOSE</button>
                <a href="#" id="printButton" style="border-radius:0px" class="btn btn-success">Print</a>
                <button style="display:none; border-radius:0px" class="btn btn-info filter_btn" onclick="filterData()">FILTER</button>
                <button href="#forward_patient" data-toggle="modal" class="btn btn-warning forward_btn" style="display:none; border-radius:0px">Forward</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="supp_tracking" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" style="border-radius:0px;">
            <div class="modal-header" style="text-align:center">
                <h4 class="text-success modal-title">
                    <i style="font-size:15px" class="typcn typcn-location-arrow menu-icon"></i>
                    SUPPLEMENTAL DETAILS
                </h4>
            </div>
            <div class="sup_body">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="sub_tracking" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" style="border-radius:0px;">
            <div class="modal-header" style="text-align:center">
                <h4 class="text-success modal-title">
                    <i style="font-size:15px" class="typcn typcn-location-arrow menu-icon"></i>
                    SUBTRACTED FUNDS DETAILS
                </h4>
            </div>
            <div class="sub_body">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="manage_funds" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" style="border-radius:0px;">
            <div class="modal-header" style="text-align:center">
                <h4 class="text-success modal-title">
                    <i style="font-size:15px" class="typcn typcn-location-arrow menu-icon"></i>
                    MANAGE FUNDSOURCE
                </h4>
            </div>
            <form id="contractForm" method="POST" action="{{ route('proponent.supplementalv2') }}">
                <div class="modal-body" style="padding:20px">
                    @csrf
                    <div class="row">
                        <div class="col-md-5">
                            <label style="vertical-align:center">AMOUNT: </label>
                            <input type="text" class="form-control" id="amount" name="amount" placeholder="0.00">
                        </div>
                        <div class="col-md-7">
                            <label style="vertical-align:center">FACILITY: </label>
                            <select class="form-control js-example-basic-single select2" style="width:100%" id="f_id" name="f_id">
                                <option value=""></option>
                                @foreach($facilities as $row)
                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">ADD</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modified_funds" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" style="border-radius:0px;">
            <div class="modal-header" style="text-align:center">
                <h4 class="text-success modal-title">
                    <i style="font-size:15px" class="typcn typcn-location-arrow menu-icon"></i>
                    MANAGE FUNDSOURCE
                </h4>
            </div>
            <form id="contractForm" method="POST" action="{{ route('manage.funds') }}">
                <input type="hidden" class="funds_type" name="funds_type">
                <input type="hidden" class="proponent" name="proponent">
                <div class="modal-body" style="padding:20px">
                    @csrf
                    <div class="row">
                        <div class="col-md-5">
                            <label style="vertical-align:center">AMOUNT: </label>
                            <input type="text" class="form-control" id="amount" name="amount" placeholder="0.00">
                        </div>
                        <div class="col-md-7">
                            <label style="vertical-align:center">REMARKS: </label>
                            <textarea class="form-control" id="remarks" name="remarks" style="height:58%"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" onclick="supp()">Add Supplemental</button>
                    <button type="submit" class="btn btn-warning" onclick="subtracts()">Negate Funds</button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('modal')
@endsection
@section('js')
<script>
    function supp(){
        $('.funds_type').val(1);
    }

    function subtracts(){
        $('.funds_type').val(2);
    }

    $('.select2').select2({
        placeholder: 'Select Facility',
    });

    document.getElementById('printButton').addEventListener('click', function(e) {
        e.preventDefault(); 
        var code = pro_code;  
        var f_id = $('#facility').val();  
        var patient_ids = $('#patient').val();  
        f_id = (Array.isArray(f_id) && f_id.length === 0) ? 0: f_id;
        patient_ids = (patient_ids === null || patient_ids === '') ? 0 : patient_ids;
        var url = `proponent/patient-print/${code}/${f_id}/${patient_ids}`;
        window.location.href = url;
    });

    function displayFilter(){
        $('.filter_btn').css('display', 'block');
    }

    function filterData(){
        var f_id = $('#facility').val();

        if (Array.isArray(f_id) && f_id.length === 0) {
            f_id.push("all");
        } else {
            f_id = (Array.isArray(f_id) && f_id.length === 0) ? f_id.push(undefined) : f_id;
        }

        var patient_ids = $('#patient').val(); 

        if (!patient_ids) {  
            patient_ids = "all";
        }

        $('#gl_body').html(loading);

        $.ajax({
            url: 'proponent/patient-sort/'+encodeURIComponent(pro_code)+'/'+f_id+'/0/0/'+patient_ids +'/', 
            type: 'GET',
            data: {
                pro_code: pro_code,
                f_id: f_id
            },
            success: function (response) {
                $('#gl_body').html(response);
            },
            error: function () {
                alert('Error fetching data.');
            }
        });
    }

    function sortData(sort_type){
        var f_id = $('#facility').val();
        console.log('sample', sort_type);
        if (Array.isArray(f_id) && f_id.length === 0) {
            f_id.push("all");
        } else {
            f_id = (Array.isArray(f_id) && f_id.length === 0) ? f_id.push(undefined) : f_id;
        }

        var patient_ids = $('#patient').val(); 

        if (!patient_ids) {  
            patient_ids = "all";
        }

        $('#gl_body').html(loading);

        $.ajax({
            url: 'proponent/patient-sort2/'+encodeURIComponent(pro_code)+'/'+f_id+'/0/0/'+patient_ids +'/', 
            type: 'GET',
            data: {
                pro_code: pro_code,
                f_id: f_id,
                sort_type: sort_type
            },
            success: function (response) {
                $('#gl_body').html(response);
            },
            error: function () {
                alert('Error fetching data.');
            }
        });
    }

    $(document).on('click', '.pro_util_pages a', function(e) {
        e.preventDefault(); 
        let url = $(this).attr('href');

        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                var newRows = $(response).filter('tr');
                $('#gl_body').html(response);
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
            }
        });
    });

    function deletePatient(rowId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to delete this patient record?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `proponent/patient-delete/${rowId}`, 
                    type: 'GET', 
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Deleted!',
                                text: 'The patient record has been successfully deleted.',
                                icon: 'success',
                                timer: 1000,
                                showConfirmButton: false
                            }).then(() => {
                                $(".gl_"+rowId).remove();
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: response.message || 'Failed to delete the record.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred while trying to delete the record.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire({
                    title: 'Cancelled',
                    text: 'Deletion has been cancelled.',
                    icon: 'info',
                    timer: 1000,
                    showConfirmButton: false
                });
            }
        });
    }

    function updateNegation(id){
        Swal.fire({
            title: 'Update Supplemental Funds',
            input: 'text', 
            inputLabel: 'Amount:',
            inputPlaceholder: '0.00',
            showCancelButton: true,
            confirmButtonText: 'Update',
            cancelButtonText: 'Cancel',
            inputValidator: (value) => {
                if (!value) {
                    return 'Please enter the amount!';
                }
            },
            didOpen: () => {
                var inputElement = Swal.getInput();
                inputElement.oninput = function () {
                    var cleanedValue = this.value.replace(/[^\d.]/g, '');
                    var formattedValue = cleanedValue.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                    this.value = formattedValue;
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                var amount = result.value; 
                var amount = parseFloat(amount.replace(/,/g, ''));
                fetch(`proponent/sub-update/${id}/${amount}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                    }
                })
                .then(async (response) => {
                    if (!response.ok) {
                        var errorDetails = await response.json().catch(() => null); 
                        throw new Error(errorDetails?.message || `HTTP Error: ${response.status}`); 
                    }
                    return response.json(); 
                })
                .then(data => {
                    Swal.fire('Success!', 'Your data has been submitted.', 'success');
                    location.reload();
                })
                .catch(error => {
                    Swal.fire('Error!', error.message, 'error');
                });

            }
        });
    }

    function updateAmount(id){
        Swal.fire({
            title: 'Update Supplemental Funds',
            input: 'text', 
            inputLabel: 'Amount:',
            inputPlaceholder: '0.00',
            showCancelButton: true,
            confirmButtonText: 'Update',
            cancelButtonText: 'Cancel',
            inputValidator: (value) => {
                if (!value) {
                    return 'Please enter the amount!';
                }
            },
            didOpen: () => {
                var inputElement = Swal.getInput();
                inputElement.oninput = function () {
                    var cleanedValue = this.value.replace(/[^\d.]/g, '');
                    var formattedValue = cleanedValue.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                    this.value = formattedValue;
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                var amount = result.value; 
                var amount = parseFloat(amount.replace(/,/g, ''));
                fetch(`proponent/sup-update/${id}/${amount}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                    }
                })
                .then(async (response) => {
                    if (!response.ok) {
                        var errorDetails = await response.json().catch(() => null); 
                        throw new Error(errorDetails?.message || `HTTP Error: ${response.status}`); 
                    }
                    return response.json(); 
                })
                .then(data => {
                    Swal.fire('Success!', 'Your data has been submitted.', 'success');
                    location.reload();
                })
                .catch(error => {
                    Swal.fire('Error!', error.message, 'error');
                });

            }
        });
    }

    var input_amount;

    function addBalance(proponent) {
        var user = <?php echo Auth::user()->userid ?>;
        $('.proponent').val(proponent);
        $('#amount').val('');
        $('#remarks').val('');
    }

    function validateAmount(element) {
        if (event.keyCode === 32) {
            event.preventDefault();
        }
        var cleanedValue = element.value.replace(/[^\d.]/g, '');
        var numericValue = parseFloat(cleanedValue);

        if ((!isNaN(numericValue) || cleanedValue === '' || cleanedValue === '.') &&
            !(cleanedValue.length === 1 && cleanedValue[0] === '0')) {
                element.value = cleanedValue.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        }else{
            element.value = '';
        }
    }
    var pro_code;
    function disUtil(code){
        pro_code = code;
        // $('.pro_body').html(loading);
        $('#gl_body').html(loading);
        $.get("{{ url('proponent/util').'/' }}"+code, function(result){
            if(result == 0){
                $('#pro_util').modal('hide');
                Swal.fire({
                    title: "No Data Found",
                    text: "There is no utilization details to display.",
                    iconHtml: '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"></svg>',
                    timer: 1000,
                    timerProgressBar: true,
                });
            }else{
                $('#gl_body').html(result);
                $('#gl_tracking').css('display', 'block');
                $('#gl_tracking').modal('show');
                $('.modal-backdrop').addClass("fade show");
            }
        });
    }

    function supDetails(proponent){
        $('.sup_body').html(loading);
        $.get("{{ url('proponent/sup-details').'/' }}"+proponent, function(result){
            $('.sup_body').html(result);
        });
    }

    function delSupplemental(id){
        $.get("{{ url('proponent/sup-del') }}" + '/' + id, function() {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Successfuly deleted this data.',
                showConfirmButton: false,
                timer: 1000
            });
            $("#row-" + id).remove();
        });
    }

    function delNegate(id){
        $.get("{{ url('proponent/sub-del') }}" + '/' + id, function() {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Successfuly deleted this data.',
                showConfirmButton: false,
                timer: 1000
            });
            $("#row-" + id).remove();
        });
    }

    function reloadPage(){
        location.reload();
    }

    function subDetails(proponent){
        $('.sub_body').html(loading);
        $.get("{{ url('proponent/sub-details').'/' }}"+proponent, function(result){
            $('.sub_body').html(result);
        });
    }

</script>
@endsection
