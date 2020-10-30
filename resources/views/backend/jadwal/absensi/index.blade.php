@extends('backend.layouts.app')

@section('title', app_name() . ' | Santri')


@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5 mb-3">
                <h4 class="card-title mb-0">
                    Absensi <small class="text-muted">{{$date_string}}</small>
                </h4>
                <small>{{$jadwal->as_text}}</small>
            </div><!--col-->

            <div class="col-sm-7">
                <div class="float-right w-lg-50">
                    <div class="row">
                        <div class="col-4">
                            <select name="kelas" id="kelas" class="form-control">
                                <option value="" {{request()->get('kelas') == '' || request()->get('kelas') == null ? 'selected' : '' }}>Semua</option>
                                <option value="A" {{request()->get('kelas') == 'A' ? 'selected' : '' }}>Kelas A</option>
                                <option value="B" {{request()->get('kelas') == 'B' ? 'selected' : '' }}>Kelas B</option>
                                <option value="C" {{request()->get('kelas') == 'C' ? 'selected' : '' }}>Kelas C</option>
                                <option value="D" {{request()->get('kelas') == 'D' ? 'selected' : '' }}>Kelas D</option>
                                <option value="E" {{request()->get('kelas') == 'E' ? 'selected' : '' }}>Kelas E</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <input name="date" id="date" type="date" value="{{request()->get('date') ?: $date}}" class="form-control">
                        </div>
                        <div class="col-4">
                            <a href="{{route('admin.jadwal.absensi.export', $jadwal).'?kelas='.request('kelas')}}" class="btn btn-success">Export</a>
                        </div>
                    </div>
                </div>
            </div><!--col-->
        </div><!--row-->

        {{-- if admin --}}
        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Mahasiswa</th>
                            {{-- <th>Action</th> --}}
                        </tr>
                        </thead>
                        <tbody>
                          @foreach ($absensi as $k => $b)
                          <tr>
                            <td>
                                <div>
                                    <strong>
                                        {{$k+1 . '. '.$b->mahasiswa_nama}} 
                                        @if ($b->keterangan != null)
                                        <span class="badge float-right badge-sm badge-{{ $b->keterangan == 'hadir' ? 'success' : ($b->keterangan == 'izin' ? 'warning' : 'danger') }}">
                                            {{strtoupper($b->keterangan) }}
                                        </span>
                                        @else
                                        <small class="float-right">Tidak ada keterangan</small>
                                        @endif
                                    </strong><br>
                                    NIM : {{$b->nim}} <br>
                                    Kelas : {{$b->kelas}}
                                </div>
                            </td>
{{--                             
                            <td>
                                <div class="btn-group">
                                    <a type="a" class="btn btn-sm btn-pill btn-success" href="{{ route('admin.jadwal.absensi.mhs', [$b->jadwal_id, $b->mahasiswa_id]) }}">Hadir</a>
                                </div>
                            </td> --}}
                          </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
            </div><!--col-->
        </div><!--row-->

        <div class="row">
            <div class="col-7">
                <div class="float-left">
                    {{-- {!! $users->total() !!} {{ trans_choice('labels.backend.access.users.table.total', $users->total()) }} --}}
                </div>
            </div><!--col-->

            <div class="col-5">
                <div class="float-right">
                    {{-- {!! $users->render() !!} --}}
                </div>
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->
</div><!--card-->
@endsection

@push('after-scripts')
<script>
function absen(url, keterangan, date) {
    if (url != null && keterangan != null) {
        console.log(url);
        $.ajax({
            url: url,
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                keterangan: keterangan,
                date: date
            },
            success: function(s) {
                window.location.reload(true)
            },
            error: function(e) {
                alert('Error');
            }
        })
    }
}

let dateselect = document.getElementById('date');
let kelasselect = document.getElementById('kelas');

dateselect.addEventListener('change', function(e){
    let date = (new Date(this.value)).toLocaleString("sv-SE", {
        day: "2-digit",
        month: "2-digit",
        year: "numeric"
    })
    reloadData(date, kelasselect.value)
})

kelasselect.addEventListener('change', function(e){
    let date = (new Date(dateselect.value)).toLocaleString("sv-SE", {
        day: "2-digit",
        month: "2-digit",
        year: "numeric"
    })
    reloadData(date, this.value)
})

function reloadData(date, kelas) {
    window.location = window.location.href.split('?')[0] + '?date='+date+'&kelas='+kelas
}
</script>
@endpush
