<?php
require "includes/config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $config['title']; ?></title>

    <!-- Bootstrap Grid -->
    <link rel="stylesheet" type="text/css" href="/media/assets/bootstrap-grid-only/css/grid12.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">

    <!-- Custom -->
    <link rel="stylesheet" type="text/css" href="/media/css/style.css">
</head>
<body>

<!--TODO Сделать авторизацию входа в админку-->

<div id="wrapper">

    <!--HEADER -->
    <?php include 'includes/header.php'; ?>
    <!--/HEADER-->

                        <div id="article-add-form" class="block">
                            <h3>Панель Администратора / Добавить статью</h3>
                            <div class="block__content">
                                <form class="form" method="POST" action="admin.php">
                                    <?php //Обработчик формы в этом же файле

                                    if ( isset($_POST['do_post'])){
                                        $errors = array();


                                        if ($_POST['title'] == '') {$errors[] = 'Введите название статьи';}
                                        if ($_POST['cat_id'] == '') {$errors[] = 'Выберите категорию';}
                                        if ($_POST['text'] == '') {$errors[] = 'Введите текст статьи';}

                                        if (empty($errors))
                                        {
                                            //Добавить комментарий

                                            mysqli_query($connection, "INSERT INTO `articles` (`title`, `image`, `text`, `categorie_id`, `pubdate`) VALUES ('".$_POST['title']."', '".$_POST['image']."', '".$_POST['text']."', '".$_POST['cat_id']."', NOW())");

                                            echo '<span style="color: #0cad07; font-weight: bold; margin-bottom: 10px; display: block;">' . 'Статья успешно добавлена' . '</span>';
                                        } else {
                                            //Вывести ошибку
                                            // foreach ($errors as $err) echo $err;
                                            echo '<span style="color: red; font-weight: bold; margin-bottom: 10px; display: block;">' . $errors['0'] . '</span>';
                                        }

                                    }

                                    ?>
                                    <div class="form__group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" class="form__control" name="title" placeholder="Название статьи" value="<?php echo @$_POST['title']; ?>">
                                            </div>
                                            <div class="col-md-3">
                                              <p>Выберите категорию</p>

                                             <?php
                                                foreach ($categories as $cat)
                                                 {
                                                   ?>
                                                     <p><input type="radio" name="cat_id" value="<?php echo $cat['id']; ?>"><?php echo $cat['title']; ?></p>
                                                    <?php
                                                     }
                                                    ?>






                                            </div>
                                            <div class="col-md-3">
                                                <p>Загрузите изображение</p>
                                                <input type="file" class="form__control" name="image" title="Загрузите изображение">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form__group">
                                        <textarea name="text" class="form__control"
                                                  placeholder="Текст статьи ..."><?php echo @$_POST['text']; ?></textarea>
                                    </div>
                                    <div class="form__group">
                                        <input type="submit" class="form__control" name="do_post"
                                               value="Добавить статью">
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
            </div>
        </div>


    <!--FOOTER-->
    <?php
    include 'includes/footer.php';
    ?>


</div>

</body>