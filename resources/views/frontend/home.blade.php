@extends('layouts.frontend')

@section('content')
    <section class="background d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="search_box">
                        <h5 class="fw-bold mt-3">Search Tours</h5>
                        <p>Find your dream tour today!</p>
                        {{-- <form action="{{ route('search') }}" method="GET">
                            <div class="input-group">
                                <select name="from" required class="form-control">
                                    <option value="">From</option>
                                    @foreach ($data as $item)
                                    <option value="{{ $item->id }}">{{ $item->destination }}</option>
                                    @endforeach
                                </select>
                                <span class="position-absolute"><i class="fa-solid fa-location-dot"></i></span>
                            </div>
                            <div class="input-group">
                                <select name="to" required class="form-control">
                                    <option value="">To</option>
                                    @foreach ($data as $item)
                                    <option value="{{ $item->id }}">{{ $item->destination }}</option>
                                    @endforeach
                                </select>
                                <span class="position-absolute"><i class="fa-solid fa-location-dot"></i></span>
                            </div>
                            <div class="input-group">
                                <input type="date" name="date" value="{{ date('Y-m-d') }}" required class="form-control" id="">
                            </div>
                            <button type="submit" class="custom_btn">Find Now</button>
                        </form> --}}
                        <form action="{{ url('/excel-store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="file" accept=".xlsx" name="file" id="">
                        <button type="submit">submit</button>
                        </form>
                    </div>
                </div>
                {{-- <div class="col-md-8 ps-md-5">
                    <h1>On the placess you'll go</h1>
                    <p>It is not down in any map; true place naver are.</p>
                    <div class="row pt-4">
                        <div class="col-md-4">
                            <div class="d-flex">
                                <div>
                                    <i class="fa-solid fa-users fa-2x bg-primary text-white rounded-2 p-2"></i>
                                </div>
                                <div class="ms-2">
                                    <h6 class="text-primary">Total Passenger</h6>
                                    <h6 class="text-primary">{{ \App\Models\Order::groupBy('number')->count() }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex">
                                <div>
                                    <i class="fa-solid fa-bus fa-2x bg-primary text-white rounded-2 p-2"></i>
                                </div>
                                <div class="ms-2">
                                    <h6 class="text-primary">Total Fleet</h6>
                                    <h6 class="text-primary">{{ \App\Models\Vehicles::count() }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex">
                                <div>
                                    <i class="fa-solid fa-road fa-2x bg-primary text-white rounded-2 p-2"></i>
                                </div>
                                <div class="ms-2">
                                    <h6 class="text-primary">Today Trip</h6>
                                    <h6 class="text-primary">0</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Swiper -->
                    <div class="swiper mySwiper mt-4">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide border">
                                <img src="{{ asset('assets/frontend/img/1.jpg') }}" alt="img" class="img-fluid">
                            </div>
                            <div class="swiper-slide border">
                                <img src="{{ asset('assets/frontend/img/3.jpg') }}" alt="img" class="img-fluid">
                            </div>
                            <div class="swiper-slide border">
                                <img src="{{ asset('assets/frontend/img/4.jpg') }}" alt="img" class="img-fluid">
                            </div>
                            <div class="swiper-slide border">
                                <img src="{{ asset('assets/frontend/img/1.jpg') }}" alt="img" class="img-fluid">
                            </div>
                            <div class="swiper-slide border">
                                <img src="{{ asset('assets/frontend/img/3.jpg') }}" alt="img" class="img-fluid">
                            </div>
                            <div class="swiper-slide border">
                                <img src="{{ asset('assets/frontend/img/4.jpg') }}" alt="img" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </section>
@endsection
