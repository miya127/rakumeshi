<?php
session_start();
require('dbconnect.php');


if(isset($_SESSION['id']) && $_SESSION['time']+3600 > time()){
    //ログインしている場合
    $_SESSION['time']=time();
    
    $members=$db->prepare('SELECT * FROM members WHERE id=?');
    $members->execute(array($_SESSION['id']));
    $member=$members->fetch();
    
    $posts=$db->prepare('SELECT m.* , p.* FROM members m,posts p WHERE m.id=p.member_id AND m.id=? ORDER BY p.created_at DESC');
     $posts->execute(array($_SESSION['id']));
    //exit;
    

}

//投稿を取得する

    $news=$db->query('SELECT * FROM posts ORDER BY created_at DESC');


     $rnks=$db->query('SELECT * FROM posts ORDER BY goods DESC');
 $tags=$db->query('SELECT * FROM tags ORDER BY id ASC');


if(isset($_SESSION['id'])){
    $saves=$db->prepare('SELECT p.* FROM posts p, saves s WHERE p.id=s.post_id AND s.user_id=? ORDER BY s.created_at DESC');
    $saves->execute(array($_SESSION['id']));
    
    $goods=$db->prepare('SELECT p.* FROM posts p, goods g WHERE p.id=g.post_id AND g.user_id=? ORDER BY g.created_at DESC');
    $goods->execute(array($_SESSION['id']));

}







function h($value){
    return htmlspecialchars($value, ENT_QUOTES);
}
?>

<!doctype html>
<html lang="ja=JP">
    <head>
        <title>楽飯</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="@miyadesuu" /> 
<meta property="og:url" content="https://rakumeshi.net" /> 
<meta property="og:title" content="楽飯" /> 
<meta property="og:description" content="楽して美味しさを求める人々が生み出したアレンジ料理、ズボラ飯を投稿する新しいレシピサイトです" /> 
<meta property="og:image" content="https://rakumeshi.net/assets/show.png" /> 
        <link rel="SHORTCUT ICON" href="assets/rakumeshi_mini.png">
        <link rel="stylesheet" media="(min-width: 480px)" href="assets/style-480.css">
       　　 <link rel="stylesheet" href="bootstrap.min.css" />
       　　 <link rel="stylesheet"  href="assets/common.css"/>
       　　 <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<link href="slick/slick-theme.css" rel="stylesheet" type="text/css">
<link href="slick/slick.css" rel="stylesheet" type="text/css">
           <style>
          


           </style>
    </head>
    <body class="bg-light">

                <nav class='navbar navbar-expand fixed-top border-bottom '>
                        <div class="container">
                        <a href="index.php" class="navbar-brand p-2 mx-lg-auto mx-md-auto ml-2"><img src="assets/rakumeshi.png" class="img-responsive center-block d-none d-md-block"　alt="ホームへ戻る"><img src="assets/rakumeshi.png" class="img-responsive center-block  d-md-none d-block " width="80%" height="80%"　alt="ホームへ戻る"></a>  

                        <form action="search.php" class="navbar-form mx-auto mb-3  col-md-5 col-lg-6 d-none d-md-block " name="search" method="get" >
　　　　　　　　　　　　 <div class="input-group mb-3　 ">
                              <input type="text" style="" name="search_text" class="form-control " placeholder="キーワードで検索" aria-label="Recipient's username" aria-describedby="basic-addon2">
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



        
        <main >
      <?php if(!isset($_SESSION['id'])):?>
         <div class="jumbotron ">
           <div class=" bg">
               <div class="container con ">

                   <h5 class="font-weight-bold text-white title">主婦のためのレシピサイトはもう終わり<br>これからは、ズボラ飯<br></h5>
                   <p class="mt-4 small text-white tell col-12">楽飯とは、楽して美味しさを求める人々が生み出したアレンジ料理、ズボラ飯を投稿する新しいレシピサイトである。</p>
                   <a href="what.php" class="small cp_link text-white">楽飯についてもっと詳しく→</a>


               </div>
                          


           </div>
           </div>
        <?php endif;?>  


            <div class=" container text-center mt-3">
              <ul class="nav nav-pills  justify-content-center d-flex flex-nowrap" id="pills-tab" role="tablist ">
                  <li class="nav-item mx-lg-4 mx-md-4 mx-auto">
                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true"><img src="assets/house.png" class="img-responsive center-block "　alt="ランキング"><span class="d-none d-md-inline">　ホーム</span></a>
                  </li>
                  <li class="nav-item mx-lg-4 mx-md-4 mx-auto">
                    <a class="nav-link" id="pills-ranking-tab" data-toggle="pill" href="#pills-ranking" role="tab" aria-controls="pills-ranking" aria-selected="false"><img src="assets/trophy.png" class="img-responsive center-block "　alt="ランキング"><span class="d-none d-md-inline">　人気</span></a>
                  </li>
                  <li class="nav-item mx-lg-4 mx-md-4 mx-auto">
                    <a class="nav-link" id="pills-search-tab" data-toggle="pill" href="#pills-search" role="tab" aria-controls="search-contact" aria-selected="false"><img src="assets/search.png" class="img-responsive center-block"　alt="検索"><span class="d-none d-md-inline">　検索</span></a>
                  </li>
                  <li class="nav-item mx-lg-4 mx-md-4 mx-auto">
                    <a class="nav-link" id="pills-my-tab" data-toggle="pill" href="#pills-my" role="tab" aria-controls="pills-my" aria-selected="false"><img src="assets/avatar.png" class="img-responsive center-block "　alt="ランキング"><span class="d-none d-md-inline">　ライブラリ</span></a>
                  </li>
                </ul>
                <hr class="mt-0 mb-4">
                
                <div class="tab-content" id="pills-tabContent">
                    
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                       <p class="mt-5 mb-3">新着</p>                     
                                 <div class="row">       
                                 <?php
                                  foreach($news as $new):
                                  ?>
                                  <div class="col-6 col-md-3 col-lg-3 card-group ">
                                  <section class="card  mb-3">

                                
                                   <a href="post/post_view.php?id=<?php echo h($new['id']); ?>">
                                        <figure class="view card-img-top slider">

                                          <div><img src="img/<?php echo h($new['picture']);?>" class="mw-100 mh-100 " /></div>
                                          <?php if(!empty($new['picture1'])):?>
                                          <div><img src="img/<?php echo h($new['picture1']);?> " class="mw-100 mh-100"/></div>
                                          <?php endif ;?>
                                          <?php if(!empty($new['picture2'])):?>
                                          <div><img src="img/<?php echo h($new['picture2']);?>" class="mw-100 mh-100 " /></div>
                                          <?php endif;?>
                                          <?php if(!empty($new['picture3'])):?>
                                          <div><img src="img/<?php echo h($new['picture3']);?> " class="mw-100 mh-100"/></div>     
                                          <?php endif;?>
                                       </figure>
                                       <div class="view card-body pt-0 pb-2 px-2">
                                            <label class="card-text"><?php echo h($new['name']);?></label>
                                        
                                            <hr class="mt-0 mb-1">
                                            <p class="small text-left"><?php echo h($new['make']);?></p>
                                     
                                        </div>
                                   </a>
                                     </section>
                                     </div>
                                    <?php
                                    endforeach;
                                    ?>
                                    </div>
                           </div>
                 
                  
                  <div class="tab-pane fade" id="pills-ranking" role="tabpanel" aria-labelledby="pills-ranking-tab"> 
                      <p class="mt-5 mb-3">ランキング</p>
                      
                              <div class="row">       
                                 <?php
                                  foreach($rnks as $rnk):
                                  ?>
                                  <div class="card-group col-6 col-md-3 col-lg-3 ">
                                  <section class="card  mb-3">

                                
                                   <a href="post/post_view.php?id=<?php echo h($rnk['id']); ?>">
                                        <figure class="view card-img-top slider">

                                          <div><img src="img/<?php echo h($rnk['picture']);?>" class="mw-100 mh-100 " /></div>
                                          <?php if(!empty($rnk['picture1'])):?>
                                          <div><img src="img/<?php echo h($rnk['picture1']);?> " class="mw-100 mh-100"/></div>
                                          <?php endif ;?>
                                          <?php if(!empty($rnk['picture2'])):?>
                                          <div><img src="img/<?php echo h($rnk['picture2']);?>" class="mw-100 mh-100 " /></div>
                                          <?php endif;?>
                                          <?php if(!empty($rnk['picture3'])):?>
                                          <div><img src="img/<?php echo h($rnk['picture3']);?> " class="mw-100 mh-100"/></div>     
                                          <?php endif;?>
                                       </figure>
                                       <div class="view card-body pt-0 pb-2 px-2">
                                            <label class="card-text"><?php echo h($rnk['name']);?></label>
                                        
                                            <hr class="mt-0 mb-1">
                                            <p class="small text-left"><?php echo h($rnk['make']);?></p>

                                        </div>
                                   </a>
                                     </section>
                                     </div>
                                    <?php
                                    endforeach;
                                    ?>
                                    </div>
                   </div>
                   <div class="tab-pane fade mb-5" id="pills-search" role="tabpanel" aria-labelledby="pills-search-tab-tab"> 
                   <div class="container">
                       <div class="row">
                        <form action="search.php" class="navbar-form mx-auto mb-3 col-12  d-md-none d-block " name="search" method="get" >
　　　　　　　　　　　　 <div class="input-group mb-3　 ">
                              <input type="text" style="" name="search_text" class="form-control " placeholder="キーワードで検索" aria-label="Recipient's username" aria-describedby="basic-addon2">
                          <div class="input-group-append">
                            <button class="btn btn-dark" type="submit" value="search">検索</button>
                          </div>
                        </div>
                          </form>
                          </div>
                    </div>
                    <hr class=" d-md-none d-block">
                    <p class="mt-5">タグで検索</p>
                  <div class="mx-auto col-lg-10 col-lg-offset-1">
                    <?php foreach($tags as $tag):?>
                    <a href="search.php?id=<?php echo h($tag['id']); ?>" class="btn btn-outline-secondary btn-sm m-1 " role="button"><span><?php echo h($tag['name'])?></span></a>
                    <?php endforeach;?>
                    </div>

                    
                   </div>
                 <div class="tab-pane fade" id="pills-my" role="tabpanel" aria-labelledby="pills-my-tab">
                 <div class="mt-5"> 
                    <ul class="nav nav-pills  justify-content-center mb-3" id="pills-tab" role="tablist ">
                          <li class="nav-item mx-4">
                            <a class="nav-link active" id="pills-save-tab" data-toggle="pill" href="#pills-save" role="tab" aria-controls="pills-save" aria-selected="false">保存</a>
                          </li>
                          <li class="nav-item mx-4">
                            <a class="nav-link" id="pills-good-tab" data-toggle="pill" href="#pills-good" role="tab" aria-controls="pills-good" aria-selected="false">評価</a>
                          </li>
                        </ul>

            <div class="tab-content" id="pills-tabContent">
                  <div class="tab-pane fade show active" id="pills-save" role="tabpanel" aria-labelledby="pills-save-tab">
                <?php if(isset($_SESSION['id'])):?>
                    <div class="row">
                         <?php if(!isset($saves)):?>
                         <div class="my-5"> 
                          <p class="text-center">レシピを保存して便利に！！</p>
                      <?php else: ?>

                                 <?php
                                  foreach($saves as $save):
                                  ?>
                                  <div class="col-6 col-md-3 col-lg-3 card-group ">
                                  <section class="card  mb-3">

                                
                                   <a href="post/post_view.php?id=<?php echo h($save['id']); ?>">
                                        <figure class="view card-img-top slider">

                                          <div><img src="img/<?php echo h($save['picture']);?>" class="mw-100 mh-100 " /></div>
                                          <?php if(!empty($save['picture1'])):?>
                                          <div><img src="img/<?php echo h($save['picture1']);?> " class="mw-100 mh-100"/></div>
                                          <?php endif ;?>
                                          <?php if(!empty($save['picture2'])):?>
                                          <div><img src="img/<?php echo h($save['picture2']);?>" class="mw-100 mh-100 " /></div>
                                          <?php endif;?>
                                          <?php if(!empty($save['picture3'])):?>
                                          <div><img src="img/<?php echo h($save['picture3']);?> " class="mw-100 mh-100"/></div>     
                                          <?php endif;?>
                                       </figure>
                                       <div class="view card-body pt-0 pb-2 px-2">
                                            <label class="card-text"><?php echo h($save['name']);?></label>
                                        
                                            <hr class="mt-0 mb-1">
                                            <p class="small text-left"><?php echo h($save['make']);?></p>

                                        </div>
                                   </a>
                                     </section>
                                     </div>
                                    <?php
                                    endforeach;
                                    ?>

                            <?php endif;?>
                                    </div>
                        <?php else:?>
                          <div class="my-5"> 
                          <p>楽メンになってもっと使いやすく！</p>

                              <a href="join/register.php" class="btn btn-outline-danger pr-4 pl-4" role="button">新規会員登録</a>
                              <a href="join/login.php"  class="btn btn-outline-dark pr-5 pl-5 my-4" role="button" >ログイン</a>
                        </div>
                  <?php endif;?>
                  </div> 
                  <div class="tab-pane fade" id="pills-good" role="tabpanel" aria-labelledby="pills-good-tab">
                    <?php if(isset($_SESSION['id'])):?>
             
                    <div class="row">  
                    
                         <?php if(!isset($goods)) :?>
                         <div class="my-5"> 
                          <p class="text-center">美味しかった料理を評価しよう！！</p>
                      <?php else: ?>
                                 

                                <?php
                                  foreach($goods as $good):
                                  ?>
                                  <div class="col-6 col-md-3 col-lg-3 card-group ">
                                  <section class="card  mb-3">

                                
                                   <a href="post/post_view.php?id=<?php echo h($good['id']); ?>">
                                        <figure class="view card-img-top slider">

                                          <div><img src="img/<?php echo h($good['picture']);?>" class="mw-100 mh-100 " /></div>
                                          <?php if(!empty($good['picture1'])):?>
                                          <div><img src="img/<?php echo h($good['picture1']);?> " class="mw-100 mh-100"/></div>
                                          <?php endif ;?>
                                          <?php if(!empty($good['picture2'])):?>
                                          <div><img src="img/<?php echo h($good['picture2']);?>" class="mw-100 mh-100 " /></div>
                                          <?php endif;?>
                                          <?php if(!empty($good['picture3'])):?>
                                          <div><img src="img/<?php echo h($good['picture3']);?> " class="mw-100 mh-100"/></div>     
                                          <?php endif;?>
                                       </figure>
                                       <div class="view card-body pt-0 pb-2 px-2">
                                            <label class="card-text"><?php echo h($good['name']);?></label>
                                        
                                            <hr class="mt-0 mb-1">
                                            <p class="small text-left"><?php echo h($good['make']);?></p>

                                        </div>
                                   </a>
                                     </section>
                                     </div>
                                    <?php
                                    endforeach;
                                    ?>
                            <?php endif;?>
                                    </div>
                   
                  <?php else:?>
                          <div class="my-5"> 
                          <p>楽メンになってもっと使いやすく！</p>

                              <a href="join/register.php" class="btn btn-outline-danger pr-4 pl-4" role="button">新規会員登録</a>
                              <a href="join/login.php"  class="btn btn-outline-dark pr-5 pl-5 my-4" role="button" >ログイン</a>
                        </div>
                  <?php endif;?>
                  </div>
            </div>

               

       



                  
                   </div>
                   
                 </div>           
                            
               
            </div>
        </div>
              <a href="post/post.php" class="btn fixed-bottom bp d-none d-md-inline" role="button"><span>投稿する</span></a>
                  <a href="post/post.php" class="btn fixed-bottom bpp d-md-none d-inline" role="button"><span>投稿</span></a>
           
        </main>
        <footer class="">  
        <hr>
<ul class="list-inline text-center mt-5 ">
  <li class="list-inline-item "><a href="right/terms.php" class="small">利用規約</a></li>
  <li class="list-inline-item mx-4"><a href="right/policy.php" class="small">プライバシーポリシー</a></li>
  <li class="list-inline-item "><a href="right/contact.php" class="small">お問い合わせ</a></li>

</ul>
<p class="text-center small">&copy; <?php
$fromYear = 2018;
$thisYear = (int)date('Y');
echo $fromYear . (($fromYear != $thisYear) ? '-' . $thisYear : '');?> rakumeshi.net.</p>
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
