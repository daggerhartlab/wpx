<?php

namespace WpxExampleAdminPages;

use Wpx\Admin\AdminPageBase;
use Wpx\Form\FieldBase;
use Wpx\Form\FormBase;
use Wpx\Form\FormStyleBase;

class SimpleForm extends AdminPageBase {

	/**
	 * @inheritDoc
	 */
	public function slug() {
		return 'simple-form';
	}

	/**
	 * @inheritDoc
	 */
	public function title() {
		return 'Simple Form';
	}

	/**
	 * @inheritDoc
	 */
	public function content() {
		$form = new FormBase('whatwhat');
		$form
			->setFormStyle(new FormStyleBase())
			->addField(
				(new FieldBase('testing123'))
					->setType('text')
					->setLabel('Test Field')
			);

		echo $form->render();

		?>
		<pre style="border: 1px solid #bbb; padding: 6px;"><?= htmlentities(
			str_replace("><", ">\n<", $form->render())
		) ?></pre>
		<?php
	}
}
