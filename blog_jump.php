<?php
    
    //ブログトップへのジャンプ
    if(isset($_POST['blog_jump'])):
    
        $name = $_SESSION['name'];
        $jumpto = $_POST['blog_jump'];
    
        $stmt = $pdo -> prepare("SELECT * FROM BLOGTITLE WHERE name=:name");
        $stmt -> bindValue(':name', $jumpto, PDO::PARAM_STR);
        $stmt -> execute();
        $results = $stmt->fetch();
        $rcount = $stmt->rowCount();
    
        if($rcount!=0):
    
            if($results['private']==True && $name!=$jumpto):
        
                $_SESSION['page'] = $jumpto;
                $_SESSION['mode'] = 'private';
                $_SESSION['cat_board'] = "";
                $_SESSION['edit_art_id'] = -1;
        
            else:
        
                $_SESSION['page'] = $jumpto;
                $_SESSION['mode'] = 'home';
                $_SESSION['cat_board'] = "";
                $_SESSION['edit_art_id'] = -1;
        
            endif;
        
            header("Location: ./mypage.php");
    
        else:
            
            echo "ブログが削除されているかリンクが間違っています。<br>";
    
        endif;
    
    endif;
    
    //個別記事へのジャンプ
    if(isset($_POST['art_jump'])):

        $name = $_SESSION['name'];
        $jumpto = $_POST['art_jump'];

        $stmt = $pdo -> prepare("SELECT * FROM ARTICLE WHERE id=:id");
        $stmt -> bindValue(':id', $jumpto, PDO::PARAM_STR);
        $stmt -> execute();
        $results = $stmt->fetch();
        $rcount = $stmt->rowCount();
    
        echo $jumpto;

        if($rcount!=0):

            if($results['private']==True && $results['name']!=$name):
        
                $_SESSION['page'] = $results['name'];
                $_SESSION['mode'] = 'private';
                $_SESSION['cat_board'] = "";
                $_SESSION['edit_art_id'] = -1;
        
            else:
        
                $_SESSION['page'] = $results['name'];
                $_SESSION['edit_art_id'] = $jumpto;
                $_SESSION['cat_board'] = "";
                $_SESSION['mode'] = 'indiv';
        
            endif;
        
            header("Location: ./mypage.php");

        else:
            
            echo "ブログが削除されているかリンクが間違っています。<br>";

        endif;

    endif;

?>
