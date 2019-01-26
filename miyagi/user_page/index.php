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

    
    
}else{
    header('Location:../index.php');
}


//投稿を取得する
$posts=$db->prepare('SELECT m.* , p.* FROM members m,posts p WHERE m.id=p.member_id AND m.id=? ORDER BY p.created_at DESC');
    $posts->execute(array($_SESSION['id']));
    //$post=$posts->fetch();
    
    
    $saves=$db->prepare('SELECT p.* FROM posts p, saves s WHERE p.id=s.post_id AND s.user_id=? ORDER BY s.created_at DESC');
    $saves->execute(array($_SESSION['id']));
    
    $goods=$db->prepare('SELECT p.* FROM posts p, goods g WHERE p.id=g.post_id AND g.user_id=? ORDER BY g.created_at DESC');
    $goods->execute(array($_SESSION['id']));


function h($value){
    return htmlspecialchars($value, ENT_QUOTES);
}
?>

<!doctype html>
<html lang="ja=JP">
    <head>
        <title>マイページ</title>
        <link rel="SHORTCUT ICON" href="../assets/rakumeshi_mini.png">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="@miyadesuu" /> 
<meta property="og:url" content="https://rakumeshi.net/user_page/index.php" /> 
<meta property="og:title" content="楽飯" /> 
<meta property="og:description" content="楽して美味しさを求める人々が生み出したアレンジ料理、ズボラ飯を投稿する新しいレシピサイトです" /> 
<meta property="og:image" content="https://rakumeshi.net/assets/show.png" /> 
       　　 <link rel="stylesheet" href="../bootstrap.min.css" />
       　　 <link rel="stylesheet" href="../assets/user.css"/>
       　　 　 <link rel="stylesheet" href="../assets/common.css" />
       <link href="../slick/slick-theme.css" rel="stylesheet" type="text/css">
<link href="../slick/slick.css" rel="stylesheet" type="text/css">　　 

           <style>
.bp{
  display: block;
   margin: 0 10px 10px auto;
  background: #DC143C;
  color: #FFF;
  width: 120px;
  height: 120px;
  line-height: 105px;
  border-radius: 50%;
  text-align: center;
  vertical-align: middle;
  overflow: hidden;
  transition: .2s;
  border:solid;
  border: solid #255,255,225;
}

.bp:hover{
    background: #B22222;
    color:#FFF;
}

           </style>
    </head>
    <body class="bg-light">                
                <nav class='navbar navbar-expand  border-bottom fixed-top '>

                                    <div class="container">
                        <a href="../index.php" class="navbar-brand p-2 mx-lg-auto mx-md-auto ml-2"><img src="../assets/rakumeshi.png" class="img-responsive center-block d-none d-md-block"　alt="ホームへ戻る"><img src="../assets/rakumeshi.png" class="img-responsive center-block  d-md-none d-block "width="80%" height="80%"　alt="ホームへ戻る"></a>  

                        <form action="../search.php" class="navbar-form mx-auto mb-3  col-md-5 col-lg-6 d-none d-md-block " name="search" method="get" >
　　　　　　　　　　　　 <div class="input-group mb-3　 ">
                              <input type="text" style="" name="search_text" class="form-control " placeholder="キーワードで検索" aria-label="Recipient's username" aria-describedby="basic-addon2">
                          <div class="input-group-append">
                            <button class="btn btn-dark" type="submit" value="search">検索</button>
                          </div>
                        </div>
                          </form> 
                    <ul class="navbar-nav mx-lg-auto mx-md-auto mr-0 align-items-center ">
                      <?php if(isset($member['id'])):?>
                        <li class="nav_item　mr-3">
                <a href="../join/logout.php" class="btn btn-sm btn-outline-danger " role="button">ログアウト</a>
                
                <a href="../user_page/edit_account.php" class="btn btn-sm btn-outline-dark small" role="button">編集</a>
                         </li>   


                    　
                        <?php else:?>
                        <li class="navbar-item ">
                <a href="../join/login.php" class="btn btn-sm btn-outline-dark " role="button">ログイン</a>
                <a href="../join/register.php" class="btn btn-sm btn-outline-danger" role="button">新規会員登録</a>
                        </li>
                        <?php endif;?>
        
                        
                    
                </ul>
                            </div>
                </nav>
        


        </header>
        
        <main >
            <div class="container text-center mt-3">  
　　　　
                 <div class="mt-5"> 

                      <img src="../img/<?php echo h($member['prf_picture']);?>" class="prof bg-light"  width="100" height="100" />
                      <p class="small">@<?php echo h($member['user_name']); ?></p>

                      <h5 class="mb-5"><?php echo h($member['display_name']); ?></h5>


                      <ul class="nav nav-pills  justify-content-center " id="pills-tab" role="tablist ">
                          <li class="nav-item mx-4">
                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">投稿</a>
                          </li>
                          <li class="nav-item mx-4">
                            <a class="nav-link" id="pills-save-tab" data-toggle="pill" href="#pills-save" role="tab" aria-controls="pills-save" aria-selected="false">保存</a>
                          </li>
                          <li class="nav-item mx-4">
                            <a class="nav-link" id="pills-good-tab" data-toggle="pill" href="#pills-good" role="tab" aria-controls="pills-good" aria-selected="false">評価</a>
                          </li>
                        </ul>
                        <hr class="mt-0 mb-4">
            </div>
            <div class="tab-content" id="pills-tabContent">
                               <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                       <p class="mt-5 mb-3"><?php echo h($member['display_name']); ?>の投稿一覧</p>                     
                         <div class="row">       
                                 <?php
                                  foreach($posts as $post):
                                  ?>
                                  <div class="col-6 col-md-3 col-lg-3 card-group ">
                                  <section class="card  mb-3">

                                
                                   <a href="../post/post_view.php?id=<?php echo h($post['id']); ?>">
                                        <figure class="view card-img-top slider">

                                          <div><img src="../img/<?php echo h($post['picture']);?>" class="mw-100 mh-100 " /></div>
                                          <?php if(!empty($post['picture1'])):?>
                                          <div><img src="../img/<?php echo h($post['picture1']);?> " class="mw-100 mh-100"/></div>
                                          <?php endif ;?>
                                          <?php if(!empty($post['picture2'])):?>
                                          <div><img src="../img/<?php echo h($post['picture2']);?>" class="mw-100 mh-100 " /></div>
                                          <?php endif;?>
                                          <?php if(!empty($post['picture3'])):?>
                                          <div><img src="../img/<?php echo h($post['picture3']);?> " class="mw-100 mh-100"/></div>     
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
                          </div>     
                  </div>
                  <div class="tab-pane fade" id="pills-save" role="tabpanel" aria-labelledby="pills-save-tab">
                       <p class="mt-5 mb-3">保存したレシピ</p>                     
                         <div class="row">       
                            <?php if(!isset($saves)):?>
                               <p class="text-center">レシピを保存して便利に！！</p>
                            <?php else: ?>

                                 <?php
                                  foreach($saves as $save):
                                  ?>
                                  <div class="col-6 col-md-3 col-lg-3 card-group ">
                                  <section class="card  mb-3">

                                
                                   <a href="../post/post_view.php?id=<?php echo h($save['id']); ?>">
                                        <figure class="view card-img-top slider">

                                          <div><img src="../img/<?php echo h($save['picture']);?>" class="mw-100 mh-100 " /></div>
                                          <?php if(!empty($save['picture1'])):?>
                                          <div><img src="../img/<?php echo h($post['picture1']);?> " class="mw-100 mh-100"/></div>
                                          <?php endif ;?>
                                          <?php if(!empty($save['picture2'])):?>
                                          <div><img src="../img/<?php echo h($save['picture2']);?>" class="mw-100 mh-100 " /></div>
                                          <?php endif;?>
                                          <?php if(!empty($save['picture3'])):?>
                                          <div><img src="../img/<?php echo h($save['picture3']);?> " class="mw-100 mh-100"/></div>     
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
                </div>
                  <div class="tab-pane fade" id="pills-good" role="tabpanel" aria-labelledby="pills-good-tab">
                                         
                       <p class="mt-5 mb-3">評価したレシピ</p>                     
                         <div class="row">       
                            <?php if(!isset($goods)):?>
                               <p class="text-center">美味しかった料理を評価しよう！！</p>
                            <?php else: ?>

                                 <?php
                                  foreach($goods as $good):
                                  ?>
                                  <div class="col-6 col-md-3 col-lg-3 card-group ">
                                  <section class="card  mb-3">

                                
                                   <a href="../post/post_view.php?id=<?php echo h($good['id']); ?>">
                                        <figure class="view card-img-top slider">

                                          <div><img src="../img/<?php echo h($good['picture']);?>" class="mw-100 mh-100 " /></div>
                                          <?php if(!empty($good['picture1'])):?>
                                          <div><img src="../img/<?php echo h($good['picture1']);?> " class="mw-100 mh-100"/></div>
                                          <?php endif ;?>
                                          <?php if(!empty($good['picture2'])):?>
                                          <div><img src="../img/<?php echo h($good['picture2']);?>" class="mw-100 mh-100 " /></div>
                                          <?php endif;?>
                                          <?php if(!empty($good['picture3'])):?>
                                          <div><img src="../img/<?php echo h($good['picture3']);?> " class="mw-100 mh-100"/></div>     
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
                  </div>
            </div>
            

          
           
        </main>
        <footer>
                  <a href="../post/post.php" class="btn fixed-bottom bp d-none d-md-inline" role="button"><span>投稿する</span></a>
                  <a href="../post/post.php" class="btn fixed-bottom bpp d-md-none d-inline" role="button"><span>投稿</span></a>
        </footer>
        </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>
　　<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
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

</script>        
    </body>
        
    </html>
