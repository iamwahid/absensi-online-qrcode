@extends('backend.layouts.app')

@section('title', app_name() . ' | Mata Kuliah')


@section('content')
{{ html()->modelForm($mata_kuliah, 'POST', route('admin.mata_kuliah.dosen', $mata_kuliah))->class('form-horizontal')->open() }}
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5">
                        <h4 class="card-title mb-0">
                            Atur Mata Kuliah
                            <small class="text-muted">Pilih Dosen</small>
                        </h4>
                    </div><!--col-->
                </div><!--row-->

                <hr>

                <div class="row">
                    <div class="col">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Dosen</th>
                                    <th>Pilih</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dosen as $k => $d)
                                <tr>
                                    <td>
                                        <strong>{{$k+1 .'. '.$d->user->name.' ('.$d->matkuls->count().' Mata Kuliah)'}} </strong>
                                        {{-- <p class="mb-0">SKS : {{$b->sks}}</p> --}}
                                    </td>
                                    <td>
                                        <input type="checkbox" name="dosen[]" value="{{$d->id}}" {{ $mata_kuliah->dosens->contains('id', $d->id) ? 'checked' : ''}} class="custom-form-control">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div><!--col-->
                </div><!--row-->
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
