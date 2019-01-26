<?php
session_start();
require('../dbconnect.php');

if(isset($_SESSION['id']) && $_SESSION['time']+3600 > time()){
    //ログインしている場合
    $_SESSION['time']=time();
    $members=$db->prepare('SELECT * FROM members WHERE id=?');
    $members->execute(array($_SESSION['id']));
    $member=$members->fetch();

//会員情報、投稿を取得する    

    
    
}
if(empty($_GET['id'])){
    header('Location:../index.php');exit();
}
//投稿を取得する
$posts=$db->prepare('SELECT m.display_name, m.prf_picture, p.*  FROM members m, posts p WHERE m.id=p.member_id AND p.id=?  ');
$posts->execute(array($_GET['id']));


$tags=$db->prepare('SELECT p.*, t.* FROM tags t, posts p WHERE p.tag=t.id AND p.id=?');
$tags->execute(array($_GET['id']));
$tag=$tags->fetch();

$tags=$db->prepare('SELECT p.*, t.* FROM tags t, posts p WHERE p.tag1=t.id AND p.id=?');
$tags->execute(array($_GET['id']));
$tag1=$tags->fetch();

$tags=$db->prepare('SELECT p.*, t.* FROM tags t, posts p WHERE p.tag2=t.id AND p.id=?');
$tags->execute(array($_GET['id']));
$tag2=$tags->fetch();

$tags=$db->prepare('SELECT p.*, t.* FROM tags t, posts p WHERE p.tag3=t.id AND p.id=?');
$tags->execute(array($_GET['id']));
$tag3=$tags->fetch();

$tags=$db->prepare('SELECT p.*, t.* FROM tags t, posts p WHERE p.tag4=t.id AND p.id=?');
$tags->execute(array($_GET['id']));
$tag4=$tags->fetch();


//いいねの数の取得
    $goods=$db->prepare('SELECT COUNT(*) as cnt FROM goods WHERE post_id=?');
    $goods->execute(array(
       $_GET['id']));
    $good=$goods->fetch();
    $god=$good['cnt'];



//ログインしてるときない時の動きを変えるためのSQL
if(isset($_GET['id'])&& isset($_SESSION['id'])){
$btns=$db->prepare('SELECT COUNT(*) as cnt FROM goods  WHERE user_id=? AND post_id=?');
$btns->execute(array(
    $_SESSION['id'],
    $_GET['id']));
$btn=$btns->fetch();
$bt=$btn['cnt'];
}

  
  if(isset($_GET['id'])&& isset($_SESSION['id'])){
$saves=$db->prepare('SELECT COUNT(*) as cnt FROM saves  WHERE user_id=? AND post_id=?');
$saves->execute(array(
    $_SESSION['id'],
    $_GET['id']));
$save=$saves->fetch();
$save=$save['cnt'];
}



function h($value){
    return htmlspecialchars($value, ENT_QUOTES);
}



?>

<!doctype html>
<html lang="ja=JP">
    <head>
        <title>レシピ</title>
                <meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="@miyadesuu" /> 
<meta property="og:url" content="https://rakumeshi.net/post/post_view.php?id=<?php $_GET['id']; ?>" /> 
<meta property="og:title" content="楽飯" /> 
<meta property="og:description" content="楽して美味しさを求める人々が生み出したアレンジ料理、ズボラ飯を投稿する新しいレシピサイトです" /> 
<meta property="og:image" content="https://rakumeshi.net/assets/show.png" /> 

        <link rel="SHORTCUT ICON" href="../assets/rakumeshi_mini.png">

   
       　　 <link rel="stylesheet" href="../bootstrap.min.css" />
       　　 <link rel="stylesheet"  href="../assets/common.css"/>
       　　  <link rel="stylesheet"  href="../assets/good.css"/>
<link href="../slick/slick-theme.css" rel="stylesheet" type="text/css">
<link href="../slick/slick.css" rel="stylesheet" type="text/css">
       　
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
        　     　　 
           <style>


           </style>







    </head>
    
    
    
<body class=" bg-light">
    

<header >
                     
                <nav class='navbar navbar-expand fixed-top border-bottom  '>
                     <?php 
        if($post=$posts->fetch()):
        ?> 
                        <div class="container">
                        <a href="../index.php" class="navbar-brand p-2 mx-lg-auto mx-md-auto ml-2"><img src="../assets/rakumeshi.png" class="img-responsive center-block d-none d-md-block"　alt="ホームへ戻る"><img src="../assets/rakumeshi.png" class="img-responsive center-block  d-md-none d-block "width="80%" height="80%"　alt="ホームへ戻る"></a>  

                        <form action="../search.php" class="navbar-form mx-auto mb-3  col-md-5 col-lg-6 d-none d-md-block " name="search" method="get" >
　　　　　　　　　　　　 <div class="input-group mb-3　 ">
                              <input type="text" style="" name="search_text" class="form-control " placeholder="キーワードで検索" aria-label="Recipient's username" aria-describedby="basic-addon2">
                          <div class="input-group-append">
                            <button class="btn btn-secondary" type="submit" value="search">検索</button>
                          </div>
                        </div>
                          </form> 
                    <ul class="navbar-nav mx-lg-auto mx-md-auto mr-0 align-items-center ">
                      <?php if(isset($member['id'])):?>
                           <a href="../user_page/index.php" class="text-centert"><img src="../img/<?php echo h($member['prf_picture']);?>"  class="prof bg-light img-responsive d-none d-md-block"  width="45" height="45" /><img src="../img/<?php echo h($member['prf_picture']);?>"  class="prof bg-light img-responsive d-md-none d-block"  width="35" height="35" /></a>
 


                    　
                        <?php else:?>
                        <li class="navbar-item ">
                            <a href="../join/login.php" class="btn btn-sm btn-outline-dark " role="button">ログイン</a>
                            <a href="../join/register.php" class="btn btn-sm btn-outline-danger mr-lg-0 mr-md-0 mr-2 " role="button">新規会員登録</a>
                        </li>
                        <?php endif;?>
        
                        
                    
                </ul>
                            </div>
                </nav>

</header>
       <main>

           

              

              
                <div class="container mt-3 bg-white">
                 
                      <ul class="list-inline list-unstyled pt-3 mb-0">

                          <li class="list-inline-item">
                   　<?php if(isset($_SESSION['id']) && $post['member_id']==$_SESSION['id']):?>
                   　<a href="../user_page/index.php"><img src="../img/<?php echo h($post['prf_picture']);?>"  class="prof bg-light img-responsive"  width="50" height="50" /></a>
                     <?php else:?>
                     <a href="../user_page/user_page.php?id=<?php echo h($post['id']);?>"><img src="../img/<?php echo h($post['prf_picture']);?>"  class="prof bg-light img-responsive"  width="50" height="50" /></a>
                     <?php endif;?>                              
                          </li>
                        <li class="list-inline-item">
                              <p class=" mb-0"><?php echo h($post['display_name']); ?></p>
                          </li>
                   　<hr class="my-2">
                      </ul>


              
               <div class="row mx-auto ">

                   
                   <div class="col-12 col-md-12 col-lg-6  mb-3">

                     
                                <div class="form-group form-center mt-3 mb-4 col-md-10 col-lg-10">

                                        <h5><?php if(isset($post['name'])){
                                        echo h($post['name']); 
                                        }?></h4>
                                 <div class="text-center slider p_view">
                                       
                                        
                                  
                                          <div ><img src="../img/<?php echo h($post['picture']);?>" class="mw-100 mh-100 " /></div>
                                          <?php if(!empty($post['picture1'])):?>
                                          <div><img src="../img/<?php echo h($post['picture1']);?> " class="mw-100 mh-100"/></div>
                                          <?php endif ;?>
                                          <?php if(!empty($post['picture2'])):?>
                                          <div><img src="../img/<?php echo h($post['picture2']);?>" class="mw-100 mh-100 " /></div>
                                          <?php endif;?>
                                          <?php if(!empty($post['picture3'])):?>
                                          <div><img src="../img/<?php echo h($post['picture3']);?> " class="mw-100 mh-100"/></div>     
                                          <?php endif;?>

                            
                                 </div>
                                 
                                 
                                 <div class="">
                               <label class="mt-3 align-middle list-inline-item icon_good <?php echo h($post['id']); ?>"><?php if(isset($god) && is_numeric($god)){echo ($god);}else{echo 0;} ?></label>
                                 
                              <ul class="list-inline float-right">
                                <?php if(isset($_SESSION['id'])):?>
                                 
                                 <li class="mx-0 align-middle list-inline-item <?php if(isset($bt) && $bt>0){
                                 echo('btn_vote on');}else{ echo 'btn_vote';} ?>" id="<?php echo h($post['id']); ?>"></li>
                                <li class="align-middle list-inline-item <?php if(isset($save) && $save>0){
                                 echo('btn_save on');}else{ echo 'btn_save';} ?>" id="<?php echo h($post['id']); ?>"></li>                                
                                

                                 <?php else :?>
                                
                                
                                 <a href="../join/login.php" class="mx-auto btn_vote align-middle list-inline-item" role="button"></a>   
                                <a href="../join/login.php" class="btn_save align-middle list-inline-item" role="button "></a>                                                                                          
                                 <?php endif ;?>
                                

                               
                             </ul>

                                 </div>
                                 <div class="mt-3">
                                 <ul class="list-unstyled">
                                     <li>時間 : <?php if(isset($post['cooking_time'])){
                                        echo h($post['cooking_time']); 
                                        }?> 分</li>
                                     <li>費用 : <?php if(isset($post['cost'])){
                                        echo h($post['cost']); 
                                        }?> 円</li>
                                 </ul>
                       
                          
                                 </div>
                          </div>       
                                 
                   </div>
                    <div class="col-12 col-md-12 col-lg-6  mb-3">
                       
                                <div class="form-group form-center my-4 col-md-10 col-lg-10">
                                    <label>材料</label>
                                        <p class="card card-body p-2"><?php if(isset($post['ingredients'])){
                                        echo h($post['ingredients']); 
                                        }?></p>
                                        
                                    <label>作り方 / コメント</label>
                                        <p class="card card-body p-2"><?php if(isset($post['make'])){
                                        echo h($post['make']); 
                                        }?></p>


                                   <div class=" mb-3" >

<?php if(!empty($tag)):?>

    <a href="../search.php?id=<?php echo h($tag['id']); ?>" class="btn btn-outline-secondary btn-sm m-1 " role="button"><span><?php echo h($tag['name'])?></span></a>
  
 <?php endif;?>
 <?php if(!empty($tag1)):?>

<a href="../search.php?id=<?php echo h($tag1['id']); ?>" class="btn btn-outline-secondary btn-sm m-1 " role="button"><span><?php echo h($tag1['name'])?></span></a>
  <?php endif;?>
  <?php if(!empty($tag2)):?>
   
<a href="../search.php?id=<?php echo h($tag2['id']); ?>" class="btn btn-outline-secondary btn-sm m-1 " role="button"><span><?php echo h($tag2['name'])?></span></a>
  
  <?php endif;?>
  <?php if(!empty($tag3)):?>
    
<a href="../search.php?id=<?php echo h($tag3['id']); ?>" class="btn btn-outline-secondary btn-sm m-1 " role="button"><span><?php echo h($tag3['name'])?></span></a>
 
  <?php endif;?>
  <?php if(!empty($tag4)):?>

<a href="../search.php?id=<?php echo h($tag4['id']); ?>" class="btn btn-outline-secondary btn-sm m-1 " role="button"><span><?php echo h($tag4['name'])?></span></a>

  <?php endif;?>

</div>
                                </div>

                        <?php if(isset($_SESSION['id']) && $post['member_id']==$_SESSION['id']):?>
                             <div class="text-center ">
                                 <a href="../user_page/edit_post.php?id=<?php 
                                   echo h($post['id']); ?>" class="btn btn-outline-info col-sm-8 col-md-8 col-lg-8  pr-4 pl-4 mt-3" role="button">編集する</a>
                        
                              
                          </div>
                          <div class="text-center ">
                              <a href="../user_page/delete_post.php?id=<?php 
                                   echo h($post['id']); ?>" class="btn btn-outline-danger col-sm-8 col-md-8 col-lg-8  pr-4 pl-4  mt-3 mb-4" role="button">削除する</a><br>
                              
              
                          </div>
                        <?php endif;?>
           
                             

                            

                                
                   </div>
                   
                </div>
           </form>
      </div>
        <?php
       endif;
       ?>
       </main>
     
       <fotter>
          

       </fotter>
   </div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> 
<script type="text/javascript" src="../assets/good.js"></script>
<script type="text/javascript" src="../assets/save.js"></script>
    <script src="../slick/slick.min.js"></script>

	
　　<script type="text/javascript">


$(function(){

$('.slider').slick({
  variableWidth: true,
  slidesToShow: 1,
  centerMode: true,
  arrows: true,
  variableWidth: true,

   
});
  
});
</script>
</body>
</html>