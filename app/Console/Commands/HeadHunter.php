<?php

namespace App\Console\Commands;

use App\Lib\Integrations\HeadHunterIntegrator\HeadHunterIntegrationManager;
use Illuminate\Console\Command;

class HeadHunter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'headhunter:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $manager = new HeadHunterIntegrationManager();
        $manager->updateVacanciesData();
        return Command::SUCCESS;
    }
}
