@extends('layouts.backend')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Route List
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
                    <a href="{{ route('admin.trip.route.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>
                        Add</a>
                </div>
                <!-- /.box-header -->
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Route Name</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Distance</th>
                                <th>Duration</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->froms->destination }}</td>
                                    <td>{{ $item->too->destination }}</td>
                                    <td>{{ $item->distance }}</td>
                                    <td>{{ $item->duration }}</td>
                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" data-id="{{ $item->id }}"
                                                {{ $item->status == 1 ? 'checked' : '' }} name="status">
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.trip.route.destroy', $item->id) }}" class="d-flex"
                                            method="POST">
                                            @csrf
                                            @method('delete')
                                            <a class="btn btn-xs btn-primary"
                                                href="{{ route('admin.trip.route.edit', $item->id) }}">Edit</a>
                                            <button onclick="return confirm('Are you sure to Delete?')" class="btn btn-xs btn-danger" type="submit">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>SL</th>
                                <th>Route Name</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Distance</th>
                                <th>Duration</th>
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
                    url: "{{ url('admin/trip/route/status') }}/" + id,
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
