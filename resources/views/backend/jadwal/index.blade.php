@extends('backend.layouts.app')

@section('title', app_name() . ' | Jadwal')


@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    Jadwal <small class="text-muted">Daftar Jadwal</small>
                </h4>
            </div><!--col-->

            <div class="col-sm-7">
                <div class="float-right">
                    {{-- <select name="kelas" id="kelas" class="form-control">
                        <option value="" {{request()->get('kelas') == '' || request()->get('kelas') == null ? 'selected' : '' }}>Semua</option>
                        <option value="A" {{request()->get('kelas') == 'A' ? 'selected' : '' }}>Kelas A</option>
                        <option value="B" {{request()->get('kelas') == 'B' ? 'selected' : '' }}>Kelas B</option>
                        <option value="C" {{request()->get('kelas') == 'C' ? 'selected' : '' }}>Kelas C</option>
                    </select> --}}
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
                            <th>Jadwal</th>
                            {{-- <th>No. UAS</th> --}}
                            {{-- <th>Nama</th> --}}
                            {{-- <th>Kelas / Kelas Umum</th> --}}
                            {{-- <th>Jilid</th> --}}
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                          @foreach ($jadwals as $k => $b)
                          <tr>
                            <td>
                                <strong>{{$k+1 .'. '.$b->dayname.' '.$b->start_time.' - '. $b->finish_time}} </strong>
                                <p class="mb-0">Mata Kuliah : {{$b->matkul->nama}}</p>
                                <p class="mb-0">Dosen : {{$b->dosen->user->name}}</p>
                                <p class="mb-0">Ruang : {{$b->room}}</p>
                                <div class="mt-2 text-center">
                                    <p>{!!$b->qr_code->html!!}</p>
                                    <strong>{{$b->qr_code->plain}}</strong>
                                </div>
                            </td>
                            <td>{!! $b->actions !!}</td>
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
function deleteItem(url) {
    if (confirm('Yakin Menghapus Jadwal?')) {
        // console.log(url);
        $.ajax({
            url: url,
            method: 'POST',
            data: {
                _method:'delete',
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(s) {
                window.location.reload(true)
            },
            error: function(e) {
                alert('Error');
            }
        })
    } else {
    // Do nothing
    }
}

let kelasselect = document.getElementById('kelas');

kelasselect.addEventListener('change', function(e){
    reloadData(this.value)
})

function reloadData(kelas) {
    window.location = '/admin/jadwal?kelas='+kelas
}
</script>
@endpush
