@extends('app')

@section('content')
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <form action="{{ route('admin.upload:post') }}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                  <label for="input_image">Image</label>
                  <input type="file" id="input_image" name="image" required>
                </div>

                <div class="form-group">
                    <select class="form-control" name="album_id">
                        @foreach ($albums as $album)
                            <option value="{{ $album->id }}">{{ $album->title }}</option>
                        @endforeach
                        @foreach ($albumsDisabled as $album)
                            <option value="{{ $album->id }}">{{ $album->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="input_title">Title</label>
                    <input type="text" class="form-control" name="title" id="input_title" placeholder="Title" value="{{ old('title') }}" required autofocus>
                </div>

                <div class="form-group">
                    <label for="input_description">Description</label>
                    <textarea class="form-control" rows="3" name="description" id="input_description" placeholder="Description" required>{{ old('description') }}</textarea>
                </div>

                <button type="submit" class="btn btn-lg btn-primary">Save</button>
            </form>
        </div>
    </div>
@endsection
