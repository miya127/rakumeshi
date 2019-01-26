<?php
session_start();
require('dbconnect.php');


?>

<!doctype html>
<html lang="ja=JP">
    <head>
        <title>楽飯とは</title>
        <link rel="SHORTCUT ICON" href="assets/rakumeshi_mini.png">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="@miyadesuu" /> 
<meta property="og:url" content="https://rakumeshi.net/what.php" /> 
<meta property="og:title" content="楽飯" /> 
<meta property="og:description" content="楽して美味しさを求める人々が生み出したアレンジ料理、ズボラ飯を投稿する新しいレシピサイトです" /> 
<meta property="og:image" content="https://rakumeshi.net/assets/show.png" /> 
       　　 <link rel="stylesheet" href="bootstrap.min.css" />
       　　 <link rel="stylesheet"  href="assets/common.css"/>
       　　 <link href="slick/slick-theme.css" rel="stylesheet" type="text/css">
<link href="slick/slick.css" rel="stylesheet" type="text/css">
           <style>
.under {
  border-bottom: dotted 2px #DC143C;
  }

           </style>
    </head>
    <body class="">
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
                <div class="row ">
                    <div class="col-lg-11 mx-auto">
　　　　　　　<h5 class="mb-0 "><span class="under">楽飯とは</span></h5>
　　　　　　　<p class="small mb-5">ズボラ飯専用レシピ投稿サイトです。<br>
近年は、独り身の人も増えていますが<br>主婦向けのレシピサイトは正直ハードルが高いし、<br>既製品を使ってパパッと作りたい。
<br>ということでそんな人たちにぴったりのレシピサイトを作りました！<br>各々が考え出したズボラ飯、一手間加えるだけのアレンジ飯などを投稿し自己流レシピを共有しませんか？
</p>
<h6>ー 作成経緯 ー</h6>
<p class="small">は、面倒だったからです。<br>私は一人暮らしなのですが、面倒臭がりなので自炊はほとんどしません。<br>コンビニは私の冷蔵庫だと思っています。<br>ですが、美味しいコンビニでも飽きるのです。
<br>そんな中幸いなことにTwitterで簡単なレシピを見つけました。その後、いざ作ろうと思ったら投稿が見つからない。<br>次第に探すのも面倒になり、このサイトを作ったのです。<br>

<p class="small pt-4">このサイトに関するご意見や感想などありましたら<br>
下記までお気軽にご連絡ください！</p>

</p>
<label class="small"><u>CONTACT</u></label>
<p class="small">Eメールアドレス：<a href="mailto:rakumeshi2018.gmail.com?subject=お問い合わせ">rakumeshi2018@gmail.com</a><br>

  </p>

            <div class="text-center mt-5">
             
            </div>     
                                        
</div>
            </div>
     
          
           
        </main>
        <footer>
<hr class="mt-5 ">
<ul class="list-inline text-center mt-4">
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

</script>        
    </body>
        
    </html>
