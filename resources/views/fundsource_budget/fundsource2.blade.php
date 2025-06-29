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
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <form method="GET" action="{{ route('fundsource_budget') }}">
                <div class="input-group float-right w-50" style="min-width: 600px;">
                    <input type="text" class="form-control" name="keyword" placeholder="SAA" value="{{$keyword}}" aria-label="Recipient's username">
                        <div class="input-group-append">
                            <button class="btn btn-sm btn-info" type="submit"><img src="\maif\public\images\icons8_search_16.png">Search</button> 
                            <button class="btn btn-sm btn-warning text-white" type="submit" name="viewAll" value="viewAll"><img src="\maif\public\images\icons8_eye_16.png">View All</button>
                        </div>
                </div>
            </form>
            <h4 class="card-title">MANAGE FUNDSOURCE: BUDGET</h4>
            <p class="card-description">
                MAIF-IPP
            </p>
            @if(isset($fundsources) && $fundsources->count() > 0)
                <div class="row">
                    @foreach($fundsources as $fund)
                        <div class="col-md-3 mt-2 grid-margin grid-margin-md-0 stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <table style="border-collapse: collapse; width: 100%; margin: 0; padding: 0; ">
                                        <tr>
                                            <td>
                                                @if($section == 6)
                                                    <b><h3><a class="card-title text-success" href="#budget_track2" onclick="budgetTracking({{ $fund->id }})" data-toggle="modal">{{$fund->saa}}</a></h3></b>
                                                @else
                                                    <b><h3><a class="card-title text-success" href="#update_fundsource" onclick="updateFundsource('{{ $fund->id }}')" data-backdrop="static" data-toggle="modal">{{$fund->saa}}</a></h3></b>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <button style="border-radius:0px; border:1px solid blue; width:110px;" class="btn btn-sm btn-outline-info" onclick="budgetCost({{ $fund->id }}, '{{ $fund->saa }}')">Budget Cost</button>
                                                <button style="width:110px; border-radius:0; border:1px solid teal" id="track" data-fundsource-id="{{  $fund->id }}" data-target="#track_details" onclick="track_details(event)" class='btn btn-sm btn-outline-success track_details'>Tracking</button>
                                            </td>
                                        </tr>
                                    </table>
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <table style="border-collapse: collapse; width: 100%; margin-top: 5px; font-size:12px">
                                            <?php
                                                $allocated = !Empty($fund->proponentInfo[0]->total_allocated_funds) ? $fund->proponentInfo[0]->total_allocated_funds : 0;
                                                $admin_cost = !Empty($fund->proponentInfo[0]->total_admin_cost) ? $fund->proponentInfo[0]->total_admin_cost : 0;
                                                $utilized = !Empty($fund->utilization[0]->total_bbudget_utilize) ? $fund->utilization[0]->total_bbudget_utilize : 0;
                                                $transfer_from_rem = !Empty($fund->utilization[0]->transfer_from_rem) ? $fund->utilization[0]->transfer_from_rem : 0;
                                                $deduction = (isset($fund->a_cost) && count($fund->a_cost) > 0) ? $fund->a_cost[0]->total_admin_cost : 0;
                                            ?>
                                            <tr>
                                                <td style="width:50%; padding: 5px;">
                                                    Allocated Funds
                                                    :
                                                    <strong class="text-info">{{ number_format(floatval(str_replace(',', '',$allocated)), 2, '.', ',') }}</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:50%; padding: 5px;">
                                                    Admin Cost Balance
                                                    :
                                                    <strong class="{{ $admin_cost + $fund->budget_cost - $deduction == 0 ? 'text-danger' : 'text-info' }}" onclick="costTracking({{ $fund->id }})">
                                                        {{ number_format(floatval(str_replace(',', '',$admin_cost + $fund->budget_cost - $deduction)), 2, '.', ',') }}
                                                        <small class="text-info"><em>(details)</em></small>
                                                    </strong>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:50%; padding: 5px;">
                                                    Remaining Balance
                                                    :
                                                    <strong class="{{ $fund->remaining_balance == 0 ? 'text-danger' : 'text-info' }}">
                                                        {{ number_format(floatval(str_replace(',', '', $allocated - ($utilized + $transfer_from_rem))), 2, '.', ',') }}
                                                    </strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style="width:50%; padding: 5px;">
                                                    <button class="btn btn-sm btn-info" href="#budget_funds" onclick="fundsTracking({{ $fund->id }})" data-toggle="modal" style="border-radius: 0; flex: 1; width:110px;">&nbsp;&nbsp;Breakdowns of Funds&nbsp;</button>
                                                    <button class="btn btn-sm btn-success" href="" onclick="budgetTracking('{{ $fund->saa }}',{{ $fund->id }}, {{ !Empty($fund->admin_cost) ? floatval(str_replace(',', '',$fund->admin_cost)): 0 }}, {{ !Empty($fund->budget_cost) ? floatval(str_replace(',', '',$fund->budget_cost)): 0 }})" data-toggle="modal" style="border-radius: 0; flex: 1; width:110px;">Breakdowns of Charges</button>
                                                </td>
                                              
                                            </tr>
                                        </table>
                                        <!-- <div style="width:70%;">

                                            <ul class="list-arrow mt-3" style="list-style: none; padding: 0; margin: 0;">
                                                <?php
                                                    $allocated = !Empty($fund->proponentInfo[0]->total_allocated_funds) ? $fund->proponentInfo[0]->total_allocated_funds : 0;
                                                    $admin_cost = !Empty($fund->proponentInfo[0]->total_admin_cost) ? $fund->proponentInfo[0]->total_admin_cost : 0;
                                                    $utilized = !Empty($fund->utilization[0]->total_bbudget_utilize) ? $fund->utilization[0]->total_bbudget_utilize : 0;
                                                    $deduction = (isset($fund->a_cost) && count($fund->a_cost) > 0) ? $fund->a_cost[0]->total_admin_cost : 0;
                                                ?>
                                                <li><span class="ml-3">Allocated Funds: <strong class="text-info">{{ number_format(floatval(str_replace(',', '',$allocated)), 2, '.', ',') }}</strong></span></li>
                                                <li onclick="costTracking({{ $fund->id }})">
                                                    <span class="ml-3" title="Click to see admin cost tracking!">Admin Cost Balance: <strong class="text-info">{{ number_format(floatval(str_replace(',', '',$admin_cost + $fund->budget_cost - $deduction)), 2, '.', ',') }}
                                                    </strong></span>
                                                </li>    
                                                <li>
                                                    <span class="ml-3">Remaining Balance: 
                                                        <strong class="{{ $fund->remaining_balance == 0 ? 'text-danger' : 'text-info' }}">
                                                            {{ number_format(floatval(str_replace(',', '', $allocated - ($utilized + $admin_cost))), 2, '.', ',') }}
                                                        </strong>
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div style="display: flex; gap: 5px;">
                                            <button class="btn btn-sm btn-info" href="#budget_funds" onclick="fundsTracking({{ $fund->id }})" data-toggle="modal" style="border-radius: 0; flex: 1;">&nbsp;&nbsp;Breakdowns of Funds&nbsp;</button>
                                            <button class="btn btn-sm btn-success" href="" onclick="budgetTracking('{{ $fund->saa }}',{{ $fund->id }}, {{ !Empty($fund->admin_cost) ? floatval(str_replace(',', '',$fund->admin_cost)): 0 }}, {{ !Empty($fund->budget_cost) ? floatval(str_replace(',', '',$fund->budget_cost)): 0 }})" data-toggle="modal" style="border-radius: 0; flex: 1;">Breakdowns of Charges</button>
                                        </div> -->
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
                {!! $fundsources->appends(request()->query())->links('pagination::bootstrap-5') !!}
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="create_fundsource2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Fund Source</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal_body">
            <form id="contractForm" method="POST" action="{{ route('fundsource_budget.save') }}">
                <div class="modal-body for_clone">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label >Fundsource:</label>
                                <input type="text" class="form-control" id="saa" name="saa[]" placeholder="SAA" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" style="display: flex; flex-direction: column;">
                                <label for="allocated_funds">Allocated Fund</label>
                                <div style="display: flex; align-items: center;">
                                    <input type="text" class="form-control" id="allocated_funds" name="allocated_funds[]" onkeyup="validateAmount(this)" placeholder="Allocated Fund" required>
                                    <button type="button" class="form-control btn-info add_saa" style="width: 5px; margin-left: 5px; color:white; background-color:#355E3B">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="update_fundsource" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b><h5 class="modal-title" id="exampleModalLabel">Update Fundsource</h5></b>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="update_fundsource2">
                @csrf    
                <div class="modal_body">
                    <div class="card" style="padding:10px">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fname">SAA:</label>
                                    <input type="text" class="form-control saa" id="saa" name="saa" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lname">Allocated Funds:</label>
                                    <input type="text" class="form-control allocated_funds" onkeyup="validateAmount(this)" id="allocated_funds" name="allocated_funds" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fname">Admin Cost:</label>
                                    <input type="number" class="form-control admin_cost" id="admin_cost" name="admin_cost" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>            
        </div>
    </div>
</div>
@include('modal')
@endsection
@section('js')
<script src="{{ asset('admin/vendors/sweetalert2/sweetalert2.js?v=1') }}"></script>
<script src="{{ asset('admin/vendors/x-editable/bootstrap-editable.min.js?v=1') }}"></script>
<script>

    function costTracking(id){
        $('#cost_tracking').modal('show');
        $('.cost_main').html(loading);
        $.get("{{ url('budget/cost') }}" +'/'+ id, function(result){
            $('.cost_main').html(result);
        });
    }

    $(document).on('click', '.budget_track_pag a', function(e) {
        e.preventDefault(); 
        let url = $(this).attr('href');

        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                var newRows = $(response).filter('tr');
                $('#budget_track_body').html(response);
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
            }
        });
    });

    $(document).on('click', '.funds_pagination a', function(e) {
        e.preventDefault(); 
        let url = $(this).attr('href');

        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                var newRows = $(response).filter('tr');
                $('#budget_track_funds').html(response);
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
            }
        });
    });

    function budgetCost(id, saa) {
        Swal.fire({
            title: 'Enter Budget Cost',
            input: 'text',
            inputPlaceholder: 'Enter a decimal value',
            inputAttributes: {
                'aria-label': 'Enter a decimal value'
            },
            showCancelButton: true,
            confirmButtonText: 'Submit',
            cancelButtonText: 'Cancel',
            didOpen: () => {
                var inputField = Swal.getInput();

                inputField.addEventListener('input', (e) => {
                    var value = e.target.value;

                    value = value.replace(/[^0-9.]/g, ''); 
                    var parts = value.split('.');

                    if (parts.length > 2) {
                        value = `${parts[0]}.${parts[1]}`;
                    }

                    e.target.value = formatNumber(value); 
                });
            },
            preConfirm: (value) => {
                return new Promise((resolve, reject) => {
                    var numericValue = value.replace(/,/g, ''); 
                    if (!numericValue) {
                        reject('You need to enter a value!');
                    } else if (isNaN(numericValue) || parseFloat(numericValue) <= 0) {
                        reject('Please enter a valid positive decimal number!');
                    } else {
                        resolve(numericValue);
                    }
                });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                var amount = parseFloat(result.value.replace(/,/g, '')).toFixed(2);

                fetch(`budget-cost/${id}/${amount}`, {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then((response) => {
                    if (response.ok) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: `Budget cost updated for fundsource ${saa} with amount ${amount}.`,
                            timer: 1500, 
                            showConfirmButton: false 
                        });
                        location.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to update budget cost.'
                        });
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong. Please try again later.'
                    });
                });
            }
        }).catch((error) => {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Input',
                text: error
            });
        });
    }

    function formatNumber(value) {
        var [integerPart, decimalPart] = value.split('.');
        var formattedInteger = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        return decimalPart !== undefined ? `${formattedInteger}.${decimalPart}` : formattedInteger;
    }

    var saa;
    function addCost() {
        var table = document.getElementById("budget_track2").getElementsByTagName('tbody')[0];
        var newRow = table.insertRow();

        for (var i = 0; i < 12; i++) {
            var cell = newRow.insertCell(i);
            cell.style.border = "1px solid gray";
            cell.style.padding = "2px";
            cell.style.textAlign = "center";

            switch (i) {
                case 0:
                    cell.innerHTML = '<span style="text-align:center">' + (typeof saa !== 'undefined' ? saa : '') + '</span>';
                    cell.style.minWidth = "200px";
                    break;
                case 1:
                    cell.innerHTML = '<input type="text" name="pro_name[]" class="pro_name" style="width: 100%; border:0px">';
                    cell.style.maxWidth = "190px";
                    break;
                case 2:
                    cell.innerHTML = '<span name="ad_date[]" class="ad_date" style="width: 100%; border:0px">{{(new DateTime())->format('Y-m-d')}}</span>';
                    cell.style.maxWidth = "90px";
                    break;
                case 3:
                    cell.innerHTML = '<input type="text" name="dv_no[]" class="dv_no" style="width: 100%; border:0px">';
                    cell.style.maxWidth = "60px";
                    break;
                case 4:
                    cell.innerHTML = '<input type="text" name="payee[]" class="payee" style="width: 100%; border:0px">';
                    cell.style.maxWidth = "150px";
                    break;
                case 5:
                    cell.innerHTML = '<input type="text" name="rec_fc[]" class="rec_fc" style="width: 100%; border:0px">';
                    cell.style.maxWidth = "150px";
                    break;
                case 6:
                    cell.innerHTML = '<input type="text" class="ors_no" name="ors_no[]" class="ors_no" style="width: 100%; border:0px">';
                    cell.style.maxWidth = "60px";
                    break;
                case 7:
                    cell.innerHTML = ''; // Empty cell
                    cell.style.maxWidth = "130px";
                    break;
                case 8:
                    cell.innerHTML = ''; // Empty cell
                    cell.style.maxWidth = "130px";
                    break;
                case 9:
                    cell.innerHTML = '<input type="text" class="admin_uacs" name="admin_uacs[]" style="width: 100%; border:0px">';
                    cell.style.maxWidth = "90px";
                    break;
                case 10:
                    cell.innerHTML = '<input type="text" class="admin_cost" name="admin_cost[]" onkeyup="validateAmount(this)" style="width: 100%; border:0px">';
                    cell.style.maxWidth = "90px";
                    break;
                case 11:
                    cell.innerHTML = '<i onclick="adminCost($(this))" class="typcn typcn-tick-outline menu-icon text-info" style="font-size: 24px;"></i>';
                    break;
            }
        }
    }

    function updateFundsource(fundsource_id){
        $('#update_fundsource2').attr('action', "{{ route('update.fundsource', ['type' => 'save', 'fundsource_id' => ':fundsource_id']) }}".replace(':fundsource_id', fundsource_id));
        var url = "{{ url('fundsource').'/' }}" +'display' +'/'+ fundsource_id;
        $.ajax({
            url: url,
            type: 'GET',
            success: function(result) {
                $('.saa').val(result.saa);
                var formattedAmount = result.alocated_funds.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                $('.allocated_funds').val(formattedAmount);
                $('.admin_cost').val(result.cost_value);
            }
        });
    }

    function adminCost(element){
        var l_id = $('.last_id').val();
        var row = $(element).closest('tr');
        var uacs = row.find('.admin_uacs').val();
        var cost = row.find('.admin_cost').val();
        var ors = row.find('.ors_no').val();
        var fc = row.find('.rec_fc').val();
        var payee = row.find('.payee').val();
        var date = row.find('.ad_date').val();
        var pro = row.find('.pro_name').val();
        var dv_no = row.find('.dv_no').val();
        var data = 
            {
                l_id: l_id,
                uacs: uacs,
                cost: cost,
                ors: ors,
                fc: fc,
                payee: payee,
                date: date,
                pro: pro,
                saa_id: saa_id,
                dv_no: dv_no
            };

        $.ajax({
                type: 'POST',
                url: '{{ route("save.cost") }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    data: data
            },
            success: function (response) {
                Swal.fire({
                    icon: 'success',            
                    title: 'Success!',
                    text: 'Operation completed successfully.', 
                    timer: 1000,                
                    timerProgressBar: true,     
                    showConfirmButton: false   
                });
            },
            error: function (error) {
                if (error.status) {
                    console.error('Status Code:', error.status);
                }

                if (error.responseJSON) {
                    console.error('Response JSON:', error.responseJSON);
                }

            }
        });
    }

    function gen(){
        var timerInterval;
        Swal.fire({
            title: "Generating data!",
            html: "Closing in <b></b> milliseconds.",
            timer: 1100,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
                var timer = Swal.getPopup().querySelector("b");
                timerInterval = setInterval(() => {
                timer.textContent = `${Swal.getTimerLeft()}`;
                }, 100);
            },
            willClose: () => {
                clearInterval(timerInterval);
            }
        });
    }

    function fundsTracking(id){
        gen();
        $.get("{{ url('budget/funds').'/' }}"+id, function (result){
            $('#budget_track_funds').html(result);
        });
    }

    var saa_id;

    function budgetTracking(fundsource, id, amount, budget_amount){
        saa_id = id;
        saa = fundsource;

        $('#budget_track_body').empty();
        $.get("{{ url('budget/fundsource').'/' }}"+saa_id, function(result){

            if(result == 'No data available!' && amount == 0 && budget_amount == 0){
                $('#budget_track2').modal('hide');
                Swal.fire({
                    title: "No Data Found",
                    text: "There is no utilization details to display.",
                    iconHtml: '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"></svg>',
                    timer: 1000,
                    timerProgressBar: true,
                });
            }else{
                gen();
                $('#budget_track_body').html(result);
                $('#budget_track2').css('display', 'block');
                $('#budget_track2').modal('show');
                $('.modal-backdrop').addClass("fade show");
            }
        });
        if(amount + budget_amount == 0){
            $('.add_cost').css('display', 'none');
        }else{
            $('.add_cost').css('display', 'block');
        }
    }

    $(document).ready(function () {
        
        $(".for_clone").on("click", ".add_saa", function () {
            var clonedDiv = $(".for_clone .row:first").clone(true);
            $(clonedDiv).find('#saa').val('');
            $(clonedDiv).find('#allocated_funds').val('');
            $(clonedDiv).find(".add_saa").text("-");
            $(clonedDiv).find(".add_saa").removeClass("add_saa").addClass("remove_saa");
            $(".for_clone").append(clonedDiv);
        });

        $(".for_clone").on("click", ".remove_saa", function () {
            $(this).closest(".row").remove();
        });
    
    });

    var saaE = document.getElementById('saa');

    saaE.addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });

    function track_details(event){
        event.stopPropagation();
        $('#track_details').modal('show');

        var fundsourceId = event.target.getAttribute('data-fundsource-id');
        var i = 0;
        var type = "for_modal";
        var url = "{{ url('budget/tracking').'/' }}"+ fundsourceId +'/' + 'for_modal';
        $.ajax({
        url: url,
        type: 'GET',
        
            success: function(result) {
                $('#t_body').empty(); 
                $('.tracking_footer').empty();
                if(result.length > 0){
                    result.forEach(function(item) {
                        var saa = item.fund_sourcedata && item.fund_sourcedata.saa !== null ? item.fund_sourcedata.saa : '-';
                        var proponentName = item.proponentdata && item.proponentdata.proponent !== null ? item.proponentdata.proponent : '-';
                        var facility = item.facilitydata && item.facilitydata.name !== null ? item.facilitydata.name : '-';
                        var user = item.user_budget && item.user_budget.lname !== null ? item.user_budget.lname +', '+item.user_budget.fname : '-';

                        var timestamp = item.obligated_on !== null ? item.obligated_on : item.updated_at;
                        var date = new Date(timestamp);
                        var formattedDate = date.toLocaleString('en-US', {
                            month: 'long',
                            day: 'numeric',
                            year: 'numeric'
                        });
                        var formattedTime = date.toLocaleTimeString('en-US', {
                            hour: 'numeric',
                            minute: 'numeric'
                        });
                        var stat='';
                        if(item.obligated == 1){
                            stat = 'Obligated';
                        }else if(item.status == 2){
                            stat = 'Transfered/Deducted';
                        }else if(item.status == 3){
                            stat = 'Transfered/Added';
                        }
                        var beg_balance = item.budget_bbalance.replace(',', '');
                        var utilize = (item.budget_utilize !== null)?number_format(parseFloat(item.budget_utilize.replace(/,/g, '')), 2, '.', ','):'';
                        var route = item.div_id.toString();
                        var new_row = '<tr style="text-align:center">' +
                            '<td>' + saa + '</td>' +
                            '<td>' + proponentName + '</td>' +
                            '<td>' + facility + '</td>' +
                            '<td>' + number_format(parseFloat(beg_balance.replace(',', '')), 2, '.', ',') + '</td>' +
                            '<td>' +(item.div_id != 0 ?'<a class="modal-link" href="#i_frame" data-routeId="'+route+'" onclick="openModal(this)">' + utilize + '</a>' :utilize) +'</td>' +
                            '<td>' +(item.div_id != 0 ?'<a class="modal-link" href="#obligate" data-backdrop="static" data-toggle="modal" data-dvNo="'+item.dv_no+'" data-routeId="'+route+'" onclick="getDv(this)">' + item.div_id + '</a>' :'') +'</td>' +
                            '<td>' + item.user_budget.lname +', '+item.user_budget.fname+ '</td>' +
                            '<td>' + formattedDate+'<br>'+ formattedTime + '</td>' +
                            '<td>' + stat + '</td>' +
                            '</tr>';
                        $('#t_body').append(new_row);
                        i= i+1;
                    });
                    var printButton = $('<a>', { 
                        href: "{{ url('budget/tracking') }}/" + fundsourceId +'/'+ 'pdf',
                        target: '_blank',
                        type: 'button',
                        class: 'btn btn-success btn-sm',
                        text: 'PDF'
                    });
                $('.tracking_footer').append(printButton);
                }else{
                    var new_row = '<tr>' +
                        '<td colspan ="9">' + "No Data Available" + '</td>' +
                        '</tr>';
                    $('#t_body').append(new_row);
                }
            }
        });
    }

    function openModal(link) {
        var routeNoo = $(link).data('routeid');
        var src = "http://192.168.110.17/dts/document/trackMaif/" + routeNoo;

        $('.modal-body').append('<img class="loadingGif" src="public/images/loading.gif" alt="Loading..." style="display:block; margin:auto;">');

        var iframe = $('#trackIframe');

        iframe.hide();

        iframe.attr('src', src);
    
        iframe.on('load', function() {
            iframe.show(); 
            $('.loadingGif').css('display', 'none');
        });

        $('#myModal').modal('show');
    }

    function getDv( link) {
        var route_no = $(link).data('routeid');
        var dv_no = $(link).data('dvNo');

        $('.modal_body').html(loading);
        $('.modal-title').html("Disbursement Voucher");
        var url = "{{ url('dv').'/' }}"+route_no + '/' +'view';
        setTimeout(function(){
            $.ajax({
                url: url,
                type: 'GET',
                success: function(result) {
                    $('.modal_body').html(result);
                }
            });
        },1000);
    }

    function number_format(number, decimals, decimalSeparator, thousandsSeparator) {
        decimals = decimals || 0;
        number = parseFloat(number);

        if (!isFinite(number) || !number && number !== 0) return NaN;

        var result = number.toFixed(decimals);
        result = result.replace('.', decimalSeparator);

        var parts = result.split(decimalSeparator);
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousandsSeparator);

        return parts.join(decimalSeparator);
    }


    function editfundsource(fundsourceId){
        var proponent_id = event.target.getAttribute('data-proponent-id');
        $('.modal_body').html(loading);
        $('.modal-title').html("Update Fundsource");
        var url = "{{ url('fundsource/edit').'/' }}"+ fundsourceId +'/'+proponent_id;
        setTimeout(function() {
            $.ajax({
                url: url,
                type: 'GET',
                success: function(result){
                    $('.modal_body').html(result);
                }
            });
        }, 500);
    }
    function transferFunds(fundsourceId){
        var proponent_id = event.target.getAttribute('data-proponentInfo-id');
        var facility_id = event.target.getAttribute('data-facility-id');
        $('.modal_body').html(loading);
        $('.modal-title').html("Transfer Funds");
        var url = "{{ url('fundsource/transfer_funds').'/' }}"+ fundsourceId+'/'+proponent_id+'/'+ facility_id;
        setTimeout(function() {
            $.ajax({
                url: url,
                type: 'GET',
                success: function(result){
                    $('.modal_body').html(result);
                }
            });
        }, 500);
    }

    function addTransaction() {
        event.preventDefault();
        $.get("{{ route('transaction.get') }}",function(result) {
            $("#transaction-container").append(result);
        });
    }
    function validateAmount(element) {
        if (event.keyCode === 32) {
            event.preventDefault();
        }
        var cleanedValue = element.value.replace(/[^\d.]/g, '');
        var numericValue = parseFloat(cleanedValue);
        if (!isNaN(numericValue) || cleanedValue === '' || cleanedValue === '.') {
            element.value = cleanedValue.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        } else {
            element.value = ''; 
        }
    }
    function proponentCode(proponent){
        
        if(proponent.val()){
            var proponent_id = proponent.val()
            var url = "{{ url('proponent').'/' }}"+ proponent_id;
            setTimeout(function() {
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(result){
                        $("#proponent_code").val(result).prop('readonly', true);
                        var selectedText = $('#proponent_exist option:selected').text();
                        $("#proponent").val(selectedText).prop('readonly', true);
                    }
                });
            }, 500);
        }else{
            $("#proponent_code").val('').prop('readonly', false);
        }   
    }
</script>
@endsection
