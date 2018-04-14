<?php

namespace GussRw\LaravelRoutes\Commands;

use Illuminate\Console\Command;
use GussRw\LaravelRoutes\Routes;

class GenerateDocs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'route:docs {--path=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $path = $this->option('path');
        $real_path = base_path();
        if($path)
            $real_path .= $path;
        else
        {
            $real_path .= "/docs";
            $path = "/docs";
        }

        Routes::createFileHtml($real_path);
        $this->info('Route documentation successfully created in Project'.$path);
    }
}
