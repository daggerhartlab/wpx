<?php

namespace WpxExampleAdminPages;

use Wpx\Admin\AdminPageBase;
use Wpx\Form\ElementInterface;
use Wpx\Form\FieldBase;
use Wpx\Form\FieldInterface;
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
				(new FieldBase('text', 'testing123', 'Test Field'))
			)
			->addField(
				(new FieldBase('checkbox', 'my-checkbox', 'What about checkboxes?'))
			)
			->addField(
				(new FieldBase('submit','submit'))
					->setValue('Save')
			)
		;

		$out = $form->render();
		echo $out;

		?>
		<pre style="border: 1px solid #bbb; padding: 6px;"><?= htmlentities(
			str_replace("><", ">\n<", $out)
		) ?></pre>
		<?php
	}
}
