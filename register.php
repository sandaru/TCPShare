<?php
//Register new user in to "register" table
	// MySql connection
    include ('connection.php');

    $uuid = $_POST['uuid'];
    $username = $_POST['email'];

    $connection = new createConnection(); //i created a new object
    $connection->connectToDatabase(); // connected to the database
    $connection->selectDatabase();// closed connection

    mysqli_query($connection->myconn,"INSERT INTO register(user_name,uuid,availability) VALUES('$username','$uuid','false')");

?>