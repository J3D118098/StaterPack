@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="jumbotron jumbotron-fluid">
                @if (session('Pesan'))
                    <div class="alert alert-success" role="alert">
                        {{ session('Pesan') }}
                    </div>
                @endif
                <div class="container">
                    <h1 class="display-4">{{ $categories->category }}</h1>
                    <p class="lead">{{ $categories->description }}</p>
                    <div class="list-group">
                        @foreach ($categories->posts as $post)
                            <a href="/posts/{{$post->slug}}/show" class="list-group-item list-group-item-action list-group-item-secondary">{{ $post->name_video }}</a>
                        @endforeach
                    </div>
                    <br>
                </div>

                @hasrole('admin')
                    <form class="m-2" action="{{ route('category.delete', ['category' => $categories->slug]) }}"
                        method="POST">
                        @method('DELETE')
                        @csrf
                        <a href="{{route('category.edit',['category'=> $categories->slug])}}" class="btn btn-info btn-md active" role="button" aria-pressed="true">Edit</a>
                        <button type="submit" class="btn btn-danger ml-3">Delete</button>
                    </form>
                @endhasrole
                <a href="{{route('category.index')}}" class="btn btn-info btn-md ml-2 secondary" role="button" aria-pressed="true">Kembali</a>

              </div>
        </div>
    </div>
</div>
@endsection
