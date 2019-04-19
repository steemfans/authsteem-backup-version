<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Phpunit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'phpunit:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PHPUnit Test Run';

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
     * @return mixed
     */
    public function handle()
    {
        system('./vendor/bin/phpunit');
    }
}
