<div class="nnr-wrap">

	<?php require_once( 'header.php' ) ?>

	<div class="nnr-container">

		<div class="nnr-content">

			<h1 id="nnr-heading"><?php _e( 'Custom Functions', 'nnr-custom-functions' ) ?></h1>

			<form method="post" class="" role="form">

				<?php

				// General WordPress Functions Section
				$this->generate_settings(
					esc_html__( 'General WordPress Functions', 'nnr-custom-functions' ),
					$this->get_general_settings()
				);

				// General Content Functions Section
				$this->generate_settings(
					esc_html__( 'General Content Functions', 'nnr-custom-functions' ),
					$this->get_general_content_settings()
				);

				// General User Functions Section
				$this->generate_settings(
					esc_html__( 'General User Functions', 'nnr-custom-functions' ),
					$this->get_general_user_settings()
				);

				wp_nonce_field( self::$prefix . 'admin_settings' );
				?>
				<p class="submit">
					<input type="submit" name="submit" id="submit" class="btn btn-info" value="<?php _e( 'Save Changes', 'nnr-custom-functions' ) ?>">
				</p>

			</form>

		</div>

		<?php require_once( 'sidebar.php' ) ?>

	</div>

</div>
