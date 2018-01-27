<?php
  session_start(); 
  $page_name = "Admin";  
  include('inc/header.php');
  if (!isset($_SESSION['loggedin'])) {
    redirect_to("login.php");
  } 
?>

<!-- Page Content -->
<div class="container">
<div class="row">
  <div class="col-md-6 col-sm-12">
    <h1 class="my-4">Administration</h1>
  </div>
  <div class="col-md-6 col-sm-12">
    <button type="button" class="btn btn-danger btn-lg" id="add_new_product" data-toggle="modal" data-target="#addModal">Add new product</button>
  </div>
</div>
<div class="row">   
    <?php
      echo (isset($_COOKIE["s"])) ? $_COOKIE["s"] : "" ;
    ?> 
    <div class="col-md-12">
        <div class="table-responsive">   
              <table id="mytable" class="table table-bordred table-striped">
                <thead>
                    <th class="hidden">ID</th>
                    <th>Image</th>
                	  <th>Product name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Sale</th>
                    <th>Edit</th> 
                    <th>Delete</th>
                </thead>
    			<tbody>
            <?php
              if (isset($_GET['page'])) {
                $page = $_GET['page']-1;
                $allProducts = getAllProductsWithLimit($page * 4, 4);
              }else{
                $allProducts = getAllProductsWithLimit();
              }
              $tableRows = "";
              for ($i=0; $i < count($allProducts); $i++) { 
                $row = "<tr>";
                $row .= "<td class='hidden'>". $allProducts[$i]['id'] . "</td>" ;
                $row .= "<td><img class='thumbnail' src='img/product_images/". $allProducts[$i]['image'] . "'></td>" ;
                $row .= "<td>". $allProducts[$i]['product_name'] . "</td>" ;
                $row .= "<td>". decodeString($allProducts[$i]['description']) . "</td>" ;
                $row .= "<td>". $allProducts[$i]['price'] . "</td>" ;
                $row .= "<td>". $allProducts[$i]['quantity'] . "</td>" ;
                $row .= "<td>". $allProducts[$i]['sale'] . "</td>" ;
                $row .= "<td><p data-placement='top' data-toggle='tooltip' title='Edit'><button onclick=\"deleteEdit(".$allProducts[$i]['id'].", 'edit')\" class='btn btn-primary btn-xs' data-title='Edit' data-toggle='modal' data-target='#editModal' ><img src='img/edit.png'></button></p></td>
                <td><p data-placement='top' data-toggle='tooltip' title='Delete'><button onclick=\"deleteEdit(".$allProducts[$i]['id'].", 'delete')\"  class='btn btn-danger btn-xs' data-title='Delete' data-toggle='modal' data-target='#deleteModal' ><img src='img/trash.png'></button></p></td>";
                $row .= "</tr>";

                $tableRows .= $row;
              }

              echo $tableRows;
              ?>
    				</tbody>
				</table>   
      </div>   
    </div>
	</div>
</div>

      <!-- Pagination -->
      <?php
          echo createNav(4,"admin.php");
      ?>

    </div>
    <!-- /.container -->

  <!-- Add new product frame -->
  <div class="modal fade" id="addModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add new product</h4>
        </div>
        <div class="modal-body">
          <form method="post" action="inc/adminHandeling.php" enctype="multipart/form-data">
            <input type="hidden" name="id" id="id">
            <div class="form-group">
              <label for="name">Product name:</label>
              <input type="text" class="form-control" id="name" name="name" value="<?php echo (isset($fillFormAdd)) ? $fillFormAdd[0] : "" ; ?>">
            </div>
            <div class="form-group">
              <label for="image">Product image:</label>
              <input type="file" class="form-control" id="image" name="image">
            </div>
            <div class="form-group">
              <label for="price">Price:</label>
              <input type="number" class="form-control" id="price" name="price" step="0.01" value="<?php echo (isset($fillFormAdd)) ? $fillFormAdd[1] : "" ; ?>">
            </div>
            <div class="form-group" id="salePriceInput">
              <label for="saleprice">Sale price:</label>
              <input type="number" class="form-control" id="saleprice" name="salePrice" step="0.01" value="<?php echo (isset($fillFormAdd)) ? $fillFormAdd[5] : "" ; ?>">
            </div>
            <div class="form-group">
              <label for="quantity">Quantity:</label>
              <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo (isset($fillFormAdd)) ? $fillFormAdd[3] : "" ; ?>">
            </div>
            <div class="form-group">
              <label for="description">Description:</label>
              <textarea id="description" class="form-control" name="description"><?php echo (isset($fillFormAdd)) ? $fillFormAdd[4] : "" ; ?></textarea>
            </div>
            <button type="submit" class="btn btn-default" name="addProduct_submit">Submit</button>
          </form>

          <div class="errors"> 
            <p>
              <?php 

                if (isset($errors) && !empty($errors) ) {
                  if (isset($form) && $form == "addForm") {
                    $err = "";
                    foreach ($errors as $key => $value) {
                        $err .= $key . ": " . $value . "<br />";
                    }
                    echo $err;
                  }
                }

              ?>
            </p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" data-backdrop="static">Quit</button>
        </div>
      </div>   
    </div>
  </div>

  <!-- Deleting product -->
  <div class="modal fade" id="deleteModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Delete product</h4>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this product?</p>
        </div>
        <div class="modal-footer">
          <form method="post" action="inc/adminHandeling.php">
            <input type="hidden" name="id" id="id">
            <button type="submit" class="btn btn-default" name="deleteProduct_submit">Yes</button>
          </form>
          <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        </div>
      </div>   
    </div>
  </div>

  <!-- Editing product -->
  <div class="modal fade" id="editModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit product</h4>
        </div>
        <div class="modal-body">
          <form method="post" action="inc/adminHandeling.php" enctype="multipart/form-data">
            <input type="hidden" name="id" id="id">
            <div class="form-group">
              <label for="name">Product name:</label>
              <input type="text" class="form-control" id="name" name="name" value="<?php echo (isset($fillFormEdit)) ? $fillFormEdit[0] : "" ; ?>">
            </div>
            <div class="form-group">
              <label for="image">Product image:</label>
              <input type="file" class="form-control" id="image" name="image">
            </div>
            <div class="form-group">
              <label for="price">Price:</label>
              <input type="number" class="form-control" id="price" name="price" step="0.01" value="<?php echo (isset($fillFormEdit)) ? $fillFormEdit[1] : "" ; ?>">
            </div>
            <div class="form-group" id="salePriceInput">
              <label for="saleprice">Sale price:</label>
              <input type="number" class="form-control" id="saleprice" name="salePrice" step="0.01" value="<?php echo (isset($fillFormEdit)) ? $fillFormEdit[5] : "" ; ?>">
            </div>
            <div class="form-group">
              <label for="quantity">Quantity:</label>
              <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo (isset($fillFormEdit)) ? $fillFormEdit[3] : "" ; ?>">
            </div>
            <div class="form-group">
              <label for="description">Description:</label>
              <textarea id="description" class="form-control" name="description"><?php echo (isset($fillFormEdit)) ? $fillFormEdit[4] : "" ; ?></textarea>
            </div>
            <button type="submit" class="btn btn-default" name="editProduct_submit">Submit</button>
          </form>
          <div class="errors"> 
            <p>
              <?php 

                if (isset($errors) && !empty($errors) ) {
                  if (isset($form) && $form == "editForm") {
                    $err = "";
                    foreach ($errors as $key => $value) {
                        $err .= $key . ": " . $value . "<br />";
                    }
                    echo $err;
                  }
                }

              ?>
            </p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>   
    </div>
  </div>

<?php
  
  include('inc/footer.php');
  
?>