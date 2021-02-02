<div class="flex_item">

    <div class="menu" align="left">
        <!-- 🏠 最近の更新<br> -->
        📂 カテゴリ別に探す<br>
        <?php
        
            require("./blog_category.php");
            
            foreach($cat_list as $c) echo "<button class='btn-link' type='submit' name='cat_search' value='".$c."'>・".$c."</button><br>";
            
        ?>

        <button class='btn-link' type='submit' name='board'>📜 掲示板</button><br>

    </div>

    <div class="line"></div>

    <div class="main">

        <?php
        
            echo "<div align='center'><b><font size='8'>TECH-BLOG</font></b><br>お手軽ブログ作成＆閲覧サービス</div>";
            
            
        ?>

        <div align="right"><input type="text" name="art_search_text" placeholder="記事を検索"><input type='submit' name='art_search' value='検索'></div>
        <hr>

        <?php
            
            //ブログ記事の検索
            if(isset($_SESSION['mode'])&&$_SESSION['mode']=='blog_search'):
            
                $stmt = $pdo -> prepare("(SELECT A1.*, A2.blogtitle FROM (SELECT * FROM ARTICLE WHERE private=0) AS A1 INNER JOIN (SELECT * FROM BLOGTITLE WHERE private=0) AS A2 ON (A1.name = A2.name) WHERE A1.title like '%".$_SESSION['art']."%' ORDER BY A1.id DESC LIMIT 1000)"
                    ."UNION (SELECT A1.*, A2.blogtitle FROM (SELECT * FROM ARTICLE WHERE private=0) AS A1 INNER JOIN (SELECT * FROM BLOGTITLE WHERE private=0) AS A2 ON (A1.name = A2.name) WHERE A1.str like '%".$_SESSION['art']."%' ORDER BY A1.id DESC LIMIT 1000)");
                $stmt -> execute();
                
                $disp_art = $stmt->fetchAll();
                $art_count = $stmt->rowCount();
            
//                            $stmt = $pdo -> prepare("SELECT A1.*, A2.blogtitle FROM (SELECT * FROM ARTICLE WHERE private=0) AS A1 INNER JOIN (SELECT * FROM BLOGTITLE WHERE private=0) AS A2 ON (A1.name = A2.name) WHERE A1.str like '%".$_SESSION['art']."%' ORDER BY id DESC");
//                            $stmt -> execute();
//
//                            $disp_art = array_merge($disp_art,($stmt->fetchAll()));
//                            $art_count += $stmt->rowCount();
            
                if($art_count == 0):
                    echo $_SESSION['art'].'の検索結果はありません。<br>';
                else:
                                        
                    //新着ブログを10個表示
                    if(isset($_POST['trans_blog'])) $disp_count = $_POST['trans_blog'];
                    else $disp_count = 0;

                    echo '<div align="left"> " '.$_SESSION['art'].' " の検索結果<br>';
                    echo '<div align="center">全 '.$art_count.' 件中 '.($disp_count+1).'-'.(min(($disp_count+10),$art_count)).' 番目の記事を表示中<hr></div>';
                
                    require("./toppage_disp_blog.php");
                                        
                endif;
            
                echo '<br><div align="center"><button type="submit" class="btn-link" name="link_toppage">トップに戻る</div>';
            
            elseif(isset($_SESSION['mode'])&&$_SESSION['mode']=='cat_search'):
            
                $stmt = $pdo -> prepare("SELECT A1.*, A3.blogtitle FROM (SELECT * FROM ARTICLE WHERE private=0) AS A1 "
                    ."LEFT JOIN (SELECT * FROM ARTICLE WHERE private=0) AS A2 ON (A1.name = A2.name AND A1.date < A2.date) "
                    ."INNER JOIN (SELECT * FROM BLOGTITLE WHERE private=0 and category=:category) AS A3 ON (A1.name = A3.name) WHERE A2.date IS NULL ORDER BY id DESC");
                $stmt -> bindValue(':category', $_SESSION['cat'], PDO::PARAM_STR);
                $stmt -> execute();
                
                $disp_art = $stmt->fetchAll();
                $art_count = $stmt->rowCount();
            
                echo '<div align="left"> カテゴリ： '.$_SESSION['cat'].' の検索結果<br>';
            
                if($art_count == 0):
                    echo "<div align='center'>条件に該当するブログは見つかりませんでした。</div>";
                else:
                    
                    //新着ブログを10個表示
                    if(isset($_POST['trans_blog'])) $disp_count = $_POST['trans_blog'];
                    else $disp_count = 0;

                    echo '<div align="center">全 '.$art_count.' 件中 '.($disp_count+1).'-'.(min(($disp_count+10),$art_count)).' 番目のブログを表示中<hr></div>';
                
                    require("./toppage_disp_blog.php");
                
                endif;
            
                echo '<br><div align="center"><button type="submit" class="btn-link" name="link_toppage">トップに戻る</button></div>';
            
            else:
            
                $stmt = $pdo -> prepare("SELECT A1.*, A3.blogtitle FROM (SELECT * FROM ARTICLE WHERE private=0) AS A1 "
                    ."LEFT JOIN (SELECT * FROM ARTICLE WHERE private=0) AS A2 ON (A1.name = A2.name AND A1.date < A2.date) "
                    ."INNER JOIN (SELECT * FROM BLOGTITLE WHERE private=0) AS A3 ON (A1.name = A3.name) WHERE A2.date IS NULL ORDER BY id DESC");
                $stmt -> execute();
                
                $disp_art = $stmt->fetchAll();
                $art_count = $stmt->rowCount();
                if($art_count == 0):
                    echo "<div align='center'>ブログがありません。</div>";
                else:
                    
                    //新着ブログを10個表示
                    if(isset($_POST['trans_blog'])) $disp_count = $_POST['trans_blog'];
                    else $disp_count = 0;

                    echo '<div align="center"><font color="red">★注目の新着記事を紹介！★</font></div>';
                    echo '<div align="center">全 '.$art_count.' 件中 '.($disp_count+1).'-'.(min(($disp_count+10),$art_count)).' 番目のブログを表示中<hr></div>';
                
                    require("./toppage_disp_blog.php");
                
                endif;
            
            endif;
            
        ?>

    </div>

</div>
