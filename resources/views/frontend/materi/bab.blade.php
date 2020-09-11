@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.general.home'))

@section('content')
    <div class="row mb-4">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="w-100 mb-3">
                        <h3><i class="fas fa-folder"></i> {{$name}}</h3>
                    </div>
                    <hr>
                    <div class="row mt-4">
                        <div class="col">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Materi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($data as $k => $v)
                                    <tr>
                                        <td>
                                            {{$k}} <a href="{{route('frontend.materi.show', $k)}}" class="btn float-right btn-sm btn-pill btn-success">Buka</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--card-->
        </div><!--col-->
    </div><!--row-->
@endsection
