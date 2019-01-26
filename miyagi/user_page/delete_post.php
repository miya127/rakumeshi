<?php 
session_start();
require('../dbconnect.php');

if(isset($_SESSION['id'])){
    $id=$_GET['id'];


//投稿を検査する
$posts=$db->prepare('SELECT * FROM posts WHERE id=?');
$posts->execute(array($id));
$post=$posts->fetch();

if($post['member_id']==$_SESSION['id']){
    //削除する
    $del=$db->prepare('DELETE FROM posts WHERE id=?');
    $del->execute(array($id));
   }
}

header('Location:index.php');exit();
?>