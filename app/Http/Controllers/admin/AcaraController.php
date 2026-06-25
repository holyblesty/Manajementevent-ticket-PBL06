<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Models\{Event, Tiket, KategoriEvent};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, File, Auth};

class AcaraController extends Controller
{
<<<<<<< HEAD

    public function index()
    {
        // Ambil semua data acara dari database
        $events = \App\Models\Event::latest()->get();

        // Kembalikan ke view (pastikan nama view-nya sesuai dengan file-mu)
        return view('admin.acara.index', compact('events'));
    }
=======
    // 1. READ: Menampilkan daftar acara
    public function index()
    {
        $events = Event::with('kategori')->get();
        return view('admin.dashboard', compact('events'));
    }

    // 2. CREATE: Menampilkan form tambah
>>>>>>> 6d738c7514dad7274b3aaf49b3390360e03c3b6f
    public function create()
    {
        $kategoris = KategoriEvent::all();
        return view('admin.tambah', compact('kategoris'));
    }

    // 3. STORE: Menyimpan event baru
    public function store(StoreEventRequest $request)
    {
        try {

            if (!$request->hasFile('poster')) {
                throw new \Exception('File poster tidak ditemukan');
            }

            $image = $request->file('poster');

            $imageName = time() . '_' . $image->getClientOriginalName();

            $image->move(public_path('images'), $imageName);

            $data = $request->validated();
            $data['poster'] = $imageName;
            $data['id_admin'] = Auth::id();
            $data['kapasitas'] = 0;
            $data['kuota_tersedia'] = 0;
            $data['status_event'] = 'open';

            Event::create($data);

            return redirect()
                ->route('admin.dashboard')
                ->with('success', 'Event berhasil dibuat.');
        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    // 4. EDIT: Menampilkan form edit
    public function edit(int $id_event)
    {
        $event = Event::where('id_event', $id_event)->firstOrFail();
        $kategoris = KategoriEvent::all();

        return view('admin.edit', compact('event', 'kategoris'));
    }

    // Halaman Manajemen Tiket
    public function tiket(int $id_event)
    {
        $event = Event::with('tiket')->findOrFail($id_event);

        return view('admin.tiket', compact('event'));
    }

    // 5. UPDATE: Menyimpan perubahan
    public function update(Request $request, int $id_event)
    {
        $event = Event::where('id_event', $id_event)->firstOrFail();

        $request->validate([
            'judul' => 'required|string|max:255',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        DB::transaction(function () use ($request, $event) {

            $data = $request->except('poster');

            if ($request->hasFile('poster')) {

                if ($event->poster && File::exists(public_path('images/' . $event->poster))) {
                    File::delete(public_path('images/' . $event->poster));
                }

                $imageName = time() . '_' . $request->poster->hashName();

                $request->poster->move(public_path('images'), $imageName);

                $data['poster'] = $imageName;
            }

            $event->update($data);
        });

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Event berhasil diupdate.');
    }
}
