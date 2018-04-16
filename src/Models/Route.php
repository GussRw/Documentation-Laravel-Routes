<?php
namespace GussRw\LaravelRoutes\Models;

class Route
{
    public function __construct($values)
    {
        $this->method = $values['method'];
        $this->uri = $values['uri'];
        $this->name = $values['name'];
        $this->action = $values['action'];
        $this->middleware = $values['middleware'];
        $this->comment = null;
        $this->params = collect();
    }

    public function getMethodClass()
    {
        switch($this->method)
        {
            case "GET|HEAD":
                return "get";
            case "POST":
                return "post";
            case "PUT|PATCH":
                return "put";
            case "DELETE":
                return "delete";
        }
    }
    public function addParam(Param $param)
    {
        $this->params->push($param);
    }
}