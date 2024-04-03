<div class="modal fade" id="modal_edit_product" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.product.update') }}" id="create-product" class="needs-validation" enctype="multipart/form-data">
                @method('patch')
                @csrf

                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-black" id="staticBackdropLabel">Update Produk</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="product_id" id="product_id">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
                    <div class="form-group  mt-4">
                        <label>Harga Produk</label>
                        <input type="number" name="price" id="price" class="form-control">
                    </div>
                    <div class=" form-group mt-4">
                        <label>Foto Produk</label>
                        <input type="file" name="img" id="img" class="form-control">
                    </div>
                    <div class="form-group  mt-4">
                        <label>Status</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status1" value="active">
                            <label class="form-check-label" for="status1">
                            Active
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status2" value="inactive">
                            <label class="form-check-label" for="status2">
                            Inactive
                            </label>
                        </div>
                    </div>
                </div>
                <div class=" modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
