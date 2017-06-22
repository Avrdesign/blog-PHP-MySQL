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

<div id="wrapper">

    <!--HEADER -->
    <?php include 'includes/header.php'; ?>
    <!--/HEADER-->

    <?php
    $article = mysqli_query($connection, "SELECT * FROM `articles` WHERE `id` = " . (int)$_GET['id']);
    //(int) для безопасности кода, чтобы хакер не ввел ничего кроме числа
    if (mysqli_num_rows($article) <= 0) {
        ?>
        <div id="content">
            <div class="container">
                <div class="row">
                    <section class="content__left col-md-8">
                        <div class="block">
                            <h3>Статья не найдена</h3>
                            <div class="block__content">
                                <img src="/media/images/post-image.jpg">

                                <div class="full-text">
                                    Запрашиваемая статья не существует!
                                </div>
                            </div>
                        </div>

                    </section>
                    <section class="content__right col-md-4">
                        <?php include 'includes/sidebar.php' ?>
                    </section>
                </div>
            </div>
        </div>
        <?php
    } else {
        $art = mysqli_fetch_assoc($article);
        mysqli_query($connection, "UPDATE `articles` SET `views` = `views` + 1 WHERE `id` = " . (int)$art['id']);
        //Увеличивает кол-во просмотров на 1
        ?>
        <div id="content">
            <div class="container">
                <div class="row">
                    <section class="content__left col-md-8">
                        <div class="block">
                            <a><?php echo $art['views']; ?> просмотров</a>
                            <h3><?php echo $art['title']; ?></h3>
                            <div class="block__content">
                                <img src="/static/images/<?php echo $art['image']; ?>" style="max-width: 100%">
                                <div class="full-text">
                                    <?php echo $art['text']; ?>
                                </div>
                            </div>
                        </div>
                        <div class="block">
                            <a href="#comment-add-form">Добавить свой</a>
                            <h3>Комментарии</h3>
                            <div class="block__content">
                                <div class="articles articles__vertical">

                                    <?php
                                    $comments = mysqli_query($connection, "SELECT * FROM `comments` WHERE `articles_id` = " . (int)$art['id'] . " ORDER BY `id` DESC");
                                    /*Вывод последних отзывов к статье - самые новые вначале*/
                                    if (mysqli_num_rows($comments) <= 0) {
                                        echo "Нет комментариев";
                                    }
                                    while ($comment = mysqli_fetch_assoc($comments)) {
                                        ?>
                                        <article class="article">
                                            <div class="article__image"
                                                 style="background-image: url(https://gravatar.com/avatar/<?php echo md5($comment['email']); ?>);"></div>
                                            <div class="article__info">
                                                <a href="/article.php?id=<?php echo $comment['articles_id']; ?>"><?php echo $comment['author']; ?></a>
                                                <div class="article__info__meta"></div>
                                                <div class="article__info__preview"><?php echo $comment['text']; ?></div>
                                            </div>
                                        </article>
                                        <?php
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>

                        <div id="comment-add-form" class="block">
                            <h3>Добавить комментарий</h3>
                            <div class="block__content">
                                <form class="form" method="POST" action="/article.php?id=<?php echo $art['id'];?>#comment-add-form">
                                    <?php //Обработчик формы в этом же файле

                                    if ( isset($_POST['do_post'])){
                                        $errors = array();


                                        if ($_POST['name'] == '') {$errors[] = 'Введите имя';}
                                        if ($_POST['nickname'] == '') {$errors[] = 'Введите никнейм';}
                                        if ($_POST['email'] == '') {$errors[] = 'Введите Email';}
                                        if ($_POST['text'] == '') {$errors[] = 'Введите текст комментария';}

                                        if (empty($errors))
                                        {
                                            //Добавить комментарий

                                            mysqli_query($connection, "INSERT INTO `comments` (`author`, `nickname`, `email`, `text`, `pubdate`, `articles_id`) VALUES ('".$_POST['name']."', '".$_POST['nickname']."', '".$_POST['email']."', '".$_POST['text']."', NOW(), '".$art['id']."')");

                                            echo '<span style="color: #0cad07; font-weight: bold; margin-bottom: 10px; display: block;">' . 'Комментарий успешно добавлен' . '</span>';
                                        } else {
                                            //Вывести ошибку
                                            // foreach ($errors as $err) echo $err;
                                            echo '<span style="color: red; font-weight: bold; margin-bottom: 10px; display: block;">' . $errors['0'] . '</span>';
                                        }

                                    }

                                    //TODO проблема с комментариями, если оставлять заполнение формы, типа value="<?php echo $_POST['name'];... . Возможно это проблема WAMP
                                    //TODO коментарий не появляется на странице сразу, а при обновлении дублируется в базе. Найти решение.

                                    ?>
                                    <div class="form__group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input type="text" class="form__control" name="name" placeholder="Имя" > <!-- value="<?php echo $_POST['name']; ?>" -->
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" class="form__control" name="nickname"  placeholder="Никнейм" > <!-- value="<?php echo $_POST['nickname']; ?>"-->
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" class="form__control" name="email"  placeholder="Email (не будет показан)" > <!-- value="<?php echo $_POST['email']; ?>"-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form__group">
                                        <textarea name="text" class="form__control"
                                                  placeholder="Текст комментария ..."></textarea> <!-- <?php echo $_POST['text']; ?> -->
                                    </div>
                                    <div class="form__group">
                                        <input type="submit" class="form__control" name="do_post"
                                               value="Добавить комментарий">
                                    </div>
                                </form>
                            </div>
                        </div>

                    </section>
                    <section class="content__right col-md-4">
                        <?php include 'includes/sidebar.php' ?>
                    </section>
                </div>
            </div>
        </div>
        <?php
    }
    ?>


    <!--FOOTER-->
    <?php
    include 'includes/footer.php';
    ?>


</div>

</body>