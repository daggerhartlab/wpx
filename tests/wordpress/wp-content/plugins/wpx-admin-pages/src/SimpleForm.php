<?php

namespace WpxExampleAdminPages;

use Wpx\Admin\AdminPageBase;
use Wpx\Form\Collection\FieldsCollection;
use Wpx\Form\Element;
use Wpx\Form\FieldBase;
use Wpx\Form\FormStyle\Simple;
use Wpx\Service\FormBuilder;

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

	public function actions() {
		return [
			'simple-form' => [$this, 'submitSimpleForm'],
		];
	}

	/**
	 * @inheritDoc
	 */
	public function content() {
		$form = $this->mkform();
		$out = $form->render();
		echo $out;

		?>
		<pre style="border: 1px solid #bbb; padding: 6px;"><?= htmlentities(
			str_replace("><", ">\n<", $out)
		) ?></pre>
		<?php
		dump($form->getSubmittedValues()->all());
	}

	public function mkform() {
		$builder = new FormBuilder();
		return $builder
			->create(
				'whatwhat',
				$this->actionPath('simple-form'),
				'POST',
				new FieldsCollection([
						new FieldBase( (new Element())->setTag('input'), 'text', 'testing123', 'Test Field'),
						new FieldBase( (new Element())->setTag('input'), 'checkbox', 'my-checkbox', 'What about checkboxes?'),
						(new FieldBase( (new Element())->setTag('input'), 'submit','submit'))
								->setValue('Save')
				]),
				new Simple(),
				null,
			);
	}

	public function submitSimpleForm() {
		$this->validateAction();
		$form = $this->mkform();
		ob_start();
			dump($form->getSubmittedValues()->all());
			dump($form->getRequest());
		$ob = ob_get_clean();
		return $this->result("submitted " . $ob);
	}
}
