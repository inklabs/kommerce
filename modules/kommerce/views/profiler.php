<div class="row">
	<div class="col-sm-12">
		<?php
			$stats = Profiler::application();

			if ($stats['current']['time'] > 2) {
				$profiler_collapse = '';
				echo '<style>#footer { background: #FF4D4D !important; }</style>';
			} else {
				$profiler_collapse = 'collapse';
			}
		?>
		<a data-toggle="collapse" href="#kohana-profiler">Kohana Profiler Stats</a>
		<div id="kohana-profiler" class="<?=$profiler_collapse?>">
			<?=View::factory('profiler/stats')?>
		</div>
	</div>
</div>
