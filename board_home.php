<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_6</title>
    </head>
    <body>

        <form action="" method="post" accept-charset="UTF-8">

            <div class="main"  style='background-color: silver;
                background-image: linear-gradient(335deg, #b4745c 23px, transparent 23px),
                linear-gradient(155deg, #d08e71 23px, transparent 23px),
                linear-gradient(335deg, #b4745c 23px, transparent 23px),
                linear-gradient(155deg, #d08e71 23px, transparent 23px);
                background-size: 58px 58px;
                background-position: 0px 2px, 4px 35px, 29px 31px, 34px 6px;'>
                <!-- ここはsessionを使ってログイン状態限定のアクセスにする -->
                <div align="center">
                                
                    <br>
                    <table align="center" border='0' bgcolor='#dddddd' style='width:85vw;'>

                        <tr>
                            <td align='center'><font size='6'>— 掲示板 —</font></td>
                        </tr>

                        <tr>
                            <td align='center'>ブログジャンル間で自由に交流できる掲示板です。</td>
                        </tr>
                                
                        <tr>
                            <td><br></td>
                        </tr>
                                
                        <tr><td>
                            <table align="center" border='1' style='width:70vw; table-layout: fixed;'>
                                    
                                    <?php
                                    
                                        require("./blog_category.php");
                                        
                                        for($i=1;$i<=4*(ceil((count($cat_list))/4));$i++):
                                    
                                            if($i%4==1) echo '<tr>';
                                            if($i<count($cat_list)) echo "<td align='left'><button class='btn-link' type='submit' name='cat_board' value='".$cat_list[$i]."'>・".$cat_list[$i]."</button></td>";
                                            if($i%4==0) echo '</tr>';
                                    
                                        endfor;
                                    
                                    ?>
                                
                            </table>
                        </td></tr>
                        
                        <tr>
                            <td><br></td>
                        </tr>
                                
                        <tr>
                            <td><div align="center"><button type="submit" class="btn-link" name="link_toppage">トップに戻る</div></td>
                        </tr>
                                
                        <tr>
                            <td><br></td>
                        </tr>

                    </table>
                                
                    <br>

            </div>
                            
        </form>

    </body>
</html>
