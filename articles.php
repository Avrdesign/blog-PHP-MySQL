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

    <div id="content">
      <div class="container">
        <div class="row">
          <section class="content__left col-md-8">
            <div class="block">
              <h3>Все статьи</h3>
              <div class="block__content">
                <div class="articles articles__horizontal">

                    <?php
                        $per_page = 4; //количество статей на странице (LIMIT)
                        $page = 1; //номер страницы 1- по умолчанию
                        $offset = 0; // Сдвиг - 1-й аргумент для оператора - ...ORDER BY `id` DESC LIMIT ...
                    if ( isset($_GET['page'])) {
                            $page = (int) $_GET['page'];
                        }
                    if ( isset($_GET['categorie'])) {
                        $categorie = (int) $_GET['categorie'];
                        $total_count_q = mysqli_query($connection, "SELECT COUNT(`id`) AS `total_count` FROM `articles` WHERE `categorie_id`= $categorie");
                        $total_count = mysqli_fetch_assoc($total_count_q);
                        $total_count = $total_count['total_count']; //кол-во статей в базе
                    } else {
                        $total_count_q = mysqli_query($connection, "SELECT COUNT(`id`) AS `total_count` FROM `articles`");
                        $total_count = mysqli_fetch_assoc($total_count_q);
                        $total_count = $total_count['total_count']; //кол-во статей в базе
                    }


                    $total_pages = ceil($total_count / $per_page); //общее кол-во страниц в пагинации
                    if($page <= 1 || $page > $total_pages) {
                        $page = 1;
                    }

                   $offset = $per_page * $page - $per_page;
                    // 0 = 4 * 1 - 4  - вычисление сдвига
                    // 4 = 4 * 2 - 4
                    // 8 = 4 * 3 - 4


                    if ( isset($_GET['categorie'])) {
                        $categorie = (int) $_GET['categorie'];
                        $articles = mysqli_query($connection, "SELECT * FROM `articles` WHERE `categorie_id`= $categorie ORDER BY `id` DESC LIMIT $offset, $per_page");
                        /*Вывод статей определенной категории отсортированных - самые новые вначале*/

                    } else {
                        $articles = mysqli_query($connection, "SELECT * FROM `articles` ORDER BY `id` DESC LIMIT $offset, $per_page");
                        /*Вывод ВСЕХ статей отсортированных - самые новые вначале*/
                    }
                    $articles_exist = true; //Ключ существования статей
                    if( mysqli_num_rows($articles) <= 0)
                    {
                        $articles_exist = false;
                        echo 'Нет статей!';
                    }

                    while($art = mysqli_fetch_assoc($articles))
                    {
                    ?>
                    <article class="article">
                    <div class="article__image" style="background-image: url(/static/images/<?php echo $art['image']; ?>);"></div>
                    <div class="article__info">
                      <a href="/article.php?id=<?php echo $art['id']; ?>"><?php echo $art['title']; ?></a>
                      <div class="article__info__meta">
                          <?php
                          $art_cat = false;
                          if (isset($categories)) {
                              foreach ($categories as $cat)
                              {
                                  if($cat['id'] == $art['categorie_id'])
                                  {
                                      $art_cat = $cat;
                                      break;
                                  }
                              }
                          }
                          ?>
                        <small>Категория: <a href="/articles.php?categorie=<?php echo $art_cat['id']; ?>"><?php echo $art_cat['title']; ?></a></small>
                      </div>
                      <div class="article__info__preview"><?php echo mb_substr(strip_tags($art['text']), 0, 100, 'utf-8') . ' ...'; ?></div>
                    </div>
                  </article>
                    <?php
                    }
                    ?>

                   </div>
                  <?php
                  if($articles_exist) //Простой пагинатор
                  {
                      echo '<div class="paginator">';
                      if ($page > 1) {
                          echo '<span class="article__cat"><a href="/articles.php?page=' . ($page - 1) .'">&laquo Предыдущая страница || </a> </span>';
                      }
                      if ($page < $total_pages) {
                          echo '<span class="article__cat"> <a href="/articles.php?page=' . ($page + 1) .'">Следующая страница &raquo</a> </span>';
                      }
                      echo '</div>';
                  }
                  ?>

              </div>
            </div>



          </section>
          <section class="content__right col-md-4">
            <?php include 'includes/sidebar.php'?>
          </section>
        </div>
      </div>
    </div>

      <!--FOOTER-->
      <?php
      include 'includes/footer.php';
      ?>

  </div>

</body>
</html>