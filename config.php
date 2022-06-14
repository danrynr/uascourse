<?php
    $db_user = 'dan';
    $db_pass = 'Sourbread012&*';
    $db_host = 'localhost';
    $db_name = 'advwp_uascourse';

    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

    if (mysqli_connect_error()) {
        die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
    }
?>