<?php
   
    
    require "layout/header.php";
    if(isset($_COOKIE['search'])){
        unset($_COOKIE["search"]);
    }
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Products</h1>
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
            <a href="add.php" class="btn btn-success mb-3">Add Product</a>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Product Table</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered text-center">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">id</th>
                      <th>Name</th>
                      <th>Description</th>
                      <th>Price</th>
                      <th>Quantity</th>
                      <th>Category</th>
                      <th colspan="2">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    // pagination
                    [$pageno,$products,$totalPages]=pagination(3,"products",$pdo);
                    if($products)
                    {
                        foreach($products as $product): 
                    ?>
                      <tr>
                        <td><?=escape($product->id);?></td>
                        <td><?=escape($product->name);?></td>
                        <td><?=escape(substr($product->description,0,50));?>...</td>
                        <td class="text-success text-bold">$<?=escape($product->price);?></td>
                        <td><?=escape($product->quantity);?></td>
                        <?php 
                          $stmt=$pdo->prepare("select * from categories where id =$product->category_id");
                          $stmt->execute();
                          $category=$stmt->fetch(PDO::FETCH_OBJ);
                        ?>
                        <td><?=escape($category->name);?></td>
                        <td>
                          <a href="edit.php?id=<?=$product->id; ?>" class="btn btn-warning">Edit</a>
                        </td>
                        <td>
                          <a href="delete.php?id=<?=$product->id; ?>" class="btn btn-danger" onclick="return confirm('are u sure want to delete');">Delete</a>
                        </td>
                      </tr>
                    <?php 
                        endforeach;
                      }
                    ?>
                  </tbody>
                   <?php 
                    // pagination component
                    require "components/pagination.php";
                   ?>
                </table>
              </div>
            </div> 
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
 
    <?php require "layout/footer.php"; ?>