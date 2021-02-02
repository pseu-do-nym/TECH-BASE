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
                        
                        if($_SESSION['kind_of_search'] == "all"):
                        
                            //ORDER BY date DESC, id DESCにしていたが、なんか1時と19時が逆になったのでidだけに。
                            if($name==$page) $stmt = $pdo -> prepare("SELECT * FROM ARTICLE WHERE name=:name and str like '%".$_SESSION['art']."%' ORDER BY id DESC");
                            else $stmt = $pdo -> prepare("SELECT * FROM ARTICLE WHERE name=:name and str like '%".$_SESSION['art']."%' and private=0 ORDER BY id DESC");
                            $stmt -> bindValue(':name', $_SESSION['page'], PDO::PARAM_STR);
                            $stmt -> execute();
                            echo '<div align="left"> 本文：" '.$_SESSION['art'].' " の検索結果<br>';
                        
                        elseif($_SESSION['kind_of_search'] == "tag"):
                        
                            if($name==$page) $stmt = $pdo -> prepare("SELECT * FROM ARTICLE WHERE name=:name and tag like '%,".$_SESSION['art'].",%' ORDER BY id DESC");
                            else $stmt = $pdo -> prepare("SELECT * FROM ARTICLE WHERE name=:name and tag like '%,".$_SESSION['art'].",%' and private=0 ORDER BY id DESC");
                            $stmt -> bindValue(':name', $_SESSION['page'], PDO::PARAM_STR);
                            $stmt -> execute();
                            echo '<div align="left"> タグ：" '.$_SESSION['art'].' " の検索結果<br>';
                        
                        endif;
                        
                        $disp_art = $stmt->fetchAll();
                        $art_count = $stmt->rowCount();
                            
                        //新着記事を３つ表示
                        if(isset($_POST['trans_art'])) $disp_count = $_POST['trans_art'];
                        else $disp_count = 0;

                        echo '<div align="center">全 '.$art_count.' 件中 '.(min(($disp_count+1),$art_count)).'-'.(min(($disp_count+3),$art_count)).' 番目の記事を表示中<hr></div>';

                        if($art_count == 0) echo "<div align='center'>検索結果が見つかりませんでした。<br></div>";

                        require("./mypage_disp_art.php");
                    
                        echo '<br><div align="center"><button type="submit" class="btn-link" name="back_to_home">ブログトップに戻る</div>';
                        
                    ?>

                </div>

            </div>

        </form>
    </body>
</html>
