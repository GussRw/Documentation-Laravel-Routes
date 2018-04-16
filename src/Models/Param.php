<?php
namespace GussRw\LaravelRoutes\Models;


class Param
{
    public function __construct($values)
    {
        $this -> name = $values['name'];
        $this -> description = $values['description'];
    }
}