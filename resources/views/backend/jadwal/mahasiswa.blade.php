@extends('backend.layouts.app')

@section('title', app_name() . ' | Jadwal')


@section('content')
{{ html()->modelForm($jadwal, 'POST', route('admin.jadwal.mahasiswa', $jadwal))->class('form-horizontal')->open() }}
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5">
                        <h4 class="card-title mb-0">
                            Atur Jadwal
                            <small class="text-muted">Atur Mahasiswa</small>
                        </h4>
                    </div><!--col-->
                </div><!--row-->

                <hr>
                <div class="row">
                    <div class="col">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Mahasiswa</th>
                                    <th>Pilih</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mahasiswa as $k => $d)
                                <tr>
                                    <td>
                                        <strong>{{$k+1 .'. '.$d->user->name.' (Kelas '.$d->kelas.')'}} </strong>
                                        {{-- <p class="mb-0">SKS : {{$b->sks}}</p> --}}
                                    </td>
                                    <td>
                                        <input type="checkbox" name="mahasiswa[]" value="{{$d->id}}" {{ $jadwal->mahasiswas->contains('id', $d->id) ? 'checked' : ''}} class="custom-form-control">
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
                        {{ form_cancel(route('admin.jadwal.index'), __('buttons.general.cancel')) }}
                    </div><!--col-->

                    <div class="col text-right">
                        {{ form_submit(__('buttons.general.crud.edit')) }}
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
