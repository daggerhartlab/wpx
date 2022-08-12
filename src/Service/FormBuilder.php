<?php

namespace Wpx\Service;

use Wpx\Form\Collection\Attributes;
use Wpx\Form\Collection\FieldsCollection;
use Wpx\Form\Collection\FormStylesCollection;
use Wpx\Form\Collection\FormStylesCollectionInterface;
use Wpx\Form\FormBase;
use Wpx\Form\FormStyle\FormStyleInterface;
use Wpx\Form\FormStyle\Simple;

class FormBuilder {

	/**
	 * @var FormStylesCollectionInterface
	 */
	protected $formStyles;

	/**
	 * Constructor.
	 */
	public function __construct() {
		// @todo - refactor to injection
		$this->formStyles = new FormStylesCollection( [
			'simple' => new Simple(),
		] );
	}

	/**
	 * Create a new form instance by providing important values.
	 *
	 * @param string $id
	 * @param string $action
	 * @param string $method
	 * @param FormStyleInterface|null $form_style
	 * @param Attributes|null $attributes
	 * @param FieldsCollection|null $fields_collection
	 *
	 * @return FormBase
	 */
	public function create(
		string $id,
		string $action = '',
		string $method = 'POST',
		FormStyleInterface $form_style = null,
		Attributes $attributes = null,
		FieldsCollection $fields_collection = null )
	{
		$form = new FormBase();
		return $form
			->setId( $id )
			->setAction( $action )
			->setMethod( $method )
			// @todo - registry for form styles.
			->setFormStyle( $form_style ?? new Simple() )
			->setAttributes( $attributes ?? new Attributes( [] ) )
			->setFields( $fields_collection ?? new FieldsCollection( [] ) );
	}

}
