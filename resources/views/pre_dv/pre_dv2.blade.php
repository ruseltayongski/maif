<?php
use App\Models\TrackingMaster;
use App\Models\TrackingDetails; 
?>
@extends('layouts.app')
@section('content')
<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="float-right">
                <div class="input-group">
                    <form method="GET" action="">
                        <div class="input-group">
                            <input type="text" class="form-control" name="keyword" placeholder="Search..." value="{{$keyword}}" id="search-input" style="width:350px;">
                            <div class="input-group-append">
                                <button class="btn btn-sm btn-info" type="submit"><img src="\maif\public\images\icons8_search_16.png">Search</button>
                                <button class="btn btn-sm btn-warning text-white" type="submit" name="viewAll" value="viewAll"><img src="\maif\public\images\icons8_eye_16.png">View All</button>
                                <button type="submit" value="filt" style="display:none; background-color:green; color:white; width:79px; font-size:11px" name="filt_dv" id="filt_dv" class="btn btn-xs"><i class="typcn typcn-filter menu-icon"></i>&nbsp;&nbsp;&nbsp;Filter</button>
                                <button type="button" id="release_btn" data-target="#releaseTo" style="display:none; background:teal; color:white" onclick="putRoutes($(this))" data-backdrop="static" data-toggle="modal" class="btn btn-md">Release All</button>
                                <input type="hidden" class="all_route" id="all_route" name="all_route">
                            </div>
                        </div>
                        <div class = "input-group">
                            <input type="text" style="text-align:center" class="form-control" id="dates_filter" value="{{ $dates_generated }}" name="dates_filter" />
                            <button type="submit" id="gen_btn" style="background-color:teal; color:white; width:79px; border-radius: 0; font-size:11px" class="btn btn-xs"><i class="typcn typcn-calendar-outline menu-icon"></i>Generate</button>
                        </div>
                        <input type="hidden" id="generate" name="generate" value="{{$generate}}"></input>
                        <input type="hidden" name="f_id" class="facility_id" value="{{ implode(',',$f_id) }}">
                        <input type="hidden" name="p_id" class="proponent_id" value="{{ implode(',',$p_id) }}">
                        <input type="hidden" name="b_id" class="user_id" value="{{ implode(',',$b_id) }}">
                        <input type="hidden" name="s_id" class="stat_id" value="{{ implode(',',$s_id) }}">
                    </form>
                </div>
            </div>  
            <h4 class="card-title">PRE - DV (v2)</h4>
            <p class="card-description">
                MAIF-IPP
            </p>
            <div class="table-responsive">
            @if(count($results) > 0)
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="padding:5px; min-width:300px"></th>
                            <th style="text-align:center;min-width:150px ">
                                <a class="text-info select_all">Release All</a>
                            </th>
                            <th>Route</th>
                            <th>Remarks</th>
                            <th>Forwarded</th>
                            <th class="status" style="min-width:100px">Status
                                <i id="stat_i" class="typcn typcn-filter menu-icon"><i>
                                <div class="filter" id="stat_div" style="display:none;">
                                    <select style="width: 120px;" id="stat_select" name="stat_select" multiple>
                                        <?php $item = [0,1,2]; ?>
                                        @foreach($item as $d)
                                            <option value="{{ $d }}" {{ is_array($s_id) && in_array($d, $s_id) ? 'selected' : '' }}>
                                                {{ $d == 0? 'Pending' : ($d == 1 ? 'Obligated' : 'Paid') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>  
                            </th>
                            <th class="facility">Facility
                                <i id="fac_i" class="typcn typcn-filter menu-icon"><i>
                                <div class="filter" id="fac_div" style="display:none;">
                                    <select style="width: 120px;" id="fac_select" name="fac_select" multiple>
                                        <?php $check = []; ?>
                                        @foreach($facility_data as $index => $d)
                                            @if(!in_array($d->id, $check))
                                                <option value="{{ $d->id }}" {{ is_array($f_id) && in_array($d->id, $f_id) ? 'selected' : '' }}>
                                                    {{ $d->name}}
                                                </option>
                                                <?php $check[] = $d->id; ?>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>  
                            </th>
                            <th class="proponent" style="min-width: 300px">Proponent
                                <i id="proponent_i" class="typcn typcn-filter menu-icon"><i>
                                <div class="filter" id="proponent_div" style="display:none;">
                                    <select style="width: 120px;" id="proponent_select" name="proponent_select" multiple>
                                        <?php $check = []; ?>
                                        @foreach($pros as $d)
                                            @if(!in_array($d->id, $check))
                                                <option value="{{ $d->id }}" {{ is_array($p_id) && in_array($d->id, $p_id) ? 'selected' : '' }}>
                                                    {{ $d->proponent }}
                                                </option>
                                                <?php $check[] = $d->id; ?>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>  
                            </th>
                            <th style="min-width:100px">Grand Total</th>
                            <th class="user" style="min-width:120px">Created By
                                <i id="by_i" class="typcn typcn-filter menu-icon"><i>
                                <div class="filter" id="by_div" style="display:none;">
                                    <select style="width: 120px;" id="by_select" name="by_select" multiple>
                                        <?php $check = []; ?>
                                        @foreach($results as $index => $d)
                                            @if(!in_array($d->user->userid, $check))
                                                <option value="{{ $d->user->userid }}" {{ is_array($b_id) && in_array($d->user->userid, $b_id) ? 'selected' : '' }}>
                                                    {{ $d->user->fname .' '.$d->user->lname }}
                                                </option>
                                                <?php $check[] = $d->user->userid; ?>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>  
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $index => $row)
                            <tr>
                                <td class="td" style="padding:5px;text-align:left">
                                    @if($row->new_dv)
                                        <?php
                                            $routed = TrackingDetails::where('route_no',$row->new_dv->route_no)
                                                ->count();
                                            if($routed){

                                                $doc = TrackingDetails::where('route_no',$row->new_dv->route_no)
                                                    ->orderBy('id','desc')
                                                    ->first();

                                                $doc_id = $doc->id;
                                                $data_action = $doc->action;
                                                
                                                if($data_action){
                                                    $stat = $data_action;
                                                }else{
                                                    $stat = "none";
                                                }
                                                
                                            }else{
                                                $doc_id= 0;
                                                $routed = 0;
                                                $stat = "none";
                                            }
                                        ?>                                   
                                        <button type="button" class="btn btn-xs" style="background-color:#165A54; border-radius:0; color:white;" data-toggle="modal" href="#iframeModal" data-routeId="{{$row->new_dv->route_no}}" id="track_load" onclick="openModal()">Track</button>
                                        <a href="{{ route('new_dv.pdf', ['id' => $row->id]) }}" style="background-color:green; border-radius:0; color:white; width:50px;" target="_blank" type="button" class="btn btn-xs">Print</a>
                                        <button data-toggle="modal" data-target="#releaseTo" data-id="{{ $doc_id }}" data-route_no="{{ $row->new_dv->route_no }}" onclick="putRoute($(this))" style="background-color:#1E90FF; border-radius:0; color:white; width:85px;" type="button" class="btn btn-xs">Release To</button>
                                        <button data-toggle="modal" data-target="#acceptModal" data-id="{{ $doc_id }}" data-route_no="{{ $row->new_dv->route_no }}" onclick="acceptModal({{ $doc_id }}, '{{ $row->new_dv->route_no }}')" style="background-color:blue; border-radius:0; color:white; width:85px; display: inline-block" type="button" class="btn btn-xs accept_document">Accept</button>
                                    @else
                                        <span class="text-danger"><i>dv is not yet created</i></span>
                                    @endif
                                </td>
                                @if($row->new_dv)
                                    <td style="padding:5px;text-align:center" class="group-release" data-route_no="{{ $row->new_dv->route_no }}" data-id="{{ $doc_id }}" >
                                        <input type="checkbox" style="width: 60px; height: 20px;" name="release_dv[]" id="releaseDvId_{{ $index }}" 
                                            class="group-releaseDv" >
                                    </td>
                                @else
                                    <td></td>
                                @endif
                                <td>
                                    @if($row->new_dv)
                                        {{$row->new_dv->route_no}}
                                    @endif
                                </td>
                                <td>
                                    @if($row->new_dv)
                                        @if($row->new_dv->remarks != null)
                                            <a href="#update_remarks" onclick="updateRemarks('{{$row->new_dv->route_no}}', '{{($row->new_dv->remarks ==null)?0:$row->new_dv->remarks}}')" data-backdrop="static" data-toggle="modal">{{$row->new_dv->remarks}}</a>
                                        @else
                                            <a href="#update_remarks" onclick="updateRemarks('{{$row->new_dv->route_no}}', '{{($row->new_dv->remarks ==null)?0:$row->new_dv->remarks}}')" data-backdrop="static" data-toggle="modal" type="button" class="btn btn-xs"><i class="typcn typcn-edit menu-icon" style="color:green; font-size: 24px; width:200px;"></i></a>
                                        @endif
                                    @endif
                                </td>
                                <td style="text-align:center">
                                    @if(isset($routed) && $routed > 1)
                                        <i class="typcn typcn-tick menu-icon" style="font-size: 24px; width:200px;"></i>
                                    @endif
                                </td>
                                <td>{{ $row->new_dv ? ($row->new_dv->status == 0? 'Pending' : ($row->new_dv->status == 1 ? 'Obligated': 'Paid')):'' }}</td>
                                <td><a data-toggle="modal" data-backdrop="static" href="#view_v2" onclick="viewV1({{$row->id}})">{{ $row->facility ? $row->facility->name : $row->id }}</a></td>
                                <td>
                                    @foreach($row->extension as $index => $data)
                                        {{$data->proponent->proponent}}
                                        @if($index + 1 % 2 == 0)
                                        <br>
                                        @endif
                                        
                                        @if($index < count($row->extension) - 1)
                                            ,
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{number_format(str_replace(',','',$row->grand_total), 2, '.',',')}}</td>
                                <td>{{$row->user->lname .', '.$row->user->fname}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-danger" role="alert" style="width: 100%; margin-top:5px;">
                    <i class="typcn typcn-times menu-icon"></i>
                    <strong>No data found!</strong>
                </div>
            @endif
            </div>
            <div class="alert alert-info" role="alert" style="width: 100%; margin-top:5px;">
                <strong>Total number of data generated: {{ count($results) }}</strong>
            </div>
            <div class="pl-5 pr-5 mt-5">
                {!! $results->appends(request()->query())->links('pagination::bootstrap-5') !!}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="view_v2" role="dialog" style="overflow-y:scroll;">
    <div class="modal-dialog modal-lg" role="document" style="width:1000px">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#17c964;padding:15px; color:white">
                <h4 class="modal-title"><i class="fa fa-plus" style="margin-right:auto;"></i>DV ( new version )</h4>
                <button type="button" class="close" id="exit" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="color:white;">&times;</span></button>
            </div>
            <div class="pre_body" style="display: flex; flex-direction: column; align-items: center; padding:15px">

            </div>
        </div>
    </div>
</div>

@include('modal')
@endsection
@section('js')
<script src="{{ asset('admin/vendors/daterangepicker-master/moment.min.js?v=1') }}"></script>
<script src="{{ asset('admin/vendors/daterangepicker-master/daterangepicker.js?v=1') }}"></script>
<script>

    $('#gen_btn').on('click', function(){
        $('#generate').val(1);
    });

    $('#dates_filter').daterangepicker();   

    $('.filter-division').select2();
    $('.filter-section').select2();

    $('#fac_select').select2();
    $('#by_select').select2();
    $('#proponent_select').select2();
    $('#stat_select').select2();

    $('.facility').on('click', function(){
        $('#fac_div').css('display', 'block');
    });

    $('.user').on('click', function(){
        $('#by_div').css('display', 'block');
    });

    $('.filter').on('click', function(){
        $('#filt_dv').css('display', 'block');
    });

    $('.proponent').on('click', function(){
        $('#proponent_div').css('display', 'block');
    });

    $('.status').on('click', function(){
        $('#stat_div').css('display', 'block');
    });

    $('#filt_dv').on('click', function(){
        $('.facility_id').val($('#fac_select').val());
        $('.userid').val($('#by_select').val());
        $('.proponent_id').val($('#proponent_select').val());
        $('.stat_id').val($('#stat_select').val());
    });

    function viewV1(id) {
        $('.pre_body').empty();
        $('.pre_body').html(loading);

        console.log('id', id);
        $.get("{{ url('pre-dv/v2/').'/' }}" + id, function(result) {
            $('.pre_body').html(result);
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

    function putRoutes(form){
        $('#route_no').val($('#all_route').val());
        $('#currentID').val($('#release_btn').val());
        $('#multiple').val('multiple');
        $('#op').val(0);
    }

    function putRoute(form){
        var route_no = form.data('route_no');
        $('#route_no').val(route_no);
        $('#op').val(0);
        $('#currentID').val(form.data('id'));
        $('#multiple').val('single');
    }

    var accept_id;
    var accept_route_no;
    function acceptModal(id, route_no){
        console.log('id', id);
        console.log('route_no', route_no);
        accept_id = id;
        accept_route_no = route_no;
    }

    $('.confirmAccept').on('click', function(){
        console.log('id', accept_id);
        console.log('route_no', accept_route_no);
        var remarks = $('#accept_remarks').val();
        $.ajax({
            type: 'POST',
            url: '{{ route("document.accept") }}',
            data: {
                _token: '{{ csrf_token() }}',
                id : accept_id,
                route_no : accept_route_no,
                remarks : remarks
            },
            success: function (response) {
                // location.reload();
                Lobibox.notify('success', {
                    msg: "Successfully accepted this document",
                });
                location.reload();
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

    // $('.confirmAccept').click(function(){
    //         var id = $('#acceptModal').data('id');
    //         var route_no = $('#acceptModal').data('route');
    //         var remarks = $('#accept_remarks').val();
    //         var _token = "{{ csrf_token() }}";
    //         $('[data-id=' + id + ']').addClass('hide');
    //         $('.loading').show();
    //         $.ajax({
    //             url: url,
    //             type: 'POST',
    //             data: {
    //                 id:id,
    //                 remarks:remarks,
    //                 _token: _token
    //             },
    //             success: function(data){
    //                 $(document).ready(function () {
    //                     insertFirebase({
    //                         "route_no" : data.route_no,
    //                         "section_owner_id" : data.section_owner_id,
    //                         "user_accepted_name" : data.user_accepted_name,
    //                         "section_accepted_id" : data.section_accepted_id,
    //                         "section_accepted_name" : data.section_accepted_name,
    //                         "remarks" : data.remarks,
    //                         "status" : data.status
    //                     });
    //                     countIncoming += 1;
    //                     var count = incomingFunction();
    //                     $('.badgeIncoming').html(count-countIncoming);
    //                     Lobibox.notify('success', {
    //                         msg: 'Accepted successfully!'
    //                     });
    //                     $('.loading').hide();
    //                     if(count-countIncoming == 0){
    //                         location.reload();
    //                     }
    //                     appendOutgoing(id,route_no);
    //                 });
    //             }
    //         });
    //     });

    function updateRemarks(route_no, remarks){
        if(remarks != 0){
            $('.text_remarks').val(remarks);
        }
        $('.remarks_id').val(route_no);

        var editRoute = `{{ route('dv2.remarks') }}`;
        $('#remarks_update').attr('action', editRoute);
    }

    $('.filter-division').on('change',function(){
        // checkDestinationForm();
        var id = $(this).val();
        $('.filter-section').html('<option value="">Select section...</option>')
        $.get("{{ url('getsections').'/' }}"+id, function(result) {
            $.each(result, function(index, optionData) {
                $('.filter-section').append($('<option>', {
                    value: optionData.id,
                    text: optionData.description
                }));  
            });
        });
    });

    var s_ident = 0; 

     //select_all
    $('.select_all').on('click', function(){
        if(s_ident == 0){
            document.getElementById('release_btn').style.display = 'inline-block';
            $('.group-releaseDv').prop('checked', true);
            $('.group-releaseDv').trigger('change');
            s_ident = 1; 
        }else{
            document.getElementById('release_btn').style.display = 'none';
            $('.group-releaseDv').prop('checked', false);
            $('.group-releaseDv').trigger('change');
            s_ident = 0; 
        }
    });

    $('.group-releaseDv').change(function () {
        document.getElementById('release_btn').style.display = 'inline-block';
           
        var checkedMailBoxes = $('.group-releaseDv:checked');
        var ids = [];
        var routes = [];

        checkedMailBoxes.each(function () {
            var doc_id = $(this).closest('.group-release').data('id');
            var route = $(this).closest('.group-release').data('route_no');
            ids.push(doc_id);
            routes.push(route);
        });
        if(ids.length ==  0){
            document.getElementById('release_btn').style.display = 'none';
        }
        $('#release_btn').val(ids);
        $('#all_route').val(routes);
    });

</script>
@endsection