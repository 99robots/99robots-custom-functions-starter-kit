<h1><?php _e('Settings Page', self::$text_domain1); ?></h1>
<form method="post">

	<h3><?php _e('General Section', self::$text_domain1); ?></h3>

	<table class="form-table" enctype="multipart/form-data">
		<tbody>
			<!--Show Featured Image -->

			<tr>
				<th>
					<label><?php _e('Show Featured Image', self::$text_domain1); ?></label>
					<td>
						<input type="checkbox" id="<?php echo self::$prefix1; ?>check_image" name="<?php echo self::$prefix1; ?>check_image" <?php echo isset($settings['check_image']) && $settings['check_image'] ? 'checked="checked"' : ''; ?>/>
					</td>
				</th>
			</tr>
			<!-- Restrict Users To See Only Their Post -->

			<tr>
				<th>
					<label><?php _e('Restrict Users To See Only Their Post', self::$text_domain1); ?></label>
					<td>
						<input type="checkbox" id="<?php echo self::$prefix1; ?>check_post" name="<?php echo self::$prefix1; ?>check_post" <?php echo isset($settings['check_post']) && $settings['check_post'] ? 'checked="checked"' : ''; ?>/>
						
					</td>
				</th>
			</tr>
			<!-- Login Error -->
			<tr>
				<th>
					<label><?php _e('Hide Login Errors', self::$text_domain1); ?></label>
					<td>
						<input type="checkbox" id="<?php echo self::$prefix1; ?>login_error" name="<?php echo self::$prefix1; ?>login_error" <?php echo isset($settings['login_error']) && $settings['login_error'] ? 'checked="checked"' : ''; ?>/>
						
					</td>
				</th>
			</tr>
			<!-- Display Updates Message To Only Admin -->
			<tr>
				<th>
					<label><?php _e('Display Updates Message To Only Admin', self::$text_domain1); ?></label>
					<td>
						<input type="checkbox" id="<?php echo self::$prefix1; ?>check_update" name="<?php echo self::$prefix1; ?>check_update" <?php echo isset($settings['check_update']) && $settings['check_update'] ? 'checked="checked"' : ''; ?>/>
						
					</td>
				</th>
			</tr>
			<!-- Allow Contributors To Upload Media File -->
			<tr>
				<th>
					<label><?php _e('Allow Contributors To Upload Media File', self::$text_domain1); ?></label>
					<td>
						<input type="checkbox" id="<?php echo self::$prefix1; ?>check_upload_file" name="<?php echo self::$prefix1; ?>check_upload_file" <?php echo isset($settings['check_upload_file']) && $settings['check_upload_file'] ? 'checked="checked"' : ''; ?>/>
						
					</td>
				</th>
			</tr>
			<!--Default Image Quality -->
			<tr>
				<th>
					<label><?php _e('Make Default Image Quality 100%', self::$text_domain1); ?></label>
					<td>
						<input type="checkbox" id="<?php echo self::$prefix1; ?>check_image_quality" name="<?php echo self::$prefix1; ?>check_image_quality" <?php echo isset($settings['check_image_quality']) && $settings['check_image_quality'] ? 'checked="checked"' : ''; ?>/>
						
					</td>
				</th>
			</tr>
			<!--Disable Self-Pinging -->
			<tr>
				<th>
					<label><?php _e('Disable Self-Pinging', self::$text_domain1); ?></label>
					<td>
						<input type="checkbox" id="<?php echo self::$prefix1; ?>check_Self-Pinging" name="<?php echo self::$prefix1; ?>check_Self-Pinging" <?php echo isset($settings['check_Self-Pinging']) && $settings['check_Self-Pinging'] ? 'checked="checked"' : ''; ?>/>
						
					</td>
				</th>
			</tr>
			<!--Disable Header Meta -->
			<tr>
				<th>
					<label><?php _e('Disable Header Meta', self::$text_domain1); ?></label>
					<td>
						<input type="checkbox" id="<?php echo self::$prefix1; ?>check_meta" name="<?php echo self::$prefix1; ?>check_meta" <?php echo isset($settings['check_meta']) && $settings['check_meta'] ? 'checked="checked"' : ''; ?>/>
						
					</td>
				</th>
			</tr>
			<!--Hide Widgets And Menu From Appearance -->
			<tr>
				<th>
					<label><?php _e('Hide Widgets And Menu From Appearance', self::$text_domain1); ?></label>
					<td>
						<input type="checkbox" id="<?php echo self::$prefix1; ?>check_widgets" name="<?php echo self::$prefix1; ?>check_widgets" <?php echo isset($settings['check_widgets']) && $settings['check_widgets'] ? 'checked="checked"' : ''; ?>/>
						
					</td>
				</th>
			</tr>
			<!--Remove All Meta Box -->
			<tr>
				<th>
					<label><?php _e('Remove All Meta Box', self::$text_domain1); ?></label>
					<td>
						<input type="checkbox" id="<?php echo self::$prefix1; ?>check_remove_metabox" name="<?php echo self::$prefix1; ?>check_remove_metabox" <?php echo isset($settings['check_remove_metabox']) && $settings['check_remove_metabox'] ? 'checked="checked"' : ''; ?>/>
						
					</td>
				</th>
			</tr>
			<!--Redirect author link to another Page -->
			<tr>
				<th>
					<label><?php _e('Redirect author link to another Page', self::$text_domain1); ?></label>
					<td>
						<input type="checkbox" id="<?php echo self::$prefix1; ?>check_author_link" name="<?php echo self::$prefix1; ?>check_author_link" <?php echo isset($settings['check_author_link']) && $settings['check_author_link'] ? 'checked="checked"' : ''; ?>/>
						
					</td>
				</th>
			</tr>
			<!--Disable post revisions to prevent database size overload -->
			<tr>
				<th>
					<label><?php _e('Disable post revisions', self::$text_domain1); ?></label>
					<td>
						<input type="checkbox" id="<?php echo self::$prefix1; ?>check_post_revision" name="<?php echo self::$prefix1; ?>check_post_revision" <?php echo isset($settings['check_post_revision']) && $settings['check_post_revision'] ? 'checked="checked"' : ''; ?>/>
						
					</td>
				</th>
			</tr>
			<!--Open External Post Links in New Windows -->
			<tr>
				<th>
					<label><?php _e('Open External Post Links in New Windows', self::$text_domain1); ?></label>
					<td>
						<input type="checkbox" id="<?php echo self::$prefix1; ?>check_link" name="<?php echo self::$prefix1; ?>check_link" <?php echo isset($settings['check_link']) && $settings['check_link'] ? 'checked="checked"' : ''; ?>/>
						
					</td>
				</th>
			</tr>
			<!--Display Message If Username is Admin -->
			<tr>
				<th>
					<label><?php _e('Display Message If Username is Admin', self::$text_domain1); ?></label>
					<td>
						<input type="checkbox" id="<?php echo self::$prefix1; ?>check_admin" name="<?php echo self::$prefix1; ?>check_admin" <?php echo isset($settings['check_admin']) && $settings['check_admin'] ? 'checked="checked"' : ''; ?>/>
						
					</td>
				</th>
			</tr>
			<!--Disable Auto Updates from Wordpress -->
			<tr>
				<th>
					<label><?php _e('Disable Auto Updates from Wordpress', self::$text_domain1); ?></label>
					<td>
						<input type="checkbox" id="<?php echo self::$prefix1; ?>check_auto_update" name="<?php echo self::$prefix1; ?>check_auto_update" <?php echo isset($settings['check_auto_update']) && $settings['check_auto_update'] ? 'checked="checked"' : ''; ?>/>
						
					</td>
				</th>
			</tr>
			<!--Add featured image to RSS feeds -->
			<tr>
				<th>
					<label><?php _e('Add featured image to RSS feeds', self::$text_domain1); ?></label>
					<td>
						<input type="checkbox" id="<?php echo self::$prefix1; ?>check_rss" name="<?php echo self::$prefix1; ?>check_rss" <?php echo isset($settings['check_rss']) && $settings['check_rss'] ? 'checked="checked"' : ''; ?>/>
						
					</td>
				</th>
			</tr>
</tbody>
</table>
<?php wp_nonce_field(self::$prefix1 . 'admin_settings'); ?>

<?php submit_button( ) ?>

</form>