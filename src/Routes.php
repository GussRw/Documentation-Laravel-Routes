<?php
/**
 * Created by PhpStorm.
 * User: guss
 * Date: 4/13/18
 * Time: 3:50 PM
 */

class Routes
{
    public static function getArrayRoutes()
    {
        Artisan::call('route:list');                        // Call php artisan route list command
        $routes_output = Artisan::output();                          // Get output of artisan command
        $routes_array= explode("\n",$routes_output);        // Explode result with line break
        $method_index = strpos($routes_array[1],"Method");  // Get index of the route method
        $uri_index = strpos($routes_array[1],"URI");        // Get index of the uri method
        $name_index = strpos($routes_array[1],"Name");      // Get index of the name method
        $action_index = strpos($routes_array[1],"Action");  // Get index of the action method
        $middleware_index = strpos($routes_array[1],"Middleware");  // Get index of the action method

        //dd($routes_array);
        array_splice($routes_array,0,3);
        $routes = collect();
        foreach ($routes_array as $key => $route_string)
        {
            $route = (object)[
                'method' => trim(substr($route_string,$method_index,$uri_index-$method_index-2)),
                'uri' => trim(substr($route_string,$uri_index,$name_index-$uri_index-2)),
                'name' => trim(substr($route_string,$name_index,$action_index-$name_index-2)),
                'action' => trim(substr($route_string,$action_index,$middleware_index-$action_index-2)),
                'middleware' => trim(substr($route_string,$middleware_index,strlen($route_string)-$middleware_index-2)),
            ];
            $routes->push($route);

        }
        return $routes;
    }
}