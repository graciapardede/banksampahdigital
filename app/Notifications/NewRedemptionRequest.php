<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Redemption;

class NewRedemptionRequest extends Notification
{
    use Queueable;

    protected $redemption;

    /**
     * Create a new notification instance.
     */
    public function __construct(Redemption $redemption)
    {
        $this->redemption = $redemption;
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
        // Load redemptionItems dengan rewardItem dan user
        $this->redemption->load('items.rewardItem', 'user');
        
        // Ambil ringkasan item yang ditukar
        $itemsDescription = $this->redemption->items->map(function ($item) {
            return $item->rewardItem->name . ' (x' . $item->quantity . ')';
        })->take(2)->join(', ');
        
        // Tambahkan "..." jika lebih dari 2 item
        if ($this->redemption->items->count() > 2) {
            $itemsDescription .= ', ...';
        }

        return [
            'title' => 'Permintaan Penukaran Baru',
            'message' => "{$this->redemption->user->name} mengajukan penukaran: {$itemsDescription}. Total {$this->redemption->total_points} poin.",
            'type' => 'info',
            'icon' => 'gift',
            'link' => url('/admin/penukaran/' . $this->redemption->id),
            'redemption_id' => $this->redemption->id,
            'user_name' => $this->redemption->user->name,
            'total_points' => $this->redemption->total_points,
            'items_count' => $this->redemption->items->count(),
        ];
    }
}
