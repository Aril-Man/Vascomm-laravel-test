@extends('layouts.admin.app')
@section('head')
@section('title', 'List All Product')
@section('content')
    @include('admin.product.modal.create_product')
    @include('admin.product.modal.edit_product')
    <section class="section">
        <div class="section-header">
            <h1>List All Product</h1>
        </div>

        <div class="row mt-5">
            <div class="col-lg-15 col-md-12 col-12 col-sm-12">
                <div class="card">
                    @if (Session::has('success'))
                        <div class="alert alert-success alert-has-icon">
                            <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                            <div class="alert-body alert-dismissible fade show" role="alert">
                                <div class="alert-title">Success</div>
                                @php
                                    $msg = explode("|",Session::get('success'));
                                @endphp
                                {{$msg[0]}}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    @endif
                    @if (Session::has('error'))
                        <div class="alert alert-danger alert-has-icon">
                            <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                            <div class="alert-body alert-dismissible fade show" role="alert">
                                <div class="alert-title">Failed</div>
                                {{ Session::get('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-end mb-3">
                                    <a onclick="openModal()" class="btn btn-primary">Add Product</a>
                                </div>
                                <div class="table-responsive">
                                    <table class="table mt-2" id="data">
                                        @if (count($data->products) > 0)
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Price</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data->products as $row)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $row->name }}</td>
                                                        <td>RP {{ number_format($row->price) }}</td>
                                                        <td>
                                                            @if ($row->status != 'active')
                                                                <button class="btn btn-danger">Inactive</button>
                                                            @else
                                                                <button class="btn btn-success">Active</button>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-warning" onclick="openModalEdit('{{ $row->id }}')">Update</button>
                                                            <button class="btn btn-danger" onclick="openModalHapus('{{ $row->id }}', '{{ $row->name }}')">Hapus</button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        @else
                                            <h4 class="text-center">Data Not Found</h4>
                                        @endif
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#data').DataTable();
        });

        function openModal() {
            $('#create-product').trigger("reset");
            $('#modal_create_product').modal('show')
        }

        function openModalEdit(id) {
            $('#modal_edit_product').modal('show')

            const url = `{{ url('/admin/product' ) }}/${id}`

            $.ajax({
                url : url,
                type : 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success : function (result) {
                    $('#product_id').val(result.data.product.id);
                    $('#name').val(result.data.product.name);
                    $('#price').val(result.data.product.price);
                    var status = result.data.product.status;
                    if(status) {
                        $('input[name=status][value='+status+']').prop('checked', true);
                    }
                }
            })
        }

        function openModalHapus(id, name) {

            const url = `{{ url('/admin/product/delete') }}/${id}`

            Swal.fire({
            title: "Konfirmasi Hapus",
            text: `Apakah kamu yakin menghapus “${name}”?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
            }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: url,
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (result) {
                        if (result.status) {
                            Swal.fire({
                                title: "Deleted!",
                                text: result.message,
                                icon: "success"
                            });
                            setInterval(() => {
                                window.location.reload();
                            }, 2000);
                        } else {
                            Swal.fire({
                                title: "Deleted!",
                                text: result.message,
                                icon: "error"
                            });
                            setInterval(() => {
                                window.location.reload();
                            }, 2000);
                        }
                    }
                })


            }
            });
        }

    </script>
@endsection
