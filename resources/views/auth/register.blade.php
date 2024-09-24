@extends('auth.layouts.app')

@section('title', 'Register')

@section('content')
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-register-image align-content-center">
                    <img src="{{ asset('img/logo.png') }}" alt="login" class="img-fluid">
                </div>
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                        </div>
                        <form class="user" method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group name">
                                <input id="name" type="text"
                                    class="form-control form-control-user @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" placeholder="Name" required
                                    autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="email" type="email"
                                    class="form-control form-control-user @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" placeholder="Email Address" required
                                    autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input id="password" type="password"
                                        class="form-control form-control-user @error('password') is-invalid @enderror"
                                        placeholder="Password" name="password" required autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-sm-6">
                                    <input id="password-confirm" type="password" class="form-control form-control-user"
                                        placeholder="Repeat Password" name="password_confirmation" required
                                        autocomplete="new-password">
                                </div>
                            </div>
                            <div class="form-group">
                                <select name="user_role" id="user_role" required
                                    class="form-control @error('user_role') is-invalid @enderror"
                                    style="border-radius: 10rem;">
                                    <option value="" selected disabled>Select Role</option>
                                    <option value="merchant">Merchant</option>
                                    <option value="customer">Customer</option>
                                </select>
                                @error('user_role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="merchant-container d-none">
                                <div class="form-group">
                                    <textarea id="address_merchant" type="text"
                                        class="form-control form-control-user @error('address') is-invalid @enderror" name="address_merchant"
                                        value="{{ old('address') }}" placeholder="Address Merchant" autocomplete="address"></textarea>
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input id="contact_merchant" type="text"
                                        class="form-control form-control-user @error('contact') is-invalid @enderror"
                                        name="contact_merchant" value="{{ old('contact') }}" placeholder="Contact Merchant"
                                        autocomplete="contact">
                                    @error('contact')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <textarea id="description_merchant" type="text"
                                        class="form-control form-control-user @error('description') is-invalid @enderror" name="description_merchant"
                                        value="{{ old('description') }}" placeholder="Description Merchant" autocomplete="description"></textarea>
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="customer-container d-none">
                                <div class="form-group">
                                    <textarea id="address_customer" type="text"
                                        class="form-control form-control-user @error('address') is-invalid @enderror" name="address_customer"
                                        value="{{ old('address') }}" placeholder="Address Customer" autocomplete="address"></textarea>
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input id="contact_customer" type="text"
                                        class="form-control form-control-user @error('contact') is-invalid @enderror"
                                        name="contact_customer" value="{{ old('contact') }}"
                                        placeholder="Contact Customer" autocomplete="contact">
                                    @error('contact')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Register Account
                            </button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="{{ route('login') }}">Already have an account? Login!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#user_role').select2({
            theme: 'bootstrap4',
            width: '100%'
        });

        $('#user_role').change(function() {
            var role = $(this).val();
            if (role == 'merchant') {
                $('.merchant-container').removeClass('d-none');
                $('.customer-container').addClass('d-none');
            } else if (role == 'customer') {
                $('.customer-container').removeClass('d-none');
                $('.merchant-container').addClass('d-none');
            } else {
                $('.merchant-container').addClass('d-none');
                $('.customer-container').addClass('d-none');
            }
        });
    </script>
@endsection
