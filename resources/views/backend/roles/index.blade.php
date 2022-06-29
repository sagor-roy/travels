@extends('layouts.backend')
@php
$user = Auth::user();
@endphp
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Role List
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
                    @if ($user->can('user.create'))
                        <a href="{{ route('admin.role.all.create') }}" class="btn btn-sm btn-primary"><i
                                class="fa fa-plus"></i>
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
                                <th>Name</th>
                                <th>Email</th>
                                <th>Roles</th>
                                @if ($user->can('user.edit') || $user->can('user.delete'))
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>
                                        @foreach ($item->roles as $role)
                                            <span class="badge">
                                                {{ $role->name }}
                                            </span>
                                        @endforeach
                                    </td>
                                    @if ($user->can('user.edit') || $user->can('user.delete'))
                                        <td>
                                            <form action="{{ route('admin.role.all.destroy', $item->id) }}" class="d-flex"
                                                method="POST">
                                                @csrf
                                                @method('delete')
                                                @if ($user->can('user.edit'))
                                                    <a class="btn btn-xs btn-primary"
                                                        href="{{ route('admin.role.all.edit', $item->id) }}">Edit</a>
                                                @endif
                                                @if ($user->can('user.delete'))
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
                                <th>Name</th>
                                <th>Email</th>
                                <th>Roles</th>
                                @if ($user->can('user.edit') || $user->can('user.delete'))
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
    {{-- <script>
        $(function() {
            //////
        })
    </script> --}}
@endsection
@endsection
