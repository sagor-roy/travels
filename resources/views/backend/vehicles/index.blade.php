@extends('layouts.backend')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Vehicles List
                <small>Control Panel</small>
            </h1>
            <ol class="breadcrumb">
                 <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li>List</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <div class="box box-primary">
                <div class="box-header with-border text-right">
                    <a href="{{ route('admin.fleet.vehicles.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>
                        Add</a>
                </div>
                <!-- /.box-header -->
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Regis. NO</th>
                                <th>Fleet Type</th>
                                <th>Engine No</th>
                                <th>Model No</th>
                                <th>Chasis No</th>
                                <th>Owner</th>
                                <th>Owner Ph.</th>
                                <th>Brand</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->regis }}</td>
                                    <td>{{ $item->types->type }}</td>
                                    <td>{{ $item->engine_no }}</td>
                                    <td>{{ $item->model_no }}</td>
                                    <td>{{ $item->chasis_no }}</td>
                                    <td>{{ $item->owner }}</td>
                                    <td>{{ $item->owner_phone }}</td>
                                    <td>{{ $item->brand }}</td>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" data-id="{{ $item->id }}"
                                                {{ $item->status == 1 ? 'checked' : '' }} name="status">
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.fleet.vehicles.destroy', $item->id) }}" class="d-flex"
                                            method="POST">
                                            @csrf
                                            @method('delete')
                                            <a class="btn btn-xs btn-primary"
                                                href="{{ route('admin.fleet.vehicles.edit', $item->id) }}">Edit</a>
                                            <button onclick="return confirm('Are you sure to Delete?')" class="btn btn-xs btn-danger" type="submit">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>SL</th>
                                <th>Regis. NO</th>
                                <th>Fleet Type</th>
                                <th>Engine No</th>
                                <th>Model No</th>
                                <th>Chasis No</th>
                                <th>Owner</th>
                                <th>Owner Ph.</th>
                                <th>Brand</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </section>
        <!-- /.content -->
    </div>

@section('script')
    <script>
        $(function() {
            'use strict';

            $('input[name="status"]').on('change', function(event) {
                event.preventDefault();
                let status = $(this).is(':checked') ? 1 : 0;
                let id = $(this).data('id');
                $.ajax({
                    url: "{{ url('admin/fleet/vehicles/status') }}/" + id,
                    type: 'put',
                    data: {
                        _token: "{{ csrf_token() }}",
                        status: status
                    },
                    success: (result) => {}
                })
            })
        })
    </script>
@endsection
@endsection
