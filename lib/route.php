<?php
function route($path, $httpMethod)
{
    try {
        // urlがhttp://localhost/home/index だった場合
        // HomeControllerのindex()関数を使用するように設定している。
        // またget,postによって参照する関数が変わるようになっている。
        list($controller, $method) = explode('/', $path);
        $case = [$controller, $method, $httpMethod];
        switch ($case) {
            case ['home', 'index', 'get']:
                $controllerName = 'HomeController';
                $methodName = 'index';
                break;
            case ['user', 'log-in', 'get']:
                $controllerName = 'UserController';
                $methodName = 'logIn';
                break;
            case ['user', 'sign-up', 'get']:
                $controllerName = 'UserController';
                $methodName ='signUp';
                break;
            case ['user', 'log-out', 'get']:
                $controllerName = 'UserController';
                $methodName = 'logOut';
                break;
            case ['user', 'create', 'post']:
                $controllerName = 'UserController';
                $methodName = 'create';
                break;
            case ['user', 'certification', 'post']:
                $controllerName = 'UserController';
                $methodName = 'certification';
                break;
            case ['user', 'my-page', 'get']:
                $controllerName = 'UserController';
                $methodName ='myPage';
                break;
            case ['user', 'edit', 'get']:
                $controllerName = 'UserController';
                $methodName = 'edit';
                break;
            case ['user', 'update', 'post']:
                $controllerName = 'UserController';
                $methodName = 'update';
                break;
            case ['user', 'delete', 'get']:
                $controllerName = 'UserController';
                $methodName = 'delete';
                break;
            default:
                $controllerName = '';
                $methodName = '';
        }

        require_once (ROOT_PATH."Controllers/{$controllerName}.php");

        $obj = new $controllerName();
        $obj->$methodName();

    } catch (Throwable $e) {
        header("HTTP/1.0 404 Not Found");
    }
}