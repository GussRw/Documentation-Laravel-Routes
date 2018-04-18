<?php

namespace GussRw\LaravelRoutes;


class Config
{
    public function __construct($config)
    {
        $this -> path = $config['path'];
        $this -> commented = $config['commented'];
        $this -> sortby = $config['sortby'];
        $this -> lang = $config['lang'];
    }
}