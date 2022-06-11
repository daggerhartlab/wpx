<?php

namespace WpxExampleAdminPages;

use Wpx\Admin\AcfAdminPageBase;

/**
 * Example ACF page.
 */
class AcfPageTopLevel extends AcfAdminPageBase {

	/**
	 * @inheritDoc
	 */
	public function slug() {
		return 'acf-top-level';
	}

	/**
	 * @inheritDoc
	 */
	public function title() {
		return 'ACF Top Level';
	}

	/**
	 * @inheritDoc
	 */
	public function description() {
		return 'Example page description';
	}

	/**
	 * @inheritDoc
	 */
	public function content() {
		echo "Top level ACF admin page";
	}

	/**
	 * @inheritDoc
	 */
	public function acfFieldGroups(): array {
		return [
			'group_1' => [
				'key' => 'group_1',
				'title' => 'My Group',
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'fields' => [
					[
						'key' => 'field_1',
						'label' => 'Sub Title',
						'name' => 'sub_title',
						'type' => 'text',
						'prefix' => '',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => [
							'width' => '',
							'class' => '',
							'id' => '',
						],
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
						'readonly' => 0,
						'disabled' => 0,
					],
				],
			],
		];
	}
}
