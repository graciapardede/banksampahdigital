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
        
        // Ambil detail item yang ditukar
        $itemsDescription = $this->penukaran->items->map(function ($item) {
            return $item->rewardItem->name . ' (x' . $item->quantity . ')';
        })->join(', ');

        return [
            'title' => 'Penukaran Poin Berhasil',
            'message' => "Penukaran poin Anda untuk {$itemsDescription} berhasil diproses. Total {$this->penukaran->total_points} poin telah dipotong dari saldo Anda.",
            'type' => 'info',
            'icon' => 'gift',
            'redemption_id' => $this->penukaran->id,
            'points_used' => $this->penukaran->total_points,
        ];
    }
}
