<?php 
    require "./layout/header.php"; 
    $bestSellerQuantityAmount=7;
    // get quantity amount above $bestSellerQuantityAmount
    $stmt=$pdo->prepare("select * from products");
    $stmt->execute();
    $products=$stmt->fetchAll(PDO::FETCH_OBJ);
    $bestSellerProducts=[];
    foreach($products as $product){
        $sql="select sum(quantity) from order_details where product_id=?";
        $stmt=$pdo->prepare($sql); 
        $stmt->execute([$product->id]);
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
        $eachProdcutSoldQuantityAmount=$result[0]["sum(quantity)"]; //get each user total spent amount
   
        // get the products which quantity above 7
        if($eachProdcutSoldQuantityAmount >= $bestSellerQuantityAmount){
            $product->total_bought_quantity_amount=$eachProdcutSoldQuantityAmount;
            $bestSellerProducts[]=$product;
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
            <h1 class="m-0 text-dark">Best Seller Products Table</h1>
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
              <div class="card-header">
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered text-center" id="myTable">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">id</th>
                      <th>Product Name</th>
                      <th>Total Bought quantity</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php   
                    if($bestSellerProducts)
                    {
                        foreach($bestSellerProducts as $product): 
                    ?>
                      <tr >
                        <td><?=escape($product->id);?></td>
                        <td><?=escape($product->name);?></td>
                        <td><?=escape($product->total_bought_quantity_amount);?></td>
                      </tr>
                    <?php 
                        endforeach;
                      }
                    ?>
                  </tbody>
                </table>
              </div>
            </div> 
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
<?php require "layout/footer.php"; ?>