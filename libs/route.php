<?php
function route($path, $httpMethod)
{
    try {
        // urlがhttp://localhost/home/index だった場合
        // HomeControllerのindex()関数を使用するように設定している。
        // またget,postによって参照する関数が変わるようになっている。
        list($controller, $method) = explode('/', $path);
        $case = [$method, $httpMethod];
        switch ($controller) {
            case 'home':
                $controllerName = 'HomeController';
                switch ($case) {
                    case ['index', 'get']:
                        $methodName = 'index';
                        break;
                    default:
                        $controllerName = '';
                        $methodName = '';
                }
                break;
            case 'user':
                $controllerName = 'UserController';
                switch ($case) {
                    case ['log-in', 'get']:
                        $methodName = 'logIn';
                        break;
                    case ['sign-up', 'get']:
                        $methodName ='signUp';
                        break;
                    case ['log-out', 'get']:
                        $methodName = 'logOut';
                        break;
                    case ['create', 'post']:
                        $methodName = 'create';
                        break;
                    case ['certification', 'post']:
                        $methodName = 'certification';
                        break;
                    case ['my-page', 'get']:
                        $methodName ='myPage';
                        break;
                    case ['edit', 'get']:
                        $methodName = 'edit';
                        break;
                    case ['update', 'post']:
                        $methodName = 'update';
                        break;
                    case ['delete', 'get']:
                        $methodName = 'delete';
                        break;
                    default:
                        $controllerName = '';
                        $methodName = '';
                }
                break;
            default:
                $controllerName = '';
                $methodName = '';
        }

        error_log($controllerName);
        error_log($methodName);

        require_once (ROOT_PATH."Controllers/{$controllerName}.php");

        $obj = new $controllerName();
        $obj->$methodName();

    } catch (Throwable $e) {
        error_log($e->getMessage());
        header("HTTP/1.0 404 Not Found");
    }
}