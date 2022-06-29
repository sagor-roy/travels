@extends('layouts.backend')
@php
$user = Auth::user();
@endphp
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Role Edit
                <small>Control Panel</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">Edit</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <div class="box box-primary">
                <div class="box-header with-border text-right">
                    @if ($user->can('role.view'))
                        <a href="{{ route('admin.role.create.index') }}" class="btn btn-sm btn-primary"><i
                                class="fa fa-list"></i> List</a>
                    @endif
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form action="{{ route('admin.role.create.update', $roles->id) }}" method="POST">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="role" value="{{ $roles->name }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="custom-checkbox custom-control">
                                <input type="checkbox" class="custom-control-input" id="checkbox-all"
                                    {{ \App\Models\User::roleHasPermissions($roles, $allPermissions) ? 'checked' : '' }}>
                                <label for="checkbox-all" class="custom-control-label">All</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr>
                        </div>
                        <div class="col-md-6">
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($group as $item)
                                @php
                                    $permissions = \App\Models\User::getpermissionsByGroupName($item->name);
                                @endphp
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox"
                                                onclick="clickCheckbox('role-{{ $i }}-manage',this)"
                                                class="custom-control-input" id="group-{{ $i }}-checkbox"
                                                {{ \App\Models\User::roleHasPermissions($roles, $permissions) ? 'checked' : '' }}>
                                            <label for="group-{{ $i }}-checkbox"
                                                class="custom-control-label">{{ ucfirst($item->name) }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-8 role-{{ $i }}-manage">
                                        @foreach ($permissions as $permission)
                                            <div class="custom-checkbox custom-control">
                                                <input type="checkbox"
                                                    onclick="checkByGroup('role-{{ $i }}-manage','group-{{ $i }}-checkbox',{{ count($permissions) }})"
                                                    name="permission[]" value="{{ $permission->id }}"
                                                    class="custom-control-input" id="checkbox-{{ $permission->id }}"
                                                    {{ $roles->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                                <label for="checkbox-{{ $permission->id }}"
                                                    class="custom-control-label">{{ $permission->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <br>
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                        </div>
                        <div class="col-md-12" style="margin-bottom: 20px">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        <!-- /.content -->
    </div>

@section('script')
    @include('backend.roles.script')
@endsection

@endsection
