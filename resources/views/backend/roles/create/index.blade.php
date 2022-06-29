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
                    @if ($user->can('role.create'))
                        <a href="{{ route('admin.role.create.create') }}" class="btn btn-sm btn-primary"><i
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
                                <td width="25%">Role</th>
                                <th>Permission</th>
                                @if ($user->can('role.edit') || $user->can('role.delete'))
                                    <th width="12%">Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ ucfirst($item->name) }}</td>
                                    <td>
                                        @foreach ($item->permissions as $per)
                                            <span style="font-weight:500" class="badge">
                                                {{ $per->name }}
                                            </span>
                                        @endforeach
                                    </td>
                                    @if ($user->can('role.edit') || $user->can('role.delete'))
                                        <td>
                                            <form action="{{ route('admin.role.create.destroy', $item->id) }}"
                                                class="d-flex" method="POST">
                                                @csrf
                                                @method('delete')
                                                @if ($user->can('role.edit'))
                                                    <a class="btn btn-xs btn-primary"
                                                        href="{{ route('admin.role.create.edit', $item->id) }}">Edit</a>
                                                @endif
                                                @if ($user->can('role.delete'))
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
                                <th>Permission</th>
                                @if ($user->can('role.edit') || $user->can('role.delete'))
                                    <th width="12%">Action</th>
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
