<?php
  session_start();
  $page_name = "Cart"; 
  include('inc/header.php'); 
  if (isset($_POST['buy'])) {
    purchase($_SESSION['user_id']);
  }
?>
    <!-- Page Content -->
    <div class="container">

      <!-- Page Heading -->
      <h1 class="my-4">Cart</h1>
      <div class="row">
        <?php 

          if (isset($_SESSION['user_id'])) {
            
            $userProducts = getProductsFromCart($_SESSION['user_id']);
            $itemList = "";

            for ($i=0; $i < count($userProducts); $i++) {
                $productID = $userProducts[$i]['product_id'];
                $product = getProductByID($productID);
                
                $saleORnot = ($product['sale']>0) ? true : false;
                $item = "<div class='col-lg-3 col-md-4 col-sm-6 portfolio-item ".($product['sale'] > 0 ? "sale" : "") ."'><div class='card h-100'>";
                $item .= "<img class='card-img-top' src='img/product_images/".$product['image']."' alt='".$product['image']."'>";
                $item .= "<div class='card-body'><h4 class='card-title'>".$product['product_name']."</h4>";
                $item .= "<p class='card-text'>".decodeString($product['description'])."</p><p>".($product['sale'] > 0 ? $product['sale'] : $product['price']) ."$</p></div></div></div>";
          
                $itemList .=  $item;
            }
            echo $itemList;
          }

        ?>
        
      </div>
      <div class="row pad">
        <div class="col-sm-12">
          <p class="total">Total price: <?php echo (isset($_SESSION['user_id'])) ? countTotalPrice($_SESSION['user_id']) : "0"; ?>$</p>
          <form method="POST" action="cart.php">
            <button class="btn" type="submit" name="buy">Buy</button>
          </form>
        </div>
      </div>
    </div>
    <!-- /.container -->

<?php
  
 include('inc/footer.php');
  
?>