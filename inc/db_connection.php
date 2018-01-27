<?php 
	//create a database connection
	$hostName="localhost";
	$userName="axi7027";
	$password="propertyfifty"; 
	$DBName="axi7027";

	try {
		//open a connection
		$conn = new PDO("mysql:host=$hostName;dbname=$DBName",$userName,$password);
		$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

	} catch(PDOException $e) {
		echo $e->getMessage();
	}
	
?>