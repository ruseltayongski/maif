<?php
    use App\Models\TrackingDetails;
    use App\Models\Fundsource;
    use App\Models\Fundsource_Files;
?>
<style>
      .custom-center-align .lobibox-body .lobibox-message {
        text-align: center;
    }
</style>
@extends('layouts.app')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <form method="GET" action="">
                <div class="input-group float-right w-50" style="min-width: 600px;">
                    <input type="text" class="form-control" name="keyword" placeholder="Route No/DV No" value="{{ $keyword }}">
                    <div class="input-group-append">
                        <button class="btn btn-sm btn-info" type="submit"><img src="\maif\public\images\icons8_search_16.png">Search</button> 
                        <button class="btn btn-sm btn-warning text-white" type="submit" name="viewAll" value="viewAll"><img src="\maif\public\images\icons8_eye_16.png">View All</button>
                    </div>
                </div>
                <input type="hidden" class="all_route" id="all_route" name="all_route">

            </form>
            <h4 class="card-title">DISBURSEMENT VERSION V3</h4>
            <p class="card-description">
                MAIF-IPP
            </p>
            @if(isset($dv3) && $dv3->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tracking</th>
                            <th style="min-width:90px;">Route_No</th>
                            <th>Remarks</th>
                            <th>Facility</th>
                            <th style="min-width:150px;">SAA</th>
                            <th>Proponent</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th style="min-width:150px;">Created On</th>
                            <th style="min-width:150px;">Created By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dv3 as $index=> $row)
                            <tr>
                                <td>
                                    <button type="button" class="btn btn-xs col-sm-12" style="background-color:#165A54;color:white;" data-toggle="modal" href="#iframeModal" data-routeId="{{$row->route_no}}" id="track_load" onclick="openModal()">Track</button>
                                </td>
                                <td>
                                    <?php
                                        $routed = TrackingDetails::where('route_no',$row->route_no)
                                            ->count();
                                        if($routed){
                                            $doc_id = TrackingDetails::where('route_no',$row->route_no)
                                            ->orderBy('id','desc')
                                            ->first()
                                            ->id;
                                        }else{
                                            $doc_id= 0;
                                        }
                                    ?>
                                    <a data-dvId="{{$row->id}}" onclick="updateDv3('{{$row->route_no}}')" style="background-color:teal;color:white;width:90px;" type="button" class="btn btn-xs" data-backdrop="static" data-toggle="modal">{{ $row->route_no }}</a>
                                </td>
                                <td>
                                    @if($row->remarks == 0)
                                        Pending
                                    @elseif($row->remarks == 1)
                                        Obligated
                                    @elseif($row->remarks == 2)
                                        Processed
                                    @endif
                                </td>
                                <td>{{$row->facility->name}}</td>
                                <td>
                                    @foreach($row->extension as $item)
                                    <br>
                                        {{$item->proponentInfo->fundsource->saa}}
                                    @endforeach
                                </td>
                                <td>{{$row->extension[0]->proponentInfo->proponent->proponent}}</td>
                                <td>{{date('F j, Y', strtotime($row->date))}}</td>
                                <td>{{number_format($row->total, 2, '.', ',')}}</td>
                                <td>{{date('F j, Y', strtotime($row->created_at))}}</td>
                                <td>{{$row->user->lname .', '. $row->user->fname}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    </table>
                </div>
                @else
                    <div class="alert alert-danger" role="alert" style="width: 100%;">
                        <i class="typcn typcn-times menu-icon"></i>
                        <strong>No disbursement voucher version 3 found!</strong>
                    </div>
                @endif
            <div class="pl-5 pr-5 mt-5">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="create_dv3" role="dialog" style="overflow-y:scroll;">
    <input type="hidden" class="identifier" id="identifier" value="{{$type}}">
    <div class="modal-dialog modal-lg" role="document" style="width:900px">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#17c964;padding:15px; color:white">
                <h4 class="modal-title"><i class="fa fa-plus" style="margin-right:auto;"></i> Disbursement Vouchers (v3)</h4>
                <button type="button" class="close" id="exit" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="color:white;">&times;</span></button>
            </div>
            <div class="dv3_body">
                <div class="modal_content"></div>
            </div>
        </div>
    </div>
</div>

@endsection
@include('modal')
@section('js')
<script>

    var doc_type = @json($type);

    $('.filter-division').select2();
    $('.filter-section').select2();

    function createDv3() {
        $('.modal_body').html(loading);
        var url = "{{ route('dv3.create') }}";
        $.ajax({
            url: url,
            type: 'GET',
            success: function(result) {
                $('.modal_body').html(result);
            }
        });
    }

    function openModal() {
        var routeNoo = event.target.getAttribute('data-routeId'); 
        var src = "http://192.168.110.17/dts/document/trackMaif/" + routeNoo;

        var base_url = "{{ url('/') }}";
        $('.modal-body').append('<img class="loadingGif" src="' + base_url + '/public/images/loading.gif" alt="Loading..." style="display:block; margin:auto;">');

        var iframe = $('#trackIframe');

        iframe.hide();

        iframe.attr('src', src);
    
        iframe.on('load', function() {
            iframe.show(); 
            $('.loadingGif').css('display', 'none');
        });

        $('#myModal').modal('show');
    }

    function updateDv3(route_no){
        $('#confirm_dv').modal('hide');
        $('#create_dv3').modal('show');
        $('.dv3_body').html(loading);
        $.get("{{url('dv3/update').'/'}}"+route_no, function(result){
            $('.dv3_body').html(result);
        });
    }

    function obligate(){
        $('#confirm_dv').modal('hide');
        con = 1;
        $('#create_dv3').modal('show');
        $('.dv3_body').html(loading);
        $.get("{{url('dv3/update').'/'}}"+route, function(result){
            $('.dv3_body').html(result);
        });
    }

    var util_id = 0;
    var con = 0;

    function confirmed(){

        var cs = $('.editable-input').val();
        if(cs == ''){
            Swal.fire({
                icon: "error",
                title: "Empty ORS No",
                text: " Ors no is required to confirm this data",
                timer: 1000,
                showConfirmButton: false
            });
        }else{
            $('#checkbox_' + util_id).prop('checked', true);

            var checkboxes = $('.confirm_check');
            var allChecked = checkboxes.filter(':not(:checked)').length == 0;

            if (allChecked) {
                $('.budget_obligate').css('display', 'block');
            } else {
                $('.budget_obligate').css('display', 'none');
            }
            $('#budget_confirm').modal('hide');
        }
    }
    var route;
    function displayFunds(route_no, proponent, id){
        util_id = id;
        route = route_no;
        $('#budget_confirm').modal('show');
        $('.confirm_budget').html(loading);
        $.get("{{ url('confirm-budget').'/' }}" + id, function(result) {
            $('.confirm_budget').html(result);
        });
    }
    
</script>
@endsection


