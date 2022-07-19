<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;



class AddComment
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user_id;
    public $comment_body;
    public $property_id;
    public $comment_id;
    /*
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->user_id = $data['user_id'];
        $this->comment_body = $data['comment_body'];
        $this->property_id = $data['property_id'];
        $this->comment_id = $data['comment_id'];
    }

    /*
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // return new PrivateChannel('add-comment');
        return ['add-comment'];
    }
}
