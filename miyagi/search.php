<?php
session_start();
require('dbconnect.php');


if(isset($_SESSION['id']) && $_SESSION['time']+3600 > time()){
    //ログインしている場合
    $_SESSION['time']=time();
    
    $members=$db->prepare('SELECT * FROM members WHERE id=?');
    $members->execute(array($_SESSION['id']));
    $member=$members->fetch();
    
}



//投稿を取得する
if( !empty($_GET['search_text'])){
    $stmt = $db->prepare('SELECT * FROM posts WHERE  name  LIKE ? OR  make LIKE ? ORDER BY created_at DESC');
    $stmt->execute(array(
        '%'.$_GET['search_text'].'%',
        '%'.$_GET['search_text'].'%'        
    ));
    $posts = $stmt->fetchAll();
}elseif(isset($_GET['id'])&!empty($_GET['id'])){
    
    $stmt=$db->prepare('SELECT name FROM tags WHERE id=? ');
    $stmt->execute(array($_GET['id']));
    $tag=$stmt->fetch();
    
    $stmt=$db->prepare('SELECT * FROM tags t, posts p WHERE p.tag=t.id AND t.id=? ORDER BY p.created_at DESC');
    $stmt->execute(array($_GET['id']));
    $posts0 = $stmt->fetchAll();
    
    $stmt=$db->prepare('SELECT * FROM tags t, posts p WHERE p.tag1=t.id AND t.id=? ORDER BY p.created_at DESC');
    $stmt->execute(array($_GET['id']));
    $posts1 = $stmt->fetchAll();
    
    $stmt=$db->prepare('SELECT * FROM tags t, posts p WHERE p.tag2=t.id AND t.id=? ORDER BY p.created_at DESC');
    $stmt->execute(array($_GET['id']));
    $posts2 = $stmt->fetchAll();
    
    $stmt=$db->prepare('SELECT * FROM tags t, posts p WHERE p.tag3=t.id AND t.id=? ORDER BY p.created_at DESC');
    $stmt->execute(array($_GET['id']));
    $posts3 = $stmt->fetchAll();
    
    $stmt=$db->prepare('SELECT * FROM tags t, posts p WHERE p.tag4=t.id AND t.id=? ORDER BY p.created_at DESC');
    $stmt->execute(array($_GET['id']));
    $posts4 = $stmt->fetchAll();


}else{
    header('Location:index.php');exit();
}




function h($value){
    return htmlspecialchars($value, ENT_QUOTES);
}
?>

<!doctype html>
<html lang="ja=JP">
    <head>
        <title>楽飯</title>
        <link rel="SHORTCUT ICON" href="assets/rakumeshi_mini.png">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="@miyadesuu" /> 
<meta property="og:url" content="https://rakumeshi.net" /> 
<meta property="og:title" content="楽飯" /> 
<meta property="og:description" content="楽して美味しさを求める人々が生み出したアレンジ料理、ズボラ飯を投稿する新しいレシピサイトです" /> 
<meta property="og:image" content="https://rakumeshi.net/assets/show.png" /> 
       　　 <link rel="stylesheet" href="bootstrap.min.css" />
       　　 <link rel="stylesheet"  href="assets/common.css"/>
       　　 <link href="slick/slick-theme.css" rel="stylesheet" type="text/css">
<link href="slick/slick.css" rel="stylesheet" type="text/css">
           <style>


           </style>
    </head>
    <body class="bg-light">
        <header class="">

                
                <nav class='navbar navbar-expand fixed-top border-bottom '>
                        <div class="container">
                        <a href="index.php" class="navbar-brand p-2 mx-lg-auto mx-md-auto ml-2"><img src="assets/rakumeshi.png" class="img-responsive center-block d-none d-md-block"　alt="ホームへ戻る"><img src="assets/rakumeshi.png" class="img-responsive center-block  d-md-none d-block " width="80%" height="80%"　alt="ホームへ戻る"></a>  

                        <form action="search.php" class="navbar-form mx-auto mb-3  col-md-5 col-lg-6 d-none d-md-block " name="search" method="get" >
　　　　　　　　　　　　 <div class="input-group mb-3　 ">
                              <input type="text" style="" name="search_text" class="form-control " placeholder="キーワードで検索" aria-label="Recipient's username" aria-describedby="basic-addon2"
                              value="<?php if(isset($_GET['search_text'])){
                              echo ($_GET['search_text']);} ?>" >
                          <div class="input-group-append">
                            <button class="btn btn-dark" type="submit" value="search">検索</button>
                          </div>
                        </div>
                          </form> 
                    <ul class="navbar-nav mx-lg-auto mx-md-auto mr-0 align-items-center ">
                      <?php if(isset($member['id'])):?>
                           <a href="user_page/index.php" class="text-centert"><img src="img/<?php echo h($member['prf_picture']);?>"  class="prof bg-light img-responsive d-none d-md-block"  width="45" height="45" /><img src="img/<?php echo h($member['prf_picture']);?>"  class="prof bg-light img-responsive d-md-none d-block"  width="35" height="35" /></a>
 


                    　
                        <?php else:?>
                        <li class="navbar-item ">
                            <a href="join/login.php" class="btn btn-sm btn-outline-dark " role="button">ログイン</a>
                            <a href="join/register.php" class="btn btn-sm btn-outline-danger mr-lg-0 mr-md-0 mr-2 " role="button">新規会員登録</a>
                        </li>
                        <?php endif;?>
        
                        
                    
                </ul>
                            </div>
                </nav>


        </header>

              

        
        <main>
            <div class="container  mt-3">

                 <div class="mt-2 "> 
                 <?php if(isset($posts)):?>
                         <form action="search.php" class="navbar-form mx-auto mb-3 col-12  d-md-none d-block " name="search" method="get" >
　　　　　　　　　　　　 <div class="input-group mb-3　 ">
                              <input type="text" style="" name="search_text" class="form-control " placeholder="キーワードで検索" aria-label="Recipient's username" aria-describedby="basic-addon2"
                              value="<?php if(isset($_GET['search_text'])){
                      echo ($_GET['search_text']);}?>">
                          <div class="input-group-append">
                            <button class="btn btn-dark" type="submit" value="search">検索</button>
                          </div>
                        </div>
                          </form>
                          
                  <?php endif;?>
                       <?php if(isset($tag)):?>  
                        <a href="search.php?id=<?php  echo h($tag['id']); ?>" class="btn btn-secondary btn-sm m-1 mt-4 " role="button"><span><?php echo h($tag['name'])?></span></a>
                   <?php endif;?>
  
                          <div class="row mt-3">
                            
                            <?php if(isset($posts)):?>
                                 <?php
                                  foreach($posts as $post):
                                  ?>
                                  <div class="col-6 col-md-3 col-lg-3 card-group text-center ">                                  
                                  <section class="card  mb-3">

                                
                                   <a href="post/post_view.php?id=<?php echo h($post['id']); ?>">
                                        <figure class="view card-img-top slider">

                                          <div><img src="img/<?php echo h($post['picture']);?>" class="mw-100 mh-100 " /></div>
                                          <?php if(!empty($post['picture1'])):?>
                                          <div><img src="img/<?php echo h($post['picture1']);?> " class="mw-100 mh-100"/></div>
                                          <?php endif ;?>
                                          <?php if(!empty($post['picture2'])):?>
                                          <div><img src="img/<?php echo h($post['picture2']);?>" class="mw-100 mh-100 " /></div>
                                          <?php endif;?>
                                          <?php if(!empty($post['picture3'])):?>
                                          <div><img src="img/<?php echo h($post['picture3']);?> " class="mw-100 mh-100"/></div>     
                                          <?php endif;?>
                                       </figure>
                                       <div class="view card-body pt-0 pb-2 px-2">
                                            <label class="card-text"><?php echo h($post['name']);?></label>
                                        
                                            <hr class="mt-0 mb-1">
                                            <p class="small text-left"><?php echo h($post['make']);?></p>

                                        </div>
                                   </a>
                                     </section>
                                     </div>
                                    <?php
                                    endforeach;
                                    ?>
                                    <?php endif;?>
                                    
                                    
                           <?php if(isset($posts0)):?>
                                 <?php
                                  foreach($posts0 as $post):
                                  ?>
                                  <div class="col-6 col-md-3 col-lg-3 card-group text-center ">                                  
                                  <section class="card  mb-3">

                                
                                   <a href="post/post_view.php?id=<?php echo h($post['id']); ?>">
                                        <figure class="view card-img-top slider">

                                          <div><img src="img/<?php echo h($post['picture']);?>" class="mw-100 mh-100 " /></div>
                                          <?php if(!empty($post['picture1'])):?>
                                          <div><img src="img/<?php echo h($post['picture1']);?> " class="mw-100 mh-100"/></div>
                                          <?php endif ;?>
                                          <?php if(!empty($post['picture2'])):?>
                                          <div><img src="img/<?php echo h($post['picture2']);?>" class="mw-100 mh-100 " /></div>
                                          <?php endif;?>
                                          <?php if(!empty($post['picture3'])):?>
                                          <div><img src="img/<?php echo h($post['picture3']);?> " class="mw-100 mh-100"/></div>     
                                          <?php endif;?>
                                       </figure>
                                       <div class="view card-body pt-0 pb-2 px-2">
                                            <label class="card-text"><?php echo h($post['name']);?></label>
                                        
                                            <hr class="mt-0 mb-1">
                                            <p class="small text-left"><?php echo h($post['make']);?></p>

                                        </div>
                                   </a>
                                     </section>
                                     </div>
                                    <?php
                                    endforeach;
                                    ?>
                                    <?php endif;?>
                                  <?php if(isset($posts1)):?>  
                                  <?php
                                  foreach($posts1 as $post):
                                  ?>
                                  
                                  <div class="col-6 col-md-3 col-lg-3 card-group text-center">                                  
                                  <section class="card  mb-3">

                                
                                   <a href="post/post_view.php?id=<?php echo h($post['id']); ?>">
                                        <figure class="view card-img-top slider">

                                          <div><img src="img/<?php echo h($post['picture']);?>" class="mw-100 mh-100 " /></div>
                                          <?php if(!empty($post['picture1'])):?>
                                          <div><img src="img/<?php echo h($post['picture1']);?> " class="mw-100 mh-100"/></div>
                                          <?php endif ;?>
                                          <?php if(!empty($post['picture2'])):?>
                                          <div><img src="img/<?php echo h($post['picture2']);?>" class="mw-100 mh-100 " /></div>
                                          <?php endif;?>
                                          <?php if(!empty($post['picture3'])):?>
                                          <div><img src="img/<?php echo h($post['picture3']);?> " class="mw-100 mh-100"/></div>     
                                          <?php endif;?>
                                       </figure>
                                       <div class="view card-body pt-0 pb-2 px-2">
                                            <label class="card-text"><?php echo h($post['name']);?></label>
                                        
                                            <hr class="mt-0 mb-1">
                                            <p class="small text-left"><?php echo h($post['make']);?></p>

                                        </div>
                                   </a>
                                     </section>
                                     </div>
                                    <?php
                                    endforeach;
                                    ?>
                                    <?php endif;?>
                                    
                                    
                                <?php if(isset($posts2)):?>  
                                <?php
                                  foreach($posts2 as $post):
                                  ?>
                                  <div class="col-6 col-md-3 col-lg-3 card-group text-center ">                                  
                                  <section class="card  mb-3">

                                
                                   <a href="post/post_view.php?id=<?php echo h($post['id']); ?>">
                                        <figure class="view card-img-top slider">

                                          <div><img src="img/<?php echo h($post['picture']);?>" class="mw-100 mh-100 " /></div>
                                          <?php if(!empty($post['picture1'])):?>
                                          <div><img src="img/<?php echo h($post['picture1']);?> " class="mw-100 mh-100"/></div>
                                          <?php endif ;?>
                                          <?php if(!empty($post['picture2'])):?>
                                          <div><img src="img/<?php echo h($post['picture2']);?>" class="mw-100 mh-100 " /></div>
                                          <?php endif;?>
                                          <?php if(!empty($post['picture3'])):?>
                                          <div><img src="img/<?php echo h($post['picture3']);?> " class="mw-100 mh-100"/></div>     
                                          <?php endif;?>
                                       </figure>
                                       <div class="view card-body pt-0 pb-2 px-2">
                                            <label class="card-text"><?php echo h($post['name']);?></label>
                                        
                                            <hr class="mt-0 mb-1">
                                            <p class="small text-left"><?php echo h($post['make']);?></p>

                                        </div>
                                   </a>
                                     </section>
                                     </div>
                                    <?php
                                    endforeach;
                                    ?>
                                    <?php endif;?>
                                    
                                    <?php if(isset($posts3)):?>  
                                
                                <?php
                                  foreach($posts3 as $post):
                                  ?>
                                  <div class="col-6 col-md-3 col-lg-3 card-group text-center">                                  
                                  <section class="card  mb-3">

                                
                                   <a href="post/post_view.php?id=<?php echo h($post['id']); ?>">
                                        <figure class="view card-img-top slider">

                                          <div><img src="img/<?php echo h($post['picture']);?>" class="mw-100 mh-100 " /></div>
                                          <?php if(!empty($post['picture1'])):?>
                                          <div><img src="img/<?php echo h($post['picture1']);?> " class="mw-100 mh-100"/></div>
                                          <?php endif ;?>
                                          <?php if(!empty($post['picture2'])):?>
                                          <div><img src="img/<?php echo h($post['picture2']);?>" class="mw-100 mh-100 " /></div>
                                          <?php endif;?>
                                          <?php if(!empty($post['picture3'])):?>
                                          <div><img src="img/<?php echo h($post['picture3']);?> " class="mw-100 mh-100"/></div>     
                                          <?php endif;?>
                                       </figure>
                                       <div class="view card-body pt-0 pb-2 px-2">
                                            <label class="card-text"><?php echo h($post['name']);?></label>
                                        
                                            <hr class="mt-0 mb-1">
                                            <p class="small text-left"><?php echo h($post['make']);?></p>

                                        </div>
                                   </a>
                                     </section>
                                     </div>
                                    <?php
                                    endforeach;
                                    ?>
                                   <?php endif;?> 
                                 <?php if(isset($posts4)):?>  
                                 <?php
                                  foreach($posts4 as $post):
                                  ?>
                                  <div class="col-6 col-md-3 col-lg-3 card-group text-center">                                  
                                  <section class="card  mb-3">

                                
                                   <a href="post/post_view.php?id=<?php echo h($post['id']); ?>">
                                        <figure class="view card-img-top slider">

                                          <div><img src="img/<?php echo h($post['picture']);?>" class="mw-100 mh-100 " /></div>
                                          <?php if(!empty($post['picture1'])):?>
                                          <div><img src="img/<?php echo h($post['picture1']);?> " class="mw-100 mh-100"/></div>
                                          <?php endif ;?>
                                          <?php if(!empty($post['picture2'])):?>
                                          <div><img src="img/<?php echo h($post['picture2']);?>" class="mw-100 mh-100 " /></div>
                                          <?php endif;?>
                                          <?php if(!empty($post['picture3'])):?>
                                          <div><img src="img/<?php echo h($post['picture3']);?> " class="mw-100 mh-100"/></div>     
                                          <?php endif;?>
                                       </figure>
                                       <div class="view card-body pt-0 pb-2 px-2">
                                            <label class="card-text"><?php echo h($post['name']);?></label>
                                        
                                            <hr class="mt-0 mb-1">
                                            <p class="small text-left"><?php echo h($post['make']);?></p>

                                        </div>
                                   </a>
                                     </section>
                                     </div>
                                    <?php
                                    endforeach;
                                    ?>
                                    <?php endif;?>
                           </div>
                  </div>
                            
                            

            </div>
     
          
           
        </main>
        <footer>
                  <a href="post/post.php" class="btn fixed-bottom bp d-none d-md-inline" role="button"><span>投稿する</span></a>
                  <a href="post/post.php" class="btn fixed-bottom bpp d-md-none d-inline" role="button"><span>投稿</span></a>
        </footer></div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>
　　<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <script src="slick/slick.min.js"></script>

	
　　<script type="text/javascript">
$(function() {
 
    if($.cookie("openTag")){
        // 一旦すべての active を外す
        $('a[data-toggle="pill"]').parent().removeClass('active');
        $('a[href="#' + $.cookie("openTag") +'"]').click();
    }
 
    $('a[data-toggle="pill"]').on('show.bs.tab', function (e) {
        var tabName = e.target.href;
        var items = tabName.split("#");
        // クッキーに選択されたタブを記憶
        $.cookie("openTag",items[1], { expires: 1800 });
    });
});

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
