<?php
session_start();
require('../dbconnect.php');

if(isset($_SESSION['id']) && $_SESSION['time']+3600 > time()){
    //ログインしている場合
    $_SESSION['time']=time();
    $members=$db->prepare('SELECT * FROM members WHERE id=?');
    $members->execute(array($_SESSION['id']));
    $member=$members->fetch();
}


//会員情報、投稿を取得する    
 
 
if(!empty($_POST)){

    $update_name=$db->prepare('UPDATE members SET  display_name=? ,updated_at=NOW() WHERE id=?');
         $update_name->execute(array(
             $_POST['display_name'],
             $_SESSION['id'],
             ));

             
              if(!empty($_FILES['image']['name'])){
        
        
        
        $image= date('YmdHis').$_FILES['image']['name'];

           // Upload file
           move_uploaded_file($_FILES['image']['tmp_name'],"../img/$image");

        $_POST['picture']=$image;

         $update_member=$db->prepare('UPDATE members SET prf_picture=?,  updated_at=NOW() WHERE id=?');
         $update_member->execute(array(
             $_POST['picture'],
             $_SESSION['id'],
             ));

               header('Location:index.php');
    }
    header('Location:index.php');
}
    
   


function h($value){
    return htmlspecialchars($value, ENT_QUOTES);
}


?>

<!doctype html>
<html lang="ja=JP">
    <head>
        <title>プロフィール変更</title>
<link rel="SHORTCUT ICON" href="../assets/rakumeshi_mini.png">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="@miyadesuu" /> 
<meta property="og:url" content="https://rakumeshi.net" /> 
<meta property="og:title" content="楽飯" /> 
<meta property="og:description" content="楽して美味しさを求める人々が生み出したアレンジ料理、ズボラ飯を投稿する新しいレシピサイトです" /> 
<meta property="og:image" content="https://rakumeshi.net/assets/show.png" /> 
       　　 <link rel="stylesheet" href="../bootstrap.min.css" />
       　　 <link rel="stylesheet" href="../assets/user.css"/>
           <style>

         
           </style>
    </head>
<body　class="pt-0">
    <header>
            <div class="text-center">
                <a href="../index.php"><img src="../assets/rakumeshi.png" class="img-responsive center-block "　alt="ホームへ戻る"></a>
            </div>
       </header>
  
       
       <main>
         <div class="container">
            <div class="bg-light text-center mt-3">
        <?php 
        if($_SESSION['id']==$member['id']):
        ?>
            <form action="" method="post" enctype="multipart/form-data">


                 <div class=""> 
                      <p class="mt-3 pt-4">プロフィールの編集</p>
                      <hr>
                      <div class="sample1 mx-auto">

                        	<img src="../img/<?php 
                        	 echo h($member['prf_picture']); ?>" class="picture"  name="" width="100" height="100" />
                        	<div class="mask">
                        		<input   class="input_img" type="file" name="image" widht="100" height="100"><div class="caption">画像を変更</div></>
                        	</div>
                        
　　　　　　　　　　　</div>
                      
                      
                      

                      <p class="small">@<?php echo h($member['user_name']); ?></p>
                      <row>
                       <div class="row mx-auto col-lg-2 col-lg-offset-5 col-md-2 col-md-offset-5 col-6 col-offset-3">
                        <input type="text" class="col form-control" name="display_name" id="exampleFormControlInput1" placeholder="名前" 
                                value="<?php 
                                echo h($member['display_name']);?>"/>
                      </div>    
                      </row>


                      
                      
                      
                 </div>
                                           <div class="text-center ">

                              <button type="submit"  class="btn btn-danger col-8 col-md-8 col-lg-4 my-4" >変更する</button>
                              
                          </div>
                       
        </form>


      
      </div> 
       </main>
       <?php
       endif;
       ?>
       <fotter>
          

       </fotter>
   </div>
</body>
</html>