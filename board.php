<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_6</title>
    </head>
    <body>

        <div class="flex_item">

            <?php
                
                require("./connect_db.php");
                
                //掲示板トップに戻る
                if(isset($_POST['board_top'])):
                
                    $_SESSION['cat_board'] = "";
                
                endif;
                
                //掲示板ジャンルを押したとき
                if(isset($_POST['cat_board'])):
                
                    $_SESSION['cat_board'] = $_POST['cat_board'];
                
                endif;
                
                if(isset($_SESSION['cat_board']) && $_SESSION['cat_board']!=""):
                
                    require("./board_body.php");
                
                else:
                
                    require("./board_home.php");
                
                endif;
                
            ?>

        </div>

    </body>
</html>
