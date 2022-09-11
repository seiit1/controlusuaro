    <?php
    require "coneccion.php";
    require "user.php";
    require "rol.php";
    require "proyect.php";

    session_start();

    $user = "";
    $GLOBALS['urlEmpty'] = false;

    if(isset($_GET["action"])){

        $action = $_GET["action"];

        switch ($action) {
            case 'login':

                $user = $_POST["username"];
                $pass = $_POST["pass"];

                if(login($user,$pass)){
                    echo '<script>alert("Login exitoso")</script>';
                }else{
                    echo '<script>alert("Usuario o contraseña incorrectos")</script>';
                }

                break;

            case 'logout':
                    logout();

                break;

            case 'registerUser':
                $user = $_POST["username"];
                $pass = $_POST["pass"];
                $fisrtName = $_POST["primernombre"];
                $secondName = $_POST["segundonombre"];
                $fisrtape = $_POST["primerapellido"];
                $secondape = $_POST["segundoApellido"];
                $rol = $_POST["rol"];
                if(crateUser($user,$pass,$fisrtName,$secondName,$fisrtape,$secondape,$rol)){
                    header("Location: index.php?action=usuarios");
                }else{
                    header("Location: index.php?action=usuarios&log=Datos incorrectos");  
                }
            break;
                
            case 'editUser':
                $user = $_POST["username"];
                $fisrtName = $_POST["primernombre"];
                $secondName = $_POST["segundonombre"];
                $fisrtape = $_POST["primerapellido"];
                $secondape = $_POST["segundoApellido"];
                $rol = $_POST["rol"];
                
                if(updateUser($user,$fisrtName,$secondName,$fisrtape,$secondape,$rol)){
                    header("Location: index.php?action=usuarios");
                }else{
                    header("Location: index.php?action=usuarios&log=Datos incorrectos");  
                }
            break;

            case 'deleteUser':
                $user = $_POST["username"];
                deleteUser($user);
                header("Location: index.php?action=usuarios");
            break;

            case 'saveProyect':
                $titulo = $_POST["nombreProyecto"];
                $descripcion = $_POST["descripcion"];
                crateProyect($titulo,$descripcion);

                header("Location: index.php?action=proyectos");
            break;
                
            case 'editProyect':
                $id = $_POST["idProyecto"];
                $titulo = $_POST["nombreProyecto"];
                $descripcion = $_POST["descripcion"];;
                
                updateProyect($id,$titulo,$descripcion);

                header("Location: index.php?action=proyectos");
            break;

            case 'deleteProyect':
                $id = $_POST["idProyecto"];
                deleteProyect($id);
                header("Location: index.php?action=proyectos");
            break;
            
            default:
                # code...
                break;
        }
    }

    if(isset($_SESSION['username'])){
        $GLOBALS['urlEmpty'] = true;
        $user = " -> ".$_SESSION['username'];
    }else{
        $GLOBALS['urlEmpty'] = false;
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Administrador de usuarios</title>
        <link rel="stylesheet" href="css/bootstrap-5.2.1-dist/css/bootstrap.min.css">
        <script src="css\bootstrap-5.2.1-dist\js\bootstrap.min.js"></script>
        <script src="css\bootstrap-5.2.1-dist\js\bootstrap.bundle.min.js"></script>

    </head>
    <body>
        <nav class="navbar navbar-expand-lg bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="#">Control de usuarios<?php echo $user?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            
                <?php
                    if($GLOBALS['urlEmpty']){
                        echo '<div class="container-fluid">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">';
                        if( $_SESSION['rol'] == "admin"){
                            echo '
                            <li class="nav-item">
                                <a class="nav-link active text-white" aria-current="page" href="index.php?action=usuarios">Usuarios</a>
                            </li>
                            ';
                        }
                        echo '
                            <li class="nav-item">
                                <a class="nav-link text-white" href="index.php?action=proyectos">Proyectos</a>
                            </li>
                        </ul>
                        ';
                    }            
                ?>
        
            </div>
            <?php
                if(isset($_SESSION['username'])){
                    echo "
                    <form action='index.php?action=logout' method='post'>
                        <button class='btn btn-success' type='submit'>Cerrar</button>
                    </form>
                    ";
                }
            ?>
            
            
        </div>
        </nav>
        <br><br><br><br><br>

        <?php
            if(!$GLOBALS['urlEmpty']){
                echo "
                <form action='index.php?action=login' method='post'>
                    <div class='center-block'>
                        <div class='card col-md-8 mx-auto' style='width: 18rem;'>
                            <img src='css/R.png' class='card-img-top' alt='...'>
                            <div class='card-body'>
                                <h5 class='card-title'>Nombre Usuario</h5>
                                <input type='text' class='form-control' id='username' name='username' placeholder='Nombre de usuario'>
                                <h5 class='card-title'>Contraseña</h5>
                                <input type='password' class='form-control' id='pass' name='pass'>
                            </div>
                            <button type='submit' class='btn btn-primary'>Login</button>
                        </div>
                    </div>
                </form>
                ";
            }

            if($GLOBALS['urlEmpty']){
                if( $_SESSION['rol'] == "admin" && isset($_GET["action"]) && $_GET["action"] == "usuarios"){
                    echo "
                    <div style='width:40%;float:left;' >
                        <form action='index.php?action=registerUser' method='post'>
                            <div class='card col-md-5 mx-auto' style='width: 18rem;'>
                            <h2 class='card-title'>Nuevo Usuario</h2>
                            
                                <div class='card-body'>
                                    <h5 class='card-title'>Nombre Usuario</h5>
                                    <input type='text' class='form-control' id='username' name='username' placeholder='Nombre de usuario'>
                                    <h5 class='card-title'>Contraseña</h5>
                                    <input type='password' class='form-control' id='pass' name='pass'>
                                    <h5 class='card-title'>Primer nombre</h5>
                                    <input type='text' class='form-control' id='primernombre' name='primernombre' placeholder='Primer nombre'>
                                    <h5 class='card-title'>Segundo nombre</h5>
                                    <input type='text' class='form-control' id='segundonombre' name='segundonombre' placeholder='Segundo Nombre'>
                                    <h5 class='card-title'>Primer apellido</h5>
                                    <input type='text' class='form-control' id='primerapellido' name='primerapellido' placeholder='Primer apellido'>
                                    <h5 class='card-title'>Segundo apellido</h5>
                                    <input type='text' class='form-control' id='segundoApellido' name='segundoApellido' placeholder='Segundo apellido'>
                                    <h5 class='card-title'>Rol</h5>
                                    <select class='form-select' aria-label='Default select example' id='rol' name='rol'>";
                                    getRoles();
                                    echo "
                                    </select>
                                </div>
                                <button type='submit' class='btn btn-primary'>Registrar</button>
                            </div>
                        </form>
                    </div>";

                    if(isset($_GET["log"])){
                        echo "
                            <div style='width:60%;float:left;'>
                                <div class='card col-md-7 style='width:90%;'>
                                    <h2 class='card-title'>Log</h2>
                                    <table class='table'>
                                        <thead>
                                            <tr>
                                                <th scope='col'>Descripcion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <form action='index.php?action=saveProyect' method='post'>
                                                    <td><textarea class='form-control' id='descripcion' name='descripcion' placeholder='Descripcion' readonly>".$_GET["log"]."</textarea></td>
                                                </form>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>";
                    }

                    echo "
                    <div style='width:60%;float:left;' >
                        <div class='card col-md-7' style='width:90%;'>
                            <table class='table'>
                                <thead>
                                    <tr>
                                    <th scope='col'>Nombre usuario</th>
                                    <th scope='col'>Primer nombre</th>
                                    <th scope='col'>Segundo nombre</th>
                                    <th scope='col'>Primer apellido</th>
                                    <th scope='col'>Segundo apellido</th>
                                    <th scope='col'>Rol</th>
                                    <th scope='col'>Editar</th>
                                    <th scope='col'>Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody>";

                                        getUsers();

                                echo"
                                </tbody>
                            </table>
                        </div>
                    </div>
                    ";
                }  
            }

            if($GLOBALS['urlEmpty']){
                if( isset($_GET["action"]) && $_GET["action"] == "proyectos"){
                    if($_SESSION['rol'] != "invitado"){
                        echo "
                            <div>
                                <div class='card col-md-7 mx-auto' style='width:90%;'>
                                    <h2 class='card-title'>Proyectos</h2>
                                    <table class='table'>
                                        <thead>
                                            <tr>
                                                <th scope='col'>Nombre proyecto</th>
                                                <th scope='col'>Descripcion</th>
                                                <th scope='col'>Insertar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <form action='index.php?action=saveProyect' method='post'>
                                                    <td><input type='text' class='form-control' id='nombreProyecto' name='nombreProyecto' placeholder='Nombre proyecto'></td>
                                                    <td><textarea class='form-control' id='descripcion' name='descripcion' placeholder='Descripcion'></textarea></td>
                                                    <td><button type='submit' class='btn btn-primary'>Guardar</button>
                                                </form>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>";
                    }
                    
                    echo "
                    <div>
                        <div class='card col-md-7 mx-auto' style='width:90%;'>
                            <h2 class='card-title'>Proyectos</h2>
                            <table class='table'>
                                <thead>
                                    <tr>
                                    <th scope='col'>Nombre proyecto</th>
                                    <th scope='col'>Descripcion</th>";
                                    if($_SESSION['rol'] != "invitado"){
                                        echo "
                                            <th scope='col'>Editar</th>
                                            <th scope='col'>Eliminar</th>
                                        ";
                                    }
                                    echo "
                                    </tr>
                                </thead>
                                <tbody>";

                                    getProyects();

                                echo"
                                </tbody>
                            </table>
                        </div>
                    </div>
                    ";
                }  
            }

            if($GLOBALS['urlEmpty']){
                if( isset($_GET["action"]) && $_GET["action"] == "login"){
                    echo "
                        <div class='center-block'>
                            <div class='card col-md-8 mx-auto'>
                                <h2 class='card-title'>Bienvenido usa la barra de navegacion</h2>
                                <h2 class='card-title'>para acceder a las opciones</h2>
                                <img src='css/f4_generated.jpg' class='card-img-top' alt='...'>
                            </div>
                        </div>
                    ";
                }
            }
        ?>

    </body>
    </html>
