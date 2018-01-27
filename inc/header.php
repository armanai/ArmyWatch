<?php 
  include('LIB_project1.php');
  $success = false;   
  $form = ""; 
  if (isset($_COOKIE['fillFormAdd'])){
      $fillFormAdd = unserialize($_COOKIE['fillFormAdd']);
      setcookie("fillFormAdd", '', time()-3600);
  }elseif(isset($_COOKIE['fillFormEdit'])){
      $fillFormEdit = unserialize($_COOKIE['fillFormEdit']);
      setcookie("fillFormEdit", '', time()-3600);
  }
  if(isset($_COOKIE['message']) && $_COOKIE['message'] === 'failed'){
      if (isset($_COOKIE['errorsMessage'])) {
        $errors = unserialize($_COOKIE['errorsMessage']);
        setcookie("errorsMessage", '', time()-3600);
      }
      $success = false;
  }elseif(isset($_COOKIE['message']) && $_COOKIE['message'] === 'succeeded'){
      $success  = true;
  }

  if (isset($_COOKIE['whichForm'])) {
    $form = $_COOKIE['whichForm'];
    setcookie("whichForm", '', time()-3600);
  }
  setcookie("message", '', time()-3600);

  if (isset($_POST['items_per_page'])) {
      if (checkItemsPerPageInput($_POST['items'])) {
         setcookie("items_per_page", $_POST['items'], time()+3600);
         redirect_to('index.php');
      }else{
        $itemnumerr = true;
      }
  }

  if ($page_name === "Home" || $page_name === "Cart") {
     userControl();
  }

  $items_per_page = 4;
  if (isset($_COOKIE['items_per_page'])) {
    $items_per_page = $_COOKIE['items_per_page'];
  }

 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ArmyWatch</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
  </head>
  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#">ArmyWatch</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <?php if($page_name === "Admin"){ 

              $menu = "";
              $menu .= "<li class='nav-item active'>
                <a class='nav-link' href='index.php'>Home</a>
              </li> 
              <li class='nav-item active'>
                <a class='nav-link' href='inc/logout.php'>Log out</a>
              </li>";
              echo $menu;

             }else{

              $menu = "";
              $menu = "<li class='nav-item active'>
              <a class='nav-link' href='index.php'>Home";
              $menu .= ($page_name == "Home" ? "<span class='sr-only'>(current)</span>" : "");
              $menu .= "</a>
              </li>
              <li class='nav-item'>
                <a class='nav-link' href='cart.php'>Cart";
              $menu .= ($page_name == "Cart" ? "<span class='sr-only'>(current)</span>" : "");
              $menu .=  "</a>
              </li>";
              echo $menu;

            }?>
          </ul>
        </div>
      </div>
    </nav>