<!--==============================head=================================-->
<head>
	<?php
	include_once 'head.html';
	?>
	<title>GAMO: Event List</title>
</head>
	<body class="" id="top">
		<div class="main">
			<!--==============================header=================================-->
			<?php
			include_once 'header.html';
			?>
			<!--Funció canvi Current-->
			<script type="text/javascript">
				$(document).ready(function() {
					//Remou current de tots i inclou a l'actual.
					$(".li1").attr("class","li1");
					$(".li2").attr("class","li2 current");
					$(".li3").attr("class","li3");
				});
			</script>
<!--==============================Content=================================-->
			<div class="content">
				<div class="container_12">
					<!--<div class="grid_12">
						<h3 class="h3__head1">Race Calendar</h3>
						<div class="custom-month-year">
							<div class="dateHolder">
								<span id="custom-month" class="custom-month"></span>
								<span id="custom-year" class="custom-year"></span>
							</div>
							<nav class="_nav">
								<span id="custom-prev" class="custom-prev"></span>
								<span id="custom-next" class="custom-next"></span>
							</nav>
						</div>
						<div id="calendar" class="fc-calendar-container"></div>
					</div>
					<div class="clear"></div>-->
				</div>
			</div>
		</div>
		<!--==============================footer=================================-->
		<footer>
		<?php
			include_once 'footer.html';
		?>
		</footer>
		<script type="text/javascript" src="js/jquery.calendario.js"></script>
		<script type="text/javascript" src="js/data.js"></script>
		<!--<script type="text/javascript">
			$(function() {
				var cal = $( '#calendar' ).calendario( {
					onDayClick : function( $el, $contentEl, dateProperties ) {
						for( var key in dateProperties ) {
							console.log( key + ' = ' + dateProperties[ key ] );
						}
					},
					caldata : codropsEvents
				} ),
				$month = $( '#custom-month' ).html( cal.getMonthName() ),
				$year = $( '#custom-year' ).html( cal.getYear() );
				$( '#custom-next' ).on( 'click', function() {
					cal.gotoNextMonth( updateMonthYear );
				} );
				$( '#custom-prev' ).on( 'click', function() {
					cal.gotoPreviousMonth( updateMonthYear );
				} );
				$( '#custom-current' ).on( 'click', function() {
					cal.gotoNow( updateMonthYear );
				} );
				function updateMonthYear() {
					$month.html( cal.getMonthName() );
					$year.html( cal.getYear() );
				}
			});
		</script>-->
	</body>
</html>