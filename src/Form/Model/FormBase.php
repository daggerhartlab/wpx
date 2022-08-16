<?php

namespace Wpx\Form\Model;

use Symfony\Component\HttpFoundation\Request;
use Wpx\Http\RequestFactory;
use Wpx\Form\Collection\SubmittedValues;
use Wpx\Form\Collection\SubmittedValuesInterface;
use Wpx\Form\FormStyle\FormStyleInterface;

class FormBase extends ContainerBase implements FormInterface {

	/**
	 * @var Request
	 */
	protected $request;

	/**
	 * @var string
	 */
	protected $method = '';

	/**
	 * Route for the form.
	 *
	 * @var string
	 */
	protected $action = '';

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
	public function getMethod(): string {
		return $this->method;
	}

	/**
	 * @inheritDoc
	 */
	public function setMethod( string $method ): FormInterface {
		$this->method = $method;
		$this->getElement()
		     ->getAttributes()
		     ->set('method', $method);

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getAction(): string {
		return $this->action;
	}

	/**
	 * @inheritDoc
	 */
	public function setAction( string $action ): FormInterface {
		$this->action = $action;
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
			$this->getRequest()->isMethod( $this->method ) &&
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
