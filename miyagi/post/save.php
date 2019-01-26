<?php
session_start();
require('../dbconnect.php');


// カウントアップ処理

if(isset($_SESSION['id'])){  
   
   //id別いいね数の取得
   $goods=$db->prepare('SELECT COUNT(*) as cnt FROM saves WHERE post_id=?');
    $goods->execute(array(
       $_GET['file']));
    $good=$goods->fetch();
    $god=$good['cnt'];
   




   
   //いいねをDBに入れる
   if (isset($_GET['file']) && isset($_GET['count']) && $_GET['count']>$god) {
    
    $goods=$db->prepare('INSERT INTO saves SET user_id=? ,post_id=?,created_at=NOW()');
    $goods->execute(array(
        $_SESSION['id'],
        $_GET['file']
        ));
      

      echo 'success';
   }elseif(isset($_GET['count']) && $_GET['count']<$god){
       
       $d_goods=$db->prepare('DELETE FROM saves where  user_id=? AND post_id=?');
       $d_goods->execute(array(
           $_SESSION['id'],
           $_GET['file']));
           echo 'delete';
   }
   
}  


?>