<?php

namespace App\Listeners;

use App\Events\ModelRated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailModelRatedNotification
{
    public function __construct()
    {
        //
    }

    public function handle(ModelRated $event)
    {
        /** @var Product $rateable */
        $rateable = $event->getRateable();

        if($rateable instanceof Product) {
            $notification = new ModelRatedNotification();

            $rateable->createdBy->notify($notification);
        }
    }
}
