@extends('layouts.backend')
@php
$user = Auth::user();
@endphp
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Booking List
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
                    {{-- @if ($user->can('desti.create')) --}}
                    <a href="{{ route('admin.ticket.booking.create') }}" class="btn btn-sm btn-primary"><i
                            class="fa fa-plus"></i>
                        Add</a>
                    {{-- @endif --}}
                </div>
                <!-- /.box-header -->
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Booking Date</th>
                                <th>Booking ID</th>
                                <th>Name</th>
                                <th>Number</th>
                                <th>Route Name</th>
                                <th>Price</th>
                                <th>Seat Number</th>
                                <th>Payment Type</th>
                                <th>Payment Status</th>
                                {{-- @if ($user->can('desti.edit') || $user->can('desti.delete')) --}}
                                <th>Action</th>
                                {{-- @endif --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ date('Y-M-d', strtotime($item->date)) }} {{ date('h:i a', strtotime($item->time)) }}</td>
                                    <td>{{ $item->ticked_no }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->number }}</td>
                                    <td>{{ $item->trip->routes->name }}</td>
                                    <td>{{ $item->price }}</td>
                                    <td>{{ $item->seat }}</td>
                                    <td>{{ $item->method }}</td>
                                    <td>{{ $item->status }}</td>
                                    {{-- @if ($user->can('desti.edit') || $user->can('desti.delete')) --}}
                                    <td>
                                        <form action="{{ route('admin.ticket.booking.destroy', $item->id) }}" class="d-flex"
                                            method="POST">
                                            @csrf
                                            @method('delete')
                                            {{-- @if ($user->can('desti.edit')) --}}
                                            <a class="btn btn-xs btn-primary"
                                                href="{{ route('admin.ticket.booking.view', $item->id) }}">view</a>
                                            {{-- @endif
                                                @if ($user->can('desti.delete')) --}}
                                            <button onclick="return confirm('Are you sure to Delete?')"
                                                class="btn btn-xs btn-danger" type="submit">Delete</button>
                                            {{-- @endif --}}
                                        </form>
                                    </td>
                                    {{-- @endif --}}
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>SL</th>
                                <th>Booking Date</th>
                                <th>Booking ID</th>
                                <th>Name</th>
                                <th>Route Name</th>
                                <th>Price</th>
                                <th>Seat Number</th>
                                <th>Payment Type</th>
                                <th>Payment Status</th>
                                {{-- @if ($user->can('desti.edit') || $user->can('desti.delete')) --}}
                                <th>Action</th>
                                {{-- @endif --}}
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
                    url: "{{ url('admin/trip/destination/status') }}/" + id,
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
