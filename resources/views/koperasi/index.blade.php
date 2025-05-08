@extends('dashboard.body.main')

@section('container')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            @if (session()->has('success'))
                <div class="alert text-white bg-success" role="alert">
                    <div class="iq-alert-text">{{ session('success') }}</div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="ri-close-line"></i>
                    </button>
                </div>
            @endif
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="mb-3">Daftar Koperasi</h4>
                </div>
                <div>
                    @can('koperasi.create')
                    <a href="{{ route('koperasi.create') }}" class="btn btn-primary add-list"><i class="fa-solid fa-plus mr-3"></i>Tambah</a>
                    @endcan
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <form action="{{ route('koperasi.index') }}" method="get">
                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <div class="form-group row">
                        <label for="row" class="col-sm-3 align-self-center">Row:</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="row">
                                <option value="10" @if(request('row') == '10')selected="selected"@endif>10</option>
                                <option value="25" @if(request('row') == '25')selected="selected"@endif>25</option>
                                <option value="50" @if(request('row') == '50')selected="selected"@endif>50</option>
                                <option value="100" @if(request('row') == '100')selected="selected"@endif>100</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-lg-12">
            <div class="table-responsive rounded mb-3">
                <table class="table mb-0">
                    <thead class="bg-white text-uppercase">
                        <tr class="ligth ligth-data">
                            <th>No.</th>
                            <th>Nama Koperasi</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="ligth-body">
                        @forelse ($koperasi as $item)
                        <tr>
                            <td>{{ (($koperasi->currentPage() * 10) - 10) + $loop->iteration }}</td>
                            <td>{{ $item->nama_koperasi }}</td>
                            <td>{{ $item->alamat ?? '-' }}</td>
                            <td>{{ $item->telepon ?? '-' }}</td>
                            <td>{{ $item->email ?? '-' }}</td>
                            <td>
                                <div class="d-flex align-items-center list-action">
                                    @can('koperasi.edit')
                                    <a class="badge bg-success mr-2" data-toggle="tooltip" data-placement="top" title="Edit"
                                        data-original-title="Edit" href="{{ route('koperasi.edit', $item->id) }}"><i class="fa-solid fa-pen-to-square"></i></a>
                                    @endcan

                                    @can('koperasi.delete')
                                    <form action="{{ route('koperasi.destroy', $item->id) }}" method="POST" style="margin-bottom: 0px">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="badge bg-danger border-0" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Data tidak tersedia</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $koperasi->links() }}
        </div>
    </div>
</div>
@endsection 