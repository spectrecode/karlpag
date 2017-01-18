<?php
include('config/conexion.php');
include('modelo/funciones.php');
include('modelo/noticia.php');
include('modelo/categoria.php');
include('modelo/globales.php');

//****Capturando las variables**** 
$objfunc  = new misFunciones();
$codcat   = $objfunc->sanitize($_GET['codigo']);
$codcategoria = $codcat;
//****Pintamos la noticia destacada*******
$rutaImg = _URL_."adminkarl/resources/assets/image/noticias/";
$objdest  = new Noticia();
$datadest   = $objdest->noticiaDestacada($_GET['codigo'],0,1);
$codigo     = $datadest[0]['art_id'];
//var_dump($datadest);
$boolnot    = count($datadest) - 1;
if ($boolnot >= 0){
    $boolnot = true;
}else{
    $boolnot = false;   
}
//echo $boolnot;
$titulo     = $datadest[0]['art_nombre'];
$des_corta     = $objfunc->convertir_html($datadest[0]['art_descripsuperior']);
$categoria     = $datadest[0]['namecategoria'];
$f_publicacion = $datadest[0]['art_fechapublicacion'];

$nameurl_seo   = $datadest[0]['nameurl_seo'];
$imgportada   = "background-image: url(".$rutaImg.$datadest[0]['art_imgportada'].")";

//*****Pintamos las noticias que pertenecen a una categoria****/
$objnot     = new Categoria();
$datanot    = $objnot->dameListado(1,'',0,0,$codcat);
$num_total_registros = count($datanot);
$stylemas = "";


$not_num = 8; //empezamos mostrando 8 noticias
if ($num_total_registros <= $not_num)
    $stylemas = "style='display:none'";
$objnot  = new Noticia();
$datanot   = $objnot->noticiaDestacada($_GET['codigo'],1,$not_num);
$item = count($datanot) - 1;
$html_not = ""; 
$classrow = "";
$itemrow = 1;
$styleImg = "";
for($i=0;$i<=$item;$i++){
    $not_codigo     = $datanot[$i]['art_id'];
    $not_titulo     = $datanot[$i]['art_nombre'];
    $not_des_corta       = $objfunc->convertir_html($datanot[$i]['art_descripsuperior']);
    $not_categoria       = $datanot[$i]['namecategoria'];
    $not_f_publicacion   = $datanot[$i]['art_fechapublicacion'];
    $for_f_publica       = $objfunc->postFecha($not_f_publicacion);
    $not_nameurl_seo     = $datanot[$i]['nameurl_seo'];
    $not_imgportada      = $datanot[$i]['art_imgportada'];
    //echo "<br />";
    if ($itemrow > 2){
        $classrow = $classrow;
        $itemrow = 1;
        if ($classrow!="blanco")
            $styleImg = "style='background-image: url(".$rutaImg.$not_imgportada.")'";
    }else{
        if ($classrow == ""){
            $classrow = "blanco";
            $styleImg = "";
        }else{
            $classrow = "";
            $styleImg = "style='background-image: url(".$rutaImg.$not_imgportada.")'";
        }
    }
    $itemrow++;
    $html_not.= "<div class='col-lg-6 col-sm-6 col-xs-12'>";
    $html_not.= "<div class='row'>";
    $html_not.= "<div class='noticia-categoria $classrow' ".$styleImg.">";
    $html_not.= "<div class='sombra' style='width:100%;height:100%;background-color:rgba(0,25,45,0.8);top:0;left:0;position:absolute;'></div><div style='position:relative;'><h4><i class='fa fa-caret-left' aria-hidden='true'></i> ".$not_categoria." <i class='fa fa-caret-right' aria-hidden='true'></i></h4>";
    $html_not.= "<h3>".$not_titulo."</h3>";
    $html_not.= $not_des_corta;
    $html_not.= "<span class='fecha'>".$for_f_publica."</span>";
    $html_not.= "<a href='noticias/".$not_nameurl_seo."' class='leer-mas'>Leer más <i class='fa fa-long-arrow-right' aria-hidden='true'></i></a></div>";
    $html_not.= "</div>";
    $html_not.= "</div>";
    $html_not.= "</div>";
}
?>
<!DOCTYPE html>
<html lang="es" ng-app="karlMaslo">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Karl Maslo | <?php echo $categoria; ?></title>
    <meta name="description" content="" />
    <link href="<?php echo _URL_;?>img/logo-karl.jpg" rel="shortcut icon">
    <link href="<?php echo _URL_;?>css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo _URL_;?>css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .blanco .sombra{
            display: none;
        }
    </style>
</head>
<body>
    
    <?php include('header.php'); ?>
    <?php
        if ($boolnot == true){
    ?>
    <div class="container-fluid text-center" id="home-categoria" style="position:relative;<?php echo $imgportada; ?>">
        <div class="container">
            <div class="sombra" style="width:100%;height:100%;background-color:rgba(0,25,45,0.8);top:0;left:0;position:absolute;"></div>
            <div style="position:relative;">
                <h2><?php echo $titulo;?></h2>
                <?php echo $des_corta; ?>
                <a href="noticias/<?php echo $nameurl_seo?>">Seguir leyendo</a> <a href="noticias/<?php echo $nameurl_seo?>">Más publicaciones</a>
            </div>
        </div>
    </div>
    
    <div class="container-fluid" id="contenido-categoria">
        
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-lg-offset-1 col-sm-12 col-xs-12">
                    <div class="row">
<!-- <div class="panel-categoria" ng-controller="categoriaNotCrtl"> -->
                        <div class="panel-categoria">
                            <?php echo $html_not; ?>
                            <div style="border:1px solid #000">
         <!-- <div class="col-lg-6 col-sm-6 col-xs-12" ng-repeat="post in datos"> -->
                                <div class="col-lg-6 col-sm-6 col-xs-12">
                                    <div class="row">
                                        <div class="noticia-categoria {{post.classrow}}" style="{{post.backgroundimage}}">
                                            <div class="sombra" style="width:100%;height:100%;background-color:rgba(0,25,45,0.8);top:0;left:0;position:absolute;"></div>
                                            <!-- <div style="position:relative;">
                                                <h4><i class="fa fa-caret-left" aria-hidden="true"></i>{{post.namecategoria}}<i class="fa fa-caret-right" aria-hidden="true"></i></h4>
                                                <h3>{{post.titulo}}</h3>
                                                <div ng-bind-html="post.descripsuperior"></div>
                                                <span class="fecha">{{post.for_f_publica}}</span>
                                                <a href="noticias/{{post.nameurl_seo}}" class="leer-mas">Leer más <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <a href="javascript:void(0)" <?php echo $stylemas; ?> ng-click="paginarPost(<?php echo $codcat?>)" id="mas"><i class="fa fa-plus" aria-hidden="true"></i></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
       
    </div>
     <?php }?>
    <?php include('footer.php'); ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="<?php echo _URL_;?>adminkarl/bower_components/angular/angular.min.js"></script>
    <script src="<?php echo _URL_;?>adminkarl/bower_components/angular-sanitize/angular-sanitize.js"></script>
    <script src="<?php echo _URL_;?>js/init.js"></script>
    <script src="<?php echo _URL_;?>js/controller/controller.js"></script>
    <script src="<?php echo _URL_;?>js/app.js"></script>
    
</body>
</html>