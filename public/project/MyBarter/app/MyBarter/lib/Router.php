<?php
namespace MyBarter\lib;
class Router
{
    protected $uri;
    protected $controller;
    protected $action;
    protected $params;
    protected $route;
    protected $method_prefix;
//    protected $language;


    /**
     * @return mixed
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return mixed
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @return mixed
     */
    public function getMethodPrefix()
    {
        return $this->method_prefix;
    }

    /**
     * @return mixed
     */
 /*   public function getLanguage()
    {
        return $this->language;
    }*/

    public function __construct($uri)
    {
        $this->uri = urldecode(trim($uri, '/'));

        //Get defaults
        $routes = Config::get('routes');
        $this->route = Config::get('default_route');
        $this->method_prefix = isset($routes[$this->route]) ? $routes[$this->route] : '';
        $this->controller = Config::get('default_controller');
        $this->action = Config::get('default_action');

        $uri_parts = explode('?', $this->uri);

        //Get path like /lng/controller/action/param1....
        $path = $uri_parts[0];
        $path_parts = explode('/', $path);
        //мой код для подсчета подкаталогов относительно корневого каталога
        $prelinkCount=explode("/", PRELINK);
        foreach ($prelinkCount as $key=>$item) {
            if(empty($item)){
                unset ($prelinkCount[$key]);
            }
        }
        $prelinkModifier = count($prelinkCount);
        //конец моего кода
        if (count($path_parts) - $prelinkModifier) {
            while($prelinkModifier>0){
                array_shift($path_parts);
                $prelinkModifier-=1;//сдвигаем массив на кол-во подкаталогов в пути к главному скрипту
            }
            if (in_array(strtolower(current($path_parts)), array_keys($routes))) {
                $this->route = strtolower(current($path_parts));
                $this->method_prefix = isset($routes[$this->route]) ? $routes[$this->route] : '';
                array_shift($path_parts);
            } 
            //Get controller - next element of array
            if (current($path_parts)) {
                $this->controller = strtolower(current($path_parts));
                array_shift($path_parts);
            }
            //Get action
            if (current($path_parts)) {
                $this->action = strtolower(current($path_parts));
                array_shift($path_parts);
            }

            //Get params - all the rest
            $this->params = $path_parts;
        }
    }

    public static function redirect($location)
    {
        header("Location: $location");
    }
}