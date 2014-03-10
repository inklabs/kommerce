<!DOCTYPE html>
<html lang="en">
<head>
	<title><?=$page_title?></title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<?=HTML::style('static/flags/flags.css')?>
	<?=HTML::style('static/css/bootstrap-3.1.1.css')?>
	<?=HTML::style('static/css/admin_layout.css')?>

	<?=HTML::script('static/js/jquery-1.11.0.js')?>
	<?=HTML::script('static/js/bootstrap-3.1.1.js')?>
</head>
<body>
	<div id="body">
		<div class="container">
			<?=$content?>
		</div>
	</div>

	<div id="footer">
		<div class="container">
			<?php if (Kommerce::is_dev()) { ?>
				<?=View::factory('profiler')?>
			<?php } ?>
		</div>
	</div>
</body>
</html>
