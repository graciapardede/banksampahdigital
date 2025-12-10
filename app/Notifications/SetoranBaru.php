<?php

namespace App\Notifications;

use App\Models\Deposit;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SetoranBaru extends Notification
{
    use Queueable;

    protected $deposit;
    protected $warga;

    public function __construct(Deposit $deposit, $warga)
    {
        $this->deposit = $deposit;
        $this->warga = $warga;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Setoran Sampah Baru',
            'message' => "{$this->warga->name} telah melakukan setoran sampah",
            'deposit_id' => $this->deposit->id,
            'user_name' => $this->warga->name,
            'total_points' => $this->deposit->total_points,
            'branch_name' => $this->deposit->branch?->name,
            'action_url' => route('admin.setoran.show', $this->deposit->id),
        ];
    }
}
