<?php

namespace Wpx\Form\Service;

use Symfony\Component\HttpFoundation\Request;
use Wpx\Form\Collection\Attributes;
use Wpx\Form\Collection\FieldsCollection;
use Wpx\Form\Collection\FormStylesCollection;
use Wpx\Form\Collection\FormStylesCollectionInterface;
use Wpx\Form\Model\Element;
use Wpx\Form\Model\FormBase;
use Wpx\Form\Model\FormInterface;
use Wpx\Form\FormStyle\FormStyleInterface;
use Wpx\Form\FormStyle\Simple;
use Wpx\Http\RequestFactory;

class Factory {

	const DEFAULT_STYLE = 'simple';

	/**
	 * @var FormStylesCollectionInterface
	 */
	protected $formStyles;

	/**
	 * @var Request
	 */
	protected $request;

	/**
	 * Constructor.
	 */
	public function __construct() {
		// @todo - refactor to injection
		$this->formStyles = new FormStylesCollection( [
			static::DEFAULT_STYLE => new Simple(),
		] );
		// @todo - refactor to injection
		$this->request = RequestFactory::createFromGlobals();
	}

	/**
	 * Create a new form instance by providing important values.
	 *
	 * @param string $id
	 * @param string $action
	 * @param string $method
	 * @param FieldsCollection|null $fields_collection
	 * @param FormStyleInterface|null $form_style
	 * @param Attributes|null $attributes
	 * @param Request|null $request
	 *
	 * @return FormInterface
	 */
	public function createForm(
		string $id,
		string $action = '',
		string $method = 'GET',
		FieldsCollection $fields_collection = null,
		FormStyleInterface $form_style = null,
		Attributes $attributes = null,
		Request $request = null
	): FormInterface
	{
		return ( new FormBase( new Element() ) )
			->setId( $id )
			->setAction( $action )
			->setMethod( $method )
			->setRequest( $request ?? $this->request )
			->setFormStyle( $form_style ?? $this->formStyles->get( static::DEFAULT_STYLE ) )
			->setAttributes( $attributes ?? new Attributes( [] ) )
			->setChildren( $fields_collection ?? new FieldsCollection( [] ) )
			->setEventRegistry( new EventsRegistry() )
			;
	}

}
