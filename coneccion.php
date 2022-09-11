<?php

$GLOBALS['conn'] = null;

function openDb(){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db="sistem_control_usuario";

    $GLOBALS['conn'] = new mysqli($servername, $username, $password,$db);

    if ($GLOBALS['conn']->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

}

function closeDb(){
    $GLOBALS['conn']->close();
}


function modifyDb($sql){

    openDb();

    if ($GLOBALS['conn']->query($sql) === TRUE) {
        echo '<script>alert("Registro exitoso")</script>';
    } else {
        echo '<script>alert("Registro fallido")</script>';
    }

    closeDb();
}

function getFormDb($sql){
    openDb();
    
    $result = $GLOBALS['conn']->query($sql);

    closeDb();
    return $result;
}





?> 