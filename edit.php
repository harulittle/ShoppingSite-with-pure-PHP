<?php

require "layout/header.php"; 
$id=$_GET['id'];
$stmt=$pdo->prepare("select * from products where id = ?");
$stmt->execute([$id]);
$product=$stmt->fetch(PDO::FETCH_OBJ);
if($_POST){
  if(empty($_POST['name']) || empty($_POST['description']) || empty($_POST['price']) || empty($_POST['category_id']) || empty($_POST['quantity'])){
    if(empty($_POST['name'])){
      $nameError="name is required";
    }
    if(empty($_POST['description'])){
      $descriptionError="description is required";
    }
    if(empty($_POST['price'])){
      $priceError="price is required";
    }
    if(empty($_POST['quantity'])){
      $quantityError="quantity is required";
    }
    if(empty($_POST['category_id'])){
      $categoryError="category is required";
    }
     /*
      use is_numeric because can't use  gettype
       because form input are always string
    */
    if(!is_numeric($_POST['price'])){ 
      $priceError="price is not integer datatype";
    }
    if(!is_numeric($_POST['quantity'])){
      $quantityError="quantity is not integer datatype";
    }
    if($_FILES['image']['name']){
      $imageType=pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
      if($imageType!=="png" ||  $imageType!=="jpg"|| $imageType!=="jpeg"){
     
        $imgError="img should be png ,jpg or jpeg";
      }
    }
  }else{
     /*
      use is_numeric because can't use  gettype
       because form input are always string
    */
    if(!is_numeric($_POST['price'])){ 
      $priceError="price is not integer datatype";
    }
    if(!is_numeric($_POST['quantity'])){
      $quantityError="quantity is not integer datatype";
    }
    if(empty($priceError) && empty($quantityError)){
      if($_FILES['image']['name']){
          $imgName=$_FILES['image']['name'];
          $to="images/products/$imgName";
          $imageType=pathinfo($to,PATHINFO_EXTENSION);//pathinfo fun is getting info of the file from whole path
          if($imageType==="png" ||  $imageType==="jpg"|| $imageType==="jpeg"){
          $from=$_FILES['image']['tmp_name'];
          move_uploaded_file($from,$to);
          $sql="update products set  name=?,description=?,image=?,price=?,quantity=?,category_id=? where id = ?";
          $statement=$pdo->prepare($sql);
          $product=[
              $_POST['name'],
              $_POST['description'],
              $imgName,
              $_POST['price'],
              $_POST['quantity'],
              $_POST['category_id'],
              $_GET['id']
          ];
          $statement->execute($product);
          header('location:index.php');
          }else{
          $imgError="img should be png ,jpg or jpeg";
          }
      }else{
          $sql="update products set  name=?,description=?,price=?,quantity=?,category_id=? where id = ?";
          $statement=$pdo->prepare($sql);
          $product=[
              $_POST['name'],
              $_POST['description'],
              $_POST['price'],
              $_POST['quantity'],
              $_POST['category_id'],
              $_GET['id']
          ];
          $statement->execute($product);
          header('location:index.php');
      }
    }
  }
  
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Update Product</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
            <form  action="" enctype="multipart/form-data" method="POST">
                <input type="hidden" name="_token" value="<?=empty($_SESSION['_token'])?'':$_SESSION['_token'];?>">
                <div class="card-body">
                    <div class="form-group">
                    <label for="name">name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?=$product->name;?>">
                    <p class="text-danger"><?=empty($nameError)?'':$nameError;?></p>
                    </div>
                    <div class="form-group">
                    <label for="description">Description</label>
                    <textarea  class="form-control" id="" cols="5" rows="5" name="description"><?=$product->description;?></textarea>
                    <p class="text-danger"><?=empty($descriptionError)?'':$descriptionError;?></p>
                    </div>
                    <div class="form-group">
                    <label for="image">Image</label><br>
                    <img src="./images/products/<?=$product->image;?>" class="my-3" width="400px" height="400px">
                    <div class="input-group">
                        <div class="custom-file">
                        <input type="file" class="custom-file-input" id="image" name="image">
                        <label class="custom-file-label" for="image">Choose file</label>
                        </div>
                    </div>
                    <p class="text-danger"><?=empty($imgError)?'':$imgError;?></p>
                    </div>
                    <div class="form-group">
                        <label for="price">price</label>
                        <input type="text" class="form-control" id="price" name="price" value="<?=$product->price;?>">
                        <p class="text-danger"><?=empty($priceError)?'':$priceError;?></p>
                    </div>
                    <div class="form-group">
                        <label for="quantity">quantity</label>
                        <input type="text" class="form-control" id="quantity" name="quantity" value="<?=$product->quantity;?>">
                        <p class="text-danger"><?=empty($quantityError)?'':$quantityError;?></p>
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select name="category_id" id="" class="form-control">
                            <?php 
                                $stmt=$pdo->prepare("select * from categories");
                                $stmt->execute();
                                $categories=$stmt->fetchAll(PDO::FETCH_OBJ);
                                foreach($categories as $category):    
                            ?>
                            <option value="<?=$category->id;?>" <?=$category->id===$product->category_id?"selected":""?>><?= $category->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <p class="text-danger"><?=empty($categoryError)?'':$categoryError;?></p>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                    <input type="submit" class="btn btn-primary" value="update product">
                    </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
</div>
<?php require "layout/footer.php"; ?>