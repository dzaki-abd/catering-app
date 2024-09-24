@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Profile</h1>
    <p class="mb-4">Look and edit your profile here.</p>

    <!-- Content -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Profile Data</h6>
        </div>
        <form action="{{ route('profile.update', $id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="name" class="required">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $data->name }}"
                        required>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea type="text" class="form-control" id="address" name="address">{{ $data->address }}</textarea>
                </div>
                <div class="form-group">
                    <label for="contact">Contact</label>
                    <input type="text" class="form-control" id="contact" name="contact" value="{{ $data->contact }}">
                </div>
                <div class="form-group d-none merchant-description">
                    <label for="description">Description</label>
                    <textarea type="text" class="form-control" id="description" name="description">{{ $data->description }}</textarea>
                </div>
                <div class="form-group">
                    <label for="email" class="required">Email Address</label>
                    <input type="text" class="form-control" id="email" name="email"
                        value="{{ auth()->user()->email }}" readonly>
                </div>
                <div class="form-group">
                    <label for="password">Change Password</label>
                    <p>This feature is not yet available, please contact the admin via email <a
                            href="mailto:admin@email.com">admin@email.com</a> to change the password.</p>
                    {{-- <input type="text" class="form-control" id="password" name="password"
                        value="{{ auth()->user()->email }}" readonly> --}}
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
            var role = @json($data->role);

            if (role == 'merchant') {
                $('.merchant-description').removeClass('d-none');
            } else {
                $('.merchant-description').addClass('d-none');
            }
        });
    </script>
@endpush
