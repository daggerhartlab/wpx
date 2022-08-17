<?php

namespace Wpx\Form\Model;

use Symfony\Component\HttpFoundation\Request;
use Wpx\Form\Collection\ControlsCollectionInterface;
use Wpx\Form\Collection\SubmittedValuesInterface;
use Wpx\Form\FormStyle\FormStyleInterface;

interface FormInterface extends ControlInterface {

	/**
	 * @return Request
	 */
	public function getRequest(): Request;

	/**
	 * @param Request $request
	 *
	 * @return FormInterface
	 */
	public function setRequest( Request $request ): FormInterface;

	/**
	 * Form submit method.
	 *
	 * @return string
	 */
	public function getMethod(): string;

	/**
	 * Set the form method attribute.
	 *
	 * @param string $method
	 *
	 * @return FormInterface
	 */
	public function setMethod( string $method ): FormInterface;

	/**
	 * Form action attribute (url|uri).
	 *
	 * @return string
	 */
	public function getAction(): string;

	/**
	 * Set the action attribute for the form.
	 *
	 * @param string $action
	 *
	 * @return self
	 */
	public function setAction( string $action ): FormInterface;

	/**
	 * Form style.
	 *
	 * @return FormStyleInterface
	 */
	public function getFormStyle(): FormStyleInterface;

	/**
	 * Set the form style object.
	 *
	 * @param FormStyleInterface $style
	 *
	 * @return FormBase
	 */
	public function setFormStyle( FormStyleInterface $style ): FormInterface;

	/**
	 * Whether the form has been submitted.
	 *
	 * @return bool
	 */
	public function isSubmitted(): bool;

	/**
	 * Get all values submitted by the form.
	 *
	 * @return SubmittedValuesInterface
	 */
	public function getSubmittedValues(): SubmittedValuesInterface;

}
