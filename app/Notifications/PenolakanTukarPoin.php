<?php

namespace App\Notifications;

use App\Models\Redemption;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PenolakanTukarPoin extends Notification
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
        
        $reason = $this->redemption->rejection_reason ?? 'Stok tidak tersedia atau terjadi kesalahan sistem.';
        
        return [
            'title' => '❌ Penolakan Tukar Poin',
            'message' => "Permintaan tukar poin Anda ({$itemsDescription}) ditolak. Poin {$this->redemption->total_points} telah dikembalikan. Alasan: {$reason}",
            'type' => 'warning',
            'icon' => 'exclamation-triangle-fill',
            'redemption_id' => $this->redemption->id,
            'total_points' => $this->redemption->total_points,
            'items' => $itemsDescription,
            'rejection_reason' => $reason,
            'link' => route('riwayat'),
        ];
    }
}
