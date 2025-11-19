<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Deposit;

class SetoranDiverifikasi extends Notification
{
    use Queueable;

    protected $setoran;

    /**
     * Create a new notification instance.
     */
    public function __construct(Deposit $setoran)
    {
        $this->setoran = $setoran;
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
        // Load depositItems dengan wasteType
        $this->setoran->load('depositItems.wasteType');
        
        // Ambil detail item pertama atau ringkasan
        $itemsDescription = $this->setoran->depositItems->map(function ($item) {
            return $item->wasteType->name . ' (' . $item->weight . ' kg)';
        })->join(', ');

        return [
            'title' => 'Setoran Sampah Diverifikasi',
            'message' => "Setoran sampah Anda ({$itemsDescription}) berhasil diverifikasi. +{$this->setoran->total_points} poin ditambahkan ke saldo Anda.",
            'type' => 'success',
            'icon' => 'recycle',
            'deposit_id' => $this->setoran->id,
            'points_earned' => $this->setoran->total_points,
        ];
    }
}
