<?php View::set_global('page_title', 'Maxmind GeoLite2'); ?>
<div class="row">
	<div class="col-sm-10">
		<?=HTML::image('/static/img/admin/maxmind.png', ['style' => 'height: 36px'])?>
		<br><br>

		<div class="row">
			<div class="col-sm-12">
				<div class="well well-sm">
					<h2>Client Geo</h2>

					<?php if (empty($city)) { ?>
						<div class="alert alert-warning">
							Unable to locate.
						</div>
					<?php } else { ?>
						<?php
							$iso_3316 = $city['country']['iso_code'];
							$latitude = $city['location']['latitude'];
							$longitude = $city['location']['longitude'];
						?>
						<?=Maxmind::flag_image($iso_3316)?>
						<?=View::factory('helper/table_key_value')->set([
							'data' => 
								['remote ip'   => $remote_ip] +
								['city'        => Arr::path($city, 'city.names.en')] +
								['postal code' => Arr::path($city, 'postal.code')] +
								['continent'   => Arr::path($city, 'continent.names.en')] +
								['iso-3316'    => $iso_3316] +
								['country'     => Arr::path($city, 'country.names.en')] +
								$city['location']
							,
						])?>
						<img src="http://maps.google.com/maps/api/staticmap?size=500x300&center=<?=$latitude?>,<?=$longitude?>&zoom=7&markers=<?=$latitude?>,<?=$longitude?>&&sensor=false" />
					<?php } ?>
				</div>
			</div>
		</div>

	</div>
</div>
