@extends('layouts.backend')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Destination List
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
                    <a href="{{ route('admin.fleet.type.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>
                        Add</a>
                </div>
                <!-- /.box-header -->
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Fleet Type</th>
                                <th>Layout</th>
                                <th>Total Seat</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->type }}</td>
                                    <td>{{ $item->layout }}</td>
                                    <td>{{ $item->total }}</td>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" data-id="{{ $item->id }}"
                                                {{ $item->status == 1 ? 'checked' : '' }} name="status">
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.fleet.type.destroy', $item->id) }}" class="d-flex"
                                            method="POST">
                                            @csrf
                                            @method('delete')
                                            <a class="btn btn-xs btn-primary"
                                                href="{{ route('admin.fleet.type.edit', $item->id) }}">Edit</a>
                                            <button onclick="return confirm('Are you sure to Delete?')" class="btn btn-xs btn-danger" type="submit">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>SL</th>
                                <th>Fleet Type</th>
                                <th>Layout</th>
                                <th>Total Seat</th>
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
                    url: "{{ url('admin/fleet/type/status') }}/" + id,
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
