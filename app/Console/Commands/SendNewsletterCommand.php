<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendNewsletterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:newsletter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia un correo electronico';

    public function handle()
    {
        dd('holii');
    }
}
