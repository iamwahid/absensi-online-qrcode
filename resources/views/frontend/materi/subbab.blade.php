@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.general.home'))

@section('content')
    <div class="row mb-4">
        <div class="col">
            <div class="card">
                {{-- <div class="card-header">
                    <i class="fas fa-home"></i> @lang('navs.general.home')
                </div> --}}
                <div class="card-body">
                    <div class="w-100 mb-3">
                        <h3><i class="fas fa-file"></i> {{$name}}</h3>
                    </div>
                    <hr>
                    @if (is_array($data))
                    <div class="carousel slide" id="carouselExampleControls" data-interval="false">
                        <ol class="carousel-indicators">
                            @for ($i = 0; $i < count($data); $i++)
                            <li class="{{$i == 0 ? 'active' : ''}}" data-target="#carouselExampleIndicators" data-slide-to="{{$i}}"></li>
                            @endfor
                        </ol>
                        <div class="carousel-inner">
                        @foreach ($data as $k => $img)
                        <div class="carousel-item {{$k == 0 ? 'active' : ''}}">
                            <img class="d-block w-100" alt="{{$img}}" src="{{$img}}">
                        </div>
                        @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                    @else
                    <img class="d-block w-100" src="{{$data}}">
                    @endif
                </div>
            </div><!--card-->
        </div><!--col-->
    </div><!--row-->
@endsection
