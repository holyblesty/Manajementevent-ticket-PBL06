<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Menghadiri;

class CheckinButton extends Component
{
    public $kehadiran;

    // Menangkap data dari database saat tombol dimuat
    public function mount(Menghadiri $kehadiran)
    {
        $this->kehadiran = $kehadiran;
    }

    // Fungsi untuk mengubah status
    public function toggleCheckin()
    {
        // Ubah status (jika 'sudah' jadi 'belum', jika 'belum' jadi 'sudah')
        $this->kehadiran->sts_checkin = ($this->kehadiran->sts_checkin === 'sudah') ? 'belum' : 'sudah';
        $this->kehadiran->save();
    }

    public function render()
    {
        return view('livewire.checkin-button');
    }
}