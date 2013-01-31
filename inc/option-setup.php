<?php

function notf_custom_css_option() {
	$defaults = notf_defaults();
	$options = get_option( 'notf_settings', $defaults );

	ob_start();
	?>
	<tr valign="top"><th scope="row"><?php _e( 'Custom CSS', 'notifications' ); ?></th>
		<td>
		<?php $css_basetext = '/* ' . __( 'add your custom css here', 'notifications' ) . ' */'; ?>
					<textarea style="font-family: monospace;" id="notf_settings[css]" class="large-text" cols="50" rows="10" name="notf_settings[css]" onfocus="if (this.value == '<?php echo esc_attr($css_basetext); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php echo esc_attr($css_basetext); ?>';}"><?php if ($options['css'] != '') {
						echo wp_kses( $options['css'], array() );
					} else {
						echo esc_attr($css_basetext);
					} ?></textarea>
					<label class="description" for="notf_settings[css]"><?php _e( 'Add custom CSS overrides to your notification style.  Intended for advanced users with a good working knowledge of <abbr title="Cascading Style Sheets">CSS</abbr>. Use the <code>.notification</code> class to style your notification unless you\'ve set custom classes. If custom CSS is used, notification style will be disabled.', 'notifications' ); ?></label>
				</td>
			</tr>
		<?php
		$css = ob_get_contents();
		ob_end_clean();
		echo $css;
}

function notf_style_option() {
	$defaults = notf_defaults();
	$options = get_option( 'notf_settings', $defaults );

	ob_start();
	?>
		<tr valign="top"><th scope="row"><?php _e( 'Style', 'notifications' ); ?></th>
			<td>
				<select name="notf_settings[style]">
				<?php
					$selected = $options['style'];
					foreach ( notf_styles() as $option ) {
						$label = $option['label'];
						$value = $option['value'];
						echo '<option value="' . esc_attr( $value ) . '" ' . selected( $selected, $value ) . '>' . esc_attr( $label ) . '</option>';
					}
				?>
				</select><br />
				<label class="description" for="notf_settings[style]"><?php _e( 'Select the notification bar style.', 'notifications' ); ?></label>
			</td>
		</tr>
	<?php
	$style = ob_get_contents();
	ob_end_clean();
	echo $style;
}

function notf_class_option() {
	$defaults = notf_defaults();
	$options = get_option( 'notf_settings', $defaults );

	ob_start();
	?>
		<tr valign="top"><th scope="row"><?php _e( 'Custom CSS Class', 'notifications' ); ?></th>
			<td>
				<input type="text" size="15" name="notf_settings[class]" value ="<?php echo esc_attr( $options['class'] ); ?>" /><br />
				<label class="description" for="notf_settings[class]"><?php _e( 'Add a custom class to the notification bar output to style in your theme and override the default notification style.', 'notifications' ); ?></label>
			</td>
		</tr>
	<?php
	$class = ob_get_contents();
	ob_end_clean();
	echo $class;
}

function notf_do_options() {
	echo '<table class="form-table">';
	notf_style_option();
	notf_class_option();
	notf_custom_css_option();
	echo '</table>';
}