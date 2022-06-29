@extends('layouts.frontend')

@section('content')
    <section>
        <div class="container">
            <div class="row justify-content-center align-items-center" style="height:100vh">
                <div class="col-md-6 mx-auto">
                    <div class="card card-body shadow-lg">
                        <h2 class="text-center fw-bold">Admin</h2>
                        <form action="{{ route('access') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="" class="form-label">Email</label>
                                <input type="text" class="form-control" name="email">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password">
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection