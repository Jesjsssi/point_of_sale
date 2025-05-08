<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Koperasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class KoperasiController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->roles->contains('name', 'superadmin')) {
                abort(403, 'Unauthorized action.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $row = (int) request('row', 10);

        if ($row < 1 || $row > 100) {
            abort(400, 'The per-page parameter must be an integer between 1 and 100.');
        }

        return view('koperasi.index', [
            'koperasi' => Koperasi::filter(request(['search']))
                ->sortable()
                ->paginate($row)
                ->appends(request()->query()),
        ]);
    }

    public function create()
    {
        return view('koperasi.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_koperasi' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255|unique:koperasi,email',
        ]);

        Koperasi::create($validatedData);

        return Redirect::route('koperasi.index')->with('success', 'Koperasi berhasil ditambahkan!');
    }

    public function edit(Koperasi $koperasi)
    {
        return view('koperasi.edit', [
            'koperasi' => $koperasi
        ]);
    }

    public function update(Request $request, Koperasi $koperasi)
    {
        $validatedData = $request->validate([
            'nama_koperasi' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255|unique:koperasi,email,'.$koperasi->id,
        ]);

        $koperasi->update($validatedData);

        return Redirect::route('koperasi.index')->with('success', 'Koperasi berhasil diperbarui!');
    }

    public function destroy(Koperasi $koperasi)
    {
        // Check if koperasi has any related data
        if ($koperasi->users()->exists() || 
            $koperasi->products()->exists() || 
            $koperasi->customers()->exists() || 
            $koperasi->suppliers()->exists() || 
            $koperasi->orders()->exists()) {
            return Redirect::route('koperasi.index')
                ->with('error', 'Koperasi tidak dapat dihapus karena masih memiliki data terkait!');
        }

        $koperasi->delete();

        return Redirect::route('koperasi.index')->with('success', 'Koperasi berhasil dihapus!');
    }
} 