<?php
require "layout/header.php";
if($_POST){
  if(empty($_POST['name']) || empty($_POST['description']) || empty($_POST['price']) || empty($_POST['category_id']) || empty($_POST['quantity']) ||empty($_FILES['image']['name'])){
    if(empty($_POST['name'])){
      $nameError="name is required";
    }
    if(empty($_POST['description'])){
      $descriptionError="description is required";
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
    if(empty($_POST['category_id'])){
      $categoryError="category is required";
    }
    if(empty($_FILES['image']['name'])){
      $imgError="img is required";
      // die($imgError);
    }else{
      $imageType=pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
      if($imageType!=="png" ||  $imageType!=="jpg"|| $imageType!=="jpeg"){
        // die($imageType);
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
    if($priceError=='' && $quantityError==''){
      $imgName=$_FILES['image']['name'];
      $to="images/products/$imgName";
      $imageType=pathinfo($to,PATHINFO_EXTENSION);//pathinfo fun is getting info of the file from whole path
      if($imageType==="png" ||  $imageType==="jpg"|| $imageType==="jpeg"){
        $from=$_FILES['image']['tmp_name'];
        move_uploaded_file($from,$to);
        $sql="insert into products (name,description,image,price,quantity,category_id) values (?,?,?,?,?,?)";
        $statement=$pdo->prepare($sql);
        $product=[
          $_POST['name'],
          $_POST['description'],
          $imgName,
          $_POST['price'],
          $_POST['quantity'],
          $_POST['category_id']
        ];
        $statement->execute($product);
        header('location:index.php');
      }else{
        $imgError="img should be png ,jpg or jpeg";
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
            <h1 class="m-0 text-dark">Create Product</h1>
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
            <form  action="add.php" enctype="multipart/form-data" method="POST">
                <input type="hidden" name="_token" value="<?=empty($_SESSION['_token'])?'':$_SESSION['_token'];?>">
                <div class="card-body">
                    <div class="form-group">
                    <label for="name">name</label>
                    <input type="text" class="form-control" id="name" name="name">
                    <p class="text-danger"><?=empty($nameError)?'':$nameError;?></p>
                    </div>
                    <div class="form-group">
                    <label for="description">Description</label>
                    <textarea  class="form-control" id="" cols="5" rows="5" name="description"></textarea>
                    <p class="text-danger"><?=empty($descriptionError)?'':$descriptionError;?></p>
                    </div>
                    <div class="form-group">
                    <label for="image">Image</label>
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
                        <input type="text" class="form-control" id="price" name="price">
                        <p class="text-danger"><?=empty($priceError)?'':$priceError;?></p>
                    </div>
                    <div class="form-group">
                        <label for="quantity">quantity</label>
                        <input type="text" class="form-control" id="quantity" name="quantity">
                        <p class="text-danger"><?=empty($quantityError)?'':$quantityError;?></p>
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select name="category_id" id="" class="form-control">
                            <option disabled selected value> -- select an option -- </option>
                            <?php 
                                $stmt=$pdo->prepare("select * from categories");
                                $stmt->execute();
                                $categories=$stmt->fetchAll(PDO::FETCH_OBJ);
                                foreach($categories as $category):    
                            ?>
                            <option value="<?=$category->id;?>"><?= $category->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <p class="text-danger"><?=empty($categoryError)?'':$categoryError;?></p>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                    <input type="submit" class="btn btn-primary" value="add product">
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