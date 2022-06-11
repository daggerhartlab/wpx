<?php

namespace WpxExampleAdminPages;

use Wpx\Admin\AcfAdminPageBase;

/**
 * Example ACF page.
 */
class AcfChildPage extends AcfAdminPageBase {

	/**
	 * @inheritDoc
	 */
	public function slug() {
		return 'acf-child';
	}

	/**
	 * @inheritDoc
	 */
	public function title() {
		return 'ACF Child Page';
	}

	/**
	 * @inheritDoc
	 */
	public function content() {
		echo "Second-level ACF admin page";
	}

	/**
	 * @inheritDoc
	 */
	public function acfFieldGroups(): array {
		return [
			'group_2' => [
				'key' => 'group_2',
				'title' => 'My Group 2',
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
