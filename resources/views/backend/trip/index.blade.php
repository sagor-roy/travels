@extends('layouts.backend')
@php
$user = Auth::user();
@endphp
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Trip List
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
                    @if ($user->can('trip.create'))
                        <a href="{{ route('admin.trip.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>
                            Add</a>
                    @endif
                </div>
                <!-- /.box-header -->
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Trip Title</th>
                                <th>Type</th>
                                <th>Route</th>
                                <th>Schedule</th>
                                <th>Price</th>
                                @if ($user->can('trip.edit'))
                                    <th>Status</th>
                                @endif
                                @if ($user->can('trip.edit') || $user->can('trip.delete'))
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->types->type }} ({{ $item->types->total }})</td>
                                    <td>{{ $item->routes->name }}</td>
                                    <td>{{ $item->schedules->start }}-{{ $item->schedules->end }}</td>
                                    <td>{{ $item->price }}</td>
                                    @if ($user->can('trip.edit'))
                                        <td>
                                            <label class="switch">
                                                <input type="checkbox" data-id="{{ $item->id }}"
                                                    {{ $item->status == 1 ? 'checked' : '' }} name="status">
                                                <span class="slider round"></span>
                                            </label>
                                        </td>
                                    @endif
                                    @if ($user->can('trip.edit') || $user->can('trip.delete'))
                                        <td>
                                            <form action="{{ route('admin.trip.destroy', $item->id) }}" class="d-flex"
                                                method="POST">
                                                @csrf
                                                @method('delete')
                                                @if ($user->can('trip.edit'))
                                                    <a class="btn btn-xs btn-primary"
                                                        href="{{ route('admin.trip.edit', $item->id) }}">Edit</a>
                                                @endif
                                                @if ($user->can('trip.delete'))
                                                    <button onclick="return confirm('Are you sure to Delete?')"
                                                        class="btn btn-xs btn-danger" type="submit">Delete</button>
                                                @endif
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>SL</th>
                                <th>Trip Title</th>
                                <th>Type</th>
                                <th>Route</th>
                                <th>Schedule</th>
                                <th>Price</th>
                                @if ($user->can('trip.edit'))
                                    <th>Status</th>
                                @endif
                                @if ($user->can('trip.edit') || $user->can('trip.delete'))
                                    <th>Action</th>
                                @endif
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
                    url: "{{ url('admin/trip/status') }}/" + id,
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
