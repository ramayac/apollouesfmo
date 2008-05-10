<!DOCTYPE html PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html>
    <head>
        <meta name="generator" content="HTML Tidy, see www.w3.org">
		<meta content="text/html">
        <title>UES FMO - Unidad de Postgrados</title>
		<link type="text/css" rel="stylesheet" href="Media/main.css">
		<link type="text/css" rel="stylesheet" href="Media/transpWidgets.css">
		<link type="text/css" rel="stylesheet" href="Media/forms.css">
		<script type="text/javascript" src="mootools.js"></script>
		<script type="text/javascript" scr="demo.js"></script>
		<?php require_once("lib/VisualUsuario.php"); ?>
    </head>
    <body>
    	<div id="fondoPrincipal">
    		<div id="contenidoPrincipal">
    			<div id="loginBox">
    				<?php 
						$vuser = new VisualUsuario();
						$vuser->Show();
					?>
				</div>
				<div class="WidgetListLeft">
					<div class="WidgetLeft">
						<div class="WidgetTitle">Novedades en la Unidad</h3></div>
						<div class="WidgetContent">
							<p>widget1</p>
						</div>
					</div>
					<div class="WidgetLeft">
						<div class="WidgetTitle">Novedades en Foro</h3></div>
						<div class="WidgetContent">
							<p>widget2</p>
						</div>
					</div>					
				</div>
				<div class="WidgetListRight">
					<div class="WidgetRight">
						<div class="WidgetTitle">Cursos Actuales y Proximos</h3></div>
						<div class="WidgetContent">
							<p>widget3</p>
						</div>
					</div>
					<div class="WidgetRight">
						<div class="WidgetTitle">Acerca de la Unidad</h3></div>
						<div class="WidgetContent">
							<p>widget4</p>
						</div>
					</div>
				</div>
    		</div>
    	</div>
    </body>
</html>

