<?php

class AdminController extends Controller {

    private $pageTpl = "/views/admin.tpl.php";

    private $productsPerPage = 3;

    public function __construct() {
        $this->model = new AdminModel();
        $this->view = new View();
    }


    public function Index() {
        $this->Exit();

        if(!$_SESSION['user']) {
			header("Location: /bootstrap/index");
		}
        if($_SESSION['user']){
            $this->pageData['Answer'] = "не выполнено";
            $this->pageData['title'] = "Панель администратора";
            if(isset($_REQUEST['submit'])) {
                $this->actionAdd();
            }
            $this->actionTaskPage();
            $this->CheckTask();
            $this->EditTextTask();
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
            $allProducts = count(AdminModel::getAllProducts($sort));

        } else {

            $sort=$_REQUEST['sort'];
            $allProducts = count(AdminModel::getAllProducts($sort));

        }

        $totalPages = ceil($allProducts / $this->productsPerPage);

        $NewsList = $this->makeProductPager($allProducts, $totalPages);


        if(empty($_REQUEST['sort'])){

            $sort = "id"; // Сортировка по умолчанию
            $pagination = PaginationAdmin::drawPager($allProducts, $this->productsPerPage, $sort);
        
        } else {

            $sort1=$_REQUEST['sort'];
            $sort2 = explode("?", $sort1);
            $sort = $sort2[0];

            $pagination = PaginationAdmin::drawPager($allProducts, $this->productsPerPage, $sort);
        
        }

        $this->view->render($this->pageTpl, $this->pageData, $NewsList, $pagination);

        return true;

    }
    



    public function makeProductPager($allProducts, $totalPages) {

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
                $rightLimit = $this->productsPerPage; // 0-5

            } else if (intval($temp1) > $totalPages || intval($temp1) == $totalPages) {

                $pageNumber = $totalPages; // 2
                $leftLimit = $this->productsPerPage * ($pageNumber - 1); // 5 * (2-1) = 6
                $rightLimit = $allProducts; // 8

            } else {

                $pageNumber = intval($temp1);
                $leftLimit = $this->productsPerPage * ($pageNumber-1); // 5* (2-1) = 6
                $rightLimit = $this->productsPerPage; // 5 -> (6,7,8,9,10)

            }
        }
        
            $sort="id";

            if(empty($_REQUEST['sort'])){

                $sort = "id"; // Сортировка по умолчанию

                return $this->pageData['TaskOnPage'] = $this->model->getLimitProducts($leftLimit, $rightLimit, $sort, $pageNumber);
            
            } else {

                $sort1=$_REQUEST['sort'];
                $sort2 = explode("?", $sort1);
                $sort = $sort2[0];

                return $this->pageData['TaskOnPage'] = $this->model->getLimitProducts($leftLimit, $rightLimit, $sort, $pageNumber);
            
            }
    }


    public function Exit()
    {
        if(isset($_REQUEST['Exit'])){

            session_destroy();
            header("Location: /bootstrap/index");

        }
    }

    public function CheckTask()
    {
        $status = "выполнено";

        if(isset($_REQUEST['check'])){

            $id =  $_REQUEST['check'];
            $this->model->Performed($status, $id);

        }
    }


    public function EditTextTask()
    {
        $edit = "отредактированно администратором";

        if(isset($_REQUEST['edit'])){
            
            $id =  $_REQUEST['edit'];
            $text = htmlspecialchars($_REQUEST['text-edit']);
            $this->model->EditTask($id, $text);
            $this->model->EditAdmin($edit, $id);
        }
    }

}

 ?>