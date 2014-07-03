<?php
include 'controllers/Controller.php';
$handler = new Controller($_GET);
$content = $handler->getDataContent;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Grid CSS</title>
	<link rel="stylesheet" type="text/css" href="resources/css/resetgrid.css">
	<!--<link rel="stylesheet" type="text/css" href="resources/css/jquery-ui.css">-->
	<link rel="stylesheet" type="text/css" href="resources/css/main.css">
    <script type="application/javascript" src="resources/js/jquery.js"></script>
    <script type="application/javascript" src="resources/js/jquery-ui.js"></script>
    <script type="application/javascript" src="resources/js/main.js"></script>
</head>
<body>
	
	<div class="wrapper G12">

		<div class="header G12">
			<h2>Grid CSS Generator</h2>
			<div class="navigation">
				<?php include 'views/parts/navigation.php'; ?>
			</div>
		</div>

		<div class="content G12">
            <?php echo $content; ?>
		</div>

		<div class="footer G12">
			<p>Copyright © 2012-2014 WerdFolio by OL Werdffelynir w-code.ru. All rights reserved. </p>
		</div>

	</div>

</body>
</html>