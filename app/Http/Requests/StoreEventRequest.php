<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'id_kategori' => 'required|exists:kategori_events,id_kategori',
            'poster' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'status_event' => 'required|in:draft,open',

            'lokasi' => 'required|string|max:255',
        ];
    }
}
