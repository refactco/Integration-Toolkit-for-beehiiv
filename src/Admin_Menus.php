<?php // phpcs:ignore WordPress.Files.FileName.InvalidClassFileName

namespace Re_Beehiiv;

/**
 * This class is responsible for registering and loading the admin menus
 */
class Admin_Menus {


	/**
	 * Register the admin menus
	 *
	 * @return void
	 */
	public function register() {
		add_menu_page(
			__( 'Re/Beehiiv', 're-beehiiv' ),
			__( 'Re/Beehiiv', 're-beehiiv' ),
			'manage_options',
			're-beehiiv-import',
			array( $this, 'load_page_import' ),
			'dashicons-welcome-write-blog',
			75
		);

		// add submenu page

		add_submenu_page(
			're-beehiiv-import',
			__( 'Re/Beehiiv - Import', 're-beehiiv' ),
			__( 'Import Content', 're-beehiiv' ),
			'manage_options',
			're-beehiiv-import',
			array( $this, 'load_page_import' )
		);

		add_submenu_page(
			're-beehiiv-import',
			__( 'Re/Beehiiv - Import', 're-beehiiv' ),
			'Settings',
			'manage_options',
			're-beehiiv-settings',
			array( $this, 'add_settings_page' )
		);
	}

	/**
	 * Load the import page
	 *
	 * @return void
	 */
	public function load_page_import() {
		$this->add_notice_when_not_activated();
		if ( \Re_Beehiiv::is_plugin_activated() ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/re-beehiiv-admin-import.php';
		}
	}

	/**
	 * Add a notice when the plugin is not activated
	 *
	 * @return void
	 */
	private function add_notice_when_not_activated() {
		if ( ! \Re_Beehiiv::is_plugin_activated() ) {
			?>
			<div class="notice notice-error is-dismissible">
				<p>
				<?php 
					$message = esc_html__( 'API Key or publication ID is not set. Please set it on the ', 're-beehiiv' );
					$settings_url = esc_url( home_url( '/wp-admin/admin.php?page=re-beehiiv-settings' ) );

					echo "<p>{$message}<a href='{$settings_url}'>settings page.</a></p>";
				?>
				</p>
			</div>
			<?php
		}
	}

	/**
	 * Load the settings page
	 *
	 * @return void
	 */
	public function add_settings_page() {
		require_once RE_BEEHIIV_PATH . 'admin/partials/re-beehiiv-admin-settings.php';
	}
}
