@extends('layouts.backend')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Schedule
                <small>Control Panel</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active">schedule</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <div class="box box-primary">
                <div class="box-header with-border text-right">
                    <a href="{{ route('admin.trip.schedule.index') }}" class="btn btn-sm btn-primary"><i
                            class="fa fa-list"></i> List</a>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="{{ route('admin.trip.schedule.store') }}" method="POST">
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Start<sup class="text-danger">*</sup> :</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="time" required name="start" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>End<sup class="text-danger">*</sup> :</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="time" required name="end" class="form-control">
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
