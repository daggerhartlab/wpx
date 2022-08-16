<?php

namespace Wpx\Form\Event;

use Wpx\Form\Model\FormInterface;

class FormEvent implements EventInterface {

	/**
	 * @var FormInterface
	 */
	protected $form;

	/**
	 * @param FormInterface $form
	 */
	public function __construct( FormInterface $form ) {
		$this->form = $form;
	}

	/**
	 * @return FormInterface
	 */
	public function getForm(): FormInterface {
		return $this->form;
	}

}
