<?php
session_start();
require('../dbconnect.php');

if(isset($_SESSION['id']) && $_SESSION['time']+3600 > time()){
    //ログインしている場合
    $_SESSION['time']=time();
    
    $members=$db->prepare('SELECT * FROM members WHERE id=?');
    $members->execute(array($_SESSION['id']));
    $member=$members->fetch();
    
   
}else{
    //ログインしていなかったら
    header('Location: ../join/login_post.php');exit();
}

 $tags=$db->query('SELECT * FROM tags ORDER BY id ASC');

//投稿を記録する
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
    
   $counttags = count($_POST['tag']);
        if($counttags>5){
            $error['tag']='blank';
        }
    

var_dump($_FILES['image']['name']);
    if(empty($error)){
         // Count total files
         $countfiles = count($_FILES['image']['name']);
         
         // Looping all files
         for($i=0;$i<$countfiles;$i++){
           $image[$i] = date('YmdHis').$_FILES['image']['name'][$i];
           
           // Upload file
           move_uploaded_file($_FILES['image']['tmp_name'][$i],"../img/$image[$i]");
var_dump ($_FILES['image']['error']);
exit;
         }


        $_POST['picture']=$image[0];
        $_POST['picture1']=$image[1];
        $_POST['picture2']=$image[2];
        $_POST['picture3']=$image[3];
        

         
         // Looping all files
         for($i=0;$i<$counttags;$i++){
           $tag[$i] = $_POST['tag'][$i];
         }
          $tag['tag']=$tag[0];
          $tag['tag1']=$tag[1];
          $tag['tag2']=$tag[2];
          $tag['tag3']=$tag[3];
          $tag['tag4']=$tag[4];
          

   
        $message=$db->prepare('INSERT INTO posts SET member_id=?, name=?, picture=?,picture1=?, picture2=?, picture3=?, 
        cooking_time=?, cost=?, ingredients=?, make=?,tag=?, tag1=?, tag2=?, tag3=?, tag4=?, draft=0, created_at=NOW()');
        $message->execute(array(
        $member['id'],
        $_POST['name'],
        $_POST['picture'],//
        $_POST['picture1'],//
        $_POST['picture2'],//
        $_POST['picture3'],//TODO::カラム増やして修正
        empty($_POST['cooking_time']) ? 0 : $_POST['cooking_time'],
        empty($_POST['cost']) ? 0 : $_POST['cost'],
        $_POST['ingredients'],
        $_POST['make'],
        $tag['tag'],
        $tag['tag1'],
        $tag['tag2'],
        $tag['tag3'],
        $tag['tag4']
        
        
        ));
        

        }

         



    if(empty($error)){
        header('Location:post_complete.php');exit();
    }     
}

function h($value){
    return htmlspecialchars($value, ENT_QUOTES);
}
?>

<!doctype html>
<html lang="ja=JP">
    <head>
        <title>レシピ入力</title>
        <link rel="SHORTCUT ICON" href="../assets/rakumeshi_mini.png">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="@miyadesuu" /> 
<meta property="og:url" content="https://rakumeshi.net" /> 
<meta property="og:title" content="楽飯" /> 
<meta property="og:description" content="楽して美味しさを求める人々が生み出したアレンジ料理、ズボラ飯を投稿する新しいレシピサイトです" /> 
<meta property="og:image" content="https://rakumeshi.net/assets/show.png" /> 
       　　 <link rel="stylesheet" href="../bootstrap.min.css" />
       　　 <link rel="stylesheet" href="../assets/common.css" />
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
<body class="pt-0 ">

        <header>
            <div class="text-center">
                <a href="../index.php"><img src="../assets/rakumeshi.png" class="img-responsive center-block "　alt="ホームへ戻る"></a>
            </div>
        </header>

       <main>
        <div class="container">
           <div class="bg-light mt-3 mb-5 ">

                  <h5 class='text-center pt-3 mt-4 mb-3 '>レシピ投稿</h5>
              
              <hr>
            <form action="" method="post" enctype="multipart/form-data">
               <div class="row mx-auto　">
                   <div class="col-12 col-md-12 col-lg-6  mb-3">
                       
                            <div class="form-group form-center my-4 col-md-10 col-lg-10">

                                <label for="exampleFormControlInput1">料理名<span class="text-danger">※</span></label>
                                 <?php if(isset($error['name']) && $error['name']=='blank'):?>
                                <br><label class="alert-danger">料理名を記入してください</label>
                                <?php endif; ?>
                                <input type="text" class="form-control" name="name" id="exampleFormControlInput1" placeholder="料理名" value="<?php if(isset($_POST['name'])){
                    echo h($_POST['name']);}?>" >
    
                            </div>
                        
                        
                            <div class="row">
                                <div class="form-center my-5 col-10 col-md-9 col-lg-9">
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
                            </div>
                            
                            
                              <div class=" form-center mt-5 col-sm-10 col-md-10 col-lg-10">
                                <div class="row">
                                 <div class="col-sm-6 col-md-6 col-lg-6 pl-5">
                                   <label for="exampleFormControlInput1" class="">時間 :</label>
                                     <input type="text" class="form-control-small" name="cooking_time" id="exampleFormControlInput1" placeholder="0"
                                     value="<?php if(isset($_POST['cooking_time'])){
                    echo h($_POST['cooking_time']);}?>"><span class="">分</span>
                                 </div>
                                  <div class="col-sm-6 col-md-6 col-lg-6 pl-5">
                                     <label for="exampleFormControlInput1" class="">費用 :</label>
                                     <input type="text" class="form-control-small " name="cost" id="exampleFormControlInput1" placeholder="0"
                                     value="<?php if(isset($_POST['cost'])){
                    echo h($_POST['cost']);}?>"><span class="" >円</span>
                                 </div>
                                </div>
                              </div>
                        </div>
                        
                   
                 
                  <div class="col-sm-12 col-md-12 col-lg-6 mb-3 ">
                      <div class="form-group form-center mt-4 col-md-10 col-lg-10">
                          <label for="exampleFormControlInput1">材料<span class="text-danger">※</span></label>
                          <div class="form-group">
                          <?php if(isset($error['ingredients']) && $error['ingredients']=='blank'):?>
                            <label class="alert-danger">材料を記入してください</label>
                            <?php endif; ?>
                            <textarea class="form-control" name="ingredients" id="exampleFormControlTextarea1"  placeholder="納豆
・豆腐
・お好みでキムチ " rows="5" ><?php if(isset($_POST['ingredients'])){
                    echo h($_POST['ingredients']);}?></textarea>

                          </div>
                          <label for="exampleFormControlInput1">作り方 / コメント<span class="text-danger">※</span></label>
                          <div class="form-group">
                           <?php if(isset($error['make']) && $error['make']=='blank'):?>
                            <label class="alert-danger">作り方を記入してください</label>
                            <?php endif; ?>
                            <textarea class="form-control"  name="make" id="exampleFormControlTextarea1"  placeholder="1.納豆を混ぜる
2.豆腐の上に納豆をのせる
大豆のオンパレードですが、美味しいです！！キムチを入れるとなお美味しい。" rows="5" ><?php if(isset($_POST['make'])){
                    echo h($_POST['make']);}?></textarea>

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
       <fotter>
          

       </fotter>
   </div>
       <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>
　　<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
　　　
　　　　<script type="text/javascript">
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



