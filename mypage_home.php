<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_6</title>
    </head>
    <body>

        <form action="" method="post" accept-charset="UTF-8">

            <?php

                require("./blog_environment.php");
                
            ?>

            <div class="flex_item">

                <div class="menu" align="left">

                    <?php

                        require("./blog_sidebar.php");
                        
                    ?>

                </div>

                <div class="line"></div>

                <div class="main">

                    <?php
                        
                        echo $new_article;
                        
                        if($name==$page) $stmt = $pdo -> prepare("SELECT * FROM ARTICLE WHERE name=:name ORDER BY id DESC");
                        else $stmt = $pdo -> prepare("SELECT * FROM ARTICLE WHERE name=:name and private=0 ORDER BY id DESC");
                        $stmt -> bindParam(':name', $page, PDO::PARAM_STR);
                        $stmt -> execute();
                        
                        $disp_art = $stmt->fetchAll();
                        $art_count = $stmt->rowCount();
                        
                        if($art_count == 0):
                            echo "<div align='center'>記事がありません。<br>上の「新規記事作成」ボタンではじめての記事を投稿してみましょう！</div>";
                        else:
                            
                            //新着記事を３つ表示
                            if(isset($_POST['trans_art'])) $disp_count = $_POST['trans_art'];
                            else $disp_count = 0;

                            echo '<div align="center">全 '.$art_count.' 件中 '.($disp_count+1).'-'.(min(($disp_count+3),$art_count)).' 番目の記事を表示中<hr></div>';
                        
                                require("./mypage_disp_art.php");
                        
                        endif;
                        
                    ?>

                </div>

            </div>

        </form>
    </body>
</html>
