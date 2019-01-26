<?php
session_start();
require('../dbconnect.php');


if(!empty($_POST)){
    //エラー項目の確認
    if($_POST['display_name']==''){
        $error['display_name']='blank';
    }
    if($_POST['user_name']==''){
        $error['user_name']='blank';
    }
    if(!preg_match('/\A\w{4,15}\z/', $_POST['user_name'])) {
        $error['user_name']='regex';
    }
    if($_POST['email']==''){
        $error['email']='blank';
    }
    if(strlen($_POST['password'])<8){
        $error['password']='length';
    }

    if(!preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]+\z/i', $_POST['password'])) {
        $error['password']='regex';
    }
    
    if($_POST['password']==''){
        $error['password']='blank';
    }
     if($_POST['user_name']==$_POST['password']){
        $error['password']='same';
    }
    
    if(empty($error)){
        $member=$db->prepare('SELECT COUNT(*) AS cnt FROM members WHERE email=?');
        $member->execute(array($_POST['email']));
        $record=$member->fetch();
        if($record['cnt']>0){
            $error['email']='duplicate';
        }
    }
    
    if(empty($error)){
        $member=$db->prepare('SELECT COUNT(*) AS cnt FROM members WHERE user_name=?');
        $member->execute(array($_POST['user_name']));
        $record=$member->fetch();
        if($record['cnt']>0){
            $error['user_name']='duplicate';
        }
    }
    
    if(empty($error)){
        $_SESSION['join']=$_POST;
       
    }
}
      if(isset($_SESSION['join'])){
    
    
        $statement=$db->prepare('INSERT INTO members SET display_name=?, user_name=?, email=?, password=?, created_at=NOW()');
        echo $ret=$statement->execute(array(
            $_SESSION['join']['display_name'],
            $_SESSION['join']['user_name'],
            $_SESSION['join']['email'],
            sha1($_SESSION['join']['password']),
        ));
        
            //ログインの処理
    
        $login=$db->prepare('SELECT * FROM members WHERE email=? AND password=?');
        $login->execute(array(
            $_SESSION['join']['email'],
            sha1($_SESSION['join']['password'])
            ));
        $member=$login->fetch();
        
        if($member){
            //ログイン成功
            $_SESSION['id']=$member['id'];
            $_SESSION['time']=time();

    
        unset($_SESSION['join']);
        header('Location:complete.php');
       
        exit();
            
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
        <title>会員情報入力</title>
<link rel="SHORTCUT ICON" href="../assets/rakumeshi_mini.png">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="@miyadesuu" /> 
<meta property="og:url" content="https://rakumeshi.net/join/register.php" /> 
<meta property="og:title" content="楽飯" /> 
<meta property="og:description" content="楽して美味しさを求める人々が生み出したアレンジ料理、ズボラ飯を投稿する新しいレシピサイトです" /> 
<meta property="og:image" content="https://rakumeshi.net/assets/show.png" /> 
       　　 <link rel="stylesheet" href="../bootstrap.min.css" />
           <style>
             .very-small{
                font-size:75%;

             }
             .form-center{
                 margin:auto;
             }
              .form-control-img {
   
   
    display: block;
    width: 100%;
    height: calc(18rem + 2px);
    padding: .375rem .75rem;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    margin-bottom:0.5rem;
  
}
 a{
                 color:black;
             }
           </style>
    </head>
    <body>
        <div class="container ">
        <header>
            <div class="text-center">
                <a href="../index.php"><img src="../assets/rakumeshi.png" class="img-responsive center-block "　alt="ホームへ戻る"></a>
            </div>
        </header>
        <main>
            <div class="bg-light mt-3 ">
          <form action="" method="post">
            <div class="row mx-auto">
              <div class="form-group form-center mt-4 col-md-6 col-lg-5">
                <p class="text-center mb-3">新規会員登録</p>
                <label for="exampleFormControlInput1"  class="small">アカウント名 <span class="text-danger">※</span></label>
                <input type="text" name="display_name" class="form-control" id="exampleFormControlInput1"
                placeholder="ラク飯" value="<?php if(isset($_POST['display_name'])){
                echo h($_POST['display_name']);} ?>"/>
                <?php if(isset($error['display_name']) && $error['display_name']=='blank'):?>
                <p class="alert-danger">※ アカウント名を入力してください</p>
                <?php endif; ?>
              </div>
            </div>
        
            
            
            <div class="row mx-auto">
              <div class="form-group form-center mt-4 col-md-6 col-lg-5">
                <label for="exampleFormControlInput1"  class="small">ユーザーID<span class="text-danger"> ※<span></label>
                <p  class="very-small">( ユーザIDは半角英数字またはアンダースコアで4〜15文字で入力してください )</p>
                <label class="sr-only" for="inlineFormInputGroup">Username</label>
                      <div class="input-group ">
                        <div class="input-group-prepend">
                          <div class="input-group-text">@</div>
                        </div>
                        <input type="text" name="user_name" class="form-control" id="inlineFormInputGroup"
                        placeholder="raku_meshi" value="<?php if(isset($_POST['user_name'])){
                        echo h($_POST['user_name']);} ?>"/>
                     </div>
                <?php if(isset($error['user_name']) && $error['user_name']=='blank'):?>
                <p class="alert-danger">※ ユーザーIDを入力してください</p>
                <?php endif; ?>
                <?php if(isset($error['user_name'])&&$error['user_name']=='duplicate'):?>
                <p class="alert-danger">※ 指定されたユーザーIDはすでに登録されています</p>
                <?php endif;?>
                <?php if(isset($error['user_name'])&&$error['user_name']=='regex'):?>
                <p class="alert-danger">※ ユーザIDは半角英数字またはアンダースコアで4〜15文字で入力してください</p>
                <?php endif;?>
            </div>
            </div>
            
            <div class="row mx-auto">
              <div class="form-group form-center mt-4 col-md-6 col-lg-5">
                <label for="exampleFormControlInput1" class="small">メールアドレス<span class="text-danger">※</span></label>
                <input type="email" name="email" class="form-control" id="exampleFormControlInput1"
                placeholder="メールアドレス" value="<?php if(isset($_POST['email'])){
                echo h($_POST['email']);} ?>"/>
                <?php if(isset($error['email']) && $error['email']=='blank'):?>
                <p class="alert-danger">※メールアドレスを入力してください</p>
                <?php endif; ?>
                <?php if(isset($error['email'])&&$error['email']=='duplicate'):?>
                <p class="alert-danger">※指定されたメールアドレスはすでに登録されています</p>
                <?php endif;?>
              </div>
            </div>
            
            
            <div class="row mx-auto">
              <div class="form-group form-center mt-4 col-md-6 col-lg-5 mb-3">
                <label for="exampleFormControlInput1" class="small">パスワード  <span class="text-danger">※</span></label>
                <p class="very-small">( 英数字を組み合わせた8文字以上のパスワードをご記入ください )</p>
                <input type="password" name="password" class="form-control" id="exampleFormControlInput1" 
                placeholder="パスワード" value="<?php if(isset($_POST['password'])){
                echo h($_POST['password']);} ?>"/>
                <?php if(isset($error['password']) && $error['password']=='blank'):?>
                <p class="alert-danger">※パスワードを入力してください</p>
                <?php endif; ?>
                <?php if(isset($error['password']) && $error['password']=='length'):?>
                <p class="alert-danger">※パスワードは8文字以上で入力してください</p>
                <?php endif; ?>
                <?php if(isset($error['password']) && $error['password']=='regex'):?>
                <p class="alert-danger">※半角英字と数字両方を含むパスワードを入力してください</p>
                <?php endif; ?>
                <?php if(isset($error['password']) && $error['password']=='same'):?>
                <p class="alert-danger">※ユーザーIDと同じパスワードは設定できません</p>
                <?php endif; ?>
              </div>
            </div>
           
               <div class="text-center">
               <button type="submit" class="btn btn-danger pr-5 pl-5 my-4 " >登録</button>
              </div>
               
            </div>

          </form>
            </div>
          
        </main>
        <footer>
            
            <ul class="list-inline text-center mt-5">
  <li class="list-inline-item "><a href="../right/terms.php" class="small">利用規約</a></li>
  <li class="list-inline-item mx-3"><a href="../right/policy.php" class="small">プライバシーポリシー</a></li>
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