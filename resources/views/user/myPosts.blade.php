@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session('state'))
            <p  class="alert alert-primary" role="alert">{{session('state')}}</p>
        @endif

        <h1>My Posts</h1>
        <form id="filter_area" action="{{ route('myPosts') }}" method="GET">
            <div style="display: flex;  justify-content: space-between">
                <input class="form-control" style="width: 49%" type="text" placeholder="Filter for title" id="title" name="title" value="{{ request('title') }}">
                <input class="form-control" style="width: 49%"  type="text" placeholder="Filter for category" id="category" name="category" value="{{ request('category') }}">
            </div>
            <br>
            <i>Order by</i>
            <div style="display: flex; justify-content: space-between">
                <select class="form-control" style="width: 49%" name="orderBy" id="orderBy">
                    <option value="created_at" {{ request('orderBy') == 'created_at' ? 'selected' : '' }}>
                        Post created date
                    </option>
                    <option value="title" {{ request('orderBy') == 'title' ? 'selected' : '' }}>
                        Title
                    </option>
                    <option value="category" {{ request('orderBy') == 'category' ? 'selected' : '' }}>
                        Category
                    </option>
                </select>
                <select class="form-control" style="width: 49%" name="direction" id="direction">
                    <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>
                        Ascending order
                    </option>
                    <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>
                        Descending order
                    </option>
                </select>
            </div><br>

            <div style="display: flex;  justify-content: space-between">
                <input class="form-control" style="width:49%" type="number" min="1" max="50" placeholder="limit of shown posts per search" id="limit" name="limit" value="{{request('limit')}}">
                <input class="form-control" style="width:49%" type="text" placeholder="Written by" id="author" name="author" value="{{request('author')}}">
            </div><br>

            <input type="submit" class="form-control btn btn-success" value="Search">
        </form>

        <hr>

        <div class="row" style="display: flex; flex-direction: row; align-items: stretch; align-content: stretch">
            @foreach($posts as $post)
                <div class="col-md-4 mb-4">
                    <div class="card" style="height: 100%">
                        <div class="card-header">
                            <p class="card-text">written by {{ $post->user->name }}</p>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-center">  <img style="float: left" src="{{ $post->img_ref }}" class="postImg" alt="Post Image"> {{ $post->title }}</h5>
                            <h6 class="text-center">Category: {{  $post->category }}</h6>
                            <p class="card-text">{{ \Illuminate\Support\Str::limit($post->content, 75, $end=' ...') }}</p>
                        </div>
                        <div class="card-footer" >
                            <div style="display: flex; flex-direction: row; justify-content: space-between">
                                <small class="text-muted">
                                    {{ $post->comments_count }}
                                    {{ Str::plural('comment(s)', $post->comments_count) }}
                                </small>
                                <small class="text-muted">
                                    Date: {{ $post->created_at }}
                                </small>
                            </div>
                            <br>
                            <div style="display: flex; flex-direction: row; align-items: center; justify-content: space-between ">
                                <a href="{{route('viewPost', $post->id)}}">Go to post</a>
                                @if($post->user_id == \Illuminate\Support\Facades\Auth::user()->id)
                                    <a href="{{ route('editPost', $post->id) }}">Edit</a>
                                    <form action="{{route('deletePost', $post->id)}}" method="post" onsubmit="return confirmDelete()">
                                        @csrf
                                        @method("DELETE")
                                        <input type="submit" class="deleteBtn" value="Delete">
                                    </form>
                                @endif

                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this post?');
        }
    </script>
@endsection
