<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo 'admin panel' ?></title>

    <link rel="stylesheet" href="css/reset.css">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header> 
    <div class="header">
        <nav class="navbar navbar-default" role="navigation">
            <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#preview">

                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>

                        </button>
                        <a class="navbar-brand" href="#"><span class="logo">ADMIN PANEL</span></a>
                    </div>
                    <div class="collapse navbar-collapse" id="preview">
                        <form class="form-admin navbar-form navbar-right">
                            <span class="description">выйти из панели администратора</span>
                            <input type="hidden" name="name" value="">   
                            <button href="#" name="Exit" class="btn btn-default btn-admin">Выйти</button>
                        </form>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
    </div>
</header>

<main>
    <div class="container-fluid">
        <div class="row py-3">
             <div class="col-2 col-sm-3">       
                <div class="card border-primary mb-4">
                    <div class="card-body add-task">
                        <form class="form-task navbar-form navbar-right">
                            <h4 class="description-task">Добавить задачу</h4>
                                <div class="form-group">
                                    <input type="text" name="login" value="" class="inTask form-control" placeholder="имя">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="email" value="" class="inTask form-control" placeholder="email">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="title" value="" class="inTask form-control" placeholder="Заголовок">
                                </div>
                                <div class="form-group">
                                    <textarea name="text" value="" placeholder="Добавить задачу" class="inTask form-control" id="" cols="22" rows="5"></textarea>
                                </div>
                                <button href="#" name="submit" class="btn btn-default btn-task">Добавить</button>
                                <?php
                                    if(isset($pageData['ErrorTask']))
                                    {
                                        echo $pageData['ErrorTask'];
                                    }
                                    if(isset($pageData['ErrorTittle']))
                                    {
                                        echo $pageData['ErrorTittle'];
                                    }
                                    if(isset($pageData['Success']))
                                    {
                                        echo $pageData['Success'];
                                    }
                                ?>
                        </form>
                    </div>
                </div>    
            </div>
            <div class="blog col-7 col-sm-8 content">
            <div class="blog-head">
                    <h1 >Задачи</h1>
                    <form>            
                        <button href = "" name='sort' value='name' class='btn btn-default btn-sort'>Сортировать по имени</button>
                    </form>
                </div>
                <div class="task-on-page">
                    <?php foreach ($NewsList as $news): ?>
                        <div class="title">
                            <h2><?php echo $news['title'];?></h2>
                            <div class="checkTask">
                            <form>
                                <span><?php echo $news['edit'];?></span>
                                <span><?php echo $news['status'];?></span>
                                
                                <?php 
                                
                                $button = "<button name='check' value='".$news['id']."' id='".$news['id']."'class='btn btn-default btn-check-task'>"."отметить как выполненное"."</button>";
                                echo $button;
                                
                                ?>
                                
                            </form>
                            </div>
                        </div>
                        <div class="user">
                            <div class="block-user">
                                <div class="name-block">
                                    <span><?php echo "Автор: ".$news['name'];?></span>
                                </div>
                                <div class="email-block">
                                    <span><?php echo "Email: ".$news['email']; ?></span>
                                </div>
                            </div>
                        </div>


                        <div class="task-block">
                            <p  class="text"><?php echo $news['text']; ?></p>
                            <form>


                            <div class='form-group'>
                                <textarea name='text-edit' value='' placeholder='Введите исправленный текст задачи' class='inTask form-control' id='' cols='22' rows='5'></textarea>
                            </div>
                                
                                
                                <?php 

                                
                                $button = "<button name='edit' value='".$news['id']."' id='".$news['id']."'class='btn btn-default btn-task'>"."редактировать текст задачи"."</button>";
                                echo $button;
                                
                                ?>

                                
                                
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="block-pag">
                    <div class="pagination"><?php echo $pagination; ?></div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container -->
</main>

<footer>
<div class="container-fluid">
        <div class="foot">
            <span class="copyright">© Sam Petrikov, 2020</span>
        </div>
    </div>
    <!-- /.content -->
</footer>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>