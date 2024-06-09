<?php

namespace App\Http\Controllers\Admin;

use App\Models\Type;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Requests\TypeRequest;
use App\Http\Controllers\Controller;

class TypeController extends Controller
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
            $query = Type::query();

            return DataTables::of($query)
                ->addColumn('action', function ($type) {
                    return '
                <a class="block w-full px-2 py-1 mb-1 text-xs text-center text-white transition duration-500 bg-gray-700 border border-gray-700 rounded-md select-none ease hover:bg-gray-800 focus:outline-none focus:shadow-outline" 
                    href="' . route('admin.types.edit', $type->id) . '">
                    Sunting
                </a>
                <form class="block w-full" onsubmit="return confirm(\'Apakah anda yakin?\');" -block" action="' . route('admin.types.destroy', $type->id) . '" method="POST">
                <button class="w-full px-2 py-1 text-xs text-white transition duration-500 bg-red-500 border border-red-500 rounded-md select-none ease hover:bg-red-600 focus:outline-none focus:shadow-outline" >
                    Hapus
                </button>
                    ' . method_field('delete') . csrf_field() . '
                </form>';
                })
                ->rawColumns(['action'])
                ->make();
        }

        // Script untuk return halaman view type / untuk mengarahkan Laravel agar memuat dan mengembalikan file tampilan
        return view('admin.types.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.types.create');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TypeRequest $request)
    {
        // Untuk menyimpan data yang sudah kita inputkan
        // return $request->all(); // Cek data

        $data = $request->all();
        $data['slug'] = Str::slug($data['name'] .  '-' . Str::lower(Str::random(5))); // agar saat create slug data tidak ada yang sama (Random)

        // Untuk menyimpan data
        Type::create($data);

        // return $data;

        return redirect()->route('admin.types.index')->with('success', 'Type berhasil ditambahkan');
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
    public function edit(Type $type)
    {
        // $type = Type::where('slug', $slug)->firstOrFail();

        return view('admin.types.edit', [
            'type' => $type,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TypeRequest $request, Type $type)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($data['name'] .  '-' . Str::lower(Str::random(5))); // berfungsi untuk menghasilkan string slug yang unik dari nama Type dan 5 karakter random.

        //  memperbarui data Type di dalam database sesuai dengan data yang di-inputkan oleh user melalui form.
        $type->update($data);

        // dipanggil untuk mengarahkan user kembali ke halaman daftar Type setelah data berhasil diupdate.
        return redirect()->route('admin.types.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {
        // method delete() dipanggil pada instance $type untuk menghapusnya dari database
        $type->delete();

        return redirect()->route('admin.types.index');
    }
}
