<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Services\DataTableService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DB::table('galleries')
            ->select('id', 'title', 'image', 'category', 'order_index', 'is_active', 'created_at');

        $data = app(DataTableService::class)->make($query, [
            'columns' => [
                ['key' => 'title', 'label' => 'Judul Kegiatan', 'sortable' => true, 'type' => 'primary'],
                ['key' => 'image', 'label' => 'Foto', 'type' => 'image'],
                ['key' => 'category', 'label' => 'Kategori', 'sortable' => true, 'type' => 'badge'],
                ['key' => 'status', 'label' => 'Status', 'sortable' => true, 'type' => 'status'],
                ['key' => 'actions', 'label' => 'Aksi', 'type' => 'actions'],
            ],
            'searchable' => ['title', 'category'],
            'sortable' => ['title', 'category', 'is_active', 'created_at'],
            'actions' => ['edit', 'delete'],
            'route' => 'admin.galleries',
            'routeParam' => 'gallery',
            'title' => 'Manajemen Galeri',
            'entity' => 'galeri',
            'createLabel' => 'Tambah Foto Galeri',
            'searchPlaceholder' => 'Cari judul atau kategori...',
            'filter' => [
                'key' => 'status',
                'column' => 'is_active',
                'options' => [
                    '' => 'Semua Status',
                    'active' => 'Aktif',
                    'inactive' => 'Non-Aktif',
                ]
            ],
            'transformer' => function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title ?? 'N/A',
                    'image' => $item->image ? asset($item->image) : null,
                    'category' => $item->category ?? 'Kegiatan',
                    'is_active' => $item->is_active,
                    'status' => ($item->is_active == 1),
                ];
            },
        ], $request);

        if ($request->wantsJson()) {
            return response()->json($data);
        }

        return view('admin.galleries.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $baseCategories = ['Kursus', 'Pelatihan', 'Go to School', 'Holiday Program'];
        $existingCategories = Gallery::distinct()->pluck('category')->filter()->values()->toArray();
        $categories = array_values(array_unique(array_merge($baseCategories, $existingCategories)));

        return view('admin.galleries.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'new_category' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'required|boolean',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $category = $request->category;
        if ($category === '__new__' || !empty($request->new_category)) {
            $category = trim($request->new_category);
        }
        $category = $category ?: 'Kegiatan';

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/galleries'), $filename);
            $imagePath = 'uploads/galleries/' . $filename;
        }

        Gallery::create([
            'title' => $request->title,
            'category' => $category,
            'description' => $request->description,
            'order_index' => 0,
            'is_active' => (bool)$request->is_active,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Foto galeri berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $gallery = Gallery::findOrFail($id);
        $baseCategories = ['Kursus', 'Pelatihan', 'Go to School', 'Holiday Program'];
        $existingCategories = Gallery::distinct()->pluck('category')->filter()->values()->toArray();
        $categories = array_values(array_unique(array_merge($baseCategories, $existingCategories)));

        return view('admin.galleries.edit', compact('gallery', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'new_category' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $category = $request->category;
        if ($category === '__new__' || !empty($request->new_category)) {
            $category = trim($request->new_category);
        }
        $category = $category ?: ($gallery->category ?: 'Kegiatan');

        $imagePath = $gallery->image;
        if ($request->hasFile('image')) {
            // Hapus file lama jika ada
            if ($imagePath && file_exists(public_path($imagePath))) {
                @unlink(public_path($imagePath));
            }

            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/galleries'), $filename);
            $imagePath = 'uploads/galleries/' . $filename;
        }

        $gallery->update([
            'title' => $request->title,
            'category' => $category,
            'description' => $request->description,
            'is_active' => (bool)$request->is_active,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Foto galeri berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $gallery = Gallery::findOrFail($id);

            // Hapus file fisik jika ada
            if ($gallery->image && file_exists(public_path($gallery->image))) {
                @unlink(public_path($gallery->image));
            }

            $gallery->delete();

            return response()->json(['success' => true, 'message' => 'Foto galeri berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menghapus foto galeri'], 500);
        }
    }
}
