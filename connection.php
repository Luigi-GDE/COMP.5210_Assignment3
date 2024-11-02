<?php

    include "credentials.php";

    //Database connection
    $connection = new mysqli('localhost', $user, $password, $db);
    
    //Select all records from table
    $AllRecords = $connection -> prepare("select*from scp");
    $AllRecords->execute();
    $result = $AllRecords->get_result();

?>