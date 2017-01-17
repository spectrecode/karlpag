<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-89942102-1', 'auto');
  ga('send', 'pageview');

</script>
<?php
$activemenu = "";
if (!isset($codcategoria)){
	$codcategoria = -1;
}
?>
<header class="container-fluid">
	<div class="container">
		<div class="row">
			<a class="inline-left" href="<?php echo _URL_;?>"><img src="<?php echo _URL_;?>img/logo-karl.jpg" alt=""></a>
			<nav class="inline-right">
				<ul>
					<li><a class="md1" href="<?php echo _URL_ ?>">Inicio</a></li>
					<li><a class="md2 <?php echo ($codcategoria == 1) ? 'active' : '' ?>" href="<?php echo _URL_ ?>innovacion">Innovación</a></li>
					<li><a class="md3 <?php echo ($codcategoria == 2) ? 'active' : '' ?>" href="<?php echo _URL_ ?>industria-del-gas">Industria del Gas</a></li>
					<li><a class="md4 <?php echo ($codcategoria == 3) ? 'active' : '' ?>" href="<?php echo _URL_ ?>actualidad">Actualidad</a></li>
					<li><a class="md5 <?php echo (($codcategoria == 4) ) ? 'active' : '' ?>" href="<?php echo _URL_ ?>servicio-a-la-mineria">Servicio a la Minería <i class="fa fa-caret-down" aria-hidden="true"></i></a>
						<ul>
							<li><a class="<?php echo ($codcategoria == 5) ? 'active' : '' ?>" href="<?php echo _URL_ ?>seguridad">Seguridad</a></li>
						</ul>
					</li>
				</ul>
			</nav>
		</div>
	</div>
	<i id="menu-co" class="visible-xs fa fa-bars fa-lg" aria-hidden="true"></i>
</header>