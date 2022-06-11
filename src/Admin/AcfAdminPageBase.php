<?php

namespace Wpx\Admin;

/**
 * Admin page that contains ACF fields.
 */
abstract class AcfAdminPageBase extends AdminPageBase {

	/**
	 * @var array
	 */
	protected $acfPage = [];

	/**
	 * If set to true, this options page will redirect to the first child page (if a child page exists).
	 * If set to false, this parent page will appear alongside any child pages as its own page.
	 *
	 * @return bool
	 * @link
	 *
	 */
	public function acfRedirect() {
		return false;
	}

	/**
	 * @return string|void
	 */
	public function acfUpdateButton() {
		return __( 'Save Settings' );
	}

	/**
	 * @return string|void
	 */
	public function acfUpdatedMessage() {
		return __( 'Settings Updated' );
	}

	/**
	 * @return array
	 */
	public function acfDefaultPageArray() {
		return [
			'page_title'      => $this->title(),
			'menu_title'      => $this->menuTitle(),
			'menu_slug'       => $this->slug(),
			'capability'      => $this->capability(),
			'redirect'        => $this->acfRedirect(),
			'update_button'   => $this->acfUpdateButton(),
			'updated_message' => $this->acfUpdatedMessage(),
		];
	}

	/**
	 * Array of field group definitions.
	 *
	 * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
	 *
	 * @return array[]
	 */
	public function acfFieldGroups(): array {
		return [];
	}

	/**
	 * @return \string[][][]
	 */
	public function acfFieldGroupLocation(): array {
		return [
			[
				[
					'param'    => 'options_page',
					'operator' => '==',
					'value'    => $this->slug(),
				]
			]
		];
	}

	/**
	 * Register any field groups defined in the class.
	 *
	 * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
	 *
	 * @return void
	 */
	public function acfRegisterFields() {
		if ( ! empty( $this->acfFieldGroups() ) ) {
			foreach ( $this->acfFieldGroups() as $field_group ) {
				$field_group['location'] = isset( $field_group['location'] ) && is_array( $field_group['location'] ) ?
					array_merge( $field_group['location'], $this->acfFieldGroupLocation() ) :
					$this->acfFieldGroupLocation();

				\acf_add_local_field_group( $field_group );
			}
		}
	}

	/**
	 * Add the page as a top-level admin menu item in the admin dashboard.
	 *
	 * @link https://www.advancedcustomfields.com/resources/acf_add_options_page/
	 *
	 * @param string $icon_url
	 *   Admin icon url.
	 * @param null|int $position
	 *    Menu position.
	 */
	public function addToMenu( string $icon_url = '', $position = null ) {
		if ( empty( $this->acfPage ) ) {
			$this->acfPage = $this->acfDefaultPageArray();
		}
		$this->acfRegisterFields();
		$this->acfPage  = array_merge( $this->acfPage, [
			'position' => $position,
			'icon_url' => $icon_url,
		] );
		$this->acfPage  = \acf_add_options_page( $this->acfPage );
		$parent_slug = !empty($this->acfPage['parent_slug']) ? $this->acfPage['parent_slug'] : 'toplevel';
		$this->pageHook = "{$parent_slug}_page_{$this->slug()}";


		add_action('acf/form_data', [$this, 'showPageTop']);
		add_action($this->pageHook, [$this, 'showPage'], 100);
	}

	/**
	 * @param string|AdminPageBase $parent
	 *   Parent menu item or pageHook/slug.
	 * @param int|null $position
	 *   Menu position.
	 *
	 * @return void
	 */
	public function addToSubMenu( $parent, $position = null ) {
		if ( $parent instanceof AdminPageBase ) {
			$parent = $parent->slug();
		}
		$this->acfPage = array_merge( $this->acfDefaultPageArray(), [
			'parent_slug' => $parent,
			'position'    => $position,
		] );
		$this->addToMenu( '', $position );
	}

	/**
	 * @return void
	 */
	public function showPageTop() {
		if (!$this->onPage()) {
			return;
		}

		$messages = $this->getMessages();
		$descriptions = $this->description();
		if ( ! empty( $descriptions ) && ! is_array( $descriptions ) ) {
			$descriptions = [ $descriptions ];
		}
		dump($descriptions);
		?>
		<div class="wrap <?php print $this->slug() ?>-wrapper">
			<?php if ( ! empty( $messages ) ): ?>
				<div id="message">
					<?php foreach ( $messages as $message ): ?>
						<div class="<?php print $message['type'] ?> notice is-dismissible">
							<p><?php print $message['message'] ?></p>
						</div>
					<?php endforeach ?>
				</div>
			<?php endif ?>

			<?php if ( ! empty( $descriptions ) ): ?>
				<div class="box description">
					<?php foreach ( $descriptions as $description ): ?>
						<p><?php print $description ?></p>
					<?php endforeach ?>
				</div>
			<?php endif ?>
		</div>
		<?php
	}

	/**
	 * Output the custom page content.
	 */
	public function showPage() {
		?>
		<div class="wrap <?php print $this->slug() ?>-wrapper">
			<div class="<?php print $this->slug() ?>-content postbox acf-postbox">
				<div class="inside acf-fields">
					<div class="acf-field">
						<?php print $this->content() ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

}
