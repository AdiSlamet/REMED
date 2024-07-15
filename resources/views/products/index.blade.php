@extends('layouts.app')

@section('title', 'Data mahasiswa')

@section('contents')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="mb-0">Table</h1>
        <a href="{{ route('products.create') }}" class="btn btn-primary">Add</a>
    </div>
    <hr />
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Nim</th>
                    <th>Jurusan</th>
                    <th>Description</th>
                    <th>Profile Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if($products->count() > 0)
                    @foreach($products as $product)
                        <tr>
                            <td class="align-middle">{{ $loop->iteration }}</td>
                            <td class="align-middle">{{ $product->title }}</td>
                            <td class="align-middle">{{ $product->price }}</td>
                            <td class="align-middle">{{ $product->product_code }}</td>
                            <td class="align-middle">{{ $product->description }}</td>
                            <td class="align-middle">
                                @if($product->image)
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->title }}" width="50">
                                @else
                                    No Image
                                @endif
                            </td>
                            <td class="align-middle">
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                    <a class="btn btn-secondary" href="{{ route('products.show', $product->id) }}">Detail</a>
                                    <a class="btn btn-warning" href="{{ route('products.edit', $product->id) }}">Edit</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Delete?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="7">Data not found</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection