<?php

namespace WpxExampleConfig;

use Wpx\Admin\AdminPageBase;

class AdminConfigPage extends AdminPageBase {

	public function slug() {
		return 'example-option-config';
	}

	public function title() {
		return 'Example Option Config';
	}

	public function actions() {
		return [
			'update-config' => [ $this, 'actionUpdateConfig' ],
		];
	}

	/**
	 * @return \Wpx\Config\ConfigInterface
	 */
	protected function config() {
		return $this->getConfig('example-option-name', [
			'first_value' => 'default',
			'second_value' => 'default',
			'third_is_array' => [
				'string' => 'default',
				'boolean' => false,
				'integer' => 0,
				'float' => 0.01,
				'array' => [
					'nested_string' => 'default',
					'nested_boolean' => false,
					'nested_integer' => 0,
					'nested_float' => 0.01,
				],
			],
			'etc' => 'default',
		]);
	}

	/**
	 * @return array
	 */
	public function actionUpdateConfig() {
		$this->validateAction();

		$this->config()
		 	->set('third_is_array.string', $_POST['config']['third_is_array']['string'])
			->save();

		return $this->result('Value updated to ' . $_POST['config']['third_is_array']['string']);
	}

	/**
	 * @return string
	 */
	public function actionUpdateConfigForm() {
		ob_start();
		?>
		<form method="post" action="<?= $this->actionPath('update-config') ?>">
			<div>
				<label for="nested-string">
					Nested String:
					<input id="nested-string" name="config[third_is_array][string]" value="<?= $this->config()->get('third_is_array.string') ?>">
				</label>
			</div>
			<div>
				<input type="submit" class="button button-primary" value="Update Config">
			</div>
		</form>
		<?php
		return ob_get_clean();
	}

	/**
	 * @return string|void
	 */
	public function content() {
		echo $this->actionUpdateConfigForm();
	}
}
