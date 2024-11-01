<?php
require_once '../../../wp-load.php';
require_once '../../../wp-admin/admin.php';
?>
<script type='text/javascript'>
	jQuery(document).ready(function() {
		jQuery('#wave-embed-form :input').change(function(){
			jQuery(this).addClass('wave-val-changed');
		});
		var fg = jQuery.farbtastic('#colorpicker');
		jQuery('.farbitize').each(function() {
			fg.linkTo(jQuery(this));
			fg.setColor(jQuery(this).val());
			jQuery(this).click(function() {
				jQuery('#colorpicker').show();
				jQuery(this).attr('old-color', jQuery(this).val());
				fg.linkTo(jQuery(this));
			}).click();
			jQuery('#colorpicker').hide();
		});
		jQuery(document).mousedown(function(){
			jQuery('.farbitize').each(function(){
				if( jQuery(this).val() != jQuery(this).attr('old-color') ) {
					jQuery(this).addClass('wave-val-changed');
				}
			});
			jQuery('#colorpicker').hide();
		});
		jQuery('.wp-wave-shortcodes-reset').css('width', '50px').click(function() {
			jQuery('#width').val('<?php print get_option('wp_wave_shortcodes_width'); ?>');
			jQuery('#height').val('<?php print get_option('wp_wave_shortcodes_height'); ?>');
			jQuery('#bgcolor').val('<?php print get_option('wp_wave_shortcodes_bgcolor'); ?>').click();
			jQuery('#color').val('<?php print get_option('wp_wave_shortcodes_color'); ?>').click();
			jQuery('#colorpicker').hide();
			jQuery('#font').val('<?php print get_option('wp_wave_shortcodes_font'); ?>');
			jQuery('#fontsize').val('<?php print get_option('wp_wave_shortcodes_size'); ?>');
		}).click();
		jQuery('#wave-embed-form').submit(function(){
			if(!jQuery('#waveId').val()) {
				alert('You must supply a Wave ID.');
				return false;
			}
			otherOpts = '';
			jQuery('.wave-val-changed').each(function(){
				otherOpts += ' ' + jQuery(this).attr('name') + '="' + jQuery(this).val() + '"';
			});
			send_to_editor('[wave' + otherOpts + ']');
			return false;
		});
	});
</script>
<div id="colorpicker" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;right:0px;display:none;"></div>
<form class="media-upload-form" id="wave-embed-form">
	<table class="describe">
		<tbody>
			<tr>
				<th valign="top" scope="row" class="label">
					<span class="alignleft"><label>Wave ID</label></span>
					<span class="alignright"><abbr title="required" class="required">*</abbr></span>
				</th>
				<td class="field">
					<input id="waveId" name="id" value="" type="text">
				</td>
			</tr>
			<tr>
				<th valign="top" scope="row" class="label">
					<span class="alignleft"><label for="bgcolor">Background Color</label></span>
				</th>
				<td class="field">
					<input class='farbitize' id="bgcolor" name="bgcolor" value="<?php print get_option('wp_wave_shortcodes_bgcolor'); ?>" type="text">
				</td>
			</tr>
			<tr>
				<td></td>
				<td class="help">A color, e.g. "#020304"</td>
			</tr>
			<tr>
				<th valign='top' scope='row' class='label'>
					<label for='color'>
						<span class='alignleft'>Text Color</span>
						<br class='clear' />
					</label>
				</th>
				<td class='field'>
					<input type='text' class='farbitize' id='color' name='color' value='<?php print get_option('wp_wave_shortcodes_color'); ?>' />
				</td>
			</tr>
			<tr>
				<td></td>
				<td class="help">A color, e.g. "#020304"</td>
			</tr>
			<tr>
				<th valign='top' scope='row' class='label'>
					<label for='font'>
						<span class='alignleft'>Font Family</span>
						<br class='clear' />
					</label>
				</th>
				<td class='field'>
					<input type='text' id='font' name='font' value='<?php print get_option('wp_wave_shortcodes_font'); ?>' />
				</td>
			</tr>
			<tr>
				<td></td>
				<td class="help">A font, e.g. "Arial"</td>
			</tr>
			<tr>
				<th valign='top' scope='row' class='label'>
					<label for='fontsize'>
						<span class='alignleft'>Font Size</span>
						<br class='clear' />
					</label>
				</th>
				<td class='field'>
					<input type='text' id='fontsize' name='fontsize' value='<?php print get_option('wp_wave_shortcodes_size'); ?>' />
				</td>
			</tr>
			<tr>
				<td></td>
				<td class="help">A size, e.g. "12px"</td>
			</tr>
			<tr>
				<th valign='top' scope='row' class='label'>
					<label for='width'>
						<span class='alignleft'>Width</span>
						<br class='clear' />
					</label>
				</th>
				<td class='field'>
					<input type='text' id='width' name='width' value='<?php print get_option('wp_wave_shortcodes_width'); ?>' />
				</td>
			</tr>
			<tr>
				<th valign='top' scope='row' class='label'>
					<label for='height'>
						<span class='alignleft'>Height</span>
						<br class='clear' />
					</label>
				</th>
				<td class='field'>
					<input type='text' id='height' name='height' value='<?php print get_option('wp_wave_shortcodes_height'); ?>' />
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type='submit' class='button' name='send[37]' value='Insert into Post' />
					<div class="wp-wave-shortcodes-reset button-secondary">Defaults</div>
				</td>
			</tr>
		</tbody>
	</table>
</form>
