@extends('layouts.app')

@section('title', 'Add Menu')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Add Menu</h1>
    <p class="mb-4">Add your menu here.</p>

    <!-- Content -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Menu Data</h6>
        </div>
        <form action="{{ route('merchant.menu.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="name" class="required">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="type">Type</label>
                    <select name="type" id="type" class="form-control">
                        <option value="" selected disabled>Select Type</option>
                        <option value="Food">Food</option>
                        <option value="Drink">Drink</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea type="text" class="form-control" id="description" name="description"></textarea>
                </div>
                <div class="form-group">
                    <label for="image">Image (Max 2 MB)</label>
                    <input type="file" class="form-control" id="image" name="image"
                        accept="image/jpeg,image/png,image/jpg">
                </div>
                <div class="form-group">
                    <label for="price" class="required">Price per Item (Rp)</label>
                    <input type="text" class="form-control" id="price" name="price" required>
                </div>
                <p style="font-size: 14px"><span style="color: red">*</span> required</p>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('home') }}" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#price').mask('000.000.000', {
                reverse: true
            });
        });
    </script>
@endpush
