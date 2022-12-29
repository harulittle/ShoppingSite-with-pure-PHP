<?php
    require "layout/header.php";
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <?php 
                $stmt=$pdo->prepare("select * from orders where id=?");
                $stmt->execute([$_GET['id']]);
                $order=$stmt->fetch(PDO::FETCH_OBJ);

       
                $stmt=$pdo->prepare("select * from users where id=?");
                $stmt->execute([$order->customer_id]);
                $customer=$stmt->fetch(PDO::FETCH_OBJ);
            ?>
            <h1 class="m-0 text-dark">Order Detail For <?=escape($customer->name);?></h1>
            <h6>Order Date-<?=escape(date("Y-m-d",strtotime($order->order_date)));?></h6>
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
                <h3 class="card-title">Voucher Table</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered text-center">
                  <thead>                  
                    <tr>
                      <th>Product Name</th>
                      <th>Quantity</th>
                      <th>total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                      // pagination
                        // check pageno exist or not
                      if(isset($_GET['pageno'])) 
                      {
                        $pageno=$_GET['pageno'];
                      }
                      else{
                        $pageno=1;
                      }
                      $recordsPerPage=5;
                      $offset=($pageno-1)*$recordsPerPage;
                      $stmt=$pdo->prepare("select * from order_details where order_id={$_GET['id']}  limit $offset,$recordsPerPage");
                      $stmt->execute();
                      $order_details=$stmt->fetchAll(PDO::FETCH_OBJ);
                      // total pages
                      $statement=$pdo->prepare("select count(*) from order_details where order_id={$_GET['id']}");
                      $statement->execute();
                      $result=$statement->fetch();
                      $totalorder_details=$result[0];
                      $totalPages=ceil($totalorder_details/$recordsPerPage);
                             
                         

                          
                    if($order_details)
                    {
                        foreach($order_details as $order_detail ): 
                    ?>
                      <tr >
                        <?php 
                            $stmt=$pdo->prepare("select * from products where id=?");
                            $stmt->execute([$order_detail->product_id]);
                            $product=$stmt->fetch(PDO::FETCH_OBJ);
                        ?>
                        <td><?=escape($product->name);?></td>
                        <td><?=escape($order_detail->quantity);?></td>
                        <td><?= escape(($product->price*$order_detail->quantity)); ?></td>
                      </tr>

                    <?php 
                        endforeach;
                      }
                      ?>
                      <tr>
                        <td></td>
                        <td>Subtotal</td>
                        <td><?= $order->total_price; ?></td>
                      </tr>
                  </tbody>
                    <!-- pagination -->
                    <nav aria-label="Page navigation example">
                      <ul class="pagination">
                        <li class="page-item <?php echo $pageno<=1 ? 'disabled' :'' ;?>">
                            <a class="page-link" href='?id=<?=$_GET['id'];?>&<?=$pageno<=1? "#":"pageno=".$pageno-1;  ?>'>Prev</a>
                        </li>
                        <?php  foreach(range(1,$totalPages) as $page):?>
                          <li class="page-item"><a class="page-link" href="?id=<?=$_GET['id'];?>&pageno=<?=$page;?>"><?=$page;?></a></li>
                        <?php endforeach; ?>
                        <li class="page-item <?php echo $pageno>=$totalPages ? 'disabled' :'' ;?>">
                            <a class="page-link" href='?id=<?=$_GET['id'];?>&<?=$pageno>=$totalPages? "#":"pageno=".$pageno+1;  ?>'>Next</a>
                        </li>
                      </ul>
                    </nav>
                </table>
              </div>
            </div> 
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
 
    <?php require "layout/footer.php"; ?>