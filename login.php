<?php 
  session_start();
  include_once('inc/LIB_project1.php'); 

  if (isset($_SESSION['loggedin'])) {
    redirect_to("admin.php");
  } 

  $errors = array();

  if (isset($_POST['submit'])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!has_presence($username)) {
      $errors["username"] = "Username can't be blank.";
    }
    if (!has_presence($password)) {
      $errors["password"] = "Password can't be blank.";
    } 

    if (empty($errors)) {

      $db_password = get_password_db($username);
      
      if (has_presence($db_password)) {
        
        if (password_check($password, $db_password)) {
          
          $_SESSION['loggedin'] = true;
          redirect_to("admin.php");

        }else{

          $message = "Password do not match.";

        }

      }
      else{

          $message = "Username do not match.";

      }

    }else{
      
      $message = "Error(s) occured:" . "</br>";
      foreach ($errors as $value) {
          $message .= $value . "</br>";
      }

    }

  }else{

      $username = "";
      $password = "";
      $message = "Please log in.";

  }

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Shop - Administration</title>
  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>
<body>
   <div class="wrapper">
    <form class="form-signin" method="post" action="login.php">       
      <h2 class="form-signin-heading">Please login</h2>
      <input type="text" class="form-control" name="username" placeholder="Username" required="" autofocus="" value="<?php echo htmlspecialchars($username); ?>" />
      <input type="password" class="form-control" name="password" placeholder="Password" required=""/>
      <input class="btn btn-lg btn-primary btn-block" type="submit" name="submit" value="Login">
      <div class="errors">
        <p>
        <?php 

          echo $message;

        ?>
        </p>
      </div>   
    </form>
  </div>
</body>
</html>