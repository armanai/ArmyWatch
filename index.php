<?php
  session_start();
  $page_name = "Home"; 
  include('inc/header.php'); 
?>

    <!-- Page Content -->
    <div class="container">

      <!-- Page Heading -->
      <h1 class="my-4">Sale products</h1>

      <div class="row">

        <?php

              $saleProducts = getSaleProducts();
              $saleProductList = "";
              for ($i=0; $i < count($saleProducts); $i++) {
                  if ($saleProducts[$i]['quantity']>0) {
                    $saleProduct = "<div class='col-lg-3 col-md-4 col-sm-6 portfolio-item sale'><div class='card h-100'>";
                    $saleProduct .= "<img class='card-img-top' src='img/product_images/".$saleProducts[$i]['image']."' alt='".$saleProducts[$i]['image']."'>";
                    $saleProduct .= "<div class='card-body'><h4 class='card-title'>".$saleProducts[$i]['product_name']."</h4>";
                    $saleProduct .= "<p class='card-text'>".decodeString($saleProducts[$i]['description'])."</p>";
                    $saleProduct .= "<div class='additional-info'><p class='sale-price'><span>".$saleProducts[$i]['price']."$ </span>".$saleProducts[$i]['sale']."$</p><p class='quantity'>".$saleProducts[$i]['quantity']." left</p><form method='post' action='index.php'><input type='hidden' name='id' value='".$saleProducts[$i]['id']."'><button class='button btn' type='sumbit' name='addToCart'>Add to cart!</button></form></div>";
                    $saleProduct .= "</div></div></div>";
                    $saleProductList  .= $saleProduct; 
                  }
              }
              echo $saleProductList;

        ?>
        
      </div>
      <!-- /.row -->

      <!-- Page Heading -->
      <div class="row">
        <div class="col-sm-6">
          <h1 class="my-4">Other products</h1>
        </div>
        <div class="col-sm-6">
          <form method="post" action="index.php" class="form-inline">
            <div class="form-group">
              <label for="items">Items per page:</label>
              <input type="number" class="form-control" id="items" name="items" value="<?php echo $items_per_page; ?>">
            </div>
            <button type="sumbit" class="btn" name="items_per_page">Sumbit</button>
          </form>
        </div>
      </div>

      <div class="row">

        <?php 

              if (isset($_GET['page'])) {
                $page = $_GET['page']-1;
                $allProducts = getProductsNotSale($page * $items_per_page, $items_per_page);
              }else{
                $allProducts = getProductsNotSale(0, $items_per_page);
              }
              $productAllList = "";
              for ($i=0; $i < count($allProducts); $i++) {
                  if ($allProducts[$i]['quantity']>0) {
                    $product = "<div class='col-lg-3 col-md-4 col-sm-6 portfolio-item'><div class='card h-100'>";
                    $product .= "<img class='card-img-top' src='img/product_images/".$allProducts[$i]['image']."' alt='".$allProducts[$i]['image']."'>";
                    $product .= "<div class='card-body'><h4 class='card-title'>".$allProducts[$i]['product_name']."</h4>";
                    $product .= "<p class='card-text'>".decodeString($allProducts[$i]['description'])."</p>";
                    $product .= "<div class='additional-info'><p class='price'>".$allProducts[$i]['price']."$</p><p class='quantity'>".$allProducts[$i]['quantity']." left</p><form method='post' action='index.php'><input type='hidden' name='id' value='".$allProducts[$i]['id']."'><button class='button btn' type='sumbit' name='addToCart'>Add to cart!</button></form></div>";
                    $product .= "</div></div></div>";
                    $productAllList  .= $product; 
                  }
              }
              echo $productAllList;

        ?>
          
      </div>

      <!-- Pagination -->
      <?php
          echo createNav($items_per_page,"index.php");
      ?>
    </div>
    <!-- /.container -->
<?php
  
  include('inc/footer.php');
  
?>