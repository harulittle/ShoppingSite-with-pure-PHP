<?php
    require "layout/header.php"; 

    // pagination
    // check pageno exist or not
    if(isset($_GET['pageno'])) 
    {
    $pageno=$_GET['pageno'];
    }
    else{
    $pageno=1;
    }   
    if(isset($_GET['search'])||isset($_COOKIE['search'])){
        $recordsPerPage=5;
        $offset=($pageno-1)*$recordsPerPage;
        $search=isset($_GET['search'])?$_GET['search']:$_COOKIE['search'];
        $stmt=$pdo->prepare("select * from Users where name like '%$search%' limit $offset,$recordsPerPage");
        $stmt->execute();
        $Users=$stmt->fetchAll(PDO::FETCH_OBJ);

        // total pages
        $statement=$pdo->prepare("select count(*) from Users where name like '%$search%'");
        $statement->execute();
        $result=$statement->fetch();
        $totalUsers=$result[0];
        $totalPages=ceil($totalUsers/$recordsPerPage);
        // die(var_dump($totalPages));
    }   
?>
           
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Search Users</h1>
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
                            <a href="user_add.php" class="btn btn-success mb-3">Add User</a>
            <?php if($totalPages>0):?>       
                            <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Search Users</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered">
                                <thead>                  
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>name</th>
                                        <th>email</th>
                                        <th>phone</th>
                                        <th>address</th>
                                        <th>Role</th>
                                        <th colspan="2">actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php     
                                        if($Users)
                                        {
                                            foreach($Users as $user): 
                                    ?>
                                    <tr>
                                        <td><?=escape($user->id);?></td>
                                        <td><?=escape($user->name);?></td>
                                        <td><?=escape($user->email,0,100);?></td>
                                        <td><?=escape($user->phone);?></td>
                                        <td><?=escape($user->address);?></td>
                                        <td><?=escape($user->role);?></td>
                                        <td>
                                        <a href="user_edit.php?id=<?=$user->id; ?>" class="btn btn-warning">Edit</a>
                                        </td>
                                        <td>
                                        <a href="destroy.php?id=<?=$user->id; ?>" class="btn btn-danger" onclick="return confirm('are u sure want to delete');">Delete</a>
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
              <?php else: ?>
                <div class="mt-3">
                    <h3>Not Found Results</h3>
                    <a href="./user_index.php" class="btn btn-primary">Go Back</a>
                </div>
              <?php endif; ?>
    <?php require "layout/footer.php"; ?>