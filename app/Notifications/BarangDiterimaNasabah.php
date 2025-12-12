<?php

namespace App\Notifications;

use App\Models\Redemption;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BarangDiterimaNasabah extends Notification
{
    use Queueable;

    protected $redemption;

    public function __construct(Redemption $redemption)
    {
        $this->redemption = $redemption;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        // Load relationships
        $this->redemption->load('items.rewardItem');
        
        // Ambil ringkasan item
        $itemsDescription = $this->redemption->items->map(function ($item) {
            return $item->rewardItem->name . ' (x' . $item->quantity . ')';
        })->take(2)->join(', ');
        
        if ($this->redemption->items->count() > 2) {
            $itemsDescription .= ', ...';
        }
        
        return [
            'title' => 'Barang Diterima',
            'message' => "Barang penukaran Anda ({$itemsDescription}) telah diterima dengan sukses.",
            'type' => 'success',
            'icon' => 'check-circle-fill',
            'redemption_id' => $this->redemption->id,
            'items' => $itemsDescription,
            'link' => route('riwayat'),
        ];
    }
}
