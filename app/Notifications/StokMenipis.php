<?php

namespace App\Notifications;

use App\Models\RewardItem;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class StokMenipis extends Notification
{
    use Queueable;

    protected $rewardItem;
    protected $stockLevel;

    public function __construct(RewardItem $rewardItem, $stockLevel = null)
    {
        $this->rewardItem = $rewardItem;
        $this->stockLevel = $stockLevel ?? $rewardItem->stock;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Stok Barang Menipis',
            'message' => "Stok '{$this->rewardItem->name}' tersisa {$this->stockLevel} item. Segera lakukan restocking.",
            'type' => 'warning',
            'icon' => 'exclamation-triangle-fill',
            'reward_item_id' => $this->rewardItem->id,
            'stock_level' => $this->stockLevel,
            'link' => route('admin.reward-items.index'),
        ];
    }
}
