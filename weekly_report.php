<?php 
    require "./layout/header.php"; 

    // get weekly reports orders
        // select * from orders where date(order_date)> '2021-03-03' and date(order_date)< '2021-03-11'
  
        // minus 8 day in php;
    $fromDate=date('Y-m-d', strtotime('-8 days'));  //2021-03-03 
    $toDate=date('Y-m-d');//2021-03-11
    $sql="select * from orders where order_date between ? and ?";
    $stmt=$pdo->prepare($sql); 
    $stmt->execute([$fromDate,$toDate]);
    $orders=$stmt->fetchAll(PDO::FETCH_OBJ);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Weekly Reports Table</h1>
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
                      <th>Customer Name</th>
                      <th>Total Price</th>
                      <th>Order Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php   
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
                        <td><?=date('Y-m-d',strtotime($order->order_date));?></td>
                        <td>
                          <a href="order_detail.php?id=<?=$order->id; ?>" class="btn btn-warning">View Detail</a>
                        </td>
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