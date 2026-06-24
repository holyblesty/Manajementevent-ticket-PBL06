<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Models\{Event, Tiket, KategoriEvent};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, File, Auth};

class AcaraController extends Controller
{
    public function store(StoreEventRequest $request)
    {
        DB::transaction(function () use ($request) {
            $imageName = time() . '_' . $request->poster->hashName();
            $request->poster->move(public_path('images'), $imageName);

            Event::create(array_merge($request->validated(), [
                'poster' => $imageName,
                'id_admin' => Auth::id(),
                'kapasitas' => 0,
            ]));
        });

        return redirect()->route('admin.dashboard')->with('success', 'Event berhasil dibuat.');
    }

    public function updateTiket(Request $request, int $id_event)
    {
        $request->validate(['tiket' => 'required|array']);

        DB::transaction(function () use ($request, $id_event) {
            foreach ($request->tiket as $data) {
                Tiket::updateOrCreate(
                    ['id_event' => $id_event, 'jenis_tiket' => $data['nama']],
                    [
                        'harga' => $data['harga'],
                        'kuota_total' => $data['kuota'],
                        'kuota_tersedia' => $data['kuota'],
                        'deskripsi_tiket' => $data['deskripsi'] ?? null,
                    ]
                );
            }
            // Biarkan DB yang menghitung kapasitas agar akurat
            $total = Tiket::where('id_event', $id_event)->sum('kuota_total');
            Event::where('id_event', $id_event)->update(['kapasitas' => $total]);
        });

        return redirect()->route('admin.dashboard')->with('success', 'Tiket diperbarui.');
    }

    public function destroy(int $id_event)
    {
        $event = Event::where('id_event', $id_event)->firstOrFail();

        DB::transaction(function () use ($event) {
            if ($event->poster && File::exists(public_path('images/' . $event->poster))) {
                File::delete(public_path('images/' . $event->poster));
            }
            $event->delete(); // Pastikan ada onDelete('cascade') di migration tiket
        });

        return redirect()->route('admin.dashboard')->with('success', 'Event dihapus permanen.');
    }
}
