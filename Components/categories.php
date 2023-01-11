<div class="sidebar-categories text-center">
    <div class="head">Browse Categories</div>
    <ul class="main-categories">
    <?php 
        $stmt=$pdo->prepare("select * from categories");
        $stmt->execute();
        $categories=$stmt->fetchAll(PDO::FETCH_OBJ);
    if($categories)
    {
        foreach($categories as $category): 
            // get product count of each category
        $statement=$pdo->prepare('select count(*) from products where category_id=?');
        $statement->execute([$category->id]);
        $prdouctAmount=$statement->fetch()[0];
    ?>
            
            <li class="main-nav-list child ">
                <!-- add font style in searchProductsByCategory page -->
                <?php 
                    // check current page is home page or searchProductsByCategory page
                    $path=$_SERVER["REQUEST_URI"];
                    $pathCutArr=explode('?',$path);
                    $fileName=$pathCutArr[0];
                    
                    if($fileName==='/searchProductsByCategory.php'){
                        $cat_id=empty($_GET['cat_id'])?$_SESSION['cat_id']:$_GET['cat_id'];
                ?>
                    <a href="searchProductsByCategory.php?cat_id=<?=$category->id;?>" style="color:<?=$cat_id===$category->id?'#ff6c00':'grey'?>">
                        <?= $category->name; ?>
                        <span class="number">(<?= $prdouctAmount; ?>)</span>
                    </a>
                <?php
                    }else{
                ?>
                    <a href="searchProductsByCategory.php?cat_id=<?=$category->id;?>">
                        <?= $category->name; ?>
                        <span class="number">(<?= $prdouctAmount; ?>)</span>
                    </a>
                <?php };?>
            </li>
    <?php 
        endforeach;
        }
    ?>
    </ul>
</div>