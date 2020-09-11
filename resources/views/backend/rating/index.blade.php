@extends('backend.layouts.app')

@section('title', app_name() . ' | Penilaian')

@push('after-styles')
<style>
.rating {
  display: inline-flex;
  flex-direction: row-reverse;
}

#show-rating {
    border: 1px solid rgba(134, 134, 134, 0.37);
    border-radius: 20px;
    padding: 5px 10px 5px 10px;
}

i {
  width: 20px;
  height: 20px;
  margin: 5px;
  color: rgba(128, 128, 128, 0.575);
}

i.rated ~ i,
i.rated {
  color: rgb(255, 238, 2);
}
</style>
@endpush

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5 mb-3">
                <h4 class="card-title mb-0">
                    Penilaian Pengguna <small class="text-muted"></small>
                </h4>
            </div><!--col-->

            <div class="col-sm-7">
                <div class="float-right w-lg-50">
                    {{-- <div class="row">
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
                    </div> --}}
                </div>
            </div><!--col-->
        </div><!--row-->

        {{-- if admin --}}
        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive table-borderless">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Nilai</th>
                            {{-- <th>Action</th> --}}
                        </tr>
                        </thead>
                        <tbody>
                          @foreach ($ratings as $k => $b)
                          <tr>
                            <td>
                                <div>
                                    <div id="show-rating">
                                        <strong>
                                            {{$k+1 . '. '.$b->user->name}}
                                        </strong>
                                        <br>
                                        <div class="rating">
                                            <i class="fas fa-star {{ $b->stars == 5 ? 'rated' : '' }}"></i>
                                            <i class="fas fa-star {{ $b->stars == 4 ? 'rated' : '' }}"></i>
                                            <i class="fas fa-star {{ $b->stars == 3 ? 'rated' : '' }}"></i>
                                            <i class="fas fa-star {{ $b->stars == 2 ? 'rated' : '' }}"></i>
                                            <i class="fas fa-star {{ $b->stars == 1 ? 'rated' : '' }}"></i>
                                        </div>
                                        <p>
                                            {{ $b->message }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            
                            {{-- <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-pill btn-success" onclick="absen('{{route('admin.absensi.absen', $b->santri_id)}}', 'hadir', '{{$date}}')">Hadir</button>
                                    <button type="button" class="btn btn-sm btn-pill btn-danger" onclick="absen('{{route('admin.absensi.absen', $b->santri_id)}}', 'sakit', '{{$date}}')">Sakit</button>
                                    <button type="button" class="btn btn-sm btn-pill btn-warning" onclick="absen('{{route('admin.absensi.absen', $b->santri_id)}}', 'izin', '{{$date}}')">Izin</button>
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
    window.location = '/admin/absensi?date='+date+'&kelas='+kelas
}
</script>
@endpush
