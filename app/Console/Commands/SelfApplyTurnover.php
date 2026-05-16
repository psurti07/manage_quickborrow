<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Partnersturnover;

class SelfApplyTurnover extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:self-apply-turnover';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run selfapply function from Partnersturnover controller';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            // Call the controller method
            (new Partnersturnover)->selfapply();
            $this->info('Self Apply executed successfully.');
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }
}
