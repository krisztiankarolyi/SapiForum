
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
                        <div class="card-footer">
                            <small class="text-muted">
                                {{ $post->comments->count() }}
                                {{ Str::plural('comment(s)', $post->comments->count()) }}
                            </small>
                            <div style="display: flex; flex-direction: row; align-items: center; justify-content: space-between ">
                                <a href="#">Edit</a>
                                <a href="#" class="text-danger">Delete</a>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
