@extends('layouts.app')

@section('title', 'Order')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Order</h1>
    <p class="mb-4">Order your menu here.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Menu</h6>
        </div>
        <div class="card-body">
            <h6><b>Filter:</b></h6>
            <div class="form-group row">
                <div class="col">
                    <label for="type">Type:</label>
                    <select class="form-control" id="type" name="type">
                        <option value="" selected>All</option>
                        <option value="Food">Food</option>
                        <option value="Drink">Drink</option>
                    </select>
                </div>
                <div class="col">
                    <label for="merchant">Merchant:</label>
                    <select class="form-control" id="merchant" name="merchant">
                        <option value="" selected>All</option>
                        @foreach ($merchant as $m)
                            <option value="{{ $m->name }}">{{ $m->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="table_menu" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Merchant</th>
                            <th>Price per Items</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modals Detail --}}
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Menu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name"><b>Name:</b></label>
                        <p id="name"></p>
                    </div>
                    <div class="form-group">
                        <label for="type"><b>Type:</b></label>
                        <p id="type"></p>
                    </div>
                    <div class="form-group">
                        <label for="description"><b>Description:</b></label>
                        <p id="description"></p>
                    </div>
                    <div class="form-group">
                        <label for="image"><b>Image</b></label>
                        <br id="br_image">
                    </div>
                    <div class="form-group">
                        <label for="price"><b>Price per Item</b></label>
                        <p id="price"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modals Detail --}}
    {{-- Modals Add To Cart --}}
    <div class="modal fade" id="addToCartModal" tabindex="-1" aria-labelledby="addToCartModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formAddToCart" action="{{ route('customer.order.add-to-cart') }}" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addToCartModalLabel">Add To Cart</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="order_name"><b>Order:</b></label>
                            <p id="order_name"></p>
                        </div>
                        <div class="form-group">
                            <label for="merchant_name"><b>Merchant:</b></label>
                            <p id="merchant_name"></p>
                        </div>
                        <div class="form-group">
                            <label for="quantity"><b>Quantity:</b></label>
                            <input type="number" class="form-control" id="quantity" name="quantity" value="1"
                                min="1" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="btnAddToCart">Add To Cart</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- End Modals Add To Cart --}}
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var type = $('#type').val();
            var merchant = $('#merchant').val();

            var table = $('#table_menu').DataTable({
                fixedHeader: true,
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: '{{ route('customer.order.index') }}',
                    type: 'GET',
                    data: function(d) {
                        d.type = $('#type').val();
                        d.merchant = $('#merchant').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'merchant',
                        name: 'merchant'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#type, #merchant').on('change', function() {
                table.draw();
            });

            $('#type').select2({
                theme: 'bootstrap4',
                width: '100%',
            });

            $('#merchant').select2({
                theme: 'bootstrap4',
                width: '100%',
            });

            $('#detailModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var data = table.row(button.parents('tr')).data();

                $('#detailModal #name').text(data.name);
                $('#detailModal #type').text(data.type);
                $('#detailModal #description').text(data.description);
                $('#detailModal #price').text(data.price);
                $('#detailModal #br_image').nextAll().remove();

                var img = document.createElement('img');
                img.src = '{{ asset('images/') }}' + '/' + data.image;
                img.alt = 'Image';
                img.className = 'img-fluid';
                img.width = 200;
                $('#br_image').after(img);
            });

            $('#addToCartModal').on('show.bs.modal', function(event) {
                var id = $(event.relatedTarget).data('id');
                var button = $(event.relatedTarget);
                var data = table.row(button.parents('tr')).data();

                $('#addToCartModal #id').val(id);
                $('#addToCartModal #order_name').text(data.name);
                $('#addToCartModal #merchant_name').text(data.merchant);
            });
        });
    </script>
@endpush
