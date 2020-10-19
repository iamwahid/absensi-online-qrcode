@extends('frontend.layouts.app')

@section('title', app_name() . ' | Absensi ')


@section('content')
<div class="row mb-4">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5 mb-3">
                        <h1 class="card-title mb-0">
                            Absensi 
                        </h1>
                        <stromg class="text-muted">silahkan scan QR Code dari Dosen</stromg>
                    </div><!--col-->
        
                    {{-- <div class="col-sm-7">
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
                                    <input name="date" id="date" type="date" value="{{request()->get('date')}}" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div><!--col--> --}}
                </div><!--row-->
        
                <div class="row mt-4">
                    <div class="col">
                        @include('includes.instascan')
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
    
</script>
@endpush
