<?php View::set_global('page_title', 'Redis'); ?>

<div class="row">
	<div class="col-sm-12">
		<?=HTML::image('/static/img/admin/redis.png', ['style' => 'height: 36px'])?>
		<br><br>

		<div class="row">
			<div class="col-sm-5">
				<div class="well well-sm">
					<h2>Keys</h2>
					<?=View::factory('helper/table_key_value')->set([
						'default_heading' => TRUE,
						'data' => $key_counts
					])?>
				</div>
			</div>

			<div class="col-sm-7">
				<div class="well well-sm">
					<h2>Operations</h2>
					<?=HTML::anchor('admin/system/redis_clear_all', '<i class="glyphicon glyphicon-remove-sign"></i> Clear All', [
						'class' => 'btn btn-danger btn-xs',
					])?>
				</div>

				<div class="well well-sm">
					<h2>Status</h2>
					<?=View::factory('helper/table_key_value')->set([
						'default_heading' => TRUE,
						'data' => $redis_info,
					])?>
				</div>
			</div>
		</div>
	</div>
</div>
