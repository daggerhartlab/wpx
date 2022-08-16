<?php

namespace Wpx\Form\Model;

use Symfony\Component\HttpFoundation\Request;
use Wpx\Http\RequestFactory;
use Wpx\Form\Collection\SubmittedValues;
use Wpx\Form\Collection\SubmittedValuesInterface;
use Wpx\Form\FormStyle\FormStyleInterface;

class FormBase extends ControlBase implements FormInterface {

	/**
	 * @var Request
	 */
	protected $request;

	/**
	 * @var string
	 */
	protected $defaultMethod = 'GET';

	/**
	 * Route for the form.
	 *
	 * @var string
	 */
	protected $defaultAction = '';

	/**
	 * @var FormStyleInterface
	 */
	protected $formStyle;

	/**
	 * @var SubmittedValuesInterface
	 */
	protected $submittedValues;

	/**
	 * @inheritDoc
	 */
	public function getRequest(): Request {
		return $this->request ?? RequestFactory::createFromGlobals();
	}

	/**
	 * @inheritDoc
	 */
	public function setRequest( Request $request ): FormInterface {
		$this->request = $request;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function setElement( ElementInterface $element ) {
		$element->setTag('form');
		return parent::setElement( $element );
	}

	/**
	 * @inheritDoc
	 */
	public function getMethod(): string {
		return $this->getAttributes()->get('method', $this->defaultMethod);
	}

	/**
	 * @inheritDoc
	 */
	public function setMethod( string $method ): FormInterface {
		$this->getElement()
		     ->getAttributes()
		     ->set('method', $method);

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getAction(): string {
		return $this->getAttributes()->get('action', $this->defaultAction);
	}

	/**
	 * @inheritDoc
	 */
	public function setAction( string $action ): FormInterface {
		$this->getElement()
		     ->getAttributes()
		     ->set('action', $action);

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getFormStyle(): FormStyleInterface {
		return $this->formStyle;
	}

	/**
	 * @inheritDoc
	 */
	public function setFormStyle( FormStyleInterface $style ): FormInterface {
		$this->formStyle = $style;
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function isSubmitted(): bool {
		return (
			$this->getRequest()->isMethod( $this->getMethod() ) &&
			$this->getSubmittedValues()
		);
	}

	/**
	 * @inheritDoc
	 */
	public function getSubmittedValues(): SubmittedValuesInterface {
		if ( !empty( $this->submittedValues ) ) {
			return $this->submittedValues;
		}

		switch ($this->getRequest()->getMethod()) {
			case 'get':
				$values = $this->getRequest()->query->all()[ $this->getId() ] ?? [];
				break;

			case 'post':
			default:
				$values = $this->getRequest()->request->all()[ $this->getId() ] ?? [];
				break;
		}

		$this->submittedValues = new SubmittedValues( $values );
		return $this->submittedValues;
	}

}
