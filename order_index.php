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
            <h1 class="m-0 text-dark">Orders</h1>
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
                <h3 class="card-title">Orders Table</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered text-center">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">id</th>
                      <th>Customer Name</th>
                      <th>Total Price</th>
                      <th>Order Date</th>
                      <th>Action</th>
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
                      $stmt=$pdo->prepare("select * from orders order by id desc limit $offset,$recordsPerPage");
                      $stmt->execute();
                      $orders=$stmt->fetchAll(PDO::FETCH_OBJ);
                      // total pages
                      $statement=$pdo->prepare('select count(*) from orders');
                      $statement->execute();
                      $result=$statement->fetch();
                      $totalorders=$result[0];
                      $totalPages=ceil($totalorders/$recordsPerPage);
                             
                         

                          
                    if($orders)
                    {
                        foreach($orders as $order): 
                    ?>
                      <tr >
                        <td><?=escape($order->id);?></td>
                        <?php 
                            $stmt=$pdo->prepare("select * from users where id=?");
                            $stmt->execute([$order->customer_id]);
                            $customer=$stmt->fetch(PDO::FETCH_OBJ);
                        ?>
                        <td><?=escape($customer->name);?></td>
                        <td><?=escape($order->total_price);?></td>
                        <td><?=escape(date("Y-m-d",strtotime($order->order_date)));?></td>
                        <td>
                          <a href="order_detail.php?id=<?=$order->id; ?>" class="btn btn-warning">View Detail</a>
                        </td>
                      </tr>
                    <?php 
                        endforeach;
                      }
                    ?>
                  </tbody>
                    <!-- pagination -->
                    <nav aria-label="Page navigation example">
                      <ul class="pagination">
                        <li class="page-item <?php echo $pageno<=1 ? 'disabled' :'' ;?>">
                            <a class="page-link" href='<?=$pageno<=1? "#":"?pageno=".$pageno-1;  ?>'>Prev</a>
                        </li>
                        <?php  foreach(range(1,$totalPages) as $page):?>
                          <li class="page-item"><a class="page-link" href="?pageno=<?=$page;?>"><?=$page;?></a></li>
                        <?php endforeach; ?>
                        <li class="page-item <?php echo $pageno>=$totalPages ? 'disabled' :'' ;?>">
                            <a class="page-link" href='<?=$pageno>=$totalPages? "#":"?pageno=".$pageno+1;  ?>'>Next</a>
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