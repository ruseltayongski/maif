<style>
    hr {
        border: 1px solid;
        color: grey;
    }
    .clone:last-child .clone_facility-btn {
        z-index: 1000; 
    }
    
    .loading-container {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1000;
        display: none; 
    }

    .loading-spinner {
        width: 100%; 
        height: 100%; 
    }

</style>

<form id="contractForm" method="POST" action="{{ route('fundsource.save_breakdowns') }}">
    
    <div class="modal-body">
        <h4>{{$fundsource[0]->saa}} : PhP {{number_format($fundsource[0]->alocated_funds, 2, '.', ',')}}</h4>
        @csrf
        <br>
        <br>

        @if($fundsource[0]->proponents->count() > 0)
            @foreach($fundsource[0]->proponents as $pro)

                <div class="clone">
                    <div class="card" style="border:none;">
                        <div class="row">
                            <div class="col-md-5">
                                <b><label>Proponent:</label></b>
                                <div class="form-group">
                                    <input type="text" class="form-control proponent" name="proponent[]" value="{{$pro->proponent}}">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <b><label>Proponent Code:</label></b>
                                <div class="form-group" style="display: flex; align-items: center;">
                                    <input type="text" class="form-control proponent_code" name="proponent_code[]" value="{{$pro->proponent_code}}" style="flex: 1; width:1000px;">
                                    <button type="button" class="form-control clone_pro-btn" style="width: 10px; margin-left: 5px; color:white; background-color:#00688B">+</button>
                                </div>
                            </div>
                        </div>
                        @if($pro->proponentInfo->count() >0)

                        @foreach($pro->proponentInfo as $proInfo)
                        <div class="card1">
                            <div class="row">
                                <div class="col-md-5">
                                <label>Facility:</label>
                                    <div class="form-group">
                                        <div class="facility_select">
                                            <select class="form-control break_fac" id="{{$proInfo->id}}" name="facility_id[]" 
                                            @if($proInfo->alocated_funds != $proInfo->remaining_balance)
                                                disabled
                                            @endif
                                            >
                                                <option value="">Please select facility</option>
                                                @foreach($facilities as $facility)
                                                    <option value="{{ $facility->id }}" {{$proInfo->facility_id == $facility->id ? 'selected' :''}}>{{ $facility->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <label>Allocated Funds:</label>
                                    <div class="form-group">
                                        <div class="form-group" style="display: flex; align-items: center;">
                                            <input type="text" class="form-control alocated_funds" id="alocated_funds[]" name="alocated_funds[]" oninput="calculateFunds(this)" onkeyup="validateAmount(this)" value="{{number_format(str_replace(',', '',$proInfo->alocated_funds), 2, '.', ',')}}" style="flex: 1; width:160px;"
                                            @if($proInfo->alocated_funds != $proInfo->remaining_balance)
                                                readonly
                                            @endif
                                            >
                                            <button type="button" class="form-control btn-info clone_facility-btn" style="width: 5px; margin-left: 5px; color:white; background-color:#355E3B">+</button>
                                            <button type="button" id="transfer_funds" href="#transfer_fundsource" onclick="transferFunds({{ $fundsource[0]->id }}, {{ $proInfo->proponent_id }}, {{ $proInfo->facility_id }})" class="form-control btn-info transfer_funds" style="width: 5px; margin-left: 5px; color:white; background-color:#01796F"><i class="typcn typcn-arrow-right-thick menu-icon"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
                            $(document).ready(function() {
                                $("#"+"{{ $proInfo->id}}").select2();
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
                                        <select class="form-control break_fac" id="breakdown_select" name="facility_id[]" >
                                            <option value="">Please select facility</option>
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
                                        <input type="text" class="form-control alocated_funds" id="alocated_funds[]" name="alocated_funds[]" onkeyup="validateAmount(this)" oninput="calculateFunds(this)" placeholder="Allocated Fund" style="flex: 1; width:160px;">
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
                            <b><label>Proponent:</label></b>
                            <div class="form-group">
                                <input type="text" class="form-control proponent" name="proponent[]" placeholder="Proponent">
                            </div>
                        </div>
                        <div class="col-md-7">
                            <b><label>Proponent Code:</label></b>
                            <div class="form-group" style="display: flex; align-items: center;">
                                <input type="text" class="form-control proponent_code" name="proponent_code[]" placeholder="Proponent Code" style="flex: 1; width:1000px;">
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
                                        <select class="form-control break_fac" id="breakdown_select" name="facility_id[]" >
                                            <option value="">Please select facility</option>
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
                                        <input type="text" class="form-control alocated_funds" id="alocated_funds[]" name="alocated_funds[]" onkeyup="validateAmount(this)" oninput="calculateFunds(this)" placeholder="Allocated Fund" style="flex: 1; width:160px;">
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
<div class="loading-container">
    <img src="public\images\loading.gif" alt="Loading..." class="loading-spinner">
</div>



<script src="{{ asset('admin/js/select2.js?v=').date('His') }}"></script>
<script>
    var timer;
    $('.btn-secondary').on('click', function(){

        // $('.modal_body').empty();
    });

    function calculateFunds(inputElement){
        clearTimeout(timer);
        timer = setTimeout(() => {
                var sum =0;
                getData().forEach(item=>{
                    var funds = parseFloat(item.alocated_funds.replace(/,/g, ''));
                    sum+=funds;
                })
                console.log('sum', sum);
                if(sum>{{str_replace(',','',$fundsource[0]->alocated_funds)}}){
                    alert('Exceed allocated funds!');
                    inputElement.value = '';
                }
        }, 1000);
    }
    function getData(){
        var formData = [];
            var num=0, nu=0;
            $('.clone .card').each(function (index, clone) {
                num++;
                var proponent = $(clone).find('.proponent').val();
                var proponent_code = $(clone).find('.proponent_code').val();;

                $(clone).find('.row').each(function (rowIndex, row) {
                    console.log('check', )
                    nu++;
                    var facility_id = $(row).find('.break_fac').val();
                    if(facility_id !== '' && facility_id !== undefined){
                        console.log('djfkdf', facility_id);

                        var allocated_funds = $(row).find('.alocated_funds').val();

                        var cloneData = {
                            proponent: proponent,
                            proponent_code: proponent_code,
                            facility_id: facility_id,
                            alocated_funds: allocated_funds,
                            remaining_balance: allocated_funds,
                            fundsource_id:{{$fundsource[0]->id}}

                        };

                        formData.push(cloneData);
                    }
                    
                });
            });
            console.log('num', num);
            console.log('nu', nu);
            console.log('Collected Data:', formData);

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
            
            var divisor = {{$fundsource[0]->proponents->count()}};
            var dividend = formData.length;
            console.log('htrry', dividend % divisor);
            console.log('htrry', dividend);
            console.log('htrry', dividend/divisor );
            console.log('htrry', dividend % divisor );

            var count = {{$pro_count}};
            if(count>0){
                formData.splice(formData.length - count);
            }

            console.log('Collected Data:', formData);
            return formData;
    }

    $(document).ready(function() {
        $('#breakdown_select').select2();
        $('.clone').on('click', '.clone_pro-btn', function () {
            console.log('here');
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
            console.log('click fac');
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
            console.log('remove fac');

            $(this).closest('.clone').remove();
            $(this).closest('.clone hr').remove();
        });

        $(document).on('click', '.clone .remove_fac-clone', function () {
            $(this).closest('.row').remove();
        });

        $('#contractForm').submit(function(e) {
            $('.loading-container').show();

            console.log('contract');
            e.preventDefault();
            console.log('Collected Data:', getData());

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
                    console.log('res', response);
                    window.location.href = '{{ route("fundsource") }}';
                    $('.loading-container').css('display', 'none');
                    Lobibox.notify('success', {
                        msg: 'Successfully created a breakdowns!'
                    });
                },
                error: function (error) {
                    console.error('Error:', error);

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