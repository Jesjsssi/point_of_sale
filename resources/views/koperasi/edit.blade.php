@extends('dashboard.body.main')

@section('container')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Edit Koperasi</h4>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('koperasi.update', $koperasi->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                        <div class="form-group">
                            <label for="nama_koperasi">Nama Koperasi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_koperasi') is-invalid @enderror" id="nama_koperasi" name="nama_koperasi" value="{{ old('nama_koperasi', $koperasi->nama_koperasi) }}" required>
                            @error('nama_koperasi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3">{{ old('alamat', $koperasi->alamat) }}</textarea>
                            @error('alamat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="telepon">Telepon</label>
                            <input type="text" class="form-control @error('telepon') is-invalid @enderror" id="telepon" name="telepon" value="{{ old('telepon', $koperasi->telepon) }}">
                            @error('telepon')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $koperasi->email) }}">
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary mr-2">Simpan</button>
                            <a class="btn bg-danger" href="{{ route('koperasi.index') }}">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 