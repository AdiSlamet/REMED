@extends('layouts.app')

@section('contents')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Data</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('products.index') }}"> Back</a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Nama:</label>
            <input type="text" name="title" class="form-control" value="{{ $product->title }}" required>
        </div>

        <div class="form-group">
            <label for="price">NIm:</label>
            <input type="text" name="price" class="form-control" value="{{ $product->price }}" required>
        </div>

        <div class="form-group">
            <label for="product_code">Jurusan:</label>
            <input type="text" name="product_code" class="form-control" value="{{ $product->product_code }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea name="description" class="form-control" required>{{ $product->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="image">Profile Image:</label>
            <input type="file" name="image" class="form-control" placeholder="image">
            <img src="{{ asset($product->image) }}" width="300px">
        </div>

        <div class="row">
            <div class="d-grid col-xs-12 col-sm-12 col-md-12 text-center">
                <hr><button type="submit" class="btn btn-warning">Update</button>
            </div>
        </div>
    </form>
@endsection