<!-- resources/views/posts/show.blade.php -->

@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row justify-content-center" >
            <div class="col-md-8">
                <div class="card mb-4" style="max-height: 35vh; overflow-y: auto;">
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
                        <img src="{{ $post->img_ref }}" class="" alt="Post Image" style="max-height: 150px; max-width: 150px; padding: 10px;">
                        <p style="width: 70%;" class="card-text">{{ $post->content }}</p>
                    </div>
                </div>
                <hr>
                <i>comments</i>

                @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                <div class="alert alert-warning" role="alert">
                    {{ session('error') }}
                </div>
                @endif

                <div id="comments" style="max-height: 35vh; overflow-y: auto;">
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
                                    <div class="originalContent">
                                        <p class="card-text ">{{ $comment->content }}</p>
                                    </div>
                                </div>
                                <div class="card-footer" style="display: flex; justify-content: space-between; align-items: center; align-content: center">
                                    @if($comment->user_id == Auth::user()->id)
                                        <div class="comment-actions">
                                           <form action="{{route('deleteComment')}}" method="post" onsubmit="return confirmDelete()">
                                                @csrf
                                                @method("DELETE")
                                                <input type="hidden" name="comment_id" value="{{$comment->id}}">
                                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                                <input type="submit" class="deleteBtn" value="Delete">
                                            </form>

                                            <input type="button" class="btn btn-info editButton" style="background: rgba(0,0,0,0); border: 0; color: blue;" value="Edit">
                                            <input type="button" class="btn btn-secondary cancelButton" style="background: rgba(0,0,0,0); border: 0; color: red; display: none;" value="Cancel">
                                            <div class="update-form" style="display:none;">
                                                <form action="{{ route('updateComment') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="comment_id" value="{{$comment->id}}">
                                                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                                    <textarea style="min-width: 500px; min-height: 100px; max-height: 100px; max-width: 500px;" name="new_content" class="form-control newContent">{{$comment->content}}</textarea>
                                                    <input type="button" class="btn btn-success saveButton" value="Save">
                                                    <input type="button" class="btn btn-secondary cancelButton" style="background: rgba(0,0,0,0); border: 0; color: red;" value="Cancel">
                                                </form>
                                            </div>
                                </div>
                                    @endif
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
                        <img class="logo" src="{{Auth::user()->avatar_url}}">
                        <textarea  class="form-control" style="width: 68%; max-height: 50px" id="content_" name="content_"></textarea>
                        <input type="submit" class="btn btn-info text-center" style="width: 15%" value="Add">
                    </div>
                </form>

            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            $(document).on("click", ".editButton", function () {
                // Eltávolítjuk az előzőleg létrehozott "Cancel" gombokat
                $(".cancelButton").remove();

                // Hide the edit button, show the update form, and show the cancel button
                $(this).closest(".comment-actions").find(".editButton").hide();
                $(this).closest(".comment-actions").find(".update-form").show();

                // Hozzáadjuk az új "Cancel" gombot
                var cancelButton = $("<input type='button' class='btn btn-secondary cancelButton' style='background: rgba(0,0,0,0); border: 0; color: red;' value='Cancel'>");
                $(this).closest(".comment-actions").append(cancelButton);

                $(this).closest('.originalContent').hide();
            });

            $(document).on("click", ".cancelButton", function () {
                $(this).closest(".comment-actions").find(".update-form").hide();
                $(this).closest(".comment-actions").find(".editButton").show();
                $(this).remove(); // Eltávolítjuk a "Cancel" gombot
                $$(this)('.originalContent').show();
            });

            $(".saveButton").click(function () {
                // Hide the update form and show the edit button
                $(this).closest(".comment-actions").find(".update-form").hide();
                $(this).closest(".comment-actions").find(".editButton").show();
                $(this).closest(".comment-actions").find(".cancelButton").hide();
                $(this).closest('.originalContent').show();
                document.cookie = `XSRF-TOKEN=${$('meta[name="csrf-token"]').attr('content')}`;

                var apiEndpoint = "http://127.0.0.1:8000/api/updateComment";

                // var apiEndpoint = "{{ url('/api/updateComment') }}";

                $.ajax({
                    type: "POST",
                    url: apiEndpoint,
                    data: $(this).closest("form").serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function (response) {
                        console.log(response);
                        alert("Comment updated successfully!");
                        location.reload();
                    },
                    error: function (error) {
                        console.log(error);
                        alert("Error updating comment!");
                    }
                });
            });
        });
    </script>


@endsection
