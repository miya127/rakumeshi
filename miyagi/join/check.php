<?php
session_start();
 
if(!isset($_SESSION['join'])){
    header('Location:home.php');
    exit();
}
 //htmlspecialcharsのショートカット
 function h($value){
     return htmlspecialchars($value,ENT_QUOTES);
 }
?>
<!doctype html>
<html lang="ja=JP">
    <head>
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="@miyadesuu" /> 
<meta property="og:url" content="https://rakumeshi.net" /> 
<meta property="og:title" content="楽飯" /> 
<meta property="og:description" content="楽して美味しさを求める人々が生み出したアレンジ料理、ズボラ飯を投稿する新しいレシピサイトです" /> 
<meta property="og:image" content="https://rakumeshi.net/assets/show.png" /> 
       　　 <link rel="stylesheet" href="bootstrap.min.css" />
           <style>
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
           </style>
    </head>
    <body>
        <div class="container ">
        <header>
            <div class="text-center">
                <a href="index.php"><img src="assets/rakumeshi.png" class="img-responsive center-block "　alt="ホームへ戻る"></a>
            </div>
        </header>
        <main>
            <div class="bg-light mt-3 ">
          <form>
            <div class="row mx-auto">
              <div class="form-group form-center mt-4 col-md-6 col-lg-5">
                <label for="exampleFormControlInput1" class="small">アカウント名</label>
                <?php echo h($_SESSION['join']['display_name']);?>
              </div>
            </div>
            
            
            
            <div class="row mx-auto">
              <div class="form-group form-center mt-4 col-md-6 col-lg-5">
                <label for="exampleFormControlInput1" class="small">ユーザーID</label>
                <?php echo h($_SESSION['join']['user_name']);?>
              
            </div>
            </div>
            
             <div class="row mx-auto">
              <div class="form-group form-center mt-4 col-md-6 col-lg-5">
                <label for="exampleFormControlInput1" class="small">メールアドレス</label>
                <?php echo h($_SESSION['join']['email']);?>
              </div>
            </div>
            
            <div class="row mx-auto">
              <div class="form-group form-center mt-4 col-md-6 col-lg-5">
                <label for="exampleFormControlInput1" class="small">パスワード </label>
                <?php echo h($_SESSION['join']['password']);?>
              </div>
            </div>
           
            <div class="row mx-auto">
              <div class="form-group form-center mt-4 pb-4 col-md-6 col-lg-5">
               <label for="exampleFormControlInput1" class="small">プロフィール画像</label>
                            <div class="form-control-img img-responsive"></div>
                            <div class="input-group">
                                <label class="input-group-btn">
                                        <span class="btn btn-primary small">
                                            ファイルを選択<input type="file" style="display:none" class="uploadFile">
                                        </span>
                                </label>
                                <input type="text" class="form-control" readonly="">
                                <?php if($error['image']=='type'):?>
                                <p class="alert-danger">※　写真などは「.gif」または「.jpg」の画像を指定してください</p>
                                <?php endif;?>
                                <?php if(!empty($error)):?>
                                <p class="error">※　恐れ入りますが、画像を改めて指定してください</p>
                                <?php endif;?>
                              </div>
                              
                </div>
               
            </div>
            <div class="text-center">
                     <button type="submit" class="btn btn-danger pr-5 pl-5 my-4 " >登録</button>
              </div>
          </form>
            </div>
          
        </main>
        <footer></footer>
        </div>
        
    </body>
    </html>