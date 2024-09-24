@extends('layouts.app')

@section('title', 'Menu')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Menu</h1>
    <p class="mb-4">Add, show, edit, delete your menu here.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Menu</h6>
        </div>
        <div class="card-body">
            <a href="{{ route('merchant.menu.create') }}" class="btn btn-primary">Add Menu</a>
            <div class="table-responsive">
                <table class="table table-bordered" id="table_menu" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Description</th>
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
            var $table = $('#table_menu').DataTable({
                fixedHeader: true,
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ route('merchant.menu.index') }}',
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
                        data: 'description',
                        name: 'description'
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
        });

        $('#table_menu').on('click', '.delete', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this data!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
            }).then((result) => {
                if (result.isConfirmed) {
                    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    let url = "{{ route('merchant.menu.destroy', ':id') }}";
                    $.ajax({
                        url: url.replace(':id', id),
                        type: "DELETE",
                        data: {
                            _token: CSRF_TOKEN,
                        },
                        success: (response) => {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: response.success,
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 2000,
                                    timerProgressBar: true,
                                    allowOutsideClick: false,
                                });
                                $('#table_menu').DataTable().ajax.reload();
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: response.error,
                                    icon: 'error',
                                    showConfirmButton: false,
                                    timer: 2000,
                                    timerProgressBar: true,
                                    allowOutsideClick: false,
                                });
                            }
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                }
            });
        });
    </script>
@endpush
