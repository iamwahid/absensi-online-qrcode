@extends('backend.layouts.app')

@section('title', app_name() . ' | Mahasiswa')


@section('content')
    {{ html()->form('POST', route('admin.mahasiswa.store'))->class('form-horizontal')->open() }}
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5">
                        <h4 class="card-title mb-0">
                            Atur Mahasiswa
                            <small class="text-muted">Buat baru</small>
                        </h4>
                    </div><!--col-->
                </div><!--row-->

                <hr>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            {{ html()->label("Nama Mahasiswa")->class('form-control-label')->for('name') }}

                            {{ html()->text('name')
                                ->class('form-control')
                                ->required()
                                }}
                        </div><!--form-group-->
                    </div><!--col-->
                    <div class="col">
                        <div class="form-group">
                            {{ html()->label("Email")->class('form-control-label')->for('email') }}
                            {{ html()->email('email')
                                ->class('form-control')
                                ->required()
                                }}
                        </div><!--form-group-->
                    </div>
                </div><!--row-->

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            {{ html()->label("Password")->class('form-control-label')->for('password') }}
                            {{ html()->password('password')
                                ->class('form-control')
                                ->required()
                                }}
                        </div><!--form-group-->
                    </div>
                    <div class="col">
                        <div class="form-group">
                            {{ html()->label("Password Confirmation")->class('form-control-label')->for('password_confirmation') }}
                            {{ html()->password('password_confirmation')
                                ->class('form-control')
                                ->required()
                                }}
                        </div><!--form-group-->
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            {{ html()->label("NIM")->class('form-control-label')->for('nim') }}
                            {{ html()->text('nim')
                                ->class('form-control')
                                }}
                        </div><!--form-group-->
                    </div>
                    <div class="col">
                        <div class="form-group">
                            {{ html()->label("Kelas")->class('form-control-label')->for('kelas') }}
                            {{ html()->select('kelas')
                                ->options([
                                    'A' => 'Kelas A',
                                    'B' => 'Kelas B',
                                    'C' => 'Kelas C',
                                    'D' => 'Kelas D',
                                    'E' => 'Kelas E',
                                ])
                                ->class('form-control')->required()
                                }}
                        </div><!--form-group-->
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            {{ html()->label("Jenis Kelamin")->class('form-control-label')->for('gender') }}
                            {{ html()->select('gender')
                                ->class('form-control')
                                ->options([
                                    'male' => 'Laki-Laki',
                                    'female' => 'Perempuan',
                                ]) }}
                        </div><!--form-group-->
                    </div>
                    <div class="col">
                        <div class="form-group">
                            {{ html()->label("Alamat")->class('form-control-label')->for('alamat') }}
                            {{ html()->text('alamat')
                                ->class('form-control')
                                }}
                        </div><!--form-group-->
                    </div>
                </div>
            </div><!--card-body-->

            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col">
                        {{ form_cancel(route('admin.mahasiswa.index'), __('buttons.general.cancel')) }}
                    </div><!--col-->

                    <div class="col text-right">
                        {{ form_submit(__('buttons.general.crud.create')) }}
                    </div><!--col-->
                </div><!--row-->
            </div><!--card-footer-->
        </div><!--card-->
    {{ html()->form()->close() }}
@endsection
