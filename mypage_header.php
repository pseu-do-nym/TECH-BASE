<?php
    
    $dialog = "";
    $name = $_SESSION['name'];
    $page = $_SESSION['page'];

    if(isset($_POST['logout'])):
        
        $dialog =
        '<div align="right">
        <table frame="box" border="0" bgcolor="white">
            <tr><td align="center" colspan="2">ログアウトしますか？</td></tr>
            <tr><td><input type="submit" name="logout_det" value="はい"></td><td><input type="submit" value="いいえ"></td></tr></table>
        </div>';

    endif;

    $page_link = "";
    if($page!="" ||(isset($_SESSION['mode'])&&$_SESSION['mode']!='home')||isset($_POST['board'])||isset($_POST['art_search'])||isset($_POST['cat_search'])) $page_link .= " <button class='btn-link' type='submit' name='link_toppage'>トップページへ</button>";
    if($page!=$name && $name!="") $page_link .= " <button class='btn-link' type='submit' name='link_mypage'>マイページへ</button>";

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

    if($name==""):
        $nickname = "ゲスト";
    else:
        $stmt = $pdo -> prepare("SELECT * FROM BLOGTITLE WHERE name=:name");
        $stmt -> bindValue(':name', $name, PDO::PARAM_STR);
        $stmt -> execute();
        $results = $stmt->fetch();
        $num = $stmt->rowCount();
        if($num!=0) $nickname = $results['nickname'];
        else $nickname = $name;
    endif;
    echo
    '<div align="left">ようこそ、 '.$nickname.' さん '.$page_link.'
    </div>
    <div align="right">
        <input type="submit" name="logout" value="ログアウト"><br>'.
        $dialog
    .'</div>';

    if(isset($_POST['logout_det'])):

        $_SESSION = array();
        if (isset($_COOKIE["PHPSESSID"])):
            setcookie("PHPSESSID", '', time()-1800, '/');
            session_destroy();
            header("Location: ./toppage.php");
        endif;

    endif;
    
    echo "<hr>";
    
?>
