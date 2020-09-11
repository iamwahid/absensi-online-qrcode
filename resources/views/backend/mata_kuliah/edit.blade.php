@extends('backend.layouts.app')

@section('title', app_name() . ' | Mata Kuliah')


@section('content')
{{ html()->modelForm($mata_kuliah, 'POST', route('admin.mata_kuliah.update', $mata_kuliah))->class('form-horizontal')->open() }}
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5">
                        <h4 class="card-title mb-0">
                            Atur Mata Kuliah
                            <small class="text-muted">Edit data</small>
                        </h4>
                    </div><!--col-->
                </div><!--row-->

                <hr>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            {{ html()->label("Nama Mata Kuliah")->class('form-control-label')->for('nama') }}

                            {{ html()->text('nama')
                                ->class('form-control')
                                ->required()
                                }}
                        </div><!--form-group-->
                    </div><!--col-->
                    <div class="col">
                        <div class="form-group">
                            {{ html()->label("Jumlah SKS")->class('form-control-label')->for('sks') }}
                            {{ html()->number('sks')
                                ->class('form-control')
                                ->attribute('min', 1)
                                ->required()
                                }}
                        </div><!--form-group-->
                    </div>
                </div><!--row-->

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            {{ html()->label("Deskripsi")->class('form-control-label')->for('deskripsi') }}
                            {{ html()->textarea('deskripsi')
                                ->class('form-control')
                                }}
                        </div><!--form-group-->
                    </div>
                </div>
            </div><!--card-body-->

            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col">
                        {{ form_cancel(route('admin.mata_kuliah.index'), __('buttons.general.cancel')) }}
                    </div><!--col-->

                    <div class="col text-right">
                        {{ form_submit(__('buttons.general.crud.edit')) }}
                    </div><!--col-->
                </div><!--row-->
            </div><!--card-footer-->
        </div><!--card-->
    {{ html()->form()->close() }}
@endsection
