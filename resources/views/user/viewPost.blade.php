<!-- resources/views/posts/show.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center" >
            <div class="col-md-8">
                <div class="card mb-4" style="max-height: 40vh">
                    <div class="card-header" style="display: flex; flex-direction: row; align-items: center; align-content: center; justify-content: space-between">
                        <p class="card-text">written by
                            <img class="avatarSmall" src="{{$post->user->avatar_url}}">
                            {{ $post->user->name }}
                        </p>
                        <h3>{{$post->title}}</h3>
                        <i>
                            {{ $post->created_at }}
                        </i>

                    </div>
                    <div class="card-body" style="display: flex; flex-direction: row; justify-content: space-between;">
                        <img src="{{ $post->img_ref }}" class="img-fluid" alt="Post Image" style="width: 25%; height: 25%; max-height: 250px; max-width: 250px;">
                        <p style="width: 70%;" class="card-text">{{ $post->content }}</p>
                    </div>
                </div>
                <hr>
                <i>comments</i>
                <div id="comments" style="max-height: 40vh; overflow-y: auto;">
                    @foreach($post->comments as $comment)
                        <div class="card mb-2">
                            <div class="card" style="height: 100%;">
                                <div class="card-header" style="display: flex; flex-direction: row; align-items: center; align-content: center; justify-content: space-between">
                                    <i class="card-text">
                                        <img class="avatarSmall" src="{{$comment->user->avatar_url}}">
                                        {{ $comment->user->name }}
                                    </i>
                                    <i>
                                        {{ $comment->added_at }}
                                    </i>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">{{ $comment->content }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
        <hr>
                <form id="addComment" method="post" action="{{ route('addComment') }}">
                    @csrf
                    <input type="hidden" value="{{ Auth::user()->id }}" name="user_id">
                    <input type="hidden" value="{{ $post->id }}" name="post_id">
                    <i>Add your comment here</i>
                    <div style="display: flex; flex-direction: row; justify-content: space-between; align-content: center; align-items: center">
                        <img class="logo" src="{{$post->user->avatar_url}}">
                        <textarea  class="form-control" style="width: 68%; max-height: 50px" id="content_" name="content_">
                        </textarea>
                        <input type="submit" class="btn btn-info text-center" style="width: 15%" value="Add">
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
