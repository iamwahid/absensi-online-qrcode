@extends('frontend.layouts.app')

@section('title', app_name() . ' | Penilaian Pengguna' )

@push('after-styles')
<style>
.rating {
  display: inline-flex;
  flex-direction: row-reverse;
}

#show-rating {
    border: 1px solid rgba(0, 0, 0, 0.37);
    border-radius: 20px;
    padding: 20px;
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

input[type="radio" i] {
  width: 20px;
  height: 20px;
  margin: 5px;
  color: rgba(128, 128, 128, 0.575);
  /* border: 1px solid black; */
  transition: all 0.3s ease-in;
  appearance: unset !important;
  border: unset !important;
}

input:hover ~ input,
input:hover {
  color: rgb(255, 238, 2);
}

input:checked ~ input,
input:checked {
  color: rgb(255, 238, 2);
}
</style>
@endpush

@section('content')
    <div class="row mb-4">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>
                        Beri Nilai Aplikasi
                    </strong>
                </div><!--card-header-->

                <div class="card-body">
                    @if (auth()->user()->rating && !request()->get('edit'))
                    <h3>Penilaian anda</h3>
                    <div id="show-rating">
                        <div class="rating">
                            <i class="fas fa-star {{ auth()->user()->rating->stars == 5 ? 'rated' : '' }}"></i>
                            <i class="fas fa-star {{ auth()->user()->rating->stars == 4 ? 'rated' : '' }}"></i>
                            <i class="fas fa-star {{ auth()->user()->rating->stars == 3 ? 'rated' : '' }}"></i>
                            <i class="fas fa-star {{ auth()->user()->rating->stars == 2 ? 'rated' : '' }}"></i>
                            <i class="fas fa-star {{ auth()->user()->rating->stars == 1 ? 'rated' : '' }}"></i>
                        </div>
                        <p>
                            {{ auth()->user()->rating->message }}
                        </p>
                    </div>
                    <a href="?edit=1" class="btn btn-success mt-3">Ubah Penilaian</a>
                    @else
                    <div class="rating-form">
                        {{ html()->modelForm(auth()->user()->rating, 'POST', route('frontend.rating.post'))->open() }}
                        <div class="rating">
                            {{ html()->radio('stars', false, 5)->class('fas fa-star rating-item') }}
                            {{ html()->radio('stars', false, 4)->class('fas fa-star rating-item') }}
                            {{ html()->radio('stars', false, 3)->class('fas fa-star rating-item') }}
                            {{ html()->radio('stars', false, 2)->class('fas fa-star rating-item') }}
                            {{ html()->radio('stars', false, 1)->class('fas fa-star rating-item') }}
                        </div>
                        <div class="row my-3">
                            <div class="col">
                                {{ html()->textarea('message')->class('form-control')->attribute('rows', 4) }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-success form-control">Simpan Penilaian</button>
                            </div>
                        </div>
                        {{ html()->form()->close() }}
                    </div>
                    @endif

                </div><!--card-body-->
            </div><!-- card -->
        </div><!-- row -->
    </div><!-- row -->
@endsection

@push('after-scripts')
<script>
$('.rating-item').click(function(e){
    if ($(this).prop('checked') || $(this).siblings(':checked').length > 0 || $('.rating-item:checked').length == 0) {
        // $('.rating-item').removeProp('checked');
        // $(this).addClass('checked');
    }
})
</script>
@endpush
