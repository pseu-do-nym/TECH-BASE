<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_6</title>
    </head>
    <body>

        <hr>
        <div align="center"><font size="+2">申し訳ございません<br></font>
        このブログは現在非公開に設定されています<br>

        <?php
            
            if(isset($_POST['link_toppage'])):
                $_SESSION['page'] = "";
                $_SESSION['edit_art_id'] = -1;
                header("Location: ./toppage.php");
            endif;
            
        ?>

        <br><div align="center"><button type="submit" class="btn-link" name="link_toppage">ブログトップに戻る</div>

    </body>
</html>
