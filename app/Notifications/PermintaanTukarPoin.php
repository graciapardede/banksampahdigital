<?php

namespace App\Notifications;

use App\Models\Redemption;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PermintaanTukarPoin extends Notification
{
    use Queueable;

    protected $redemption;
    protected $warga;

    public function __construct(Redemption $redemption, $warga)
    {
        $this->redemption = $redemption;
        $this->warga = $warga;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        // Load relationships
        $this->redemption->load('items.rewardItem', 'branch');
        
        // Ambil ringkasan item
        $itemsDescription = $this->redemption->items->map(function ($item) {
            return $item->rewardItem->name . ' (x' . $item->quantity . ')';
        })->take(2)->join(', ');
        
        if ($this->redemption->items->count() > 2) {
            $itemsDescription .= ', ...';
        }
        
        $branchName = $this->redemption->branch?->name ?? 'Cabang';
        
        return [
            'title' => '📋 Permintaan Tukar Poin',
            'message' => "{$this->warga->name} meminta tukar poin ({$itemsDescription}). Total: {$this->redemption->total_points} poin.",
            'type' => 'info',
            'icon' => 'info-circle-fill',
            'redemption_id' => $this->redemption->id,
            'user_name' => $this->warga->name,
            'total_points' => $this->redemption->total_points,
            'branch_name' => $branchName,
            'items' => $itemsDescription,
            'link' => route('admin.penukaran.show', $this->redemption->id),
        ];
    }
}
