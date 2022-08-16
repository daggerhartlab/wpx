<?php

namespace Wpx\Form\Service;

use Wpx\Form\Collection\Attributes;
use Wpx\Form\Model\ElementInterface;
use Wpx\Form\Event\ElementEvent;
use Wpx\Form\Event\FieldEvent;
use Wpx\Form\Event\FormEvent;
use Wpx\Form\Model\FieldInterface;
use Wpx\Form\Model\FormInterface;

class Renderer implements RendererInterface {

	/**
	 * @var EventsRegistryInterface
	 */
	protected $eventRegistry;

	/**
	 * @param EventsRegistryInterface $events_registry
	 */
	public function __construct( EventsRegistryInterface $events_registry ) {
		$this->setEventsRegistry( $events_registry );
	}

	/**
	 * @inheritDoc
	 */
	public function setEventsRegistry( EventsRegistryInterface $events_registry ): RendererInterface {
		$render_events = [
			RendererInterface::EVENT_PRE_RENDER_FORM => [
				[$this, 'onPreRenderForm'],
			],
			RendererInterface::EVENT_PRE_RENDER_FIELD => [
				[$this, 'onPreRenderField'],
			],
			RendererInterface::EVENT_PRE_RENDER_ELEMENT => [
				[$this, 'onPreRenderElement'],
			],
		];

		$this->eventRegistry = $events_registry;
		foreach ( $render_events as $event_name => $subscribers ) {
			$this->eventRegistry->registerEvent( $event_name, $subscribers );
		}

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function renderForm( FormInterface $form ): string {
		$this->eventRegistry->dispatchEvent( new FormEvent( $form ), self::EVENT_PRE_RENDER_FORM );
		$style = $form->getFormStyle();

		$form_html = '';
		/** @var FieldInterface $field */
		foreach ($form->getChildren() as $field) {

			// Render the field and descriptors to html.
			$field_html = $this->renderField( $field, $form );
			$label = $this->renderElement( $field->getDescriptor('label') );
			$description = $this->renderElement( $field->getDescriptor('description') );
			$help = $this->renderElement( $field->getDescriptor('help') );
			$before_field = '';
			$after_field = '';

			// Everything before the field.
			foreach ( $field->getDescriptors() as $element ) {
				if ( $element->getPosition() === ElementInterface::POSITION_BEFORE_FIELD ) {
					$before_field .= $style->renderElement( $element );
				}
			}

			// Everything after the field.
			foreach ( $field->getDescriptors() as $element ) {
				if ( $element->getPosition() === ElementInterface::POSITION_AFTER_FIELD ) {
					$after_field .= $this->renderElement( $element );
				}
			}

			$form_html .= $style->renderFieldWrapperTemplate( $field, $field_html, [
				'label' => $label,
				'description' => $description,
				'help' => $help,
				'before_field' => $before_field,
				'after_field' => $after_field,
			] );
		}

		return $style->renderFormTemplate( $form, $form_html );
	}

	/**
	 * @inheritDoc
	 */
	public function renderField( FieldInterface $field, FormInterface $form ): string {
		$this->eventRegistry->dispatchEvent( new FieldEvent( $field ), self::EVENT_PRE_RENDER_FIELD );
		return $form->getFormStyle()->renderFieldTemplate( $field );
	}

	/**
	 * @inheritDoc
	 */
	public function renderElement( ElementInterface $element ): string {
		$this->eventRegistry->dispatchEvent( new ElementEvent( $element ), self::EVENT_PRE_RENDER_ELEMENT );
		return '';
	}

	/**
	 * @inheritDoc
	 */
	public function onPreRenderForm( FormEvent $event ): void {
		$form = $event->getForm();
		$form->getAttributes()
		     ->set( 'id', $form->getId() )
		     ->set( 'method', $form->getMethod() )
		     ->set( 'action', $form->getAction() );

		$form->setAttributes( new Attributes( $form->getAttributes()->filter()->all() ) );
	}

	/**
	 * @inheritDoc
	 */
	public function onPreRenderField( FieldEvent $event ): void {
		$field = $event->getField();
		$form = $field->getParent();
		$field->getElement()->getAttributes()
		      ->set( 'id', $field->getId() )
		      ->set( 'name', $form->getId() . '[' . $field->getName() . ']' )
		      ->set( 'value', $field->getValue() ?? '' );

		$field->getElement()->setAttributes( new Attributes( $field->getElement()->getAttributes()->filter()->all() ) );

		// Prepare the descriptors.
		$field->getLabel()
		      ->setTag( 'label' )
		      ->getAttributes()
		      ->set( 'for', $form->getId() );

		// Hide empty descriptors.
		foreach ( $field->getDescriptors() as $element ) {
			if ( empty( $element->getContent() ) ) {
				$element->setPosition( ElementInterface::POSITION_HIDDEN );
			}
		}

		// Sort descriptors.
		$field->setDescriptors( $field->getDescriptors()->sortedByOrder() );
	}

	/**
	 * @inheritDoc
	 */
	public function onPreRenderElement( ElementEvent $event ): void {
		$element = $event->getElement();
		$element->setAttributes( new Attributes( $element->getAttributes()->filter()->all() ?? [] ) );
	}

}
