<?php
include('config/conexion.php');
include('modelo/funciones.php');
include('modelo/noticia.php');
include('modelo/categoria.php');
include('modelo/globales.php');

//****Capturando las variables**** 
$objfunc  = new misFunciones();
$codcat   = $objfunc->sanitize($_GET['codigo']);

$objnot  = new Noticia();
$datanot        = $objnot->dameDetalle($codcat);
$codigo         = $datanot[0]['art_id'];
$codcategoria   = $datanot[0]['tca_cat_id'];
$namecategoria   = $datanot[0]['namecategoria'];
$titulo         = $datanot[0]['art_nombre'];
$descripcion    = $objfunc->convertir_html($datanot[0]['art_descripinferior']);
$frase          = $objfunc->convertir_html($datanot[0]['art_frase']);
$tipomul        = $datanot[0]['art_tipomultimedia'];
$imagen         = $datanot[0]['art_imggrande'];
$video          = $datanot[0]['art_video'];
$f_publicacion  = $datanot[0]['art_fechapublicacion'];

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Karl Maslo | Home</title>
    <meta name="description" content="" />
    <link href="img/logo-karl.jpg" rel="shortcut icon">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/owl.carousel.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<style>
    .subtitulo > p{
        font-family: 'Lato';
        font-style: italic;
        font-weight: 200;
        font-size: 18px;
        color: #808080;
        text-align: center;
    }
    .body-noti p a{
        color: #4c4c93;
        font-family: 'Lato';
        font-weight: 400;
    } 
</style>
<body>
	
	<?php include('header.php'); ?>

    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div id="noticia-body">
                    <div class="row">
                        <div class="categoria">
                            <a href="javascript:void(0)"><i class="fa fa-newspaper-o" aria-hidden="true"></i><span><?php echo $namecategoria; ?></span></a>
                        </div>
                        <a href="javascript:history.back(1)" class="volver">VOLVER</a>
                        <h1><?php echo $titulo?></h1>
                        <div class="subtitulo">
                            <?php echo $frase ?>
                        </div>
                        <img src="adminkarl/resources/assets/image/bibliografia/<?php echo $imagen;?>" alt="">
                        <div class="body-noti">
                            <?php echo $descripcion; ?>
                        </div>
                        <!--ul>
                            <li>Fuente:</li>
                            <li>Gestion.pe <a href="">Link</a></li>
                            <li>Reuters América Latina <a href="">Link</a></li>
                            <li>El Economista.com <a href="">Link</a></li>
                            <li>La Tercera.com <a href="">Link</a></li>
                        </ul-->
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-sm-6 col-xs-12 text-left">
                            <div class="row">
                                <ol>
                                    <li>Compartir</li>
                                    <li><a href="https://www.linkedin.com/in/karl-maslo-7183718?authType=&authToken=&trk=mp-allpost-aut-name" target="_blanck"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                                    <li><a href="https://twitter.com/KarlMaslo" target="_blanck"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                </ol>
                            </div>
                        </div>
                        <!--div class="col-lg-6 col-sm-6 col-xs-12 text-right">
                            <span class="fecha"><?php echo $f_publicacion; ?></span>
                        </div-->                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script>
        
    $(document).ready(function() {
     
      var owl = $("#owl-demo");

      owl.owlCarousel({
     
          autoPlay: 2000, //Set AutoPlay to 3 seconds
     
          items : 2,
          itemsDesktop : [1199,2],
          itemsDesktopSmall : [979,2]
     
      });

        $("#flecha-left").click(function(){
            owl.trigger('owl.next');
        })
        $("#flecha-right").click(function(){
            owl.trigger('owl.prev');
        })
    });

    </script>
    <script src="js/app.js"></script>
</body>
</html>