<?php
 require "layout/header.php";
if($_POST){
  $statement=$pdo->prepare("select * from users where email=?");
  $statement->execute([$_POST['email']]);
  $user=$statement->fetch(PDO::FETCH_ASSOC);
  
    if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password'])){
      if($user){
        $emailError="user email already exists";
      }
      if(empty($_POST['name'])){
        $nameError="name is required";
      }
      if(empty($_POST['email'])){
        $emailError="email is required";
      }
      if(empty($_POST['password'])){
        $passwordError="password is required";
      }
      if(empty($_POST['phone'])){
        $phoneError="phone is required";
      }
      if(empty($_POST['address'])){
        $addressError="address is required";
      }
      if(!is_numeric($_POST['phone'])){
        $phoneError='please fill phone number';
      }
      if(strlen($_POST['password'])<6){
        $passwordError="password must me at least 6 character";
      }
    }else{
      if($user){
        $emailError="user email already exists";
      }
      if(strlen($_POST['password'])<6){
        $passwordError="password must me at least 6 character";
      }
      if(!is_numeric($_POST['phone'])){
        $phoneError='please fill phone number';
      }
      if(empty($passwordError) && empty($phoneError) && empty($emailError)){

        $sql="insert into users (name,email,password,phone,address,role) values (?,?,?,?,?,?)";
        $statement=$pdo->prepare($sql);
        $post=[
          $_POST['name'],
          $_POST['email'],
         password_hash($_POST['password'],PASSWORD_DEFAULT),
         $_POST['phone'],
         $_POST['address'],
          $_POST['role']
        ];
        $statement->execute($post);
        header('location:user_index.php');
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
            <h1 class="m-0 text-dark">Create User</h1>
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
            <form  action="" method="POST">
                <input type="hidden" name="_token" value="<?=empty($_SESSION['_token'])?'':$_SESSION['_token'];?>">
                <div class="card-body">
                  <div class="form-group">
                    <label for="name">name</label>
                    <input type="text" class="form-control" id="name" name="name">
                    <p class="text-danger"><?=empty($nameError)?'':$nameError;?></p>
                  </div>
                  <div class="form-group">
                    <label for="email">email</label>
                    <input type="text" class="form-control" id="email" name="email">
                    <p class="text-danger"><?=empty($emailError)?'':$emailError;?></p>
                  </div>
                  <div class="form-group">
                    <label for="password">password</label>
                    <input type="text" class="form-control" id="password" name="password">
                    <p class="text-danger"><?=empty($passwordError)?'':$passwordError;?></p>
                  </div>
                  <div class="form-group">
                    <label for="phone">phone</label>
                    <input type="text" class="form-control" id="phone" name="phone">
                    <p class="text-danger"><?=empty($phoneError)?'':$phoneError;?></p>
                  </div>
                  <div class="form-group">
                    <label for="address">address</label>
                    <input type="text" class="form-control" id="address" name="address">
                    <p class="text-danger"><?=empty($addressError)?'':$addressError;?></p>
                  </div>
                  <div class="form-group">
                    <label for="password">role</label>
                    <select name="role" id="" class="form-control">
                      <option value="0">normal user</option>
                      <option value="1">admin</option>
                    </select>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <input type="submit" class="btn btn-primary" value="add user">
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