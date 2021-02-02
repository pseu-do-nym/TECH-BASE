<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_6</title>
    </head>
    <body>

                <?php

                    for($i=0;$i<3;$i++):

                        if(($disp_count < $art_count)):

                            require("./one_article.php");
                            
                        endif;
                        
                        $disp_count += 1;

                    endfor;
                    
                    echo "<div style='text-align: left; float: left;'>";
                    if($disp_count>=6) echo '<button class="btn-link" type="submit" name="trans_art" value='.($disp_count-6).'>←前の記事を表示</button>';
                    echo "</div><div style='text-align: right;'>";
                    if($disp_count<$art_count) echo '<button class="btn-link" type="submit" name="trans_art" value='.$disp_count.'>次の記事を表示→</button>';

                ?>

    </body>
</html>
