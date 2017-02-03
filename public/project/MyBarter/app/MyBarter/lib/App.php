<?php
namespace MyBarter\lib;

class App
{
    protected static $router;
    public static $db;

    /**
     * @return mixed
     */
    public static function getRouter()
    {
        return self::$router;
    }

    public static function run($uri)
    {
        require_once(ROOT . DS . 'app' . DS . 'MyBarter' . DS . 'config' . DS . 'config.php');
        self::checkInputAndRewritePostAndGetArray();
        self::$router = new Router($uri);

        self::$db = DB::getInstance();

        Session::loginByCookie();
        $controller_class = "MyBarter\\controllers\\".ucfirst(self::$router->getController()) . 'Controller';
        $controller_method = strtolower(self::$router->getMethodPrefix() . self::$router->getAction());
//        die($controller_class.$controller_method);
        $layout = self::$router->getRoute();
        if ($layout == 'admin' && Session::get('role') != 'admin') {
            if ($controller_method != 'admin_login') {
                Router::redirect(PRELINK . 'admin/users/login/');

            }
        }

        // Calling controller's method

        $controller_object=new $controller_class;
                if (method_exists($controller_object, $controller_method)) {
                    //Controller's action may return a view path
                    $view_path = $controller_object->$controller_method();
                    $view_object = new View($controller_object->getData(), $view_path);

                    $content = $view_object->render();

                } else {

                    throw new \Exception('Method ' . $controller_method . ' of class ' . $controller_class . ' does not exist.');
                }


                $layout_path = VIEWS_PATH . DS . $layout . '.html';

                $layout_view_object = new View(compact('content'), $layout_path);
                echo $layout_view_object->render();
        }
    public static function checkInputAndRewritePostAndGetArray()
    {
        foreach ($_POST as &$item) {
                $item = trim(htmlspecialchars($item, ENT_QUOTES));
        }
        foreach ($_GET as &$item) {
                $item = trim(htmlspecialchars($item, ENT_QUOTES));
        }
    }
    }