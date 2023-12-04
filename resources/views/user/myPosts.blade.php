
{{-- myPosts.blade.php --}}

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>My Posts</h1>

        <div class="row">
            @foreach($posts as $post)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">  <img src="{{ $post->img_ref }}" class="logo" alt="Post Image"> {{ $post->title }}</h5>
                            <p class="card-text">{{ $post->content }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
