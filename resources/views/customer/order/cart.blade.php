@extends('layouts.app')

@section('title', 'Cart')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Cart</h1>
    <p class="mb-4">Your cart.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Cart</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="table_cart" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Merchant</th>
                            <th>Price per Items</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($cart) == 0)
                            <tr>
                                <td colspan="8" class="text-center">Cart is empty.</td>
                            </tr>
                        @else
                            @foreach ($cart as $c)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $c->name }}</td>
                                    <td>{{ $c->attributes->type }}</td>
                                    <td>{{ $c->attributes->merchant }}</td>
                                    <td>Rp {{ number_format($c->price, 0, ',', '.') }}</td>
                                    <td>{{ $c->quantity }}</td>
                                    <td>Rp {{ number_format($c->getPriceSum(), 0, ',', '.') }}</td>
                                    <td>
                                        <form action="{{ route('customer.order.remove-from-cart', $c->id) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-danger"><i
                                                    class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div>
                <a href="{{ route('customer.order.index') }}" class="btn btn-primary">Order More</a>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Order Summary</h6>
        </div>
        <form action="{{ route('customer.order.checkout') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="total_price"><b>Total Price:</b></label>
                    <p>Rp {{ number_format($total, 0, ',', '.') }}</p>
                    <input type="hidden" name="total_price" value="{{ $total }}">
                </div>
                <div class="form-group">
                    <label for="address" class="required"><b>Addres Delivery:</b></label>
                    <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="date" class="required"><b>Date Delivery:</b></label>
                    <input class="form-control" id="date" name="date" type="datetime-local" required>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Order</button>
            </div>
        </form>
    </div>


@endsection
