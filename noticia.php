<?php
include('config/conexion.php');
include('modelo/funciones.php');
include('modelo/noticia.php');
include('modelo/categoria.php');
include('modelo/globales.php');
//****Capturando las variables**** 
$objfunc  = new misFunciones();
$url_seo  = $objfunc->sanitize($_GET['not_url']);

$url_seo = $objfunc->convertir_html($url_seo);

$objnot  = new Noticia();
$codcat   = $objnot->dameCodigo($url_seo);

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
$for_f_publica  = $objfunc->postFecha($f_publicacion);
if ($datanot[0]['tca_cat_id'] == 1)
    $urlcategoria  = "innovacion.html";
if ($datanot[0]['tca_cat_id'] == 2)
    $urlcategoria  = "industria-del-gas.html";
if ($datanot[0]['tca_cat_id'] == 3)
    $urlcategoria  = "actualidad.html";
if ($datanot[0]['tca_cat_id'] == 4)
    $urlcategoria  = "servicio-a-la-mineria.html";
if ($datanot[0]['tca_cat_id'] == 5)
    $urlcategoria  = "seguridad.html";

//***** traemos todas las noticias que pertenecen a esa categoría

$objlistnot   = new Noticia();
$objlistado   = $objlistnot->dameListCategoria($codcategoria);
$itemlist     = count($objlistado) - 1;
$htmllist = "";
$rutaImg = _URL_."adminkarl/resources/assets/image/noticias/";
for ($i=0;$i<=$itemlist;$i++){
    $datanot2 = $objlistado[$i];
    $list_codigo         = $datanot2['art_id'];
    $list_namecategoria  = $datanot2['namecategoria'];
    $list_titulo         = $datanot2['art_nombre'];
    $list_des_corta      = $objfunc->convertir_html($datanot2['art_descripsuperior']);
    $list_frase          = $objfunc->convertir_html($datanot2['art_frase']);
    $list_tipomul        = $datanot2['art_tipomultimedia'];
    $list_imagen         = $datanot2['art_imggrande'];
    $list_video          = $datanot2['art_video'];
    $list_f_publicacion  = $datanot2['art_fechapublicacion'];
    $list_imgportada     = $datanot2['art_imgportada'];
    $list_nameurl_seo    = $datanot2['nameurl_seo'];
    $styleImg = "style='background-image: url(".$rutaImg.$list_imgportada.")'";

    $htmllist.= "<div class='item'>";
    $htmllist.= "<div class='noticia-ver' ".$styleImg."><div class='sombra' style='width:100%;height:100%;background-color:rgba(0,25,45,0.8);top:0;left:0;position:absolute;'></div>
            ";
    $htmllist.= "<div style='position:relative;'><h3>".$list_titulo."</h3>";
    $htmllist.= $list_des_corta;
    $htmllist.= "<a href='"._URL_."noticias/".$list_nameurl_seo."' class='leer-mas'>Leer más <i class='fa fa-long-arrow-right' aria-hidden='true'></i></a></div>";
    $htmllist.= "</div>";
    $htmllist.= "</div>";
}


?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Karl Maslo | Home</title>
    <meta name="description" content="" />
    <link href="<?php echo _URL_;?>img/logo-karl.jpg" rel="shortcut icon">
    <link href="<?php echo _URL_;?>css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo _URL_;?>css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo _URL_;?>css/owl.carousel.css">
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
                            <a href="<?php echo _URL_.$urlcategoria ?>"><i class="fa fa-newspaper-o" aria-hidden="true"></i><span style="left: 80px;width: 190px;text-align: left;"><?php echo $namecategoria; ?></span></a>
                        </div>
                        <a href="javascript:history.back(1)" class="volver">VOLVER</a>
                        <h1><?php echo $titulo?></h1>
                        <div class="subtitulo">
                            <?php echo $frase ?>
                        </div>
                        <img src="<?php echo _URL_;?>adminkarl/resources/assets/image/noticias/<?php echo $imagen;?>" alt="">
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
                        <div class="col-lg-6 col-sm-6 col-xs-12 text-right">
                            <span class="fecha"><?php echo $for_f_publica; ?></span>
                        </div>                        
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12 text-center">
                            <h2>También puedes ver</h2>
                        </div>
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="row">
                                <i class="flechas-noticia fa fa-angle-left" aria-hidden="true" id="flecha-left"></i>
                                <div id="owl-demo">
                                    <?php echo $htmllist; ?>
                                </div>
                                <i class="flechas-noticia fa fa-angle-right" aria-hidden="true" id="flecha-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="<?php echo _URL_;?>js/owl.carousel.min.js"></script>
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
    <script src="<?php echo _URL_;?>js/app.js"></script>
</body>
</html>