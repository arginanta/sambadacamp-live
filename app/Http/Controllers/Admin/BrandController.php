<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use App\Http\Requests\BrandRequest;
use App\Http\Controllers\Controller;

// Brand adalah sebuah model yang merepresentasikan tabel brands dalam database dan akan digunakan untuk melakukan query dan manipulasi data pada tabel tersebut.
// Str adalah sebuah class utility untuk memanipulasi string.
// DataTables adalah sebuah class yang menyediakan fitur untuk mengatur tampilan dan sifat dari sebuah tabel yang akan ditampilkan.
// BrandRequest adalah sebuah class yang merepresentasikan form request yang digunakan untuk melakukan validasi data sebelum disimpan ke dalam database.

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Script untuk DataTables, AJAX
        if (request()->ajax()) {
            $query = Brand::query();

            return DataTables::of($query)
                ->addColumn('action', function ($brand) {
                    return '
                <a class="block w-full px-2 py-1 mb-1 text-xs text-center text-white transition duration-500 bg-gray-700 border border-gray-700 rounded-md select-none ease hover:bg-gray-800 focus:outline-none focus:shadow-outline" 
                    href="' . route('admin.brands.edit', $brand->id) . '">
                    Sunting
                </a>
                <form class="block w-full" onsubmit="return confirm(\'Apakah anda yakin?\');" -block" action="' . route('admin.brands.destroy', $brand->id) . '" method="POST">
                <button class="w-full px-2 py-1 text-xs text-white transition duration-500 bg-red-500 border border-red-500 rounded-md select-none ease hover:bg-red-600 focus:outline-none focus:shadow-outline" >
                    Hapus
                </button>
                    ' . method_field('delete') . csrf_field() . '
                </form>';
                })
                ->rawColumns(['action'])
                ->make();
        }

        // Script untuk return halaman view brand / untuk mengarahkan Laravel agar memuat dan mengembalikan file tampilan
        return view('admin.brands.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandRequest $request)
    {
        // Untuk menyimpan data yang sudah kita inputkan
        // return $request->all(); // Cek data

        $data = $request->all();
        $data['slug'] = Str::slug($data['name'] .  '-' . Str::lower(Str::random(5))); // agar saat create slug data tidak ada yang sama (Random)

        // Untuk menyimpan data
        Brand::create($data);

        // return $data;

        return redirect()->route('admin.brands.index')->with('success', 'Brand berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit (Brand $brand)
    {
        return view('admin.brands.edit', [
            'brand' => $brand,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BrandRequest $request, Brand $brand)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($data['name'] .  '-' . Str::lower(Str::random(5))); // berfungsi untuk menghasilkan string slug yang unik dari nama Brand dan 5 karakter random.

        //  memperbarui data Brand di dalam database sesuai dengan data yang di-inputkan oleh user melalui form.
        $brand->update($data);

        // dipanggil untuk mengarahkan user kembali ke halaman daftar Brand setelah data berhasil diupdate.
        return redirect()->route('admin.brands.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        // method delete() dipanggil pada instance $brand untuk menghapusnya dari database
        $brand->delete();

        return redirect()->route('admin.brands.index');
    }
}
