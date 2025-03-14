@extends('layouts.app')
@section('content')
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<div class="container-fluid col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <form method="GET" action="">
                <div class="input-group float-right w-50" style="min-width: 600px;">
                    <input type="text" class="form-control" name="keyword" placeholder="Search..." value="">
                    <div class="input-group-append">
                        <button class="btn btn-sm btn-info" type="submit"><img src="\maif\public\images\icons8_search_16.png">Search</button>
                    </div>
                </div>
            </form>
            <h4 class="card-title">USER ACTIVATION</h4>
            <p class="card-description">
                MAIF-IPP
            </p>
            @if(isset($registrations) && $registrations->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th style="width:50px">Type</th>
                            <th style="width:150px">Account</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th style="width:100px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($registrations as $row)
                            <tr>
                                <td class="td">{{$row->fname .' '.$row->lname}}</td>
                                <td class="td">
                                    {{ 
                                        $row->user_type == 1 ? 'Proponent' : 
                                        ($row->user_type == 2 ? 'Facility' : 'MPU') 
                                    }}
                                </td>
                                <td class="td">
                                    {{ 
                                        $row->user_type == 1 ? $row->proponent->proponent : 
                                        ($row->user_type == 2 ? $row->facility->name : 'MPU') 
                                    }}
                                </td>
                                <td class="td">{{$row->email}}</td>
                                <td class="td">{{$row->contact_no}}</td>
                                <td class="td">
                                    <a href="{{ route('verify.user', ['id' => $row->id]) }}" type="button" class="btn btn-xs btn-info" style="color:white; width:80px;">Verify</a>
                                    <button type="button" href="#user_cancel" style="width:100%; color:white; border" data-toggle="modal" data-backdrop="static" class="btn btn-xs btn-warning" onclick="cancel({{$row->id}})">Cancel</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-danger" role="alert" style="width: 100%;">
                <i class="typcn typcn-times menu-icon"></i>
                    <strong>No new account to be registered!</strong>
                </div>
            @endif
            <div class="pl-5 pr-5 mt-5">
                {!! $registrations->appends(request()->query())->links('pagination::bootstrap-5') !!}
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="user_cancel" role="dialog" style="overflow-y:scroll;">
    <div class="modal-dialog modal-lg" role="document" style="width:700px">
        <div class="modal-content">
            <div class="modal-header" style="text-align:center">
                <h5 class="text-success modal-title">CANCEL USER REGISTRATION</h5>
            </div>
            <div class="modal-body" style="display: flex; flex-direction: column; align-items: center;">
                <form id="cancel_user" style="width:100%; font-weight:1px solid black" method="get" >
                    @csrf
                    <div style="text-align:center">
                        <textarea class="form-control" placeholder="Remarks" name="remarks" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-sm btn-secondary" data-dismiss="modal">CLOSE</button>
                        <button type="submit" class="btn-sm btn-success submit_btn">SUBMIT</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="add_user" tabindex="-1" role="dialog" aria-hidden="true" style="opacity:1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="text-success" id="title"><i style = "font-size:30px"class="typcn typcn-user-add-outline menu-icon"></i>MPU USER PERSONAL INFO</h4><hr />
                @csrf
            </div>
            <div class="modal_body">
                <form id="contractForm" method="POST" action="{{ route('mpu') }}">
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lname">DTR Userid</label>
                                    <input type="text" class="form-control user_id" style="width:220px;" id="user_id" name="user_id" placeholder="DTR USERID" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                            </div>
                        </div>
                        <div class="row">
                           
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fname">GENDER</label>
                                    <select class="form-control gender" style="width:220px;" id="gender" name="gender">
                                        <option value="">GENDER</option>
                                        <option value="M">MALE</option>
                                        <option value="F">FEMALE</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lname">Date of Birth</label>
                                    <input type="date" class="form-control dob" style="width:220px;" id="dob" name="dob" placeholder="Date of Birth">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fname">Contact No</label>
                                    <input type="number" class="form-control contact_no" style="width:220px;" id="contact_no" name="contact_no" placeholder="Contact No" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lname">Email Address</label>
                                    <input type="email" class="form-control email_add" style="width:220px;" id="email_add" name="email_add" placeholder="sample@gmail.com" required>
                                </div>
                            </div>
                        </div>
                        
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="close_modal" data-dismiss="modal">Close</button>
                        <button type="submit" id="create_pat_btn" class="btn btn-primary">Activate User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script src="{{ asset('admin/js/select2.js?v=').date('His') }}"></script>
    <script>
        // $('#gender').select2();
        function cancel(id){
            $('#user_cancel').modal('show');
            $('#cancel_user').attr('action', '{{ route("cancel.user", [":id"]) }}'.replace(':id', id));
        }
    </script>
@endsection
