<?php

namespace App\Console\Commands;

use App\Jobs\MarkSendMessageJob;
use App\Jobs\SendMessageJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;

class SendMessageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-message';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send message to users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        dispatch(new SendMessageJob(2));

        $this->info('Queued!');
    }
}
