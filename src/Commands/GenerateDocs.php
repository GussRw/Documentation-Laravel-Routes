<?php

namespace GussRw\LaravelRoutes\Commands;

use GussRw\LaravelRoutes\Config;
use Illuminate\Console\Command;
use GussRw\LaravelRoutes\Routes;
use Illuminate\Support\Facades\App;

class GenerateDocs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'route:docs {--path=} {--commented=} {--sortby=} {--lang=}';

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
        $commented = boolval($this->option('commented')!=null && $this->option('commented')=="true");
        $sortby = $this->option('sortby');
        $lang = $this->option('lang');

        if($path==null)
            $path = "/docs";

        if(!in_array($lang, array("en", "es")))
            $lang = "en";

        if(!in_array($sortby, array("method","uri","name","action","middleware","comment")))
            $sortby = "uri";

        $config = new Config([
            'path' => $path,
            'commented' => $commented,
            'sortby' => $sortby,
            'lang' => $lang
        ]);
        App::instance(Config::class,$config);




        Routes::createHtmlFile();
        $this->info('Route documentation successfully created in Project'.$path);
    }
}
