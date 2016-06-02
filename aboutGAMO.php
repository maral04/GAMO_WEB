<!--==============================head=================================-->
<head>
	<?php
	include_once 'head.php';
	?>
	<title>GAMO: About GAMO</title>
</head>
	<body class="" id="top">
		<div class="main">
			<!--==============================header=================================-->
			<?php
			include_once 'header.php';
			?>
<!--==============================Content=================================-->
			<div class="content">
				<div class="container_12">
					<h3 class="h3__head1">About Gamo</h3>
					<div>
						<iframe width="95%" height="85%" frameborder="0" src="presentacio.html"></iframe>
					</div>
					<div class="clear"></div>
				</div>
			</div>
		</div>
<!--==============================footer=================================-->
		<footer>
			<?php
			include_once 'footer.html';
			?>
		</footer>
	</body>
<!--Funció canvi Current-->
<script type="text/javascript">
	$(document).ready(function() {
		//Remou current de tots i inclou a l'actual.
		$(".li2").attr("class","li2");
		$(".li3").attr("class","li3 current");
	});
</script>
</html>

