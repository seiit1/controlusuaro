<?php

function login($username,$pass){
    $sql = "SELECT `id_usuario`, `primer_nombre`, `primer_apellido`,`rol` FROM `usuario` LEFT JOIN `rol` ON usuario.id_rol = rol.id_rol WHERE id_usuario = '".$username."' AND password = '".$pass."'";

    $result = getFormDb($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $_SESSION['username'] = $username;
        $_SESSION['rol'] = $row["rol"];
        
        return true;
    }

    return false;
}

function logout(){
    unset($_SESSION['username']);
    session_destroy();
}

function getUsers(){
    $sql = "SELECT `id_usuario`, `password`, `primer_nombre`, `segundo_nombre`, `primer_apellido`, `segundo_apellido`,usuario.id_rol, `rol` FROM `usuario` LEFT JOIN `rol` ON usuario.id_rol = rol.id_rol;";
    $result = getFormDb($sql);

    if ($result->num_rows > 0) {
        
        while($row = $result->fetch_assoc()) {
            echo "<tr>
            <form action='index.php?action=editUser' method='post'>
                <td><input type='text' class='form-control' id='username' name='username' placeholder='Nombre de usuario' value='".$row["id_usuario"]."'></td>
                <td><input type='text' class='form-control' id='primernombre' name='primernombre' placeholder='Primer nombre' value='".$row["primer_nombre"]."'></td>
                <td><input type='text' class='form-control' id='segundonombre' name='segundonombre' placeholder='Segundo Nombre' value='".$row["segundo_nombre"]."'></td>
                <td><input type='text' class='form-control' id='primerapellido' name='primerapellido' placeholder='Primer apellido' value='".$row["primer_apellido"]."'></td>
                <td><input type='text' class='form-control' id='segundoApellido' name='segundoApellido' placeholder='Segundo apellido' value='".$row["segundo_apellido"]."'></td>
                <td>
                    <select class='form-select' aria-label='Default select example' id='rol' name='rol'>
                        <option value='".$row["id_rol"]."' selected hidden>".$row["rol"]."</option>";
                        getRoles();
                        echo "
                    </select>
                </td>
                <td><button type='submit' class='btn btn-info'>Editar</button>
            </form>
            <form action='index.php?action=deleteUser' method='post'>
                <input id='username' name='username' type='hidden' value='".$row["id_usuario"]."'>
                <td>
                    <button type='submit' class='btn btn-danger'>Eliminar</button>
                </td>
            </form>
            </tr>";            

        }
        
    }
}

function crateUser($id,$pass,$firstNm,$secondNm,$firstAp,$secondAp,$rol){
    if(!checkInsert($id,$pass,$firstNm,$secondNm,$firstAp,$secondAp,$rol)){return false;}
    $sql = "INSERT INTO `usuario`(`id_usuario`, `password`, `primer_nombre`, `segundo_nombre`, `primer_apellido`, `segundo_apellido`,`id_rol`) VALUES ('".$id."','".$pass."','".$firstNm."','".$secondNm."','".$firstAp."','".$secondNm."','".$rol."')";
    modifyDb($sql);
}

function updateUser($id,$firstNm,$secondNm,$firstAp,$secondAp,$rol){
    if(!checkUpdate($id,$firstNm,$secondNm,$firstAp,$secondAp,$rol)){return false;}
    $sql = "UPDATE `usuario` SET `id_usuario`='".$id."',`primer_nombre`='".$firstNm."',`segundo_nombre`='".$secondNm."',`primer_apellido`='".$firstAp."',`segundo_apellido`='".$secondNm."',`id_rol`='".$rol."' WHERE  `id_usuario`='".$id."'";
    modifyDb($sql);
}

function deleteUser($id){
    $sql = "DELETE FROM `usuario` WHERE id_usuario = '".$id."'";
    modifyDb($sql);
}

function checkUpdate($id,$firstNm,$secondNm,$firstAp,$secondAp,$rol){
    echo $firstAp."test";
    if($id == "" || $firstNm == "" || $secondNm == "" || $firstAp == "" || $secondAp == "" || $rol == ""){
        return false;
    }

    if(!getUserId($id)){
        return false;
    }

    return true;
}

function checkInsert($id,$pass,$firstNm,$secondNm,$firstAp,$secondAp,$rol){
    echo $firstAp."test";
    if($id == "" || $pass == "" || $firstNm == "" || $secondNm == "" || $firstAp == "" || $secondAp == "" || $rol == ""){
        return false;
    }

    if(getUserId($id)){
        return false;
    }

    return true;
}

function getUserId($id){
    $sql = "SELECT `id_usuario` FROM `usuario` WHERE id_usuario = '".$id."'";
    $result = getFormDb($sql);

    if ($result->num_rows > 0) {
        return true;
    }else{
        return false;
    }
}

?>