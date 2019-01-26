<?php 
require('../dbconnect.php');

session_start();
//送られてきた中身があるとき

if(!empty($_POST)){
    
    
    
    //ログインの処理
    if($_POST['email']!='' && $_POST['password'] != ''){
        $login=$db->prepare('SELECT * FROM members WHERE email=? AND password=?');
        $login->execute(array(
            $_POST['email'],
            sha1($_POST['password'])
            ));
        $member=$login->fetch();
        
        if($member){
            //ログイン成功
            $_SESSION['id']=$member['id'];
            $_SESSION['time']=time();
            
            //ログイン情報を記録する
            if($_POST['save']=='on'){
                setcookie('email',$_POST['email'], time()+60*60*24*14);
                setcookie('password',$_POST['password'],time()+60*60*24*14);
            }
            
            header('Location:../post/post.php');exit();
        }else{
            $error['login']='failed';
        }
    }else{
       $error['login']='blank';
    }
}

    
//htmlspecialcharsのショートカット
 function h($value){
     return htmlspecialchars($value,ENT_QUOTES);
 }
?>
     
<!doctype html>
<html lang="ja=JP">
    <head>
        <title>ログイン</title>
        <link rel="SHORTCUT ICON" href="../assets/rakumeshi_mini.png">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="@miyadesuu" /> 
<meta property="og:url" content="https://https://rakumeshi.net/join/login_post.php" /> 
<meta property="og:title" content="楽飯" /> 
<meta property="og:description" content="楽して美味しさを求める人々が生み出したアレンジ料理、ズボラ飯を投稿する新しいレシピサイトです" /> 
<meta property="og:image" content="https://rakumeshi.net/assets/show.png" /> 
       　　 <link rel="stylesheet" href="../bootstrap.min.css" />
           <style>
             .form-center{
                 margin:auto;
             }
             a{
                 color:black;
             }
           </style>
    </head>
    <body>
        <div class="container">
        <header>
            <div class="text-center">
                <a href="../index.php"><img src="../assets/rakumeshi.png" class="img-responsive center-block "　alt="ホームへ戻る"></a>
            </div>
        </header>
        
        
        <main>
            <div class="bg-light text-center">
                <div> 
                  <p class="mt-3 pt-4">アカウントをお持ちでない方はこちら</p>
                  <a href="register.php" class="btn btn-danger pr-4 pl-4" role="button">新規会員登録</a>
                  <hr class="mr-4 ml-4" >
                </div>
                
                <form action="" method="post">
                   <div class="row form-group form-center col-md-6 col-lg-5">
                      <input type="email" name="email" class="form-control mt-4 " id="exampleInputEmail1"  aria-describedby="emailHelp"
                      placeholder="メールアドレス" value="
                      <?php if(isset($_POST['email'])){
                      echo h($_POST['email']); } ?>" />
                   </div>
                   
                   <div class="row form-group form-center col-md-6 col-lg-5">
                      <input type="password" name="password" class="form-control mt-3" id="exampleInputPassword1"  
                      placeholder="パスワード" value="<?php if(isset($_POST['password'])){
                      echo h($_POST['password']); } ?>" />
                      
                      <?php if(isset($error['login']) && $error['login']=='blank'): ?>
                      <p class="alert-danger">※ メールアドレスとパスワードをご記入ください</p>
                      <?php endif; ?>
                      
                      <?php if(isset($error['login']) && $error['login']=='failed'): ?>
                      <p class="alert-danger text-left">※ ログインに失敗しました。半角英数数字を組み合わせた8文字以上のパスワードをご記入ください。パソコンから登録した方は大文字小文字を変えてみてください</p>
                      <?php endif; ?>
                      
                        
                   </div>
                   <div class="row form-check mx-auto mt-3">
                      <input id="save" type="checkbox" name="save" value="on" class="form-check-input" id="exampleCheck1">
                      <label class="form-check-label"  for="exampleCheck1">ログイン情報を記憶する</label>
                   </div>
                   <button type="submit" class="btn btn-dark pr-5 pl-5 my-4" >ログイン</button>
                </form>
            </div>
        </main>
        <footer>
            
            <ul class="list-inline text-center mt-5">
  <li class="list-inline-item "><a href="../right/terms.php" class="small">利用規約</a></li>
  <li class="list-inline-item mx-4"><a href="../right/policy.php" class="small">プライバシーポリシー</a></li>
  <li class="list-inline-item "><a href="../right/contact.php" class="small">お問い合わせ</a></li>

</ul>
<p class="text-center small">&copy; <?php
$fromYear = 2018;
$thisYear = (int)date('Y');
echo $fromYear . (($fromYear != $thisYear) ? '-' . $thisYear : '');?> rakumeshi.net.</p>
        </footer>
        </div>
        
    </body>
        
    </html>