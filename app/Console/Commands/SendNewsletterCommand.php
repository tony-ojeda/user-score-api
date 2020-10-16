<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Notifications\NewsletterNotification;

class SendNewsletterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:newsletter 
                            {emails?*} : Correos Electronicos a los cuales enviar directamente
                            {--s|schedule : Si debe ser ejecutado directamente o no}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia un correo electronico';

    public function handle()
    {
        $emails  = $this->argument('emails');
        $schedule = $this->option('schedule');
        $builder = User::query();

        if($emails) $builder->whereIn('email',$emails); 
        
        $builder->whereNotNull('email_verified_at');
        $count = $builder->count();

        if($count)  {
            $this->info("Se enviaran {$count} correos");

            if ($this->confirm('¿Estas de acuerdo?') || $schedule) {
                $productQuery = Product::query();
                $productQuery->withCount(['qualifications as average_rating'=>function ($query){
                    $query->select(DB::raw('coalesce(avg(score),0)'));
                }])->orderByDesc('average_rating');
                $products = $productQuery->take(6)->get();

                $this->output->progressStart($count);
                $builder->each(function(User $user) use ($products) {
                    $user->notify(new NewsletterNotification($products->toArray()));
                    $this->output->progressAdvance();
                });
                $this->output->progressFinish();
                $this->info('Correos enviados');
                return;
            }
        }
        $this->info('No se enviaron correos');
        
    }
}
