<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Redemption;

class BarangSiapDiambil extends Notification
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
        // Load items dengan rewardItem dan branch
        $this->redemption->load('items.rewardItem', 'branch');
        
        // Ambil ringkasan item yang ditukar
        $itemsDescription = $this->redemption->items->map(function ($item) {
            return $item->rewardItem->name . ' (x' . $item->quantity . ')';
        })->take(2)->join(', ');
        
        // Tambahkan "..." jika lebih dari 2 item
        if ($this->redemption->items->count() > 2) {
            $itemsDescription .= ', ...';
        }

        $branchName = $this->redemption->branch->name ?? 'Cabang';

        return [
            'title' => 'Barang Siap Diambil!',
            'message' => "Penukaran Anda ({$itemsDescription}) telah disetujui dan siap diambil di {$branchName}. Ambil dalam 24 jam! ⏰",
            'type' => 'success',
            'icon' => 'check-circle-fill',
            'redemption_id' => $this->redemption->id,
            'total_points' => $this->redemption->total_points,
            'branch_name' => $branchName,
            'link' => route('riwayat'),
            'redemption_id' => $this->redemption->id,
            'total_points' => $this->redemption->total_points,
            'items_count' => $this->redemption->items->count(),
        ];
    }
}
