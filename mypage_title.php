<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_6</title>
    </head>
    <body>

        <form action="" method="post">

            <?php
                
                $name = $_SESSION['name'];
                $page = $_SESSION['page'];
            
                require("./connect_db.php");
                
                $stmt = $pdo -> prepare("SELECT * FROM BLOGTITLE WHERE name=:name");
                $stmt -> bindValue(':name', $_SESSION['page'], PDO::PARAM_STR);
                $stmt -> execute();
                
                $results = $stmt->fetch();
                
                //ブログタイトルのデータ読み込み
                if($stmt->rowCount()==0):
                    $blogtitle = $name."のブログ";
                    $blogsubtitle = "";
                    $blogcolor = "#ADD8E6";
                    $category = "指定なし";
                    $nickname = $page;
                    $profile = "プロフィール未設定";
                    $prof_img = "img/avatar_default.png";
                    $private = FALSE;
                
                    $stmt = $pdo -> prepare("INSERT INTO BLOGTITLE (name, blogtitle, blogsubtitle, blogcolor, category, nickname, profile, prof_img, private) VALUES (:name, :blogtitle, :blogsubtitle, :blogcolor, :category, :nickname, :profile, :prof_img, :private)");
                    $stmt -> bindValue(':name', $_SESSION['name'], PDO::PARAM_STR);
                    $stmt -> bindValue(':blogtitle', $blogtitle, PDO::PARAM_STR);
                    $stmt -> bindValue(':blogsubtitle', $blogsubtitle, PDO::PARAM_STR);
                    $stmt -> bindValue(':blogcolor', $blogcolor, PDO::PARAM_STR);
                    $stmt -> bindValue(':category', $blogcolor, PDO::PARAM_STR);
                    $stmt -> bindValue(':nickname', $nickname, PDO::PARAM_STR);
                    $stmt -> bindValue(':profile', $profile, PDO::PARAM_STR);
                    $stmt -> bindValue(':prof_img', $prof_img, PDO::PARAM_STR);
                    $stmt -> bindValue(':private', $private, PDO::PARAM_BOOL);
                    $stmt -> execute();
                    
                else:
                    $blogtitle = $results['blogtitle'];
                    $blogsubtitle = $results['blogsubtitle'];
                    $blogcolor = $results['blogcolor'];
                    $category = $results['category'];
                    $nickname = $results['nickname'];
                    $profile = $results['profile'];
                    $prof_img = $results['prof_img'];
                    $private = $results['private'];
                endif;
                
                if($name==$page) $blogtitle_entry = "<div align='right'><input type='submit' name='blogtitle_edit' value='⚙'></div>";
                else $blogtitle_entry = "";
                
                if($private == TRUE) $private_check = '<input type="checkbox" name="private" value="1" checked="checked">';
                else $private_check = $private_check = '<input type="checkbox" name="private" value="1">';
                
                //色フォーム
                $col_disp = "";
                $col_list = [['#ADD8E6','水色'], ['#FFE4C4','オレンジ'], ['#FFC0CB','ピンク'], ['#DC143C','赤'], ['#6495ED','紺色'], ['#48D1CC','エメラルド'], ['#98FB98','黄緑'], ['#FFFFFF','白'], ['#696969','グレー'], ['#000000','黒']];
                foreach($col_list as $c):
                    if($blogcolor==$c[0]) $col_disp .= "<option value='".$c[0]."' selected>".$c[1]."</option>";
                    else $col_disp .= "<option value='".$c[0]."'>".$c[1]."</option>";
                endforeach;
                
                //カテゴリフォーム
                $cat_disp = "";
                require("./blog_category.php");
                foreach($cat_list as $c):
                    if($category==$c) $cat_disp .= "<option value='".$c."' selected>".$c."</option>";
                    else $cat_disp .= "<option value='".$c."'>".$c."</option>";
                endforeach;
                
                //歯車マークを押した時の編集画面
                if(isset($_POST['blogtitle_edit'])):
                    $blogtitle_entry = "<table align='right' border='0'>"
                    ."<tr>"
                        ."<td align='right'>ブログタイトル：</td>"
                        ."<td align='left'><input type='text' name='blogtitle' value=".$blogtitle."></td>"
                    ."</tr>"
                    ."<tr>"
                        ."<td align='right'>サブタイトル：</td>"
                        ."<td align='left'><input type='text' name='blogsubtitle' value=".$blogsubtitle."></td>"
                    ."</tr>"
                    ."<tr>"
                        ."<td align='right'>背景色：</td>"
                        ."<td align='left'><select name='blogcolor'>"
                        .$col_disp
                        ."</select></td>"
                    ."</tr>"
                
                    ."<tr>"
                        ."<td align='right'>ブログカテゴリ：</td>"
                        ."<td align='left'><select name='category'>"
                        .$cat_disp
                        ."</select></td>"
                    ."</tr>"
                
                    ."<tr>"
                        ."<td align='right'>ニックネーム：</td>"
                        ."<td align='left'><input type='text' name='nickname' size='20' value=".$nickname."></td>"
                    ."</tr>"
                
                    ."<tr>"
                        ."<td align='right'>プロフィール：</td>"
                        ."<td align='left'><input type='text' name='profile' size='20' value=".$profile."></td>"
                    ."</tr>"
                    
                    ."<tr>"
                        ."<td align='right'>プロフ画像：</td>"
                        ."<td align='left'><input type='file' name='img' accept='image/*'></td>"
                    ."</tr>"
                
                    ."<tr>"
                        ."<td align='right' colspan='2'>".$private_check."ブログを非公開に設定する</td>"
                        ."<td><input type='submit' name='blogtitle_change' value='確定'></td>"
                    ."</tr></table>";
                endif;
                
                //ブログタイトルデータの変更
                if(isset($_POST['blogtitle_change'])):
                
                    if(isset($_POST['blogtitle'])):
                        if($_POST['blogtitle']!="") $blogtitle = $_POST['blogtitle'];
                        else $blogtitle = "(無題)";
                    endif;
                    if(isset($_POST['blogsubtitle'])) $blogsubtitle = $_POST['blogsubtitle'];
                    if(isset($_POST['blogcolor'])):
                        if($_POST['blogcolor']!="") $blogcolor = $_POST['blogcolor'];
                    endif;
                    if(isset($_POST['category'])) $category = $_POST['category'];
                    if(isset($_POST['nickname'])) $nickname = $_POST['nickname'];
                    if(isset($_POST['profile'])) $profile = $_POST['profile'];
                
                    if(isset($_FILES["img"]["name"])&&$_FILES["img"]["name"]!=""):
                
                        require("./img_rename.php");
                
                        if(!move_uploaded_file($_FILES["img"]["tmp_name"],($filename))):
                                  print "プロフ画像のアップロードに失敗しました<br>";
                        else:
                            $sql = $pdo -> prepare("INSERT INTO IMG_LIST (name, img_title, date)
                            VALUES (:name, :img_title, :date)");
                            $sql -> bindParam(':name', $_SESSION['name'], PDO::PARAM_STR);
                            $sql -> bindParam(':img_title', $filename, PDO::PARAM_STR);
                            $sql -> bindParam(':date', $date, PDO::PARAM_STR);
                            $sql -> execute();
                                                   
                            $prof_img = $filename;
                                                   
                        endif;
                
                    endif;
                
                    $private = isset($_POST['private']);
                
                    $stmt = $pdo -> prepare("INSERT INTO BLOGTITLE (name, blogtitle, blogsubtitle, blogcolor, category, nickname, profile, prof_img, private) VALUES (:name, :blogtitle, :blogsubtitle, :blogcolor, :category, :nickname, :profile, :prof_img, :private) ON DUPLICATE KEY UPDATE blogtitle = :blogtitle, blogsubtitle = :blogsubtitle, blogcolor = :blogcolor, category = :category, nickname = :nickname, profile = :profile, prof_img = :prof_img, private = :private");
                    $stmt -> bindValue(':name', $_SESSION['name'], PDO::PARAM_STR);
                    $stmt -> bindValue(':blogtitle', $blogtitle, PDO::PARAM_STR);
                    $stmt -> bindValue(':blogsubtitle', $blogsubtitle, PDO::PARAM_STR);
                    $stmt -> bindValue(':blogcolor', $blogcolor, PDO::PARAM_STR);
                    $stmt -> bindValue(':category', $category, PDO::PARAM_STR);
                    $stmt -> bindValue(':nickname', $nickname, PDO::PARAM_STR);
                    $stmt -> bindValue(':profile', $profile, PDO::PARAM_STR);
                    $stmt -> bindValue(':prof_img', $prof_img, PDO::PARAM_STR);
                    $stmt -> bindValue(':private', $private, PDO::PARAM_BOOL);
                    $stmt -> execute();
                
                    $stmt = $pdo -> prepare("SELECT * FROM BLOGTITLE WHERE name=:name");
                    $stmt -> bindValue(':name', $_SESSION['name'], PDO::PARAM_STR);
                    $stmt -> execute();
                
                endif;
                
                if(($blogcolor == '#DC143C')||($blogcolor == '#6495ED')||($blogcolor == '#696969')||($blogcolor == '#000000')):
                    $blogtitle_disp = "　 <button class='btn-nohover' type='submit' name='back_to_home'><font size='6' color='white'>".$blogtitle."</font></button><br><font color='white'>　　".$blogsubtitle."</font>";
                else:
                    $blogtitle_disp = "　 <button class='btn-nohover' type='submit' name='back_to_home'><font size='6'>".$blogtitle."</font></button><br>　　".$blogsubtitle;
                endif;
                
            ?>

        </form>

        <?php
            
            echo '<form method="post" enctype="multipart/form-data">'
                    .'<div style="background-color:'.$blogcolor.'">'
                        .'<hr>'
                        .'<div align="left">'.$blogtitle_disp.'</div>'
                        .$blogtitle_entry.'<br>'

                        .'<div align="right"><select name="kind_of_search"><option value="all">全文</option><option value="tag">タグ</option></select>'
                        .'<input type="text" name="art_search_text" placeholder="記事を検索"><input type="submit" name="art_search" value="検索">'
                        .'</div>'
                        .'<hr>'
                    .'</div>'
                .'</form>';

        ?>

    </body>
</html>

