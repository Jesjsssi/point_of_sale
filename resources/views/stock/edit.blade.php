@extends('dashboard.body.main')

@section('container')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Edit Stock</h4>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('stock.update', $product->id) }}" method="POST">
                            @csrf
                            @method('put')
                            <!-- Product Name -->
                            <div class="form-group">
                                <label class="form-label" for="product_name">Nama Produk:</label>
                                <input type="text" class="form-control" value="{{ $product->product_name }}" disabled>
                            </div>

                            <!-- Current Stock -->
                            <div class="form-group">
                                <label class="form-label" for="current_stock">Stok Saat Ini:</label>
                                <input type="text" class="form-control" value="{{ $product->product_store }}" disabled>
                            </div>

                             <!-- Operation Type -->
                            <div class="form-group">
                                <label class="form-label" for="operation">Tipe Operasi:</label>
                                <select class="form-control @error('operation') is-invalid @enderror" name="operation"
                                    id="operation">
                                    <option value="add">Tambah Stok</option>
                                    <option value="subtract">Kurangi Stok</option>
                                </select>
                                @error('operation')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Add/Subtract Stock -->
                            <div class="form-group">
                                <label class="form-label" for="stock_change">Ubah Stok:</label>
                                <input type="number" class="form-control @error('stock_change') is-invalid @enderror"
                                    name="stock_change" id="stock_change">
                                @error('stock_change')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                           

                            <button type="submit" class="btn btn-primary">Update Stock</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection