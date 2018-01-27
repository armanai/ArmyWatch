<?php
	
	date_default_timezone_set("Europe/Zagreb");

	include_once('db_connection.php');

	/**
     * checks if input is number
     * @param    int
     * @return    bool
     */
	function numeric($value) {
		$reg = "/(^-?\d\d*\.\d*$)|(^-?\d\d*$)|(^-?\.\d\d*$)/";
		return preg_match($reg,$value);
	}
	/**
     * checks if input contains only letters and spaces
     * @param    string
     * @return    bool
     */
	function alphabeticSpace($value) {
		$reg = '/^[a-z0-9 :,.!().?";\'-]+$/i';
		return preg_match($reg,$value);
	}
	/**
     * sanitize input
     * @param    string
     * @return    string
     */
	function sanitizeString($var){
		$var = trim($var);
		$var = stripslashes($var);
		$var = htmlentities($var);
		$var = strip_tags($var);
		return $var;
	}
	/**
     * decodes string 
     * @param    string
     * @return    string
     */
	function decodeString($var){
		return htmlspecialchars_decode(html_entity_decode($var));
	}
	/**
     * redirecting function
     * @param    string
     */
	function redirect_to($location){
		header("Location: $location");
		exit;
	}
	/**
     * encrypts password string, returns hashed password
     * @param    string
     * @return 	 string
     */
	function password_encrypt($password){
		$hash_format = "$2y$10$";
		$salt_length = 22;
		$salt = generate_salt($salt_length);
		$format_and_salt = $hash_format . $salt;
		$hash = crypt($password, $format_and_salt);
		return $hash;
	}
	/**
     * generates salt using md5
     * @param    int
     * @return 	 string
     */
	function generate_salt($length){
		$unique_salt = md5(uniqid(mt_rand(),true));
		$base64_string = base64_encode($unique_salt);
		$modified_base64_string = str_replace('+', '.', $base64_string);
		$salt = substr($modified_base64_string, 0, $length);
		return $salt;
	}
	/**
     * checks if user input password is the same as the one in the database
     * @param    string
     * @param    string
     * @return 	 bool
     */
	function password_check($password, $password_db){
		$hash = crypt($password, $password_db);
		if ($hash === $password_db) {
			return true;
		}else{
			return false;
		}
	}
	/**
     * checks if string exists and if it is not null or empty string
     * @param    string
     * @return 	 bool
     */
	function has_presence($value){
		return isset($value) && $value !== "";
	}
	/**
     * gets user password from database by username
     * @param    string
     * @return 	 string
     */
	function get_password_db($username){
		global $conn;
		$stmt = $conn->prepare("SELECT hashed_password FROM admins WHERE username = :username");
		$stmt->bindParam(':username', $name);
		$name = $username;
		$stmt->execute();
		$row = $stmt->fetch();
		if (!empty($row)) {
			return $row['hashed_password'];
		}else{
			return "";
		}
	}
	/**
     * gets all products data from database
     * @return 	 array
     */
	function getAllProducts(){
		global $conn;
		$stmt = $conn->prepare("SELECT * FROM products ORDER BY id DESC");
		$stmt->execute();
		$result = $stmt->fetchAll();
		return $result;
	}
	/**
     * gets all products data from database
     * @param int
     * @param int
     * @return 	 array
     */
	function getAllProductsWithLimit($start1 = 0, $howmanyrecords = 4){
		global $conn;
		$conn->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
		$stmt = $conn->prepare("SELECT * FROM products ORDER BY id DESC LIMIT :start1, :howmanyrecords");
		$stmt->execute(array("start1"=> $start1 , "howmanyrecords" => $howmanyrecords));
		$result = $stmt->fetchAll();
		return $result;
	}
	/**
     * gets only products that are on sale from databse
     * @return 	 array
     */
	function getSaleProducts(){
		global $conn;
		$stmt = $conn->prepare("SELECT * FROM products WHERE sale > 0 ORDER BY id DESC");
		$stmt->execute();
		$result = $stmt->fetchAll();
		return $result;
	}
	/**
     * gets specific products that are not on sale from database
     * @param 	 int
     * @param 	 int
     * @return 	 array
     */
	function getProductsNotSale($start1 = 0, $howmanyrecords = 4){
		global $conn;
		$conn->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
		$stmt = $conn->prepare("SELECT * FROM products WHERE sale = 0 ORDER BY id DESC LIMIT :start1, :howmanyrecords");
		$stmt->execute(array("start1"=> $start1 , "howmanyrecords" => $howmanyrecords));
		$result = $stmt->fetchAll();
		return $result;
	}
	/**
     * checks how many products are on sale
     * @return 	 string
     */
	function saleProductsCount(){
		global $conn;
		$stmt = $conn->prepare("SELECT COUNT(sale) as saleNum FROM products WHERE sale > 0");
		$stmt->execute();
		$result = $stmt->fetch();
		return $result['saleNum'];
	}
	/**
     * adds new product to the database
     * @param 	 array
     * @return 	 bool
     */
	function addNewProduct($values){
		global $conn;
		$stmt = $conn->prepare("INSERT INTO products(product_name,description, price, quantity, image, sale) VALUES(:name, :description, :price, :quantity, :image, :sale);");
		$stmt->execute(array("name"=> $values[0],"description"=> $values[1],"price"=>$values[2],"quantity"=>$values[3],"image"=>$values[4], "sale"=>$values[5]));
		$result = ($stmt->rowCount() > 0);
		return $result;
	}
	/**
     * edits products
     * @param 	 array
     * @return 	 bool
     */
	function editProduct($values){
		global $conn;
		$stmt = $conn->prepare("UPDATE products SET product_name = :product_name, description = :description, price = :price, quantity = :quantity, image = :image, sale = :sale WHERE id = :id;");
		$stmt->execute(array(":product_name"=> $values[0],":description"=> $values[1],":price"=>$values[2],":quantity"=>$values[3],":image"=>$values[4], ":sale"=>$values[5], ":id"=>$values[6]));
		$result = ($stmt->rowCount() > 0);
		return $result;
	}
	/**
     * gets product data by id form databse 
     * @param 	 int
     * @return 	 array
     */
	function getProductByID($id){
		global $conn;
		$stmt = $conn->prepare("SELECT * FROM products WHERE id = :id");
		$stmt->execute(array('id' => $id));
		$result = $stmt->fetch();
		return $result;
	}
	/**
     * deletes product data by id form databse 
     * @param 	 int
     * @return 	 bool
     */
	function deleteProductByID($id){
		global $conn;
		$stmt = $conn->prepare("DELETE FROM products WHERE id = :id");
		$stmt->execute(array('id' => $id));
		$result = ($stmt->rowCount() > 0);
		return $result;
	}
	/**
     * gets product price by id from database
     * @param 	 int
     * @return 	 string
     */
	function getProductPrice($id){
		global $conn;
		$stmt = $conn->prepare("SELECT price, sale FROM products WHERE id = :id");
		$stmt->execute(array('id' => $id));
		$result = $stmt->fetch();
		$price = 0;
		if ($result['sale'] > 0) {
			$price = $result['sale'];
		}else{
			$price = $result['price'];
		}
		return $price;
	}
	/**
     * creates control buttons for item catalog
     * @param 	 int
     * @return 	 string
     */
	function createNav($itemsToShow,$pageName){
        global $conn;
        if ($pageName === "index.php") {
        	$stmt = $conn->prepare("SELECT COUNT(id) as ids FROM products WHERE sale = 0");
        }elseif($pageName === "admin.php"){
			$stmt = $conn->prepare("SELECT COUNT(id) as ids FROM products");
        }
        $stmt->execute();
        $result = $stmt->fetch(); 
        $total_records = $result[0];  
        $total_pages = ceil($total_records / $itemsToShow); 

        $nav = "<ul class='pagination justify-content-center'>";

        for ($i=1; $i < $total_pages + 1; $i++) { 
          $nav .= "<li class='page-item'><a class='page-link' href='$pageName?page=".$i."'>".$i."</a></li>";
        }
        
        $nav .= "</ul>";

        return $nav;
      
     } 
     /**
     * validates all input fields when adding or editing product in admin.php
     * @param 	 string
     * @param 	 file
     * @param 	 int
     * @param 	 array
     * @return 	 array
     */
	function validateAddEdit($name_d, $price_d, $image_d, $salePrice_d, $quantity_d, $description_d, $sale_d, $target_file_d){

		$addProduct_errors = array();

		$name = sanitizeString($name_d);
		$price = sanitizeString($price_d);
		$image = $image_d;
		$salePrice = sanitizeString($salePrice_d);
		$quantity = sanitizeString($quantity_d);
		$description = sanitizeString($description_d);
		$sale = $sale_d;
		$target_file = $target_file_d;

		if (strlen($image['name']) === 0) {
		
			$addProduct_errors['image'] = "You have to select image.";
			
		}else{

			$target_dir = "../img/product_images/";
			$target_file = $target_dir . basename($image["name"]);
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

	  		if (!getimagesize($image["tmp_name"])) {
	  			$addProduct_errors['image'] = "The file you selected is not an image.";
		    }
		    if ($image["size"] > 500000) {
		    	$addProduct_errors['image'] = "The file you selected is too large.";
		    }
		    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
		    	$addProduct_errors['image'] = "You can upload only images with extension .jpg, .png, .gif, .jpg.";
		    }

		}
		if($name == "" || !alphabeticSpace($name) || strlen($name) > 100) {
		    $addProduct_errors['name'] = "You have to enter a valid name.";
	  	}
  		if($price == "" || !numeric($price) || $price <= 0) {
	    	$addProduct_errors['price'] = "You have to enter a valid price.";
  		}
  		if($quantity == "" || !numeric($quantity) || $quantity <= 0) {
	    	$addProduct_errors['quantity'] = "You have to enter a valid quantity.";
  		}
	  	if ($description === "") {
	    	$addProduct_errors['description'] = "You have to enter a valid description."; 		 
	  	}
  		if ($salePrice > 0) {
  			$saleProductsCount = saleProductsCount();
  			if($saleProductsCount < 5 && $saleProductsCount >= 3){
	  			$sale = $salePrice;
  			}
  			else{
  				$addProduct_errors['salePrice'] = "You have $saleProductsCount products on sale right now, and you are allowed to have a minimum of 3 and a maximum of 5 products on sale at a time.";
  			}
  		}
  		if (empty($addProduct_errors)) {
  			return array('success' => array($name, $price, $image, $salePrice, $quantity, $description, $sale, $target_file));
  		}else{
  			return array('failed' => $addProduct_errors, 'fillForm' => array($name, $price, $image, $quantity, $description, $sale));
  		}
	}
	/**
     * validates input for number of items showing per page in catalog section
     * @param 	 int
     * @return 	 bool
     */
	function checkItemsPerPageInput($num){
		if ($num == "" || !numeric($num) || $num <= 0 || $num > 20) {
			return false;
		}else{
			return true;
		}
	}
	/**
     * Registers user: when new user arrive it gets unique id, creates table called by the user id for the shopping cart. 
     * @return    string
     */
	function registerNewUser(){
		global $conn;

		$uniqueid = "user".uniqid();

		$stmt = $conn->prepare("INSERT INTO users(username) VALUES(:uniqueid);");
		$stmt->execute(array('uniqueid' => $uniqueid));
		$stmt = $conn->prepare("CREATE TABLE $uniqueid (id int(11) NOT NULL AUTO_INCREMENT,product_id int NOT NULL, PRIMARY KEY (id));");
		$stmt->execute();

		return $uniqueid;
	}
	/**
     * Adding item to cart: adds items in user specific table.
     * @param    int
     * @param    string
     * @return   bool
     */
	function addToCart($id, $table){
		if (checkQuantityProduct($id,$table)) {
			global $conn;
			$stmt = $conn->prepare("INSERT INTO $table(product_id) VALUES(:id);");
			$stmt->execute(array("id"=> $id));
			return true;
		}else{
			return false;
		}
	}
	/**
     * Checks if there are more product: Checks how many same items user has added to cart and copares it to quantity of that specific product.
     * @param    int
     * @param    string
     * @return   bool
     */
	function checkQuantityProduct($id, $table){
		global $conn;

		$stmtCount = $conn->prepare("SELECT count(id) as countProd FROM $table WHERE product_id = :id");
		$stmtCount->execute(array("id"=> $id));
		$resultCount = $stmtCount->fetch();

		$stmtQuantity = $conn->prepare("SELECT quantity FROM products WHERE id = :id");
		$stmtQuantity->execute(array("id"=> $id));
		$resultQuantity = $stmtQuantity->fetch();

		if ($resultCount['countProd'] < $resultQuantity['quantity']) {
			return true;
		}
		else{
			return false;
		}

	}
	/**
     * Gets products from specific cart table from database
     * @param    string
     * @return   array
     */
	function getProductsFromCart($table){
		global $conn;
		$stmt = $conn->prepare("SELECT product_id FROM $table");
		$stmt->execute();
		$result = $stmt->fetchAll();
		return $result;
	}
	/**
     * Counts total price of all products in cart
     * @param    string
     * @return   int
     */
	function countTotalPrice($table){
		
		$totalPrice = 0;
		$products = getProductsFromCart($table);
		for ($i=0; $i < count($products); $i++) {
			$totalPrice += getProductPrice($products[$i]['product_id']);
		}
		return $totalPrice;
	}
	/**
     * Decrese quantity of all products that user has bought, deletes everything and drops the table
     * @param    string
     */
	function purchase($table){
		$products = getProductsFromCart($table);
		for ($i=0; $i < count($products); $i++) {
			decreseQuantity($products[$i]['product_id']);
		}
		deleteEverythingFromCart($table);
		deleteCartTable($table);
		$_SESSION['user_id'] = null;

	}
	/**
     * Drops the specific table
     * @param    string
     */
	function deleteCartTable($table){
		global $conn;
		$stmt = $conn->prepare("DROP TABLE $table");
		$stmt->execute();
		$result = ($stmt->rowCount() > 0);
		return $result;
	}
	/**
     * Deletes everything from specific table
     * @param    string
     * @return   bool
     */
	function deleteEverythingFromCart($table){
		global $conn;
		$stmt = $conn->prepare("DELETE FROM $table");
		$stmt->execute();
		$result = ($stmt->rowCount() > 0);
		return $result;
	}
	/**
     * Decreses quantity of specific producrt by 1 
     * @param    int
     * @return   bool
     */
	function decreseQuantity($id){
		global $conn;

		$product = getProductByID($id);
		$quantity = $product['quantity'] - 1;
		
		$stmt = $conn->prepare("UPDATE products SET quantity = :quantity WHERE id = :id;");
		$stmt->execute(array(":quantity"=> $quantity, ":id"=> $id));
		$result = ($stmt->rowCount() > 0);
		return $result;
	}
	/**
     * Checks if the new user has arrived and if the user is not registered it creates cart table for them. 
     */
	function userControl(){
	  if (!isset($_SESSION['user_id'])) {
	  	$id = registerNewUser();
	    $_SESSION['user_id'] = $id;
	  }
	}

 ?>
