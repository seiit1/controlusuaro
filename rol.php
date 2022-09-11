<?php


function getRoles(){
    $sql = "SELECT * FROM `rol`";

    $result = getFormDb($sql);

    if ($result->num_rows > 0) {

        while($row = $result->fetch_assoc()) {                            
              echo "<option value='".$row["id_rol"]."'>".$row["rol"]."</option>";
        }

    } 
}



?>