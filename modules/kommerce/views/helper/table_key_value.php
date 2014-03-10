<table class="table table-condensed">
	<tbody>
		<?php foreach ($data as $k => $v) { ?>
			<?php if (is_array($v)) { continue; } ?>
			<tr>
				<td><?=$k?></td>
				<td><?=$v?></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
