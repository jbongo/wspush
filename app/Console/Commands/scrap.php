<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Scrap as ScrapArticle;

class scrap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:scrap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'reccupère les nouveaux articles sur les sites ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ScrapArticle::scrap();
    }
}
