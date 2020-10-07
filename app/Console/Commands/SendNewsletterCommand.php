<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use App\Notifications\NewsletterNotification;

class SendNewsletterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:newsletter {emails?*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia un correo electronico';

    public function handle()
    {
        $emails  = $this->argument('emails');
        $builder = User::query();

        if($emails) $builder->whereIn('email',$emails); 
        
        $count = $builder->count();
        if($count)  {
            $this->info("Se enviaran {$count} correos");
            if ($this->confirm('¿Estas de acuerdo?')) {
                $this->output->progressStart($count);
               
                $builder->whereNotNull('email_verified_at')
                        ->each(function(User $user) {
                            $user->notify(new NewsletterNotification());
                $this->output->progressAdvance();
                $this->info('Correos enviados');
                return;
            });
            $this->output->progressFinish();
            } else {
                $this->info('No se envio ningun correo');
            }
        }

        
    }
}
