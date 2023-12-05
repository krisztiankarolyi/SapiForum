@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create New Post</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('storePost') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="category">Category:</label>
                                <input type="text" class="form-control @error('category') is-invalid @enderror" id="category" name="category" required>
                                @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" required>
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="content">Content:</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="4" required></textarea>
                                @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="img_ref">Image Reference:</label>
                                <input type="text" class="form-control @error('img_ref') is-invalid @enderror" id="img_ref" name="img_ref">
                                @error('img_ref')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Create Post</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
