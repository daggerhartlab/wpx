<?php

namespace WpxExampleAdminPages;

use Wpx\Admin\AdminPageBase;
use Wpx\Form\Collection\ControlsCollection;
use Wpx\Form\Model\ControlBase;
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
//			'simple-form' => [$this, 'submitSimpleForm'],
		];
	}

//	public function submitSimpleForm() {
////		dump($_REQUEST);
//		$this->validateAction();
//		$form = $this->mkform();
////		dump($_REQUEST);
////		die;
//		ob_start();
//		dump('form_submitted_values', $form->getSubmittedValues()->all());
//		dump('form_request', $form->getRequest());
//		dump('_REQUEST', $_REQUEST);
//		$ob = ob_get_clean();
//		return $this->result("submitted " . $ob);
//	}

	/**
	 * @inheritDoc
	 */
	public function content() {
		$form = $this->mkform();
		//dump($form);
		$renderer = new Renderer(new EventsRegistry());
		$out = $renderer->renderForm($form);
		echo $out;

		?>
		<pre style="border: 1px solid #bbb; padding: 6px;"><?= htmlentities(
			str_replace("><", ">\n<", $out)
		) ?></pre>
		<?php
		dump($form->getSubmittedValues());
		dump($form->getSubmittedValues()->get('my-group.2nd-nested-group.sub-field1'));
	}

	public function mkform() {
		$builder = new Factory();
		return $builder
			->createForm(
				'whatwhat',
				$this->pagePath(),
				//$this->actionPath('simple-form'),
				'POST',
				new ControlsCollection([
					(
						new Input(new Element('', ['type' => Input::TYPE_TEXT]), 'testing123', 'Test Field')
					),

					(
						new Input(new Element('', ['type' => Input::TYPE_CHECKBOX]), 'my-checkbox', 'What about checkboxes?')
					),

					(
						new Textarea(new Element(), 'my-textarea', 'Message')
					),

					// 1st nested group.
					(
						new ControlBase(new Element(), 'my-group')
					)->setChildren(
						new ControlsCollection([
							(
								new Input(new Element(), 'f-number', 'Number')
							)->setElementAttribute('type', Input::TYPE_NUMBER),
							(
								new Input(new Element(), 'sub-field2', 'Sub Field 2')
							)->setElementAttribute('type', Input::TYPE_TEXT),

							// 2nd nested group
							(
								new ControlBase(
									(new Element())
										->setTag('fieldset'),
									'2nd-nested-group'
								)
							)->setChildren(
								new ControlsCollection([
									(
									new Input(new Element(), 'sub-field1', 'Sub Field 1')
									)->setElementAttribute('type', Input::TYPE_TEXT),
									(
									new Input(new Element(), 'sub-field2', 'Sub Field 2')
									)->setElementAttribute('type', Input::TYPE_TEXT)
								])
							),
						])
					),
					(
						new Input(new Element('', ['type' => Input::TYPE_SUBMIT]), 'submit')
					)->setValue('Save'),
				]),
				new Simple(),
				null,
			)
				->setDefaultValues([
					'testing123' => 'This is my default value',
					'my-group' => [
						'2nd-nested-group' => [
							'sub-field1' => 'Nested default value.'
						]
					],
				]);

	}

}
