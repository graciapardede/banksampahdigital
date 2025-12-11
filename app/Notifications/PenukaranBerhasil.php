<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Redemption;

class PenukaranBerhasil extends Notification
{
    use Queueable;

    protected $penukaran;

    /**
     * Create a new notification instance.
     */
    public function __construct(Redemption $penukaran)
    {
        $this->penukaran = $penukaran;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        // Load items dengan rewardItem
        $this->penukaran->load('items.rewardItem');
        
        // Ambil ringkasan item yang ditukar
        $itemsDescription = $this->penukaran->items->map(function ($item) {
            return $item->rewardItem->name . ' (x' . $item->quantity . ')';
        })->take(2)->join(', ');
        
        // Tambahkan "..." jika lebih dari 2 item
        if ($this->penukaran->items->count() > 2) {
            $itemsDescription .= ', ...';
        }

        return [
            'title' => '✅ Penukaran Selesai!',
            'message' => "Barang Anda ({$itemsDescription}) telah diserahkan. Terima kasih telah menggunakan Green Saving!",
            'type' => 'success',
            'icon' => 'check-circle-fill',
            'link' => route('riwayat'),
            'redemption_id' => $this->penukaran->id,
            'points_used' => $this->penukaran->total_points,
            'items_count' => $this->penukaran->items->count(),
        ];
    }
}
