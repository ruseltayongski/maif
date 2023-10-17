@extends('layouts.app')

@section('content')

<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <form method="GET" action="{{ route('fundsource') }}">
                <div class="input-group float-right w-50" style="min-width: 600px;">
                    <input type="text" class="form-control" name="keyword" placeholder="SAA" value="{{ $keyword }}" aria-label="Recipient's username">
                        <div class="input-group-append">
                        <button class="btn btn-sm btn-info" type="submit">Search</button>
                        <button class="btn btn-sm btn-warning text-white" type="submit" name="viewAll" value="viewAll">View All</button>
                        <button type="button" href="#create_fundsource" onclick="createFundSource()" data-backdrop="static" data-toggle="modal" class="btn btn-success btn-md">Create</button>
                    </div>
                </div>
            </form>
            <h4 class="card-title">Manage Patients</h4>
            <p class="card-description">
                MAIF-IP
            </p>
            <div class="table-responsive">
                <table class="table table-striped">
                <thead>
                    <tr>
                        <th>
                            SAA
                        </th>
                        <th>
                            Proponent
                        </th>
                        <th>
                            Code Proponent
                        </th>
                        <th>
                            Facility
                        </th>
                        <th>
                            Allocated Fund
                        </th>
                        <th>
                            Created By
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fundsources as $fund)
                        <tr>
                            <td >
                                {{ $fund->saa }}
                            </td>
                            <td>
                                {{ $fund->proponent }}
                            </td>
                            <td>
                                {{ $fund->code_proponent }}
                            </td>
                            <td>
                                {{ $fund->facility->description }}
                            </td>
                            <td>
                                {{ $fund->alocated_funds }}
                            </td>
                            <td>
                                {{ $fund->encoded_by->name }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
            <div class="pl-5 pr-5 mt-5">
                {!! $fundsources->appends(request()->query())->links('pagination::bootstrap-5') !!}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="create_fundsource" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Fund Source</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal_body">
                
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script>
        function createFundSource() {
            $('.modal_body').html(loading);
            var url = "{{ route('fundsource.create') }}";
            setTimeout(function(){
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(result) {
                        $('.modal_body').html(result);
                    }
                });
            },500);
        }
    </script>
@endsection
