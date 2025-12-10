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
        return [
            'title' => '❌ Penolakan Tukar Poin',
            'message' => "Permintaan tukar poin Anda ditolak. Alasan: {$this->redemption->rejection_reason}",
            'type' => 'warning',
            'redemption_id' => $this->redemption->id,
            'total_points' => $this->redemption->total_points,
            'items' => $this->redemption->redemptionItems->map(function($item) {
                return $item->rewardItem->name . ' (x' . $item->quantity . ')';
            })->join(', '),
            'rejection_reason' => $this->redemption->rejection_reason,
            'link' => route('riwayat'),
        ];
    }
}
