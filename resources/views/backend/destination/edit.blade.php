@extends('layouts.backend')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Destination Edit
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
                    <a href="{{ route('admin.trip.dest.index') }}" class="btn btn-sm btn-primary"><i class="fa fa-list"></i> List</a>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="{{ route('admin.trip.dest.update',$data->id) }}" method="POST">
                    @csrf
                    @method('put')
                    <div class="box-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Destination Name<sup class="text-danger">*</sup> :</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" required name="destination" class="form-control"
                                        value="{{ $data->destination }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Description<sup class="text-danger">*</sup> :</label>
                                </div>
                                <div class="col-md-10">
                                    <textarea name="description" placeholder="Description" rows="5" class="form-control">{{ $data->description }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Status<sup class="text-danger">*</sup> :</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="radio" {{ $data->status == 1 ? 'checked':'' }} name="status" value="1" id="active">
                                    <label for="active" style="margin-right: 10px">Active</label>
                                    <input type="radio" {{ $data->status == 0 ? 'checked':'' }} name="status" value="0" id="inactive">
                                    <label for="inactive" >Inactive</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer text-right">
                        <button type="reset" class="btn btn-sm btn-primary">Reset</button>
                        <button type="submit" class="btn btn-sm btn-success">Update</button>
                    </div>
                </form>
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection
