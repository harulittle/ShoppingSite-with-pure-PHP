<?php 
    require "./layout/header.php"; 
    $royalUserMoneyAmount=100000;
    // get users who bought above $royalUserMoneyAmount
    $stmt=$pdo->prepare("select * from users");
    $stmt->execute();
    $users=$stmt->fetchAll(PDO::FETCH_OBJ);
    $royalUsers=[];
    foreach($users as $user){
        $sql="select sum(total_price) from orders where customer_id=?";
        $stmt=$pdo->prepare($sql); 
        $stmt->execute([$user->id]);
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
        $eachUserTotalSpentAmount=$result[0]['sum(total_price)']; //get each user total spent amount

        // get the user who spent above 1lakhs in loop
        if($eachUserTotalSpentAmount >= $royalUserMoneyAmount){
            $user->total_spent_amount=$eachUserTotalSpentAmount;
            $royalUsers[]=$user;
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
            <h1 class="m-0 text-dark">Royal Users Table</h1>
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
                    </tr>
                  </thead>
                  <tbody>
                    <?php   
                    if($royalUsers)
                    {
                        foreach($royalUsers as $user): 
                    ?>
                      <tr >
                        <td><?=escape($user->id);?></td>
                        <td><?=escape($user->name);?></td>
                        <td><?=escape( $user->total_spent_amount);?></td>
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