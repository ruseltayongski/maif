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
                    <input type="text" class="form-control" name="keyword" placeholder="Search..." value="{{ $keyword }}">
                    <div class="input-group-append">
                        <button class="btn btn-sm btn-info" type="submit"><img src="\maif\public\images\icons8_search_16.png">Search</button>
                        <button class="btn btn-sm btn-warning text-white" type="submit" name="viewAll" value="viewAll"><img src="\maif\public\images\icons8_eye_16.png">View All</button>
                    </div>
                </div>
            </form>
            <h4 class="card-title">USER ACTIVATION</h4>
            <p class="card-description">
                MAIF-IPP
            </p>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>@sortablelink('fname', 'First Name')
                            <th>@sortablelink('lname', 'Last Name')
                            <th>@sortablelink('birthdate', 'Birthdate')
                            <th>@sortablelink('user_type', 'Type')
                            <th>
                                <form method="GET" action="">
                                    <select id="account" class="form-control account" name="account_type" style="text-align:center" onchange="this.form.submit()">
                                        <option></option>
                                        <option value="all">All</option>
                                        @foreach($type as $row)
                                            <option value="{{ $row }}" {{ $row == $account_type ? 'selected': '' }}>
                                                {{ 
                                                    $row == 1 ? 'Proponent' : 
                                                    ($row == 2 ? 'Facility' : 'MPU') 
                                                }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </th>
                            <th>@sortablelink('email', 'Email')
                            <th>@sortablelink('contact_no', 'Contact No')
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($registrations) && $registrations->count() > 0)

                            @foreach($registrations as $row)
                                <tr>
                                    <td class="td">{{ $row->fname }}</td>
                                    <td class="td">{{ $row->lname }}</td>
                                    <td>{{ date('F j, Y', strtotime($row->birthdate)) }} </td>
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
                                    <td>{{ $row->contact_no }}</td>
                                    <td class="td">
                                        <a href="{{ route('verify.user', ['id' => $row->id]) }}" type="button" class="btn btn-xs btn-info" style="color:white; width:80px;border:0px">Verify</a>
                                        <button type="button" href="#user_cancel" style="width:80px; color:white; border:0px" data-toggle="modal" data-backdrop="static" class="btn btn-xs btn-warning" onclick="cancel({{$row->id}})">Cancel</button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" style="background-color:white">
                                    <div class="alert alert-danger" role="alert" style="width: 100%; ">
                                        <i class="typcn typcn-times menu-icon"></i>
                                        <strong>No data found!</strong>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
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
        $('#account').select2({
            tags:true,
            placeholder:'Account'
        });
        function cancel(id){
            $('#user_cancel').modal('show');
            $('#cancel_user').attr('action', '{{ route("cancel.user", [":id"]) }}'.replace(':id', id));
        }
    </script>
@endsection
