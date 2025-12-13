<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Redemption;

class RedemptionRejected extends Notification
{
    use Queueable;

    protected $redemption;
    protected $rejectionReason;

    /**
     * Create a new notification instance.
     */
    public function __construct(Redemption $redemption, $rejectionReason = null)
    {
        $this->redemption = $redemption;
        $this->rejectionReason = $rejectionReason;
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
        // Load redemptionItems dengan rewardItem
        $this->redemption->load('items.rewardItem');
        
        // Ambil ringkasan item yang ditolak
        $itemsDescription = $this->redemption->items->map(function ($item) {
            return $item->rewardItem->name . ' (x' . $item->quantity . ')';
        })->take(2)->join(', ');
        
        // Tambahkan "..." jika lebih dari 2 item
        if ($this->redemption->items->count() > 2) {
            $itemsDescription .= ', ...';
        }

        return [
            'title' => 'Penukaran Ditolak',
            'message' => "Permintaan penukaran Anda ({$itemsDescription}) telah ditolak." . 
                        ($this->rejectionReason ? " Alasan: {$this->rejectionReason}" : ""),
            'type' => 'error',
            'icon' => 'x-circle',
            'link' => url('/riwayat'),
            'redemption_id' => $this->redemption->id,
            'rejection_reason' => $this->rejectionReason,
            'total_points' => $this->redemption->total_points,
        ];
    }
}
