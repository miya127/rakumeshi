<?php
session_start();
require('../dbconnect.php');


    
if(empty($_GET['id'])){
       header('Location:../index.php');exit();
    }else{
        //投稿を取得する
        $posts=$db->prepare('SELECT * FROM posts WHERE id=?');
        $posts->execute(array($_GET['id']));
        $post=$posts->fetch();
}

 $tags=$db->query('SELECT * FROM tags ORDER BY id ASC');

if(!empty($_POST)){
     if($_POST['name']==''){
        $error['name']='blank';
     }
     
     if($_POST['ingredients']==''){
        $error['ingredients']='blank';
    }
    
    if($_POST['make']==''){
        $error['make']='blank';
    }
 


    if(empty($error) ){
         // Count total files
         
         if(!empty($_FILES['image']['name'][0]) ){
         
         $countfiles = count($_FILES['image']['name']);
         
         // Looping all files
         for($i=0;$i<$countfiles;$i++){
           $image[$i] = date('YmdHis').$_FILES['image']['name'][$i];
           
           // Upload file
           move_uploaded_file($_FILES['image']['tmp_name'][$i],"../img/$image[$i]");
            
         }
         
        $post['picture']=$image[0];
        $post['picture1']=$image[1];
        $post['picture2']=$image[2];
        $post['picture3']=$image[3];
         }
    
        
        
        
         $counttags = count($_POST['tag']);
        for($i=0;$i<$counttags;$i++){
           $tag[$i] = $_POST['tag'][$i];
           
   
         }
          $tag['tag']=$tag[0];
          $tag['tag1']=$tag[1];
          $tag['tag2']=$tag[2];
          $tag['tag3']=$tag[3];
          $tag['tag4']=$tag[4];

          
        
        $update_post=$db->prepare('UPDATE posts SET name=?, picture=?, picture1=?, picture2=?, picture3=?, 
        cooking_time=?, cost=?, ingredients=?, make=?,tag=?, tag1=?, tag2=?, tag3=?, tag4=?, draft=0, created_at=NOW() WHERE id=?');
 $update_post->execute(array(
        $_POST['name'],
        $post['picture'],
        $post['picture1'],
        $post['picture2'],
        $post['picture3'],//TODO::カラム増やして修正
        empty($_POST['cooking_time']) ? 0 : $_POST['cooking_time'],
        empty($_POST['cost']) ? 0 : $_POST['cost'],
        $_POST['ingredients'],
        $_POST['make'],
        $tag['tag'],
        $tag['tag1'],
        $tag['tag2'],
        $tag['tag3'],
        $tag['tag4'],
        $_GET['id'],
        ));
        

        
    }
    if(empty($error)){
        header('Location:post_update_do.php');exit();
    }     
}


function h($value){
    return htmlspecialchars($value, ENT_QUOTES);
}


?>

<!doctype html>
<html lang="ja=JP">
    <head>
        <title>レシピ編集</title>
        <link rel="SHORTCUT ICON" href="../assets/rakumeshi_mini.png">
         <meta name="viewport" content="width=device-width, initial-scale=1">
         <meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="@miyadesuu" /> 
<meta property="og:url" content="https://rakumeshi.net" /> 
<meta property="og:title" content="楽飯" /> 
<meta property="og:description" content="楽して美味しさを求める人々が生み出したアレンジ料理、ズボラ飯を投稿する新しいレシピサイトです" /> 
<meta property="og:image" content="https://rakumeshi.net/assets/show.png" /> 
       　　 <link rel="stylesheet" href="../bootstrap.min.css" />
       　　 <link rel="stylesheet"  href="../assets/common.css"/>
       　　  <link rel="stylesheet"  href="../assets/good.css"/>
<link href="../slick/slick-theme.css" rel="stylesheet" type="text/css">
<link href="../slick/slick.css" rel="stylesheet" type="text/css">
       　
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
     
           <style>
.custom-file-input:lang(ja) ~ .custom-file-label::after {
  content: '選択';
}
     
.custom-file {
  max-width: 20rem;
  overflow: hidden;
}
.custom-file-label {
  white-space: nowrap;
}
         
           </style>
    </head>
<body class="pt-0">

        <header>
            <div class="text-center">
                <a href="../index.php"><img src="../assets/rakumeshi.png" class="img-responsive center-block "　alt="ホームへ戻る"></a>
            </div>
        </header>

       <main>
        <?php 
        if($_SESSION['id']==$post['member_id']):
        ?>
       <div class="container">
           
            <div class="bg-light mt-3 mb-5 ">
            <h5 class='text-center pt-3 mt-4 mb-3 '>レシピ編集</h5>
              <hr>
            <form action="" method="post" enctype="multipart/form-data">
             <input type="hidden" name="id" value="<?php echo($_SESSION['id']);?>">
               <div class="row mx-auto　">
                   <div class="col-12 col-md-12 col-lg-6  mb-3">
                       
                            <div class="form-group form-center my-4 col-md-10 col-lg-10">
                                <label for="exampleFormControlInput1">料理名<span class="text-danger">※</span></label>
                                <input type="text" class="form-control" name="name" id="exampleFormControlInput1" placeholder="料理名" 
                                value="<?php if(isset($_POST['name'])){
                                echo h($_POST['name']);
                                }else{
                                echo h($post['name']);}?>"/>
                                <?php if(isset($error['name']) && $error['name']=='blank'):?>
                                <p class="alert-danger">料理名を記入してください</p>
                                <?php endif; ?>
                            </div>
                        
                        
                                                            <div class="form-group form-center mt-3 mb-4 col-md-10 col-lg-10">
                          
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
                                 <div class="form-group">
    <label for="file" class="mt-3">画像選択（最大４枚まで）</label>
    <div id="file" class="input-group">
        <div class="custom-file">
            <input type="file" id="cutomfile" class="custom-file-input" name="image[]" lang="ja" multiple />
            <label class="custom-file-label" for="customfile">image</label>
        </div>
        <div class="input-group-append">
            <button type="button" class="btn btn-outline-secondary reset">取消</button>
        </div>
    </div>
</div>
                            </div>
                             

                            
                              <div class=" form-center mt-5 col-sm-10 col-md-10 col-lg-10">
                                <div class="row">
                                 <div class="col-sm-6 col-md-6 col-lg-6 pl-5">
                                   <label for="exampleFormControlInput1" class="">時間 :</label>
                                     <input type="text" class="form-control-small" name="cooking_time" id="exampleFormControlInput1" placeholder="0"
                                     value="<?php if(isset($_POST['cooking_time'])){
                                    echo h($_POST['cooking_time']);
                                    }else{
                                    echo h($post['cooking_time']);}?>"/><span class="">分</span>
                                 </div>
                                  <div class="col-sm-6 col-md-6 col-lg-6 pl-5">
                                     <label for="exampleFormControlInput1" class="">費用 :</label>
                                     <input type="text" class="form-control-small " name="cost" id="exampleFormControlInput1" placeholder="0"
                                     value="<?php if(isset($_POST['cost'])){
                                    echo h($_POST['cost']);
                                    }else{
                                    echo h($post['cost']);}?>"/><span class="" >円</span>
                                 </div>
                                </div>
                              </div>
                        </div>
                        
                   
                 
                  <div class="col-sm-12 col-md-12 col-lg-6 mb-3 ">
                      <div class="form-group form-center mt-4 col-md-10 col-lg-10">
                          <label for="exampleFormControlInput1">材料<span class="text-danger">※</span></label>
                          <div class="form-group">
                            <textarea class="form-control" name="ingredients" id="exampleFormControlTextarea1"  placeholder="・シュールストレミング
・缶切り " rows="5" ><?php if(isset($_POST['ingredients'])){
                                echo h($_POST['ingredients']);
                                }else{
                                echo h($post['ingredients']);}?></textarea>
                          <?php if(isset($error['ingredients']) && $error['ingredients']=='blank'):?>
                            <p class="alert-danger">材料を記入してください</p>
                            <?php endif; ?>
                          </div>
                          <label for="exampleFormControlInput1">作り方/コメント<span class="text-danger">※</span></label>
                          <div class="form-group">
                            <textarea class="form-control"  name="make" id="exampleFormControlTextarea1"  placeholder="1.缶のふたを開ける
2.鼻をつまむ" rows="5" ><?php if(isset($_POST['make'])){
                                echo h($_POST['make']);
                                }else{
                                echo h($post['make']);}?></textarea>
                           <?php if(isset($error['make']) && $error['make']=='blank'):?>    
                            <p class="alert-danger">作り方を記入してください</p>
                            <?php endif; ?>
                          </div>
                          
<div class="btn-group-toggle mb-3" data-toggle="buttons">
    <label for="exampleFormControlInput1">タグ選択（5個まで可）<span class="text-danger">※</span></label><br>
<?php if(isset($error['tag']) && $error['tag']=='blank'):?>
<label class="alert-danger">タグは５個までです</label><br>
<?php endif; ?>
<?php foreach($tags as $tag):?>
  <label class="btn label btn-outline-secondary btn-sm m-1">
    <input type="checkbox" name='tag[]'  value="<?php if(isset($tag['id'])){
    echo h($tag['id']);} ?>"><?php if(isset($tag['name'])){
    echo h($tag['name']);} ?>
  </label>
<?php endforeach;?>

</div>
    
                          <div class="text-center ">

                              <button type="submit"  class="btn btn-danger col-sm-8 col-md-8 col-lg-8  pr-4 pl-4 mt-3" >投稿する</button>
                              
                          </div>

    
                              
                      </div>
                  </div>
           　</div>
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
   <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> 
       <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>

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

$('.custom-file-input').on('change', handleFileSelect);
function handleFileSelect(evt) {
    $('#preview').remove();// 繰り返し実行時の処理
    $(this).parents('.input-group').after('<div id="preview"></div>');
    var files = evt.target.files;

    for (var i = 0, f; f = files[i]; i++) {

        var reader = new FileReader();

        reader.onload = (function(theFile) {
            return function(e) {
                if (theFile.type.match('image.*')) {
                    var $html = ['<div class="d-inline-block mr-1 mt-1"><img class="img-thumbnail" src="', e.target.result,'" title="', escape(theFile.name), '" style="height:100px;" /></div>'].join('');// 画像では画像のプレビューとファイル名の表示
                } else {
                    var $html = ['<div class="d-inline-block mr-1"><span class="small">', escape(theFile.name),'</span></div>'].join('');//画像以外はファイル名のみの表示
                }

                $('#preview').append($html);
            };
        })(f);

        reader.readAsDataURL(f);
    }

    $(this).next('.custom-file-label').html(+ files.length + '個のファイルを選択');
}

//ファイルの取消
$('.reset').click(function(){
    $(this).parent().prev().children('.custom-file-label').html('ファイル選択...');
    $('.custom-file-input').val('');
    $('#preview').remove('');
})
</script>
</body>
</html>