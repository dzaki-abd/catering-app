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
        });
    </script>
@endpush
