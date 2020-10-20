<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ModelRated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private Model $qualifier;
    private Model $ratable;
    private float $score;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Model $qualifier, Model $ratable, float $score)
    {
        $this->qualifier = $qualifier;
        $this->ratable = $ratable;
        $this->score = $score;
    }

    public function getQualifier(): Model 
    {
        return $this->qualifier;
    }

    public function getRatable(): Model 
    {
        return $this->ratable;
    }

    public function getScore(): float 
    {
        return $this->score;
    }
}
