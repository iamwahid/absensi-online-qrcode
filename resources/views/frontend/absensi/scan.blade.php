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
                </div><!--row-->
        
                <div class="row mt-4">
                    <div class="col">
                        @include('includes.instascan')
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
