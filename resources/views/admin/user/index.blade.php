@extends('layouts.admin.app')
@section('head')
@section('title', 'List All User')
@section('content')
    @include('admin.user.modal.create_user')
    @include('admin.user.modal.edit_user')
    <section class="section">
        <div class="section-header">
            <h1>List All User</h1>
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
                                    <a onclick="openModal()" class="btn btn-primary">Add User</a>
                                </div>
                                <div class="table-responsive">
                                    <table class="table mt-2" id="data">
                                        @if (count($data->users) > 0)
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>No. Telpon</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data->users as $row)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $row->name }}</td>
                                                        <td>{{ $row->email }}</td>
                                                        <td>{{ $row->phone }}</td>
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
            $('#create-user').trigger("reset");
            $('#modal_create_user').modal('show')
        }

        function openModalEdit(id) {
            $('#modal_edit_user').modal('show')

            const url = `{{ url('/admin/user' ) }}/${id}`

            $.ajax({
                url : url,
                type : 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success : function (result) {
                    $('#user_id').val(result.data.user.id);
                    $('#name').val(result.data.user.name);
                    $('#email').val(result.data.user.email);
                    $('#phone').val(result.data.user.phone);
                    var status = result.data.user.status;
                    if(status) {
                        $('input[name=status][value='+status+']').prop('checked', true);
                    }
                }
            })
        }

        function openModalHapus(id, name) {

            const url = `{{ url('/admin/user/delete') }}/${id}`

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
