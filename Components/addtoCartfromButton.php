<form action="add_to_cart.php" method="POST"> 
    <input type="hidden" name="_token" value="<?=empty($_SESSION['_token'])?'':$_SESSION['_token'];?>">
    <input type="hidden" name="id" value="<?=$product->id;?>">
    <input type="hidden" name="qty" value="1">
    <div class="prd-bottom">
    <button class="primary-btn" type="submit" style="border: 0;">Add to Cart</button>
    </div>
</form>