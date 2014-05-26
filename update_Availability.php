<?php
//Update the register table about availability of the applications
	// MySql connection
    include ('connection.php');

    $connection = new createConnection(); //i created a new object
    $connection->connectToDatabase(); // connected to the database
    $connection->selectDatabase();// closed connection

    $state = $_POST['state'];
    $application_ID = $_POST['uuid'];

    if($state=="true")
    {
    	//Change the application state to false
	    mysqli_query($connection ->myconn,"UPDATE register SET availability= 'true' WHERE uuid = '$application_ID'");
    }
    else
    {
	    //Change the application state to false
	    mysqli_query($connection ->myconn,"UPDATE register SET availability= 'false' WHERE uuid = '$application_ID'");
    }
?>