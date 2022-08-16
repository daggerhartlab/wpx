<?php

namespace WpxExampleAdminPages;

use Wpx\Admin\AdminPageBase;
use Wpx\Form\Collection\FieldsCollection;
use Wpx\Form\Model\Element;
use Wpx\Form\Model\Field\Input;
use Wpx\Form\Model\Field\Textarea;
use Wpx\Form\FormStyle\Simple;
use Wpx\Form\Service\EventsRegistry;
use Wpx\Form\Service\Factory;
use Wpx\Form\Service\Renderer;

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
		$renderer = new Renderer(new EventsRegistry());
		$out = $renderer->renderForm($form);
		echo $out;

		?>
		<pre style="border: 1px solid #bbb; padding: 6px;"><?= htmlentities(
			str_replace("><", ">\n<", $out)
		) ?></pre>
		<?php
		dump($form->getSubmittedValues()->all());
	}

	public function mkform() {
		$builder = new Factory();
		return $builder
			->createForm(
				'whatwhat',
				$this->actionPath('simple-form'),
				'POST',
				new FieldsCollection([
					(new Input(new Element('', ['type' => 'text']), 'testing123', 'Test Field')),
					(new Input(new Element('', ['type' => 'checkbox']), 'my-checkbox', 'What about checkboxes?')),
					(new Textarea(new Element(), 'my-textarea', 'Message')),
					(new Input(new Element('', ['type' => 'submit']), 'testing123'))->setValue('Save'),
				]),
				new Simple(),
				null,
			)
				->setDefaultValues([
					'testing123' => 'This is my default value',
				]);
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
