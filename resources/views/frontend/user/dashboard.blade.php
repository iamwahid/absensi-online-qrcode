@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.frontend.dashboard') )

@section('content')
    <div class="row mb-4">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>
                        <i class="fas fa-tachometer-alt"></i> @lang('navs.frontend.dashboard')
                    </strong>
                </div><!--card-header-->

                <div class="card-body">
                    <div class="row">
                        <div class="col col-sm-4 order-1 order-sm-2  mb-4">
                            <div class="card mb-4 bg-light">
                                <img class="card-img-top" src="{{ $logged_in_user->picture }}" alt="Profile Picture">

                                <div class="card-body">
                                    <h4 class="card-title">
                                        {{ $logged_in_user->name }}<br/>
                                    </h4>

                                    <p class="card-text">
                                        <small>
                                            <i class="fas fa-envelope"></i> {{ $logged_in_user->email }}<br/>
                                            <i class="fas fa-calendar-check"></i> @lang('strings.frontend.general.joined') {{ timezone()->convertToLocal($logged_in_user->created_at, 'F jS, Y') }}
                                        </small>
                                    </p>

                                    <p class="card-text">

                                        <a href="{{ route('frontend.user.account')}}" class="btn btn-info btn-sm mb-1">
                                            <i class="fas fa-user-circle"></i> @lang('navs.frontend.user.account')
                                        </a>

                                        @can('view backend')
                                            &nbsp;<a href="{{ route('admin.dashboard')}}" class="btn btn-danger btn-sm mb-1">
                                                <i class="fas fa-user-secret"></i> @lang('navs.frontend.user.administration')
                                            </a>
                                        @endcan
                                    </p>
                                </div>
                            </div>

                        </div><!--col-md-4-->

                        <div class="col-md-8 order-2 order-sm-1">
                            <div class="row">
                                <div class="col">
                                    @if (!$logged_in_user->isAdmin())
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            {{ request()->show && request()->show == 'all' ? 'Semua Jadwal' : 'Jadwal Hari ini' }}
                                            @if (!request()->show || request()->show != 'all')
                                                <a class="btn btn-sm btn-primary float-right" href="?show=all">Tampilkan Semua Jadwal</a>
                                            @endif
                                        </div><!--card-header-->

                                        <div class="card-body">
                                            @if ($logged_in_user->mahasiswa && $logged_in_user->mahasiswa->jadwals)
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Jadwal</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (request()->show && request()->show == 'all')
                                                        @php
                                                            $jadwals = $logged_in_user->mahasiswa->jadwals;
                                                        @endphp
                                                        @else
                                                        @php
                                                            $jadwals = $logged_in_user->mahasiswa->jadwal_today;
                                                        @endphp
                                                        @endif
                                                        @foreach ($jadwals as $i => $jadwal)
                                                        <tr>
                                                            <td>{{$i+1}}</td>
                                                            <td>
                                                                <p>Matkul : {{$jadwal->matkul->nama}}</p>
                                                                <p>Dosen : {{$jadwal->dosen->user->name}}</p>
                                                                <p>Waktu : {{$jadwal->dayname.', '.$jadwal->start_time .' - '. $jadwal->finish_time}}</p>
                                                            </td>
                                                            <td>
                                                                @if ($jadwal->hasMhsAbsensi($logged_in_user->mahasiswa->id))
                                                                Sudah Absen
                                                                @else
                                                                <a href="{{route('frontend.scan')}}" class="btn btn-success">Absen</a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            @elseif ($logged_in_user->dosen && $logged_in_user->dosen->jadwals)
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Jadwal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (request()->show && request()->show == 'all')
                                                        @php
                                                            $jadwals = $logged_in_user->dosen->jadwals;
                                                        @endphp
                                                        @else
                                                        @php
                                                            $jadwals = $logged_in_user->dosen->jadwal_today;
                                                        @endphp
                                                        @endif
                                                        @foreach ($jadwals as $i => $jadwal)
                                                        <tr>
                                                            <td>{{$i+1}}</td>
                                                            <td>
                                                                <p>Matkul : {{$jadwal->matkul->nama}}</p>
                                                                <p>Waktu : {{$jadwal->dayname.', '.$jadwal->start_time .' - '. $jadwal->finish_time}}</p>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            @else
                                            <strong>Jadwal belum ditentukan</strong>
                                            @endif
                                        </div><!--card-body-->
                                    </div><!--card-->
                                    @endif
                                </div><!--col-md-6-->
                            </div><!--row-->
                        </div><!--col-md-8-->
                    </div><!-- row -->
                </div> <!-- card-body -->
            </div><!-- card -->
        </div><!-- row -->
    </div><!-- row -->
@endsection
