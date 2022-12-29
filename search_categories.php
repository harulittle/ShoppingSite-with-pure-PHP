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
        $stmt=$pdo->prepare("select * from categories where name like '%$search%' limit $offset,$recordsPerPage");
        $stmt->execute();
        $categories=$stmt->fetchAll(PDO::FETCH_OBJ);

        // total pages
        $statement=$pdo->prepare("select count(*) from categories where name like '%$search%'");
        $statement->execute();
        $result=$statement->fetch();
        $totalcategories=$result[0];
        $totalPages=ceil($totalcategories/$recordsPerPage);
        // die(var_dump($totalPages));
    }   
?>
           
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Search Categories</h1>
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
                            <a href="add.php" class="btn btn-success mb-3">Add Category</a>
            <?php if($totalPages>0):?>       
                            <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Search categories</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered">
                                <thead>                  
                                    <tr>
                                    <th style="width: 10px">id</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th colspan="2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php     
                                        if($categories)
                                        {
                                            foreach($categories as $category): 
                                    ?>
                                    <tr>
                                    <tr>
                                        <td><?=escape($category->id);?></td>
                                        <td><?=escape($category->name);?></td>
                                        <td><?=escape(substr($category->description,0,50));?>...</td>
                                        <td>
                                        <a href="edit.php?id=<?=$category->id; ?>" class="btn btn-warning">Edit</a>
                                        </td>
                                        <td>
                                        <a href="destroy.php?id=<?=$category->id; ?>" class="btn btn-danger" onclick="return confirm('are u sure want to delete');">Delete</a>
                                        </td>
                                    </tr>
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
                    <a href="./cat_index.php" class="btn btn-primary">Go Back</a>
                </div>
              <?php endif; ?>
    <?php require "layout/footer.php"; ?>