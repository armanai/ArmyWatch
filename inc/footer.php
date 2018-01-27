    <!-- Footer -->
    <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; ArmyWatch 2017</p>
      </div>
      <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper/popper.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/script.js"></script>
    <?php 
      if ($success) {
        echo "<script> alert('success'); </script>";
        //setcookie("message", '', time()-3600);
      }else{
        if (isset($form)) {
          if ($form == 'editForm') {
            echo "<script> $('#editModal').modal('show'); </script>";
          }elseif ($form == 'addForm') {
            echo "<script> $('#addModal').modal('show'); </script>";
          }
        }
        //setcookie("message", '', time()-3600);
      }
      if (isset($_POST['addToCart']) && isset($_POST['id'])) {
        $result = addToCart($_POST["id"], $_SESSION['user_id']);
        if ($result) {
          echo "<script> alert('Successfully added item to cart.'); </script>";
        }else{
          echo "<script> alert('Cannot add more items than we have, look at the quantity of the product.'); </script>";
        }
      }

      if (isset($itemnumerr) && $itemnumerr) {
        echo "<script> alert('You are allowed to show maximum 20 items per page'); </script>";
      }

      unset($form);
      unset($success);
    ?>

  </body>
</html>
