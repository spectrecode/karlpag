<?php
include('config/conexion.php');
include('modelo/funciones.php');
include('modelo/noticia.php');
include('modelo/globales.php');

$objfunc 	= new misFunciones();
/***Obtenemos la informacion de bibliorafia***/
$objbiblio 	= new Noticia();
$databiblio = $objbiblio->detalleBibliografia();
$descriptionBilio = $objfunc->convertir_html($databiblio[0]['art_descripsuperior']);
$codigo = $objfunc->convertir_html($databiblio[0]['art_id']);
$imgportada	= $databiblio[0]['art_imgportada'];
?>
<!DOCTYPE html>
<html lang="es" ng-app="karlMaslo">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Karl Maslo - CEO regional de EXSA S.A.</title>
    <meta name="description" content="Quiero compartir con ustedes mis opiniones y conocimientos sobre la industria Petroquímica, la industria del gas, la innovación y el sector minero en nuestro país." />
    <meta name="keywords" content="Petroquímica en el Perú,Desarrollo de la innovación,Industria del gas en el perú">
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
    	.par .sombra{
    		display: none;
    	}
    </style>
</head>
<body>
	
	<?php include('header.php'); ?>

	<div class="container-fluid" id="home">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 col-lg-offset-1 col-md-12 col-sm-12 col-xs-12">
					<div class="row">
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
							<img src="<?php echo _URL_;?>adminkarl/resources/assets/image/bibliografia/<?php echo $imgportada?>" alt="">
						</div>
						<div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
							<h1><b>K</b>ARL<br> <b>M</b>ASLO</h1>
							<?php echo $descriptionBilio; ?>
							<a href="<?php echo _URL_;?>karl-maslo">Seguir leyendo</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container-fluid" id="contenido" ng-controller="inicioCrtl">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
					<div class="row">
						<div class="col-lg-12 col-sm-12 col-xs-12 fondo-lista">
							
							<div class="row" ng-repeat="post in datos">
								<div class="noticia-mini {{post.class}}" style="{{post.backgroundimage}}" >
									<div class="sombra" style="width:100%;height:100%;background-color:rgba(0,25,45,0.8);top:0;left:0;position:absolute;"></div>
									<div class="categoria">
										<a href="<?php echo _URL_;?>{{post.urlcategoria}}"><i class="fa fa-newspaper-o" aria-hidden="true"></i><span>{{post.namecategoria}}</span></a>
									</div>
									<div class="col-lg-12 col-sm-12 col-xs-12 text-center">
										<h2>{{post.titulo}}</h2>
										<div ng-bind-html="post.descripsuperior"></div>
									</div>
									<div class="col-lg-6 col-sm-6 col-xs-12 text-left">
										<span class="fecha">{{post.for_f_publica}}</span>
									</div>
									<div class="col-lg-6 col-sm-6 col-xs-12 text-right">
										<a href="<?php echo _URL_;?>noticias/{{post.nameurl_seo}}" class="leer-mas">Leer más <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
									</div>
								</div>
							</div>

							<div class="row" id="vermasPost">
								<a href="javascript:void(0)" ng-click="paginarPost(numpage)" class="ver-mas">Ver más &nbsp;&nbsp;<i class="fa fa-angle-down" aria-hidden="true"></i></a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
					<aside>
						<div class="col-lg-12 col-sm-12 col-xs-12">
							<h3>PUBLICACIONES<br><b>POPULARES</b></h3>
						</div>
						<div class="col-lg-12 col-sm-12 col-xs-12">
							<div class="row noticia-popular" ng-repeat="post2 in datos2">
								<img src="<?php echo _URL_;?>adminkarl/resources/assets/image/noticias/{{post2.imgportada}}" alt="">
								<h2>{{post2.titulo}}</h2>
								<a href="<?php echo _URL_;?>noticias/{{post2.nameurl_seo}}">Leer más</a>
							</div>
							<div class="row" id="vermasPost2">
								<a href="javascript:void(0)" class="ver-mas" ng-click="paginarPost2(numpage2)">Ver más &nbsp;&nbsp;<i class="fa fa-angle-down" aria-hidden="true"></i></a>
							</div>
						</div>
					</aside>
				</div>
			</div>
		</div>
	</div>

	<?php include('footer.php'); ?>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="<?php echo _URL_;?>adminkarl/bower_components/angular/angular.min.js"></script>
	<script src="<?php echo _URL_;?>adminkarl/bower_components/angular-sanitize/angular-sanitize.js"></script>
	<script src="<?php echo _URL_;?>js/init.js"></script>
	<script src="<?php echo _URL_;?>js/controller/controller.js"></script>
	<script src="<?php echo _URL_;?>js/app.js"></script>
    <script>
    $(document).ready(function($){
      $('.md1').addClass("active");
    });
    </script>
</body>
</html>