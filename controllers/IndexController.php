<?php

class IndexController extends Controller
{

    private $pageTpl = '/views/main.tpl.php';
    private $TaskPerPage = 3;

    public function __construct() {

        $this->model = new IndexModel();
        $this->view = new View();

    }


    public function Index() {

        $this->pageData['title'] = "Приложение задачник";

		if(isset($_REQUEST['submit'])) {

            $this->actionAdd();

        }

        if(empty($_REQUEST['doGo'])) {

			if(!$this->login()) {

                $this->pageData['error'] = "Неправильный логин или пароль";
                
			}
        }
        $this->actionTaskPage();

    }

    
    public function login() {

        if (isset($_REQUEST['doGo'])) {

            if($_REQUEST['login']!='' && $_REQUEST['password']!=''){

                $login = htmlspecialchars($_REQUEST['login']);
                $password = htmlspecialchars($_REQUEST['password']);

            }
        
            if(isset($login)&&isset($password)){

                if(!( $this->model->checkUser($login, $password))) {

                    $this->pageData['ErrorAdmin'] = "Данные введены неверно";

                    return false;
                    
                }
            } else if(empty($login) && empty($login)){

                $this->pageData['ErrorAdminLP'] = "Поля обязательны для заполнения";

            }
        }
	}


    public function actionAdd()
    {

        if (isset($_REQUEST['submit']))
        {
            $title = htmlspecialchars($_REQUEST['title']);
            $text = htmlspecialchars($_REQUEST['text']);
            $name = htmlspecialchars($_REQUEST['login']);
            $email = htmlspecialchars($_REQUEST['email']);

        
            if(empty($title) || empty($text) || empty($name) || empty($name)){

                $this->pageData['ErrorTask'] = "Некорректный ввод";

            } else{

                $dogSymbol1 = stripos($email, '@');
                $dogSymbol2 = strrpos($email, '@');

                if($dogSymbol1 == false && $dogSymbol2 == false)

                {
                    $this->pageData['ErrorTittle'] = "Некорректный email";
                }

                else if($dogSymbol1 == $dogSymbol2){

                    $this->model->add_task($title, $text, $name, $email);
                    $this->pageData['Success'] = "Задача успешно добавлена";

                } else {

                    $this->pageData['ErrorTittle'] = "Некорректный email";

                }
            }
        }
    }

  
    public function actionTaskPage($page = 1)
    {
        
        $sort="id";
        if(empty($_REQUEST['sort'])){
            $sort = "id"; // Сортировка по умолчанию
            $allTask = count(IndexModel::getAllTask($sort));
        } else {
            $sort=$_REQUEST['sort'];
            $allTask = count(IndexModel::getAllTask($sort));
        }
        $totalPages = ceil($allTask / $this->TaskPerPage);

        $TaskList = $this->makeTaskPager($allTask, $totalPages);


        if(empty($_REQUEST['sort'])){

            $sort = "id"; // Сортировка по умолчанию
            $pagination = Pagination::drawPager($allTask, $this->TaskPerPage, $sort);

        } else {

            $sort1=$_REQUEST['sort'];
            $sort2 = explode("?", $sort1);
            $sort = $sort2[0];

            $pagination = Pagination::drawPager($allTask, $this->TaskPerPage, $sort);

        }

        $this->view->render($this->pageTpl, $this->pageData, $TaskList, $pagination);
        return true;

    }
    

    public function makeTaskPager($allTask, $totalPages) {

        $pageNumber = 1;
        $leftLimit = 0;
        $rightLimit = 0;

        if(isset($_GET['sort'])){

            $temp1 = 0;
            $temp = explode("=", $_GET['sort']);

            if(isset($temp[1])){

                $temp1 = intval($temp[1]);

            } else {

                $temp1 = 1;

            }

            if(intval($temp1) == 0 || intval($temp1) == 1 || intval($temp1) < 0) {

                $pageNumber = 1;
                $leftLimit = 0;
                $rightLimit = $this->TaskPerPage; // 0-5

            } else if (intval($temp1) > $totalPages || intval($temp1) == $totalPages) {

                $pageNumber = $totalPages; // 2
                $leftLimit = $this->TaskPerPage * ($pageNumber - 1); // 5 * (2-1) = 6
                $rightLimit = $allTask; // 8

            } else {

                $pageNumber = intval($temp1);
                $leftLimit = $this->TaskPerPage * ($pageNumber-1); // 5* (2-1) = 6
                $rightLimit = $this->TaskPerPage; // 5 -> (6,7,8,9,10)

            }
        }
        
            $sort="id";

            if(empty($_REQUEST['sort'])){

                $sort = "id"; // Сортировка по умолчанию

                return $this->pageData['TaskOnPage'] = $this->model->getLimitTask($leftLimit, $rightLimit, $sort, $pageNumber);
            
            } else {

                $sort1=$_REQUEST['sort'];
                $sort2 = explode("?", $sort1);
                $sort = $sort2[0];

                
                return $this->pageData['TaskOnPage'] = $this->model->getLimitTask($leftLimit, $rightLimit, $sort, $pageNumber);
            }
    }
}
