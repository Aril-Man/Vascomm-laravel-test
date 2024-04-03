@extends('layouts.admin.app')
@section('title', 'Dashboard')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Jumlah User</h5>
                    <p class="card-text"><strong>{{ $data->sum_user }} Users</strong></p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Jumlah User Aktif</h5>
                    <p class="card-text"><strong>{{ $data->sum_user_active }} Users</strong></p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Product</h5>
                    <p class="card-text"><strong>{{ $data->sum_product }} Produk</strong></p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Produk Aktif</h5>
                    <p class="card-text"><strong>{{ $data->sum_product_active }} Produk</strong></p>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Product Terbaru</h5>
                    <div class="table-responsive">
                        <table class="table mt-2" id="data">
                            @if (count($data->products) > 0)
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data->products as $row)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $row->name }}</td>
                                            <td>{{ $row->created_at }}</td>
                                            <td>RP {{ number_format($row->price) }}</td>
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
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#data').DataTable();
        });
    </script>
@endsection
