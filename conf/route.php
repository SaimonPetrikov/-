<?php

class Routing {

    public static function buildRoute() {

        /* Контроллер и action по умолчанию */
        $controllerName = "IndexController";
        $modelName = "IndexModel";
        $action = "index";

        $route = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

        $i = count($route)-1;

        while($i>1) {

            if($route[$i] != '') {

                if(is_file(CONTROLLER_PATH . ucfirst($route[$i]) . "Controller.php") || !empty($_GET)) {
                    
                    $route1 = explode(".", $route[$i]);

                    $controllerName = ucfirst($route1[0]) . "Controller";
                    $modelName =  ucfirst($route1[0]) . "Model";

                    break;

                } else {

                     $action = $route[$i];

                }
            }
            $i--;
        }

        require_once CONTROLLER_PATH . $controllerName . ".php";
        require_once MODEL_PATH . $modelName . ".php";

        $controller = new $controllerName();
		$controller->$action();

    }
}
