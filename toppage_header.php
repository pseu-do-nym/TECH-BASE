<?php
    
    $login = "";
    $name = "";
    $pass = "";
    $page = $_SESSION['page'];
    $id_alert = "";
    
    if(isset($_POST['log_det'])):
        
        $name = $_POST['name'];
        $pass = $_POST['pass'];
        if($name!="" && $pass!=""):
            
            require("./connect_db.php");

            $sql = 'SELECT * FROM REGISTRATION WHERE (name=:name) AND (pass=:pass)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
            $stmt->execute();
        
            if(($stmt->rowCount())==0):
                $id_alert = "<font color='red'>！IDかパスワードが間違っています</font>";
            else:
                //ログイン処理
                $_SESSION['name'] = $name;
                if(!isset($_SESSION['page'])) $_SESSION['page'] = "";
                $_SESSION['pass'] = $pass;
                $_SESSION['mode'] = 'home';
                $_SESSION['login'] = TRUE;
                $_SESSION['edit_art_id'] = -1;
                
                if(($_SESSION['page'])=="") header("Location: ./toppage.php");
                else header("Location: ./mypage.php");
                
            endif;
            
        else:
            $id_alert = "<font color='red'>！未入力の項目があります</font>";
        endif;
    endif;
    
    if(isset($_POST['login']) || isset($_POST['log_det'])):
    
        $login = "<table frame='box' border='0' bgcolor='white'>"
        ."<tr><td align='left' colspan='2'>ログイン</td></tr>"
        ."<tr>"
        ."<table frame='box' border='0' bgcolor='#EDF7FF'>"
        ."<tr><td align='right'>ID：</td><td><input type='text' name='name' size='15' value=$name></td></tr>"
        ."<tr><td align='right'>PASS：</td><td><input type='password' name='pass' size='15' value=$pass></td></tr>"
        ."<tr><td align='right'>$id_alert</td><td align='left'><input type='submit' name='log_det' value='決定'></td></tr>"
        ."</table>"
        ."</tr></table>";
    
    endif;
    
    //トップページへ戻る
    if(isset($_POST['link_toppage'])):
        $_SESSION['mode'] = 'home';
        $_SESSION['page'] = "";
        $_SESSION['cat_board'] = "";
        $_SESSION['edit_art_id'] = -1;
    header("Location: ./toppage.php");
    endif;
    
    if(isset($_POST['link_mypage'])):
        $_SESSION['mode'] = 'home';
        $_SESSION['page'] = $name;
        $_SESSION['cat_board'] = "";
        $_SESSION['edit_art_id'] = -1;
        header("Location: ./mypage.php");
    endif;
    
    $page_link = "";
    if($page!="" ||(isset($_SESSION['mode'])&&$_SESSION['mode']!='home')||isset($_POST['board'])||isset($_POST['art_search'])||isset($_POST['cat_search'])) $page_link .= " <button class='btn-link' type='submit' name='link_toppage'>トップページへ</button>";

?>

<div align="left">
ようこそ、 ゲスト さん <?php echo $page_link;?>

<div align="right">
    <input type="submit" name="login" value="ログイン">
    <input type="button" onclick="location.href='./registration.php'" value="新規登録">
</div>
<div align="right"><?php echo $login; ?></div>

<div style="width:760px; oveflow=hidden;">

    <div style="width:584px; float:right;">
    </div>

    <nav style="width:144px; float:left;">
    </nav>

</div>
<hr>
