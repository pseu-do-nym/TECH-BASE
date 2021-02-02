<?php
    
    echo $blog_fav_disp;
    
    $stmt = $pdo -> prepare("SELECT * FROM BLOGTITLE WHERE name=:name");
    $stmt -> bindValue(':name', $page, PDO::PARAM_STR);
    $stmt -> execute();
    $results = $stmt->fetch();
    
    echo "<table border='0' width='200px' bgcolor='white'>"
        ."<tr>"
            ."<td colspan='2'>ブログ主：</td>"
        ."</tr>"
        ."<tr>"
            ."<td rowspan='2'><img src='".$results['prof_img']."' style=width:64px; height:64px;></td>"
            ."<td>".$results['nickname']."</td>"
        ."</tr>"
        ."<tr>"
            ."<td><i><font color='grey'>".$results['profile']."</font></i></td>"
        ."</tr>"
        ."</table>";
    
    //echo "🏠 最近の更新<br>";
    //お気に入り一覧の表示
    
    if($fav_count!=0):
    
        echo "📖 お気に入りリンク<br>";
        for($i=0;$i<$fav_count;$i++):
        
            $stmt = $pdo -> prepare("SELECT * FROM BLOGTITLE WHERE name=:name");
            $stmt -> bindValue(':name', $fav_list[$i]['fav_name'], PDO::PARAM_STR);
            $stmt -> execute();
            $title_view = $stmt->fetch();
        
            echo "<button class='btn-link' type='submit' name='blog_jump' value='".$title_view['name']."'>・".$title_view['blogtitle']."</button><br>";
        
        endfor;
    
    endif;
?>
