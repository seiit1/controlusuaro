<?php

function getProyects(){
    $sql = "SELECT `id_proyecto`, `nombre_proyecto`, `descripcion` FROM `proyecto`";
    $result = getFormDb($sql);

    if ($result->num_rows > 0) {
        
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            if($_SESSION['rol'] != "invitado"){
                echo "<form action='index.php?action=editProyect' method='post'>";
            }
            echo "
                <input type='hidden' class='form-control' id='idProyecto' name='idProyecto' placeholder='idProyecto' value='".$row["id_proyecto"]."'>
                <td><input type='text' class='form-control' id='nombreProyecto' name='nombreProyecto' placeholder='Nombre proyecto' value='".$row["nombre_proyecto"]."'";if($_SESSION['rol'] == "invitado"){echo "readonly";} echo "></td>
                <td><textarea class='form-control' id='descripcion' name='descripcion' placeholder='Descripcion' ";if($_SESSION['rol'] == "invitado"){echo "readonly";} echo ">".$row["descripcion"]."</textarea></td>";
            if($_SESSION['rol'] != "invitado"){
                echo "
                <td><button type='submit' class='btn btn-info'>Editar</button>
            </form>
            <form action='index.php?action=deleteProyect' method='post'>
                <input id='idProyecto' name='idProyecto' type='hidden' value='".$row["id_proyecto"]."'>
                <td>
                    <button type='submit' class='btn btn-danger'>Eliminar</button>
                </td>
            </form>";
            }
            echo "</tr>";            
        }
        
    }
}

function crateProyect($name,$desc){
    $sql = "INSERT INTO `proyecto`(`nombre_proyecto`, `descripcion`) VALUES ('".$name."','".$desc."')";
    modifyDb($sql);
}

function updateProyect($id,$name,$desc){
    $sql = "UPDATE `proyecto` SET `nombre_proyecto`='".$name."',`descripcion`='".$desc."' WHERE `id_proyecto`='".$id."'";
    modifyDb($sql);
}

function deleteProyect($id){
    $sql = "DELETE FROM `proyecto` WHERE id_proyecto = '".$id."'";
    modifyDb($sql);
}

?>