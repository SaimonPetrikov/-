<?php

session_start();


$_SERVER['DOCUMENT_ROOT'] = "D:/xampp/htdocs/bootstrap";
define("ROOT", $_SERVER['DOCUMENT_ROOT']);
//define("ROOT", "D:/xampp/htdocs/bootstrap/index.php");
define("CONTROLLER_PATH", ROOT."/controllers/");
define("MODEL_PATH", ROOT."/models/");
define("VIEWS_PATH", ROOT."/views/");
define("PAGINATION_PATH", ROOT."/components/");
define("PAGINATIONADMIN_PATH", ROOT."/components/");


require_once("db.php");
require_once("route.php");
require_once CONTROLLER_PATH. 'Controller.php';
require_once MODEL_PATH. 'Model.php';
require_once VIEWS_PATH. 'View.php';
require_once PAGINATION_PATH. 'Pagination.php';
require_once PAGINATIONADMIN_PATH. 'PaginationAdmin.php';
Routing::buildRoute();