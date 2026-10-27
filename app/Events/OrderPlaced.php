<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderPlaced implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $user;

    public function __construct($order, $user)
    {
        $this->order = $order;
        $this->user = $user;
    }

    public function broadcastOn()
    {
        return [
            new PrivateChannel('user.' . $this->user->id),
            new PrivateChannel('user.1'),
        ];
    }

    public function broadcastAs()
    {
        return 'order.placed';
    }

    public function broadcastWith()
    {
        return [
            'order_id' => $this->order->id,
            'total' => $this->order->total,
            'user_name' => $this->user->name,
        ];
    }
}
