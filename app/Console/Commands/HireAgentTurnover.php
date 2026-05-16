<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Partnersturnover;

class HireAgentTurnover extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:hire-agent-turnover';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run loan agent function from Partnersturnover controller';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            // Call the controller method
            (new Partnersturnover)->hireagent();
            $this->info('Loan Agent executed successfully.');
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }
}
