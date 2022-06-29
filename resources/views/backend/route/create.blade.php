@extends('layouts.backend')
@php
$user = Auth::user();
@endphp
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Route
                <small>Control Panel</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">Route</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <div class="box box-primary">
                <div class="box-header with-border text-right">
                    @if ($user->can('route.view'))
                        <a href="{{ route('admin.trip.route.index') }}" class="btn btn-sm btn-primary"><i
                                class="fa fa-list"></i> List</a>
                    @endif
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="{{ route('admin.trip.route.store') }}" method="POST">
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Name<sup class="text-danger">*</sup> :</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" required name="name" class="form-control"
                                        placeholder="Route Name">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>From<sup class="text-danger">*</sup> :</label>
                                </div>
                                <div class="col-md-10">
                                    <select name="from" required class="form-control">
                                        <option value="">Select location</option>
                                        @foreach ($dest as $item)
                                            <option value="{{ $item->id }}">{{ $item->destination }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>To<sup class="text-danger">*</sup> :</label>
                                </div>
                                <div class="col-md-10">
                                    <select name="to" required class="form-control">
                                        <option value="">Select location</option>
                                        @foreach ($dest as $item)
                                            <option value="{{ $item->id }}">{{ $item->destination }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Distance<sup class="text-danger">*</sup> :</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" required name="distance" class="form-control"
                                        placeholder="Distance">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Duration<sup class="text-danger">*</sup> :</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" required name="duration" class="form-control"
                                        placeholder="Duration">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Google Map<sup class="text-danger">*</sup> :</label>
                                </div>
                                <div class="col-md-10">
                                    <textarea name="map" placeholder="Google map link" rows="5" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Status<sup class="text-danger">*</sup> :</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="radio" name="status" value="1" id="active">
                                    <label for="active" style="margin-right: 10px">Active</label>
                                    <input type="radio" name="status" value="0" id="inactive">
                                    <label for="inactive">Inactive</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer text-right">
                        <button type="reset" class="btn btn-sm btn-primary">Reset</button>
                        <button type="submit" class="btn btn-sm btn-success">Save</button>
                    </div>
                </form>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection
