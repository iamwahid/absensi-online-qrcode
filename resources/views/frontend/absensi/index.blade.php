@extends('frontend.layouts.app')

@section('title', app_name() . ' | Absensi Santri Hari ini')


@section('content')
<div class="row mb-4">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5 mb-3">
                        <h4 class="card-title mb-0">
                            Absensi <small class="text-muted">{{$date_string}}</small>
                        </h4>
                    </div><!--col-->
        
                    <div class="col-sm-7">
                        <div class="float-right w-lg-50">
                            <div class="row">
                                <div class="col-6">
                                    <select name="kelas" id="kelas" class="form-control">
                                        <option value="" {{request()->get('kelas') == '' || request()->get('kelas') == null ? 'selected' : '' }}>Semua</option>
                                        <option value="A" {{request()->get('kelas') == 'A' ? 'selected' : '' }}>Kelas A</option>
                                        <option value="B" {{request()->get('kelas') == 'B' ? 'selected' : '' }}>Kelas B</option>
                                        <option value="C" {{request()->get('kelas') == 'C' ? 'selected' : '' }}>Kelas C</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <input name="date" id="date" type="date" value="{{request()->get('date') ?: $date}}" class="form-control">
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
                                    <th>Santri</th>
                                </tr>
                                </thead>
                                <tbody>
                                  @foreach ($absensi as $k => $b)
                                  <tr>
                                    <td>
                                        <div>
                                            <strong>{{$k+1 .'. '.$b->nama}}</strong>
                                            @if ($b->keterangan)
                                            <span class="badge float-right badge-{{ $b->keterangan == 'hadir' ? 'success' : ($b->keterangan == 'izin' ? 'warning' : 'danger') }}">
                                                {{ strtoupper($b->keterangan) }}
                                            </span>
                                            @endif
                                        </div>
                                        <p class="mb-0">Kelas {{$b->kelas}}</p>
                                    </td>
                                    {{-- <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-success" onclick="absen('{{route('admin.absensi.absen', $b->santri_id)}}', 'hadir', '{{$date}}')">Hadir</button>
                                            <button type="button" class="btn btn-danger" onclick="absen('{{route('admin.absensi.absen', $b->santri_id)}}', 'sakit', '{{$date}}')">Sakit</button>
                                            <button type="button" class="btn btn-warning" onclick="absen('{{route('admin.absensi.absen', $b->santri_id)}}', 'izin', '{{$date}}')">Izin</button>
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
    </div>
</div>
@endsection

@push('after-scripts')
<script>
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
        window.location = '/absensi?date='+date+'&kelas='+kelas
    }
</script>
@endpush
