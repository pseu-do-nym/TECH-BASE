<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_6</title>
        <link rel="stylesheet" href="./layout.css">
    </head>
    <body>

        <form action="" method="post" accept-charset="UTF-8">

            <div class="head">
                
                <?php
                    
                    require("./connect_db.php");
                    
                    $_SESSION['page'] = "";
                    if(!isset($_SESSION['name'])) $_SESSION['name'] = "";
                    if($_SESSION['name']!="") require("mypage_header.php");
                    else require("toppage_header.php");
                    
                    require("./blog_jump.php");
                    
                ?>

            </div>

            <?php
            
                //掲示板モードへ移行
                   
               if(isset($_POST['board'])||(isset($_SESSION['mode'])&&$_SESSION['mode']=='board')):
                   $_SESSION['mode'] = 'board';
                   require("./board.php");
               
               else:
               
                   if(isset($_POST['art_search'])):
                       $_SESSION['art'] = $_POST['art_search_text'];
                       $_SESSION['mode'] = 'blog_search';
                   endif;
                   
                   if(isset($_POST['cat_search'])):
                       $_SESSION['cat'] = $_POST['cat_search'];
                       $_SESSION['mode'] = 'cat_search';
                   endif;
               
                   require("./toppage_home.php");
               
               endif;

            ?>

        </form>
    </body>
</html>
