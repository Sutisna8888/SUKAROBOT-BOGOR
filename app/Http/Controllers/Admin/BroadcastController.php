<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DataTableService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BroadcastController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DB::table('broadcasts')
            ->select('id', 'message', 'created_at');

        $data = app(DataTableService::class)->make($query, [
            'columns' => [
                ['key' => 'message', 'label' => 'Pesan', 'sortable' => true, 'type' => 'primary'],
                ['key' => 'date', 'label' => 'Tanggal', 'sortable' => true, 'type' => 'date'],
                ['key' => 'actions', 'label' => 'Aksi', 'type' => 'actions'],
            ],
            'searchable' => ['message'],
            'sortable' => ['message', 'created_at'],
            'sortColumns' => [
                'date' => 'created_at',
            ],
            'actions' => ['edit', 'delete'],
            'route' => 'admin.broadcasts',
            'title' => 'Manajemen Broadcast',
            'entity' => 'broadcast',
            'createLabel' => 'Tambah Broadcast',
            'searchPlaceholder' => 'Cari pesan broadcast...',
            'showFilter' => false,
            'transformer' => function($broadcast) {
                return [
                    'id' => $broadcast->id,
                    'message' => $broadcast->message ?? 'N/A',
                    'date' => $broadcast->created_at ? date('d F Y H:i', strtotime($broadcast->created_at)) : '-',
                    'created_at' => $broadcast->created_at
                ];
            },
        ], $request);

        if ($request->wantsJson()) {
            return response()->json($data);
        }

        return view('admin.broadcasts.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.broadcasts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:5000'],
        ]);

        DB::transaction(function () use ($validated) {
            DB::table('broadcasts')->insert([
                'message' => $validated['message'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $timestamp = now();
            $notifications = DB::table('users')
                ->where('is_active', true)
                ->whereIn('role', ['user', 'instructor'])
                ->get(['id'])
                ->map(function ($user) use ($validated, $timestamp) {
                    return [
                        'user_id' => $user->id,
                        'type' => 'broadcast',
                        'title' => 'Broadcast',
                        'message' => $validated['message'],
                        'link' => null,
                        'is_read' => false,
                        'created_at' => $timestamp,
                        'updated_at' => $timestamp,
                    ];
                })
                ->all();

            foreach (array_chunk($notifications, 500) as $chunk) {
                DB::table('notifications')->insert($chunk);
            }
        });

        return redirect()->route('admin.broadcasts.index')
            ->with('success', 'Broadcast berhasil dikirim');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $broadcast = DB::table('broadcasts')->where('id', $id)->firstOrFail();

        return view('admin.broadcasts.edit', compact('broadcast'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $broadcastQuery = DB::table('broadcasts')->where('id', $id);
        if (!$broadcastQuery->exists()) {
            abort(404);
        }

        $broadcastQuery->update([
            'message' => $validated['message'],
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.broadcasts.index')
            ->with('success', 'Broadcast berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            DB::table('broadcasts')->where('id', $id)->delete();
            return response()->json(['success' => true, 'message' => 'Broadcast berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menghapus broadcast'], 500);
        }
    }
}
