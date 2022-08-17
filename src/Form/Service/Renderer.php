<?php

namespace Wpx\Form\Service;

use Wpx\Form\Collection\Attributes;
use Wpx\Form\Event\ControlEvent;
use Wpx\Form\Model\ControlInterface;
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
			RendererInterface::EVENT_PRE_RENDER_CONTROL => [
				[$this, 'onPreRenderControl'],
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
		$event = new FormEvent( $form );
		$this->eventRegistry->dispatchEvent( $event, self::EVENT_PRE_RENDER_FORM );
		$form->getEventRegistry()->dispatchEvent( $event, self::EVENT_PRE_RENDER_FORM );

		return $this->renderControl( $form, $form );
	}

	/**
	 * @inheritDoc
	 */
	public function renderControl( ControlInterface $control, FormInterface $form ): string {
		$event = new ControlEvent( $control );
		$this->eventRegistry->dispatchEvent( $event, self::EVENT_PRE_RENDER_CONTROL );
		$control->getEventRegistry()->dispatchEvent( $event, self::EVENT_PRE_RENDER_CONTROL );

		$style = $form->getFormStyle();
		$html = '';

		/**
		 * @var ControlInterface $child
		 * @var ElementInterface $element
		 */
		foreach ($control->getChildren() as $child) {
			// Render the field and descriptors to html.
			$field_html = $this->renderField( $child, $form );
			$label = $this->renderElement( $child->getDescriptor('label'), $form );
			$description = $this->renderElement( $child->getDescriptor('description'), $form );
			$help = $this->renderElement( $child->getDescriptor('help'), $form );

			// Recursive child rendering.
			$children_html = '';
			if ($child->hasChildren()) {
				$children_html = $this->renderControl( $child, $form );
			}

			// Everything before the field.
			$before_field = '';
			foreach ( $child->getDescriptors() as $element ) {
				if ( !$element->isEmpty() && $element->getPosition() === ElementInterface::POSITION_BEFORE_FIELD ) {
					$before_field .= $style->renderElementTemplate( $element );
				}
			}

			// Everything after the field.
			$after_field = '';
			foreach ( $child->getDescriptors() as $element ) {
				if ( !$element->isEmpty() &&  $element->getPosition() === ElementInterface::POSITION_AFTER_FIELD ) {
					$after_field .= $this->renderElement( $element, $form );
				}
			}

			if ( $child instanceof FieldInterface ) {
				$html .= $style->renderFieldWrapperTemplate( $child, $field_html, [
					'label' => $label,
					'description' => $description,
					'help' => $help,
					'before_field' => $before_field,
					'after_field' => $after_field,
					'children_html' => $children_html,
				] );
			}
			elseif ( $child instanceof ControlInterface ) {
				$html .= $style->renderControlTemplate( $child, $children_html );
			}
		}

		return $style->renderControlTemplate( $control, $html );
	}

	/**
	 * @inheritDoc
	 */
	public function renderField( FieldInterface $field, FormInterface $form ): string {
		$event = new FieldEvent( $field );
		$this->eventRegistry->dispatchEvent( $event, self::EVENT_PRE_RENDER_FIELD );
		$form->getEventRegistry()->dispatchEvent( $event, self::EVENT_PRE_RENDER_FIELD );
		$field->getEventRegistry()->dispatchEvent( $event, self::EVENT_PRE_RENDER_FIELD );

		return $form->getFormStyle()->renderFieldTemplate( $field );
	}

	/**
	 * @inheritDoc
	 */
	public function renderElement( ElementInterface $element, FormInterface $form ): string {
		$this->eventRegistry->dispatchEvent( new ElementEvent( $element ), self::EVENT_PRE_RENDER_ELEMENT );
		return $form->getFormStyle()->renderElementTemplate( $element );
	}

	/**
	 * @inheritDoc
	 */
	public function onPreRenderForm( FormEvent $event ): void {
		$form = $event->getForm();
		$form->getElement()->setTag( 'form' );
		$form->getElementAttributes()
		     ->set( 'id', $form->getElementId() )
		     ->set( 'method', $form->getMethod() )
		     ->set( 'action', $form->getAction() );

		$form->setElementAttributes( new Attributes( $form->getElementAttributes()->filter()->all() ) );
	}

	/**
	 * @inheritDoc
	 */
	public function onPreRenderControl( ControlEvent $event ): void {
		$control = $event->getControl();
		$control->getElementAttributes()
			->set( 'id', $control->getElementId() );

		$control->setElementAttributes( new Attributes( $control->getElementAttributes()->filter()->all() ) );
	}

	/**
	 * @inheritDoc
	 */
	public function onPreRenderField( FieldEvent $event ): void {
		$field = $event->getField();
		$form = $field->getParent();
		$field->getElement()->getAttributes()
		      ->set( 'id', $field->getElementId() )
		      ->set( 'name', $form->getElementId() . '[' . $field->getName() . ']' )
		      ->set( 'value', $field->getValue() ?? '' );

		$field->getElement()->setAttributes( new Attributes( $field->getElement()->getAttributes()->filter()->all() ) );

		// Prepare the descriptors.
		$field
			->getLabelElement()
		    ->setTag( 'label' )
		    ->getAttributes()
		    ->set( 'for', $form->getElementId() );
		$field
			->getDescriptionElement()
			->setTag('div')
			->setAttribute('class', ['description']);
		$field
			->getHelpTextElement()
			->setTag('div')
			->setAttribute('class', ['help']);

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
