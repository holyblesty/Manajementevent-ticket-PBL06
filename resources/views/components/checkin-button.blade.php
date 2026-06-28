<div>
    <button wire:click="toggleCheckin" class="px-4 py-2 text-white bg-blue-500 rounded">
        {{ $kehadiran->sts_checkin === 'sudah' ? 'Sudah Check-in' : 'Belum Check-in' }}
    </button>
</div>