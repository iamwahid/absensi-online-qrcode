@extends('backend.layouts.app')

@section('title', app_name() . ' | Dosen')


@section('content')
    {{ html()->form('POST', route('admin.dosen.store'))->class('form-horizontal')->open() }}
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5">
                        <h4 class="card-title mb-0">
                            Atur Dosen
                            <small class="text-muted">Buat baru</small>
                        </h4>
                    </div><!--col-->
                </div><!--row-->

                <hr>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            {{ html()->label("Nama Dosen")->class('form-control-label')->for('name') }}

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
                            {{ html()->label("NIK")->class('form-control-label')->for('nik') }}
                            {{ html()->text('nik')
                                ->class('form-control')
                                }}
                        </div><!--form-group-->
                    </div>
                    <div class="col">
                        <div class="form-group">
                            {{ html()->label("No HP")->class('form-control-label')->for('no_hp') }}
                            {{ html()->text('no_hp')
                                ->class('form-control')
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
                                ])
                                }}
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
                        {{ form_cancel(route('admin.dosen.index'), __('buttons.general.cancel')) }}
                    </div><!--col-->

                    <div class="col text-right">
                        {{ form_submit(__('buttons.general.crud.create')) }}
                    </div><!--col-->
                </div><!--row-->
            </div><!--card-footer-->
        </div><!--card-->
    {{ html()->form()->close() }}
@endsection
