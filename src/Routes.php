<?php
namespace GussRw\LaravelRoutes;

use GussRw\LaravelRoutes\Models\Param;
use Illuminate\Support\Facades\App;
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

        array_splice($routes_array,0,3); //Remove the header table routes
        array_splice($routes_array,count($routes_array)-2,count($routes_array)); //Remove the footer table routes
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
                preg_match("~App\\\Http\\\Controllers\\\((.*?)@(.*$))~",$route -> action,$controller, PREG_OFFSET_CAPTURE);
                if($controller){

                    $route_part = substr($file_string,0, strpos($file_string, $controller[1][0]));

                    if($route_part != null)
                    {
                        preg_match_all("~//?\s*\*[\s\S]*?\*\s*//?~m",$route_part,$comments, PREG_OFFSET_CAPTURE);
                        $comment = end($comments[0])[0];
                        preg_match_all("~@description([\s\S]*?)\\n~",$comment,$descriptions, PREG_OFFSET_CAPTURE);
                        if(isset($descriptions[1]) && $descriptions[1]!=[])
                            $route->comment= trim($descriptions[1][0][0]);
                        preg_match_all("~@param([\s\S]*? ){2}([\s\S]*?)\\n~",$comment,$params, PREG_OFFSET_CAPTURE);
                        foreach($params[1] as $key => $param)
                            $route->addParam(new Param([
                                'name' => $param[0],
                                'description' => $params[2][$key][0],
                            ]));
                    }else
                    {

                        $route_part = substr($file_string,0, strripos($file_string, $controller[2][0]));
                        preg_match_all("~//?\s*\*[\s\S]*?\*\s*//?~m",$route_part,$comments, PREG_OFFSET_CAPTURE);
                        $comment = end($comments[0])[0];
                        preg_match_all("~@".strval(trim($controller[3][0]))."([\s\S]*?)\\n~",$comment,$descriptions, PREG_OFFSET_CAPTURE);
                        if(isset($descriptions[1][0]) && $descriptions[1][0]!=[])
                            $route->comment = trim($descriptions[1][0][0]);
                        preg_match_all("~@param([\s\S]*? ){2}([\s\S]*?)\\n~",$comment,$params, PREG_OFFSET_CAPTURE);
                        foreach($params[1] as $key => $param)
                            if(strpos($route->uri,"{".trim($param[0])."}"))
                                $route->addParam(new Param([
                                    'name' => $param[0],
                                    'description' => $params[2][$key][0],
                                ]));
                    }
                }
            }


            if(!resolve(Config::class)->commented)
                $routes->push($route);
            else if($route->comment != null)
                $routes->push($route);

        }
        return $routes->sortBy(resolve(Config::class)->sortby);
    }

    public static function getRoutesView()
    {
        $routes = self::getRoutesArray();
        App::setLocale(resolve(Config::class)->lang);
        $html = View::make('laravel-routes::routes',compact('routes'))->render();
        return $html;
    }


    public static function createHtmlFile()
    {
        $html = self::getRoutesView();
        $path = base_path().resolve(Config::class)->path;
        if(!is_dir($path))
            mkdir($path, 0777, true);

        $html_file = fopen($path."/routes.html", "w") or die("Unable to open file!");
        fwrite($html_file, $html);
        fclose($html_file);
        return true;
    }
}