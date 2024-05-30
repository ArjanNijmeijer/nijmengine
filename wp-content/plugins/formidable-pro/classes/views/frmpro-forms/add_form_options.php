<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( 'You are not allowed to call this page directly.' );
}
?>
<p class="howto">
	<?php esc_html_e( 'Determine who can see, submit, and edit form entries.', 'formidable-pro' ); ?>
</p>

<div class="frm_grid_container">
	<p class="frm4 frm_form_field">
        <label id="for_logged_in_role" for="logged_in">
			<input type="checkbox" name="logged_in" id="logged_in" value="1" <?php checked( $values['logged_in'], 1 ); ?> />
			<?php printf( __( 'Limit form visibility %1$sto%2$s', 'formidable-pro' ), '<span class="hide_logged_in ' . esc_attr( $values['logged_in'] ? '' : 'frm_invisible' ) . '">', '</span>' ); ?>
        </label>
	</p>
	<p class="frm8 frm_form_field frm_select_with_label">
        <select name="options[logged_in_role][]" id="logged_in_role" class="frm_multiselect hide_logged_in <?php echo esc_attr( $values['logged_in'] ? '' : 'frm_invisible' ); ?>" multiple="multiple">
			<option value="" <?php FrmProAppHelper::selected( $values['logged_in_role'], '' ); ?>><?php esc_html_e( 'Logged-in Users', 'formidable-pro' ); ?></option>
            <?php FrmAppHelper::roles_options($values['logged_in_role']); ?>
        </select>
	</p>

	<p class="frm4 frm_form_field">
		<label for="single_entry">
			<input type="checkbox" name="options[single_entry]" id="single_entry" value="1" <?php checked( $values['single_entry'], 1 ); ?> />
			<?php printf( __( 'Limit number of entries %1$sto one per%2$s', 'formidable-pro' ), '<span class="hide_single_entry' . esc_attr( $values['single_entry'] ? '' : ' frm_invisible' ) . '">', '</span>' ); ?>
		</label>
    </p>
	<p class="frm8 frm_form_field frm_select_with_label">
        <select name="options[single_entry_type]" id="frm_single_entry_type" class="hide_single_entry <?php echo esc_attr( $values['single_entry'] ? '' : 'frm_invisible' ); ?>">
			<option value="user" <?php selected( $values['single_entry_type'], 'user' ); ?>>
				<?php esc_html_e( 'Logged-in User', 'formidable-pro' ); ?>
			</option>
			<?php if ( FrmAppHelper::ips_saved() ) { ?>
			<option value="ip" <?php selected( $values['single_entry_type'], 'ip' ); ?>>
				<?php esc_html_e( 'IP Address', 'formidable-pro' ); ?>
			</option>
			<?php } ?>
			<option value="cookie" <?php selected( $values['single_entry_type'], 'cookie' ); ?>>
				<?php esc_html_e( 'Saved Cookie', 'formidable-pro' ); ?>
			</option>
        </select>
    </p>

	<p id="frm_cookie_expiration" class="frm_indent_opt <?php echo ( $values['single_entry'] && $values['single_entry_type'] == 'cookie' ) ? '' : 'frm_hidden'; ?>">
		<label><?php esc_html_e( 'Cookie Expiration', 'formidable-pro' ); ?></label>
		<input type="text" name="options[cookie_expiration]" value="<?php echo esc_attr($values['cookie_expiration']); ?>" size="6" class="frm-w-auto">
		<span class="howto"><?php esc_html_e( 'hours', 'formidable-pro' ); ?></span>
	</p>

<?php
require FrmProAppHelper::plugin_path() . '/classes/views/frmpro-forms/file-protection-options.php';

if ( is_multisite() ) {
	if ( current_user_can( 'setup_network' ) ) {
	?>
        <p>
			<label for="copy">
				<input type="checkbox" name="options[copy]" id="copy" value="1" <?php echo ( $values['copy'] ) ? ' checked="checked"' : ''; ?> />
				<?php esc_html_e( 'Copy this form to other blogs when Formidable Forms is activated', 'formidable-pro' ); ?>
			</label>
		</p>
	<?php
	} elseif ( $values['copy'] ) {
		?>
        <input type="hidden" name="options[copy]" id="copy" value="1" />
		<?php
    }
}

require FrmProAppHelper::plugin_path() . '/classes/views/frmpro-forms/edit-entry-options.php';
require FrmProAppHelper::plugin_path() . '/classes/views/frmpro-forms/save-draft-options.php';
?>
</div>
