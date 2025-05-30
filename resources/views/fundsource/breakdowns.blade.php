<style>
    hr {
        border: 1px solid;
        color: grey;
    }
</style>

<form id="contractForm" method="POST" action="{{ route('fundsource.save_breakdowns') }}">
    <div class="modal-body">
        <h4>{{$fundsource[0]->saa}} : Php {{number_format($fundsource[0]->alocated_funds, 2, '.', ',')}}</h4>
        <h4 class="breakdown_total">Total Breakdowns : PhP {{number_format($sum, 2, '.', ',')}}</h4>
        @csrf
        <br>
        <br>

        @if($fundsource[0]->proponents->count() > 0)
            @foreach($fundsource[0]->proponents as $index => $pro)
                <div class="clone">
                    <div class="card" style="border:none;">
                        <div class="row">
                            <div class="col-md-5">
                                <b><label>Proponent (Main):</label></b>
                                <div class="form-group">
                                    <select class="form-control proponent_main" id="proponent_main{{ $pro->id }}" name="proponent_main[]">
                                        <option value=""></option>
                                        @foreach($proponents as $proponent)
                                            <option value="{{ $proponent->id }}" 
                                                {{ $pro->proponentInfo->first() && $pro->proponentInfo->first()->main_proponent == $proponent->id ? 'selected' : '' }}>
                                                {{ $proponent->proponent }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <script>
                                        $(document).ready(function () {
                                            $('#proponent_main{{ $pro->id }}').select2({
                                                placeholder:"Select Main Proponent"
                                            });
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <b><label>Proponent:</label></b>
                                <div class="form-group">
                                    <!-- <input type="text" class="form-control proponent" name="proponent[]" value="{{$pro->proponent}}"> -->
                                    <select class="form-control proponent" id="{{$pro->id . $index}}" name="proponent[]" onchange="proponentCode($(this))" required>
                                        <option value=""></option>
                                        @foreach($proponents as $proponent)
                                            <option value="{{ $proponent->proponent }}" {{ ($proponent->proponent == $pro->proponent) ? 'selected' : '' }} data-proponent-code="{{ $proponent->proponent_code }}">
                                                {{ $proponent->proponent }}
                                            </option>
                                        @endforeach
                                        <script>
                                            $(document).ready(function () {
                                                $("#"+"{{ $pro->id . $index }}").select2({
                                                    tags: true,
                                                    placeholder: "Select/Input Proponent"
                                                });
                                            });
                                        </script>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <b><label>Proponent Code:</label></b>
                                <div class="form-group" style="display: flex; align-items: center;">
                                    <input type="text" class="form-control proponent_code" name="proponent_code[]" value="{{$pro->proponent_code}}" style="flex: 1; width:1000px;" onblur="checkCode($(this),this.value)" required>
                                    <!-- @if($index == 0) -->
                                        <button type="button" class="form-control clone_pro-btn" style="width: 10px; margin-left: 5px; color:white; background-color:#00688B">+</button>
                                    <!-- @else
                                        <button type="button" class="form-control remove_pro-btn" style="width: 10px; margin-left: 5px; color:white; background-color:#00688B">-</button>
                                    @endif -->
                                </div>
                            </div>
                        </div>
                        @if($pro->proponentInfo->count() >0)
                            @foreach($pro->proponentInfo as $index => $proInfo)
                                <div class="card1">
                                    <div class="row">
                                        <div class="col-md-5">
                                        <label>Facility:</label>
                                            <div class="form-group">
                                                <div class="facility_select">
                                                    <select class="form-control break_fac" id="{{ $proInfo->id }}" name="facility_id[id][]" multiple required
                                                        @if($proInfo->alocated_funds != $proInfo->remaining_balance)
                                                        
                                                        @endif >
                                                        <option value=""></option>

                                                        @if($proInfo->facility != null)
                                                            @foreach($facilities as $facility)
                                                                <option value="{{ $facility->id }}" {{$proInfo->facility_id == $facility->id ? 'selected' :''}}>{{ $facility->name }}</option>
                                                            @endforeach
                                                        @else
                                                            <?php 
                                                                $facilityIds = array_map('intval', json_decode($proInfo->facility_id));
                                                            ?>
                                                            @foreach($facilities as $facility)
                                                                <option value="{{ $facility->id }}" {{ in_array($facility->id, $facilityIds) ? 'selected' : '' }}>
                                                                    {{ $facility->name }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <label>Allocated Funds:</label>
                                            <div class="form-group">
                                                <div class="form-group" style="display: flex; align-items: center;">
                                                    <input type="hidden" class="info_id" value="{{!empty($proInfo->id)?$proInfo->id:0}}">
                                                    <input type="text" class="form-control alocated_funds" id="alocated_funds[]" name="alocated_funds[]" oninput="calculateFunds(this)" onkeyup="validateAmount(this)" value="{{number_format(str_replace(',', '',$proInfo->alocated_funds), 2, '.', ',')}}" style="flex: 1; width:160px;" required
                                                    @if($proInfo->alocated_funds != $proInfo->remaining_balance)
                                                        
                                                    @endif
                                                    >
                                                    @if($index == 0)
                                                        <button type="button" class="form-control btn-info clone_facility-btn" style="width: 5px; margin-left: 5px; color:white; background-color:#355E3B">+</button>
                                                    @else
                                                        <button type="button" class="form-control btn-info remove_fac-clone" onclick="remove({{$proInfo->id}})" style="width: 5px; margin-left: 5px; color:white; background-color:#355E3B">-</button>
                                                    @endif
                                                    <button type="button" id="transfer_funds" href="#transfer_fundsource" onclick="transferFunds({{ $proInfo->id }})" class="form-control btn-info transfer_funds" style="width: 5px; margin-left: 5px; color:white; background-color:#01796F"><i class="typcn typcn-arrow-right-thick menu-icon"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $("#"+"{{ $proInfo->id}}").select2({
                                            placeholder:"Select facility"
                                        });
                                        var count = 0; count++;
                                    });
                                </script>
                            @endforeach
                        @else
                            <div class="card1">
                                <div class="row">
                                    <div class="col-md-5">
                                        <label>Facility:</label>
                                        <div class="form-group">
                                            <div class="facility_select">
                                                <select class="form-control break_fac" id="breakdown_select" name="facility_id[]" multiple required>
                                                    <option value=""></option>
                                                    @foreach($facilities as $facility)
                                                        <option value="{{ $facility->id }}">{{ $facility->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <label>Allocated Funds:</label>
                                        <div class="form-group">
                                            <div class="form-group" style="display: flex; align-items: center;">
                                                <input type="hidden" class="info_id" value="0">
                                                <input type="text" class="form-control alocated_funds" id="alocated_funds[]" name="alocated_funds[]" onkeyup="validateAmount(this)" oninput="calculateFunds(this)" placeholder="Allocated Fund" style="flex: 1; width:160px;" required>
                                                <button type="button" class="form-control btn-info clone_facility-btn" style="width: 5px; margin-left: 5px; color:white; background-color:#355E3B">+</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <hr>
                    </div>
                </div>
            @endforeach
        @else
            <div class="clone">
                <div class="card" style="border:none;">
                    <div class="row">
                        <div class="col-md-5">
                            <b><label>Proponent (Main):</label></b>
                            <div class="form-group">
                                <select class="form-control proponent_main" id="proponent_main" name="proponent_main[]">
                                    <option value=""></option>
                                    @foreach($proponents as $proponent)
                                        <option value="{{ $proponent->id }}" data-proponent-code="{{ $proponent->proponent_code }}">
                                            {{ $proponent->proponent }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <b><label>Proponent (c/o):</label></b>
                            <div class="form-group">
                                <!-- <input type="text" class="form-control proponent" name="proponent[]" placeholder="Proponent"> -->
                                <select class="form-control proponent" id="proponent" name="proponent[]"  onchange="proponentCode($(this))" required>
                                    <option value=""></option>
                                    @foreach($proponents as $proponent)
                                        <option value="{{ $proponent->proponent }}" data-proponent-code="{{ $proponent->proponent_code }}">
                                            {{ $proponent->proponent }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <b><label>Proponent Code:</label></b>
                            <div class="form-group" style="display: flex; align-items: center;">
                                <input type="text" class="form-control proponent_code" name="proponent_code[]" placeholder="Proponent Code" style="flex: 1; width:1000px;" onblur="checkCode($(this),this.value)" required>
                                <button type="button" class="form-control clone_pro-btn" style="width: 10px; margin-left: 5px; color:white; background-color:#00688B">+</button>
                            </div>
                        </div>
                    </div>
                    <div class="card1">
                        <div class="row">
                            <div class="col-md-5">
                                <label>Facility:</label>
                                <div class="form-group">
                                    <div class="facility_select">
                                        <select class="form-control break_fac" id="breakdown_select" name="facility_id[]" multiple required>
                                            <option value=""></option>
                                            @foreach($facilities as $facility)
                                                <option value="{{ $facility->id }}">{{ $facility->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <label>Allocated Funds:</label>
                                <div class="form-group">
                                    <div class="form-group" style="display: flex; align-items: center;">
                                        <input type="text" class="form-control alocated_funds" id="alocated_funds[]" name="alocated_funds[]" onkeyup="validateAmount(this)" oninput="calculateFunds(this)" placeholder="Allocated Fund" style="flex: 1; width:160px;" required>
                                        <button type="button" class="form-control btn-info clone_facility-btn" style="width: 5px; margin-left: 5px; color:white; background-color:#355E3B">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
            </div>
        @endif
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="close_b" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
<script src="{{ asset('admin/js/select2.js?v=').date('His') }}"></script>
<script>
    var timer;
    var click = 0;
    var remove_click = 0;

    function checkCode(element, value) {
        setTimeout(() => { 
            var proponents_list = @json($proponents);
            var hasMatchingProponent = proponents_list.some(function(item) {
                return item.proponent_code === value;
            });
            if (hasMatchingProponent) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Sorry! This code has been used by another proponent already.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                var proponentCodeInput = element.closest('.row').find('.proponent_code');
                proponentCodeInput.val('');
            }
        }, 500);
        new_code(element, value);
    }

    function new_code(element, value){
        value = value.trim();
        var count = 0;

        $('.proponent_code').each(function () {
            const currentVal = $(this).val().trim();
            if (currentVal === value) {
                count++;
            }
        });

        if (count > 1) {
            Swal.fire({
                title: 'Error!',
                text: 'Sorry! This code has been used by another proponent already.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            $(element).val('');
        }
    }

    function proponentCode(selectElement) {
        var selectedValue = selectElement.val();
        var proponentCode = selectElement.find(':selected').data('proponent-code');
        // var proponentCode = selectElement.find('option[value="' + selectedValue + '"]').data('proponent-code');
        if (proponentCode != "" || proponentCode != undefined ) {
            var proponentCodeInput = selectElement.closest('.row').find('.proponent_code');
            proponentCodeInput.val(proponentCode);
            proponentCodeInput.prop('disabled', true);
        }
        proponentCodeInput.prop('disabled', false);
    }

    function remove(infoId){
        $.get("{{ url('proponentInfo/').'/' }}"+infoId, function(result) {
        });
    }

    function calculateFunds(inputElement){
        clearTimeout(timer);
        timer = setTimeout(() => {
                var sum =0;
                getData().forEach(item=>{
                    var funds = parseFloat(item.alocated_funds.replace(/,/g, ''));
                    sum+=funds;
                })
                $('.breakdown_total').text('Total Breakdowns: Php '+sum.toLocaleString('en-US', {maximumFractionDigits: 2}));
                if(sum>{{str_replace(',','',$fundsource[0]->alocated_funds)}}){
                    alert('Exceed allocated funds!');
                    inputElement.value = '';
                }

                var info_id = $('.info_id').val();
                if( info_id != 0 || info_id != null || info_id != undefined){
                    var jsonData = @json($util);
                    var filteredData = jsonData.filter(item => item.proponentinfo_id == info_id);
                    var totalUtilizeAmount = filteredData.reduce((sum, item) => {
                        var amount = parseFloat(item.utilize_amount.replace(/,/g, ''));
                        return sum + amount;
                    }, 0);
                    var input = inputElement.value.replace(/,/g, '');
                    if(totalUtilizeAmount > input){
                        alert('Allocated amount for this facility is lesser than total utilized amount int DV');
                    }
                }
        }, 1000);
    }
    function getData(){
        var formData = [];
            var num=0, nu=0;
            $('.clone .card').each(function (index, clone) {
                num++;
                var proponent = $(clone).find('.proponent').val();
                var proponent_code = $(clone).find('.proponent_code').val();
                var proponent_main = $(clone).find('.proponent_main').val();
                $(clone).find('.row').each(function (rowIndex, row) {
                    nu++;
                    var facility_id = $(row).find('.break_fac').val();
                    
                    if(facility_id !== '' && facility_id !== undefined){

                        var allocated_funds = $(row).find('.alocated_funds').val(); 
                        var info_id = $(row).find('.info_id').val(); 
                        if(info_id == undefined){
                            info_id = 0;
                        }
                        var cloneData = {
                            proponent: proponent,
                            proponent_main: proponent_main,
                            proponent_code: proponent_code,
                            facility_id: facility_id,
                            alocated_funds: allocated_funds,
                            remaining_balance: allocated_funds,
                            info_id: info_id,
                            fundsource_id:{{$fundsource[0]->id}}

                        };
                        formData.push(cloneData);
                    }
                    
                });
            });
            nu = nu/5;
            formData = formData.filter(function (data, index, array) {
                return (
                    data.proponent !== "" &&
                    data.proponent_code !== "" &&
                    data.alocated_funds !== "" &&
                    data.facility_id !== "" &&
                    data.proponent !== undefined &&
                    data.proponent_code !== undefined &&
                    data.alocated_funds !== undefined &&
                    data.facility_id !== undefined 
                );
            });
            
            // var divisor = {{$fundsource[0]->proponents->count()}};
            // var dividend = Math.round(formData.length/4);

            var count = {{$pro_count}};
            var to_deduct = 0;
            if(count>0){
                if(count >=5){
                    to_deduct = count/5 * 3;
                }
                // var add1 = Math.floor(formData.length/4);
                formData.splice(formData.length - count);
        }
            // var count = {{$pro_count}};
            // if(count > 0){
            //     formData.splice(count+click);
            // }
            // formData.splice(formData.length - remove_click);
            return formData;
    }

    function display(){
        var sum =0;
        getData().forEach(item=>{
            var funds = parseFloat(item.alocated_funds.replace(/,/g, ''));
            sum+=funds;
        })
        $('.breakdown_total').text('Total Breakdowns: Php '+sum.toLocaleString('en-US', {maximumFractionDigits: 2}));
    }

    $(document).ready(function() {

        $('#breakdown_select').select2({
            placeholder:"Select Facilties"
        });

        $('#proponent').select2({
            tags: true,
            placeholder:"Select/Input Proponent"
        });

        $('#proponent_main').select2({
            placeholder:"Select Proponent"
        });

        $('.clone').on('click', '.clone_pro-btn', function () {
            click = 1 + click;
            $('.loading-container').show();
            var $this = $(this); 

            setTimeout(function () {
                $.get("{{ route('facilities.get', ['type'=>'div']) }}", function (result) {
                    $('.modal-body').append(result);
                    $('.loading-container').css('display', 'none');
                });
            }, 1);  
        });

        $(document).off('click', '.clone .card1 .clone_facility-btn').on('click', '.clone .card1 .clone_facility-btn', function () {
            click = 1 + click;
            $('.loading-container').show();
            var $this = $(this);
            setTimeout(function () {
                $.get("{{ route('facilities.get', ['type'=>'fac']) }}", function (result) {
                    $this.closest('.card').find('.card1:last').append(result);
                    $('.loading-container').hide();
                });
            }, 1);
        });

        $('.btn-secondary').on('click', function() {
            $(document).off('click', '.clone .card1 .clone_facility-btn');
        });


        $(document).on('click', '.clone .remove_pro-btn', function () {
            remove_click = 1 + remove_click;
            getData();
            display();
            $(this).closest('.clone').remove();
            $(this).closest('.clone hr').remove();
          
        });

        $(document).on('click', '.clone .remove_fac-clone', function () {
            $(this).closest('.row').remove();
            remove_click = 1 + remove_click;
            getData();
            display();
        });

        $('#contractForm').submit(function(e) {
            $('.loading-container').show();

            e.preventDefault();

            var sum =0;
            getData().forEach(item=>{
                var funds = parseFloat(item.alocated_funds.replace(/,/g, ''));
                sum+=funds;
            })
            if(sum>{{str_replace(',','',$fundsource[0]->alocated_funds)}}){
                alert('Exceed allocated funds!');
                $('.loading-container').css('display', 'none');
                return false;
            }

            $.ajax({
                type: 'POST',
                url: '{{ route("fundsource.save_breakdowns") }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    breakdowns: getData(),
                    fundsource_id: {{$fundsource[0]->id}}

                },
                success: function (response) {
                    // location.reload();
                    Lobibox.notify('success', {
                        msg: "Successfully created breakdowns!",
                    });
                    $('#create_fundsource').modal('hide');
                    $('.loading-container').css('display', 'none');
                    window.location.href = '{{ route("fundsource") }}';
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
        });
    });
</script>