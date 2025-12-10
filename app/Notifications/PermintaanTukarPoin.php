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
        return [
            'title' => 'Permintaan Tukar Poin',
            'message' => "{$this->warga->name} meminta tukar poin ({$this->redemption->total_points} poin)",
            'type' => 'info',
            'redemption_id' => $this->redemption->id,
            'user_name' => $this->warga->name,
            'total_points' => $this->redemption->total_points,
            'branch_name' => $this->redemption->branch?->name,
            'items' => $this->redemption->redemptionItems->map(function($item) {
                return $item->rewardItem->name . ' (x' . $item->quantity . ')';
            })->join(', '),
            'action_url' => route('admin.penukaran.show', $this->redemption->id),
        ];
    }
}
