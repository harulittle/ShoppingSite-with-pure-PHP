<?php
require "layout/header.php";
if($_POST){
  
  if(empty($_POST['name']) || empty($_POST['description'])){
    if(empty($_POST['name'])){
      $nameError="name is required";
      // die($titleError);
    }
    if(empty($_POST['description'])){
      $descriptionError="description is required";
      // die($contentError);
    }
  }else{
      $sql="insert into categories (name,description) values (?,?)";
      $statement=$pdo->prepare($sql);
      $category=[
        $_POST['name'],
        $_POST['description']
      ];
    //   dd($category);
      $statement->execute($category);
      header('location:cat_index.php');
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
            <h1 class="m-0 text-dark">Create Category</h1>
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
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name">
                    <p class="text-danger"><?=empty($nameError)?'':$nameError;?></p>
                  </div>
                  <div class="form-group">
                    <label for="description">Description</label>
                   <textarea  class="form-control" id="" cols="30" rows="10" name="description"></textarea>
                   <p class="text-danger"><?=empty($descriptionError)?'':$descriptionError;?></p>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <input type="submit" class="btn btn-primary" value="add category">
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