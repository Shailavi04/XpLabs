<?php

namespace App\Events;

use App\Models\annoucement;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AnnouncementCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $announcement;
    public $recipientUsers;

    public function __construct(annoucement $announcement, $recipientUsers)
    {
        $this->announcement = $announcement;
        $this->recipientUsers = $recipientUsers;

        Log::info("Announcement event fired", [
            'announcement_id' => $announcement->id,
            'title' => $announcement->title,
            'recipients' => $recipientUsers,
        ]);
    }

    public function broadcastOn(): array
    {
        return collect($this->recipientUsers)
            ->map(fn($id) => new PrivateChannel('user.' . $id))
            ->toArray();
    }

    public function broadcastWith()
    {
        return [
            'title' => $this->announcement->title,
            'message' => $this->announcement->message,
        ];
    }
}
