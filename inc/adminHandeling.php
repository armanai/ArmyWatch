<?php 
	include('LIB_project1.php');  
	
	if (isset($_POST['addProduct_submit'])) {
	
		$success = true;
		$addProduct_errors = array();
		$name = $_POST['name'];
		$price = $_POST['price'];
		$image = $_FILES["image"];
		$salePrice = $_POST['salePrice'];
		$quantity = $_POST['quantity'];
		$description = $_POST['description'];
		$sale = 0;
		$target_file = "";

		$result = validateAddEdit($name, $price, $image, $salePrice, $quantity, $description, $sale, $target_file);

		if (isset($result['success'])) {

			list($name, $price, $image, $salePrice, $quantity, $description, $sale, $target_file) = $result['success'];
			if(!file_exists($target_file)){
		  		move_uploaded_file($image["tmp_name"], $target_file);
			}
			addNewProduct(array($name,$description,$price,$quantity,$image['name'],$sale));
		    setcookie("message", 'succeeded', time()+3600);

		}elseif(isset($result['failed'])){

			$addProduct_errors = $result['failed'];
			setcookie("fillFormAdd", serialize($result['fillForm']), time()+3600);
			setcookie("message", 'failed', time()+3600);
			setcookie("errorsMessage", serialize($addProduct_errors), time()+3600);
			setcookie("whichForm", 'addForm', time()+3600);

		}
		redirect_to('../admin.php');
	}
	if (isset($_POST['editProduct_submit'])) {
		
		$success = true;
		$addProduct_errors = array();
		$name = $_POST['name'];
		$price = $_POST['price'];
		$image = $_FILES['image'];
		$salePrice = $_POST['salePrice'];
		$quantity = $_POST['quantity'];
		$description = $_POST['description'];
		$sale = 0;
		$id = $_POST['id'];
		$target_file = "";

		$result = validateAddEdit($name, $price, $image, $salePrice, $quantity, $description, $sale, $target_file);

		if (isset($result['success'])) {
			list($name, $price, $image, $salePrice, $quantity, $description, $sale, $target_file) = $result['success'];
			if(!file_exists($target_file)){
		  		move_uploaded_file($image["tmp_name"], $target_file);
			}
			editProduct(array($name,$description,$price,$quantity,$image['name'],$sale,$id));
		    setcookie("message", 'succeeded', time()+3600);

		}elseif(isset($result['failed'])){

			$addProduct_errors = $result['failed'];
			setcookie("fillFormEdit", serialize($result['fillForm']), time()+3600);
			setcookie("message", 'failed', time()+3600);
			setcookie("errorsMessage", serialize($addProduct_errors), time()+3600);
			setcookie("whichForm", 'editForm', time()+3600);

		}

		redirect_to('../admin.php');
	}
	if (isset($_POST['deleteProduct_submit'])) {
		$result = deleteProductByID($_POST['id']);
		setcookie("whichForm", 'deleteForm', time()+3600);
		redirect_to('../admin.php');
	}
	if (isset($_GET['what'])) {
		if ($_GET['what'] == 'delete') {
			echo $_GET['id'];
		}elseif($_GET['what'] == 'edit'){
			$result = getProductByID($_GET['id']);
			echo $result['image']."***".$result['product_name']."***".$result['description']."***".$result['price']."***".$result['quantity']."***".$result['sale']."***".$_GET['id'];
		}
	}
	
?>