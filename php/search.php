<?php

    session_start();

    if (isset($_GET['search-form'])){

        $search = $_GET['search-form'];
        require_once('connect.php');
        $connect = $conexion->getConn();
        
        try { 
            
            $sql = "SELECT id, nombre, descripcion, alto, ancho, largo, peso FROM repuesto WHERE nombre LIKE '%$search%' ";
            $resultado = $connect->query($sql);
    

        } catch (Exception $e) {
            $error = $e->getMessage();
        }

        $repuesto = array();
        while($row = mysqli_fetch_array($resultado, MYSQLI_ASSOC)){

            array_push($repuesto, $row);
        }

        if (!empty($repuesto)){ // VALIDO SI SE ENCONTRO ALGO EN LA BUSQUEDA

            $message = ' ';

        }else{

            $message = 'No se han encontrado coincidencias con esta busqueda.';

        }

        mysqli_close($connect);
    }else{

        $message = " ";

    }


    

?>
<!doctype html>
<html lang="es">
  <head>
    <title>BlindingParts ES</title>
    <link rel="shortcut icon" href="../img/brake.png">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Custom CSS-->
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/search.css">
    <!-- CSS Responsive-->
    <link rel="stylesheet" href="../css/responsive.css">
    <!-- Custom Font-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100&display=swap" rel="stylesheet">



  </head>
  <body>

  <div class="pos-f-t fixed-top">
        <div class="collapse" id="navbarToggleExternalContent">
            <div class=" font-weight-bold text-white nav-container">
                <ul class = "nav-list">
                    <li class="nav-item">
                        <?php
                            if (!isset($_SESSION['email'])){
                        ?>
                        <a class="nav-link" href="login.php">Ingresar a mi cuenta autorizada</a>
                        <?php }else{?>
                        <a class="nav-link" href="sign-out.php">Salir de mi cuenta </a>
                        <?php }?>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contactarse con soporte</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="historial.php">Historial de Asignaciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Inicio</a>
                    </li>
                </ul>
                <form class="form-inline mt-3 search-form" style = "margin-left: 60px;" action = "search.php" method = "get">
                    <input class="form-control mr-sm-2" type="search" placeholder="Buscar repuestos..." aria-label="Search" name = "search-form">
                    <button class="btn btn-outline-light my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>
        <nav class="navbar navbar-dark">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
        </nav>
    </div>

    <?php
        if (isset($_SESSION['email'])){
    ?>
    <div class = "fixed-top user-email text-white d-flex justify-content-end p-3 w-50 ml-auto">
        <h4 class = "text-weight-bold"><?php echo $_SESSION['email'];?></h4>
    </div>
    <?php
        }
    ?>

    <div class = "wrapper">
        <div class = "background">
            <div class = "search-tittle mt-5">
                <h1>Resultados de busqueda</h1>
                <form class="form-inline mt-3 search-form" action = "search.php" method = "get">
                    <input class="form-control mr-sm-2" type="search" placeholder="Buscar repuestos..." aria-label="Search" name = "search-form">
                    <button class="btn btn-outline-light my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <?php if (!empty($repuesto)){?>
            <div class = "search-wrapper">
                <?php
                    for ($i=0; $i < count($repuesto) ; $i++) {   
                ?>
                    
                <a href="repuesto.php?id=<?php echo $repuesto[$i]['id']?>" class = "content btn btn-outline-light">
                    <h3 class = "font-weight-bold"><?php echo $repuesto[$i]['nombre'];?></h3>
                    <p><?php echo $repuesto[$i]['descripcion'];?></p>
                    <p>
                        Alto: <?php echo $repuesto[$i]['alto'];?><br>
                        Ancho: <?php echo $repuesto[$i]['ancho'];?><br>
                        Largo: <?php echo $repuesto[$i]['largo'];?><br>
                        Peso: <?php echo $repuesto[$i]['peso'];?>
                    </p>
                </a>
                <?php }?>
            </div>
            <?php }else{?>    
            <div class = "text-white font-weight-bold m-5"><?php echo $message;?></div>
                <?php }?>
           
        </div>
    </div>

    







    <footer class = "font-weight-bold">
      <div class ="footer-lists">
        <ul>
          <li class = "list-project"><a href="footer.php?sel=about"><i class="fas fa-project-diagram"></i> Acerca de este proyecto</a></li>
          <li class = "list-contact"><a href="contact.php"><i class="far fa-paper-plane"></i> Contacto</a></li>
          <li class = "list-legal"><a href="footer.php?sel=legal"><i class="fas fa-file-contract"></i> Legal</a></li>
        </ul>
        <ul>
          <li class = "list-ig"><a href="https://www.instagram.com/Jayggo"><i class = "fab fa-instagram"></i> Instagram</a></li>
          <li class = "list-fb"><a href="https://www.twitter.com/Jairog14"><i class = "fab fa-facebook"></i> Twitter</a></li>
          <li class = "list-github"><a href="https://www.github.com/Jayggo"><i class = "fab fa-github"></i> GitHub</a></li>
        </ul>
      </div>
      <p class ="text-muted copy">&copy 2021 Jairo Gomez</p>
    </footer>





    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>