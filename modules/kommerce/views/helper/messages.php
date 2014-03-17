<div id="messages">
	<div class="container">
		<div class="row">
			<?php if(Session::has_started() && Message::count() > 0) { ?>
				<div class="col-md-10 col-md-offset-1"><?=Message::output()?></div>
			<?php } ?>
		</div>
	</div>
</div>
