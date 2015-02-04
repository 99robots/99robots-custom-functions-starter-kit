<div id="<?php echo self::$prefix; ?>content">

	<h1><?php _e('Settings Page', self::$text_domain); ?></h1>

	<form method="post" class="form-horizontal" role="form">

		<!-- Add a BootStrap Panel for the settings -->

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><?php _e('General Section', self::$text_domain); ?></h3>
			</div>
			<div class="panel-body">

				<!-- Text -->

				<div class="form-group">
					<label for="<?php echo self::$prefix; ?>text" class="col-sm-3 control-label"><?php _e('Text', self::$text_domain); ?></label>
					<div class="col-sm-9">
						<input id="<?php echo self::$prefix; ?>text" name="<?php echo self::$prefix; ?>text" class="form-control" type="text" value="<?php echo isset($settings['text']) ? esc_attr($settings['text']) : ''; ?>">
						<em class="help-block"><?php _e('This is a description.', self::$text_domain); ?></em>
					</div>
				</div>

				<!-- Text Area -->

				<div class="form-group">
					<label for="<?php echo self::$prefix; ?>textarea" class="col-sm-3 control-label"><?php _e('Text Area', self::$text_domain); ?></label>
					<div class="col-sm-9">
						<textarea rows="10" cols="50" id="<?php echo self::$prefix; ?>textarea" name="<?php echo self::$prefix; ?>textarea" class="form-control"><?php echo isset($settings['textarea']) ? esc_attr($settings['textarea']) : ''; ?></textarea>
						<em class="help-block"><?php _e('This is a description.', self::$text_domain); ?></em>
					</div>
				</div>

				<!-- Checkbox -->

				<div class="form-group">
					<label for="<?php echo self::$prefix; ?>checkbox" class="col-sm-3 control-label"><?php _e('Checkbox', self::$text_domain); ?></label>
					<div class="col-sm-9">
						<input type="checkbox" id="<?php echo self::$prefix; ?>checkbox" name="<?php echo self::$prefix; ?>checkbox" class="form-control" <?php echo isset($settings['checkbox']) && $settings['checkbox'] ? 'checked="checked"' : ''; ?>/>
						<em class="help-block"><?php _e('This is a description.', self::$text_domain); ?></em>
					</div>
				</div>

				<!-- Select -->

				<div class="form-group">
					<label for="<?php echo self::$prefix; ?>select" class="col-sm-3 control-label"><?php _e('Select', self::$text_domain); ?></label>
					<div class="col-sm-9">
						<select id="<?php echo self::$prefix; ?>select" name="<?php echo self::$prefix; ?>select">
							<option value="small" <?php echo isset($settings['select']) && $settings['select'] == 'small' ? 'selected' : ''; ?>><?php _e('small', self::$text_domain); ?></option>
							<option value="medium" <?php echo isset($settings['select']) && $settings['select'] == 'medium' ? 'selected' : ''; ?>><?php _e('medium', self::$text_domain); ?></option>
							<option value="large" <?php echo isset($settings['select']) && $settings['select'] == 'large' ? 'selected' : ''; ?>><?php _e('large', self::$text_domain); ?></option>
						</select>
						<em class="help-block"><?php _e('This is a description.', self::$text_domain); ?></em>
					</div>
				</div>

				<!-- Radio -->

				<div class="form-group">
					<label for="<?php echo self::$prefix; ?>radio" class="col-sm-3 control-label"><?php _e('Radio', self::$text_domain); ?></label>
					<div class="col-sm-9">

						<div class="radio">
							<label>
								<input type="radio" name="<?php echo self::$prefix; ?>radio" class="form-control" value="start" <?php echo isset($settings['radio']) && $settings['radio'] == 'start' ? 'checked="checked"' : ''; ?>>
								<?php _e('start', self::$text_domain); ?>
							</label>
						</div>

						<div class="radio">
							<label>
								<input type="radio" name="<?php echo self::$prefix; ?>radio" class="form-control" value="middle" <?php echo isset($settings['radio']) && $settings['radio'] == 'middle' ? 'checked="checked"' : ''; ?>>
								<?php _e('middle', self::$text_domain); ?>
							</label>
						</div>

						<div class="radio">
							<label>
								<input type="radio" name="<?php echo self::$prefix; ?>radio" class="form-control" value="end" <?php echo isset($settings['radio']) && $settings['radio'] == 'end' ? 'checked="checked"' : ''; ?>>
								<?php _e('end', self::$text_domain); ?>
							</label>
						</div>

						<em class="help-block"><?php _e('This is a description.', self::$text_domain); ?></em>
					</div>
				</div>

			</div>
		</div>

		<!-- Add a BootStrap Panel for the settings -->

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><?php _e('Other Section', self::$text_domain); ?></h3>
			</div>
			<div class="panel-body">

				<!-- URL -->

				<div class="form-group">
					<label for="<?php echo self::$prefix; ?>url" class="col-sm-3 control-label"><?php _e('URL', self::$text_domain); ?></label>
					<div class="col-sm-9">
						<input id="<?php echo self::$prefix; ?>url" name="<?php echo self::$prefix; ?>url" class="form-control" type="url" size="50" value="<?php echo isset($settings['url']) ? esc_url($settings['url']) : ''; ?>">
						<em class="help-block"><?php _e('This is a description.', self::$text_domain); ?></em>
					</div>
				</div>

			</div>
		</div>

		<?php wp_nonce_field(self::$prefix . 'admin_settings'); ?>

		<p class="submit">
			<input type="submit" name="submit" id="submit" class="btn btn-primary" value="<?php _e('Save', self::$text_domain); ?>">
		</p>

	</form>
</div>