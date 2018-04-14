<?php
namespace GussRw\LaravelRoutes;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\View;
use GussRw\LaravelRoutes\Models\Route;
class Routes
{
    public static function getRoutesArray()
    {
        Artisan::call('route:list');                        // Call php artisan route list command
        $routes_output = Artisan::output();                          // Get output of artisan command
        $routes_array= explode("\n",$routes_output);        // Explode result with line break
        $method_index = strpos($routes_array[1],"Method");  // Get index of the route method
        $uri_index = strpos($routes_array[1],"URI");        // Get index of the uri method
        $name_index = strpos($routes_array[1],"Name");      // Get index of the name method
        $action_index = strpos($routes_array[1],"Action");  // Get index of the action method
        $middleware_index = strpos($routes_array[1],"Middleware");  // Get index of the action method

        $path = base_path()."/routes/web.php";
        $myfile = fopen($path, "r") or die("Unable to open file!");
        $file_string= strval(fread($myfile,filesize($path)));

        array_splice($routes_array,0,3);
        $routes = collect();
        foreach ($routes_array as $key => $route_string)
        {
            $route = new Route([
                'method' => trim(substr($route_string,$method_index,$uri_index-$method_index-2)),
                'uri' => trim(substr($route_string,$uri_index,$name_index-$uri_index-2)),
                'name' => trim(substr($route_string,$name_index,$action_index-$name_index-2)),
                'action' => trim(substr($route_string,$action_index,$middleware_index-$action_index-2)),
                'middleware' => trim(substr($route_string,$middleware_index,strlen($route_string)-$middleware_index-2)),
            ]);
            if($route -> action!=null){
                preg_match("~App\\\Http\\\Controllers\\\((.*?)@.*$)~",$route -> action,$controller, PREG_OFFSET_CAPTURE);
                if($controller){
                    $route_part = substr($file_string,0, strpos($file_string, $controller[1][0]));
                }
            }
            if(isset($route_part) && $route_part)
            {
                preg_match_all("~//?\s*\*[\s\S]*?\*\s*//?~m",$route_part,$comments, PREG_OFFSET_CAPTURE);
                $comment = end($comments[0])[0];
                preg_match_all("~@description([\s\S]*?)\\n~",$route_part,$descriptions, PREG_OFFSET_CAPTURE);
                if($descriptions[1]!=[])
                    $route->comment= trim($descriptions[1][0][0]);
            }


            $routes->push($route);

        }
        return $routes;
    }

    public static function getRoutesView()
    {
        $routes = self::getRoutesArray();
        $html = View::make('laravel-routes::routes',compact('routes'))->render();
        return $html;
    }


    public static function createFileHtml($path)
    {
        $html = self::getRoutesView();

        if(!is_dir($path))
            mkdir($path, 0777, true);

        $html_file = fopen($path."/routes.html", "w") or die("Unable to open file!");
        fwrite($html_file, $html);
        fclose($html_file);
        return true;
    }
}