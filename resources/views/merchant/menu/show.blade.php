@extends('layouts.app')

@section('title', 'Detail Menu')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Detail Menu</h1>
    <p class="mb-4">Your detail menu here.</p>

    <!-- Content -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detail Menu</h6>
        </div>

        <div class="card-body">
            <div class="form-group">
                <label for="name"><b>Name:</b></label>
                <p id="name" name="name">{{ $data->name }}</p>
            </div>
            <div class="form-group">
                <label for="type"><b>Type:</b></label>
                <p id="type" name="type">{{ $data->type }}</p>
            </div>
            <div class="form-group">
                <label for="description"><b>Description:</b></label>
                <p id="description" name="description"> {{ $data->description }} </p>
            </div>
            <div class="form-group">
                <label for="image"><b>Image</b></label>
                <br>
                <img src="{{ asset('images/' . $data->image) }}" alt="Image" class="img-fluid">
            </div>
            <div class="form-group">
                <label for="price"><b>Price per Item</b></label>
                <p id="price" name="price">Rp {{ number_format($data->price, 0, ',', '.') }}</p>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('merchant.menu.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
@endsection
