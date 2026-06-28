<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $selectedCategory = $request->query('kategori');
        $search = $request->query('search');
        $status = $request->query('status');

        $query = Event::query();

        if ($selectedCategory) {
            $query->where('kategori', $selectedCategory);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'LIKE', '%' . $search . '%')
                    ->orWhere('lokasi', 'LIKE', '%' . $search . '%');
            });
        }

        // FILTER STATUS
        if ($status) {

            if ($status == 'draft') {

                $query->where('status_event', 'draft');
            } elseif ($status == 'open') {

                $query->where('status_event', 'open')
                    ->whereDate('tgl_selesai', '>=', now());
            } elseif ($status == 'closed') {

                $query->where('status_event', 'open')
                    ->whereDate('tgl_selesai', '<', now());
            }
        }

        $eventObjects = $query
            ->latest()
            ->paginate(5)
            ->withQueryString();

        $admin = Auth::guard('admin')->user();

        return view('admin.dashboard', [
            'events' => $eventObjects,
            'selectedCategory' => $selectedCategory,
            'admin' => $admin
        ]);
    }
}
