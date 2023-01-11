<?php if($totalPages): ?>
    <div class="filter-bar d-flex flex-wrap align-items-center">
        <div class="pagination">
            <a href="<?=$pageno<=1? "#":"?pageno=".$pageno-1; ?>" class="prev-arrow" <?php echo $pageno<=1 ? 'disabled' :'' ;?>><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>
            <?php  foreach(range(1,$totalPages) as $page):?>
                <a  href="?pageno=<?=$page;?>" class="<?=$page==$pageno?'active':'';?>"><?=$page;?></a>
            <?php endforeach; ?>

            <a  href='<?=$pageno>=$totalPages? "#":"?pageno=".$pageno+1;  ?>' class="next-arrow" <?php echo $pageno>=$totalPages ? 'disabled' :'' ;?>><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
        </div>
    </div>
    
<?php else: ?>
    <h2>Not Fount Results</h2>
<?php endif; ?>