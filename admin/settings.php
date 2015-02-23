<?php require ('header.php'); ?>
 
	<div id="wpsite_plugin_content">
 
		<div id="wpsite_plugin_settings">
 
			<div class="wrap">


				<div id="<?php echo self::$prefix; ?>content">
				
					<form method="post" class="" role="form">
				
						<!-- General WordPress Functions Section -->
						
						<?php $codex_page = '&nbsp;-&nbsp;<a href="http://www.wpsite.net/custom-functions-starter-kit">Learn More</a>'; ?>
				
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title"><?php _e('General WordPress Functions', self::$text_domain); ?></h3>
							</div>
							<div class="panel-body">
				
								<!-- Hide WordPress Version & Meta Data -->
								
								<?php 
								/* Set $opid and the entire option will change. */
								$opid = 1; 
								$fullopid = self::$prefix . 'checkbox-' . $opid;	
								$settopid = 'checkbox-' . $opid;
								?>
				
								<div class="form-group">
									<div class="pull-left">
										<input type="checkbox" id="<?php echo $fullopid; ?>" name="<?php echo $fullopid; ?>" class="form-control" <?php echo isset($settings[$settopid]) && $settings[$settopid] ? 'checked="checked"' : ''; ?>/>
									</div>
									<label for="<?php echo $fullopid; ?>" class="col-sm-9 pull-left">
										<?php _e('Hide WordPress Version & Meta Data (recommended)'.$codex_page, self::$text_domain); ?>
									</label>
									<div class="clearfix"></div>
									<em class="help-block">
										<?php _e('This will prevent hackers from discovering your WP version number.', self::$text_domain); ?>
									</em>
								</div>
								
								<!-- Hide WordPress Login Errors -->
								
								<?php 
								/* Set $opid and the entire option will change. */
								$opid = 2; 
								$fullopid = self::$prefix . 'checkbox-' . $opid;	
								$settopid = 'checkbox-' . $opid;
								?>
				
								<div class="form-group">
									<div class="pull-left">
										<input type="checkbox" id="<?php echo $fullopid; ?>" name="<?php echo $fullopid; ?>" class="form-control" <?php echo isset($settings[$settopid]) && $settings[$settopid] ? 'checked="checked"' : ''; ?>/>
									</div>
									<label for="<?php echo $fullopid; ?>" class="col-sm-9 pull-left">
										<?php _e('Hide WordPress Login Errors (recommended)'.$codex_page, self::$text_domain); ?>
									</label>
									<div class="clearfix"></div>
									<em class="help-block">
										<?php _e('Prevent users from seeing the default WP login errors, which may lead to hackers guessing registered usernames.', self::$text_domain); ?>
									</em>
								</div>
								
								<!-- Check for "Admin" Security Vulnerability  -->
								
								<?php 
								/* Set $opid and the entire option will change. */
								$opid = 3; 
								$fullopid = self::$prefix . 'checkbox-' . $opid;	
								$settopid = 'checkbox-' . $opid;
								?>
				
								<div class="form-group">
									<div class="pull-left">
										<input type="checkbox" id="<?php echo $fullopid; ?>" name="<?php echo $fullopid; ?>" class="form-control" <?php echo isset($settings[$settopid]) && $settings[$settopid] ? 'checked="checked"' : ''; ?>/>
									</div>
									<label for="<?php echo $fullopid; ?>" class="col-sm-9 pull-left">
										<?php _e('Check for "Admin" Security Vulnerability (recommended)'.$codex_page, self::$text_domain); ?>
									</label>
									<div class="clearfix"></div>
									<em class="help-block">
										<?php _e('Checks WP for the username "admin" (an easy target for hackers) and notifies the site owner.', self::$text_domain); ?>
									</em>
								</div>
								
								<!-- Disable WordPress Automatic Updates -->
								
								<?php 
								/* Set $opid and the entire option will change. */
								$opid = 4; 
								$fullopid = self::$prefix . 'checkbox-' . $opid;	
								$settopid = 'checkbox-' . $opid;
								?>
				
								<div class="form-group">
									<div class="pull-left">
										<input type="checkbox" id="<?php echo $fullopid; ?>" name="<?php echo $fullopid; ?>" class="form-control" <?php echo isset($settings[$settopid]) && $settings[$settopid] ? 'checked="checked"' : ''; ?>/>
									</div>
									<label for="<?php echo $fullopid; ?>" class="col-sm-9 pull-left">
										<?php _e('Disable WordPress Automatic Updates'.$codex_page, self::$text_domain); ?>
									</label>
									<div class="clearfix"></div>
									<em class="help-block">
										<?php _e('Disables WP from automatically updating the core files.', self::$text_domain); ?>
									</em>
								</div>
								
								<!-- Disable Theme and Plugin Editors -->
								
								<?php 
								/* Set $opid and the entire option will change. */
								$opid = 5; 
								$fullopid = self::$prefix . 'checkbox-' . $opid;	
								$settopid = 'checkbox-' . $opid;
								?>
				
								<div class="form-group">
									<div class="pull-left">
										<input type="checkbox" id="<?php echo $fullopid; ?>" name="<?php echo $fullopid; ?>" class="form-control" <?php echo isset($settings[$settopid]) && $settings[$settopid] ? 'checked="checked"' : ''; ?>/>
									</div>
									<label for="<?php echo $fullopid; ?>" class="col-sm-9 pull-left">
										<?php _e('Disable Theme and Plugin Editors'.$codex_page, self::$text_domain); ?>
									</label>
									<div class="clearfix"></div>
									<em class="help-block">
										<?php _e('Removes the theme and plugin editor from all users, limiting hackers (or users) from damaging your site if they gain access.', self::$text_domain); ?>
									</em>
								</div>
								
								<!-- Show WordPress Update Notification to Admins Only -->
								
								<?php 
								/* Set $opid and the entire option will change. */
								$opid = 6; 
								$fullopid = self::$prefix . 'checkbox-' . $opid;	
								$settopid = 'checkbox-' . $opid;
								?>
				
								<div class="form-group">
									<div class="pull-left">
										<input type="checkbox" id="<?php echo $fullopid; ?>" name="<?php echo $fullopid; ?>" class="form-control" <?php echo isset($settings[$settopid]) && $settings[$settopid] ? 'checked="checked"' : ''; ?>/>
									</div>
									<label for="<?php echo $fullopid; ?>" class="col-sm-9 pull-left">
										<?php _e('Show WordPress Update Notification to Admins Only'.$codex_page, self::$text_domain); ?>
									</label>
									<div class="clearfix"></div>
									<em class="help-block">
										<?php _e('This will remove the "WordPress Update" notification from non-admin users.', self::$text_domain); ?>
									</em>
								</div>
								
							</div>
						</div>
				
				
						<!-- General Content Functions Section -->
				
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title"><?php _e('General Content Functions', self::$text_domain); ?></h3>
							</div>
							<div class="panel-body">
				
				
								<!-- Display the Featured Image on the "All Posts" Admin Screen-->
				
								<?php 
								/* Set $opid and the entire option will change. */
								$opid = 10; 
								$fullopid = self::$prefix . 'checkbox-' . $opid;	
								$settopid = 'checkbox-' . $opid;
								?>
				
								<div class="form-group">
									<div class="pull-left">
										<input type="checkbox" id="<?php echo $fullopid; ?>" name="<?php echo $fullopid; ?>" class="form-control" <?php echo isset($settings[$settopid]) && $settings[$settopid] ? 'checked="checked"' : ''; ?>/>
									</div>
									<label for="<?php echo $fullopid; ?>" class="col-sm-9 pull-left">
										<?php _e('Display the Featured Image on the "All Posts" Admin Screen'.$codex_page, self::$text_domain); ?>
									</label>
									<div class="clearfix"></div>
									<em class="help-block">
										<?php _e('This will add a column in the "All Posts" admin screen that will display the featured image of the post.', self::$text_domain); ?>
									</em>
								</div>
								
								<!-- Disable Post Revisions -->
				
								<?php 
								/* Set $opid and the entire option will change. */
								$opid = 11; 
								$fullopid = self::$prefix . 'checkbox-' . $opid;	
								$settopid = 'checkbox-' . $opid;
								?>
				
								<div class="form-group">
									<div class="pull-left">
										<input type="checkbox" id="<?php echo $fullopid; ?>" name="<?php echo $fullopid; ?>" class="form-control" <?php echo isset($settings[$settopid]) && $settings[$settopid] ? 'checked="checked"' : ''; ?>/>
									</div>
									<label for="<?php echo $fullopid; ?>" class="col-sm-9 pull-left">
										<?php _e('Disable Post Revisions'.$codex_page, self::$text_domain); ?>
									</label>
									<div class="clearfix"></div>
									<em class="help-block">
										<?php _e('Save room in your database by disabling post revisions except one autosave.', self::$text_domain); ?>
									</em>
								</div>
								
								<!-- Include Featured Image in RSS Feed -->
				
								<?php 
								/* Set $opid and the entire option will change. */
								$opid = 12; 
								$fullopid = self::$prefix . 'checkbox-' . $opid;	
								$settopid = 'checkbox-' . $opid;
								?>
				
								<div class="form-group">
									<div class="pull-left">
										<input type="checkbox" id="<?php echo $fullopid; ?>" name="<?php echo $fullopid; ?>" class="form-control" <?php echo isset($settings[$settopid]) && $settings[$settopid] ? 'checked="checked"' : ''; ?>/>
									</div>
									<label for="<?php echo $fullopid; ?>" class="col-sm-9 pull-left">
										<?php _e('Include Featured Image in RSS Feed'.$codex_page, self::$text_domain); ?>
									</label>
									<div class="clearfix"></div>
									<em class="help-block">
										<?php _e('Adds the featured image to the RSS feed.', self::$text_domain); ?>
									</em>
								</div>
								
								
								<!-- Disable Self-Pinging -->
				
								<?php 
								/* Set $opid and the entire option will change. */
								$opid = 13; 
								$fullopid = self::$prefix . 'checkbox-' . $opid;	
								$settopid = 'checkbox-' . $opid;
								?>
				
								<div class="form-group">
									<div class="pull-left">
										<input type="checkbox" id="<?php echo $fullopid; ?>" name="<?php echo $fullopid; ?>" class="form-control" <?php echo isset($settings[$settopid]) && $settings[$settopid] ? 'checked="checked"' : ''; ?>/>
									</div>
									<label for="<?php echo $fullopid; ?>" class="col-sm-9 pull-left">
										<?php _e('Disable Self-Pinging'.$codex_page, self::$text_domain); ?>
									</label>
									<div class="clearfix"></div>
									<em class="help-block">
										<?php _e('Prevents WordPress from sending and showing a ping to your site from your site.', self::$text_domain); ?>
									</em>
								</div>
								
								
								<!-- Open All External Links in a New Tab -->
				
								<?php 
								/* Set $opid and the entire option will change. */
								$opid = 14; 
								$fullopid = self::$prefix . 'checkbox-' . $opid;	
								$settopid = 'checkbox-' . $opid;
								?>
				
								<!--
<div class="form-group">
									<div class="pull-left">
										<input type="checkbox" id="<?php echo $fullopid; ?>" name="<?php echo $fullopid; ?>" class="form-control" <?php echo isset($settings[$settopid]) && $settings[$settopid] ? 'checked="checked"' : ''; ?>/>
									</div>
									<label for="<?php echo $fullopid; ?>" class="col-sm-9 pull-left">
										<?php _e('Open All External Links in a New Tab', self::$text_domain); ?>
									</label>
									<div class="clearfix"></div>
									<em class="help-block">
										<?php _e('Any link on the site that is pointed off the site will open in a new tab.', self::$text_domain); ?>
									</em>
								</div>
-->
				
							</div>
						</div>
				
				
						<!-- General User Functions Section -->
				
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title"><?php _e('General User Functions', self::$text_domain); ?></h3>
							</div>
							<div class="panel-body">
				
								<!-- Allow Contributors to Upload Photos -->
								
								<?php 
								/* Set $opid and the entire option will change. */
								$opid = 20; 
								$fullopid = self::$prefix . 'checkbox-' . $opid;	
								$settopid = 'checkbox-' . $opid;
								?>
				
								<div class="form-group">
									<div class="pull-left">
										<input type="checkbox" id="<?php echo $fullopid; ?>" name="<?php echo $fullopid; ?>" class="form-control" <?php echo isset($settings[$settopid]) && $settings[$settopid] ? 'checked="checked"' : ''; ?>/>
									</div>
									<label for="<?php echo $fullopid; ?>" class="col-sm-9 pull-left">
										<?php _e('Allow Contributors to Upload Photos'.$codex_page, self::$text_domain); ?>
									</label>
									<div class="clearfix"></div>
									<em class="help-block">
										<?php _e('This will give the user role "contributor" permission to upload images.', self::$text_domain); ?>
									</em>
								</div>
								
								<!-- Restrict Authors to View Only Their Own Posts -->
								
								<?php 
								/* Set $opid and the entire option will change. */
								$opid = 21; 
								$fullopid = self::$prefix . 'checkbox-' . $opid;	
								$settopid = 'checkbox-' . $opid;
								?>
				
								<div class="form-group">
									<div class="pull-left">
										<input type="checkbox" id="<?php echo $fullopid; ?>" name="<?php echo $fullopid; ?>" class="form-control" <?php echo isset($settings[$settopid]) && $settings[$settopid] ? 'checked="checked"' : ''; ?>/>
									</div>
									<label for="<?php echo $fullopid; ?>" class="col-sm-9 pull-left">
										<?php _e('Restrict Authors to View Only Their Own Posts'.$codex_page, self::$text_domain); ?>
									</label>
									<div class="clearfix"></div>
									<em class="help-block">
										<?php _e('This will prevent authors from viewing any content besides their own.', self::$text_domain); ?>
									</em>
								</div>
								
								<!-- Hide Admin Bar from Non-Admins -->
								
								<?php 
								/* Set $opid and the entire option will change. */
								$opid = 22; 
								$fullopid = self::$prefix . 'checkbox-' . $opid;	
								$settopid = 'checkbox-' . $opid;
								?>
				
								<div class="form-group">
									<div class="pull-left">
										<input type="checkbox" id="<?php echo $fullopid; ?>" name="<?php echo $fullopid; ?>" class="form-control" <?php echo isset($settings[$settopid]) && $settings[$settopid] ? 'checked="checked"' : ''; ?>/>
									</div>
									<label for="<?php echo $fullopid; ?>" class="col-sm-9 pull-left">
										<?php _e('Hide Admin Bar from Non-Admins'.$codex_page, self::$text_domain); ?>
									</label>
									<div class="clearfix"></div>
									<em class="help-block">
										<?php _e('Hides the WP admin bar from all users except administrators.', self::$text_domain); ?>
									</em>
								</div>
				
				
							</div>
						</div>
				
				
						<?php wp_nonce_field(self::$prefix . 'admin_settings'); ?>
				
						<p class="submit">
							<input type="submit" name="submit" id="submit" class="btn btn-primary" value="<?php _e('Save', self::$text_domain); ?>">
						</p>
				
					</form>
				</div>
				
			</div> <!-- wrap -->
			
		</div> <!-- wpsite_plugin_settings -->
 
	<?php require ('sidebar.php'); ?>
 
	</div> <!-- /wpsite_plugin_content -->
 
<?php require ('footer.php'); ?>