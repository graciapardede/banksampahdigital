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
        // Load relationships
        $this->deposit->load('depositItems.wasteType', 'branch');
        
        // Ambil ringkasan item
        $itemsDescription = $this->deposit->depositItems->map(function ($item) {
            return $item->wasteType->name . ' (' . $item->weight . ' kg)';
        })->take(2)->join(', ');
        
        if ($this->deposit->depositItems->count() > 2) {
            $itemsDescription .= ', ...';
        }
        
        $branchName = $this->deposit->branch?->name ?? 'Cabang';
        
        return [
            'title' => 'Setoran Sampah Baru',
            'message' => "{$this->warga->name} telah melakukan setoran sampah ({$itemsDescription}). Total: {$this->deposit->total_points} poin.",
            'type' => 'info',
            'icon' => 'inbox-fill',
            'deposit_id' => $this->deposit->id,
            'user_name' => $this->warga->name,
            'total_points' => $this->deposit->total_points,
            'branch_name' => $branchName,
            'items' => $itemsDescription,
            'link' => route('admin.setoran.show', $this->deposit->id),
        ];
    }
}
