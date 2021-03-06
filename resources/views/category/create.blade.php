@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Tambah Kategori') }}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session('success') }}</strong>.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @elseif (session('danger'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ session('success') }}</strong>.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('category.post') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="category">{{ __('Name') }}</label>
                            <input id="category" type="text" class="form-control @error('category') is-invalid @enderror" name="category" value="{{ old('category') }}"  autocomplete="category" autofocus>
                            @error('category')
                                <span class="text-right invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">{{ __('Description') }}</label>
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" autocomplete="description" rows="5" autofocus>{{ old('description') }}</textarea>
                            @error('description')
                                <span class="text-right invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text">Image</span>
                            </div>
                            <div class="custom-file">
                                <input id="image" aria-describedby="image" type="file" class="custom-file-input @error('image') is-invalid @enderror" name="image" autocomplete="image" autofocus>
                                <label class="custom-file-label" for="image">Choose file</label>
                            </div>
                        </div>

                        <div class="offset-md-9">
                            <a href="{{route('category.index')}}" class="btn btn-info btn-md secondary" role="button" aria-pressed="true">Kembali</a>
                            <button type="submit" class="btn btn-dark">
                                {{ __('Submit') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
