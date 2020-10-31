@extends('backend.layouts.app')

@section('title', app_name() . ' | Jadwal')


@section('content')
    {{ html()->form('POST', route('admin.jadwal.store'))->class('form-horizontal')->open() }}
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5">
                        <h4 class="card-title mb-0">
                            Atur Jadwal
                            <small class="text-muted">Buat baru</small>
                        </h4>
                    </div><!--col-->
                </div><!--row-->

                <hr>

                <div class="row">
                    
                    <div class="col-sm-12 col-lg-4">
                        <div class="form-group">
                            {{ html()->label("Mata Kuliah")->class('form-control-label')->for('matkul_id') }}
                            <select name="matkul_id" id="matkul_id" class="form-control" data-url="{{route('admin.mata_kuliah.index')}}" required>
                                <option value="">Pilih</option>
                                @foreach ($matkul as $m)
                                <option value="{{$m->id.'_'.$m->sks}}">{{$m->nama.' ('.$m->sks.' SKS)'}}</option>
                                @endforeach
                            </select>
                        </div><!--form-group-->
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <div class="form-group">
                            {{ html()->label("Dosen")->class('form-control-label')->for('dosen_id') }}
                            {{ html()->select('dosen_id')
                                ->options([
                                    '' => 'Pilih'
                                ])
                                ->class('form-control')->required()
                                }}
                        </div><!--form-group-->
                    </div>
                    {{-- <div class="col-sm-12 col-lg-4">
                        <div class="form-group">
                            {{ html()->label("Ruang")->class('form-control-label')->for('room') }}
                            {{ html()->select('room')
                                ->options([
                                    '' => 'Pilih',
                                    '401' => '401',
                                    '402' => '402',
                                    '403' => '403',
                                    '404' => '404',
                                ])
                                ->class('form-control')
                                }}
                        </div><!--form-group-->
                    </div> --}}
                </div>

                <div class="row">
                    <div class="col-sm-12 col-lg-4">
                        <div class="form-group">
                            {{ html()->label("Hari")->class('form-control-label')->for('day') }}

                            {{ html()->select('day')
                                ->options([
                                    '' => 'Pilih',
                                    '0' => 'Ahad',
                                    '1' => 'Senin',
                                    '2' => 'Selasa',
                                    '3' => 'Rabu',
                                    '4' => 'Kamis',
                                    '5' => 'Jum\'at',
                                    '6' => 'Sabtu',
                                ])
                                ->class('form-control')
                                ->required()
                                }}
                        </div><!--form-group-->
                    </div><!--col-->
                    <div class="col-sm-12 col-lg-4">
                        <div class="form-group">
                            {{ html()->label("Waktu Mulai")->class('form-control-label')->for('start_time') }}
                            <input type="hidden" name="start_at" id="start_at">
                            {{ html()->text('start_time')
                                ->attribute('type', 'time')
                                ->class('form-control')
                                ->required()
                                }}
                        </div><!--form-group-->
                    </div><!--col-->
                    <div class="col-sm-12 col-lg-4">
                        <div class="form-group">
                            {{ html()->label("Waktu Selesai")->class('form-control-label')->for('finish_time') }} <small class="text-muted">(dihitung dari banyak SKS)</small>
                            <input type="hidden" name="finish_at" id="finish_at">
                            {{ html()->text('finish_time')
                                ->attribute('type', 'time')
                                ->attribute('readonly', true)
                                ->class('form-control')
                                ->required()
                                }}
                        </div><!--form-group-->
                    </div>
                </div><!--row-->
            </div><!--card-body-->

            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col">
                        {{ form_cancel(route('admin.jadwal.index'), __('buttons.general.cancel')) }}
                    </div><!--col-->

                    <div class="col text-right">
                        {{ form_submit(__('buttons.general.crud.create')) }}
                    </div><!--col-->
                </div><!--row-->
            </div><!--card-footer-->
        </div><!--card-->
    {{ html()->form()->close() }}
@endsection

@push('after-scripts')
<script>
$(document).ready(function(d){
    $('#matkul_id').change(function(e){
        let ths = $(this)
        let val = ths.val().split('_')[0]
        // console.log(sks)
        if (val != null && val !== '') {
            $.ajax({
                method: 'GET',
                url: ths.data('url') + `/${val}/dosen-json`,
                success: function(x) {

                    let html = '<option value="">Pilih</option>';
                    for (const key in x) {
                        if (x.hasOwnProperty(key)) {
                            const element = x[key];
                            html += `<option value="${key}">${element}</option>`
                        }
                    }

                    $('#dosen_id').html(html)
                }
            })

            changeTime();
        } else $('#dosen_id').html('<option value="">Pilih</option>')
    });

    $('#day').change(function(e){
        changeTime();
    })

    $('#start_time').change(function(e){
        changeTime();
    })

    function changeTime(){
        let ths = $('#matkul_id')
        let val = ths.val().split('_')[0]
        let sks = ths.val().split('_')[1]
        let sksxtime = sks ? sks * 45 : 0
        let start_time = $('#start_time')
        let finish_time = $('#finish_time')
        let day = $('#day')
        let start_at = $('#start_at')
        let finish_at = $('#finish_at')
        let d1 = new Date();
        let st = start_time.val() ? start_time.val().split(':') : [7, 0]
        d1.setHours(st[0], st[1])
        // console.log(d1);
        start_time.val(("0" + d1.getHours()).slice(-2)+':'+("0" + d1.getMinutes()).slice(-2))
        start_at.val(day.val()+' '+start_time.val())
        d1.setMinutes(d1.getMinutes() + sksxtime)
        // console.log(d1)
        finish_time.val(("0" + d1.getHours()).slice(-2)+':'+("0" + d1.getMinutes()).slice(-2))
        finish_at.val(day.val()+' '+finish_time.val())
    }
});
</script>
@endpush
