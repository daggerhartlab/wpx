<?php

namespace Wpx\Form\Service;

use Wpx\Form\Model\ElementInterface;
use Wpx\Form\Event\ElementEvent;
use Wpx\Form\Event\FieldEvent;
use Wpx\Form\Event\FormEvent;
use Wpx\Form\Model\FieldInterface;
use Wpx\Form\Model\FormInterface;

interface RendererInterface {

	public const EVENT_PRE_RENDER_FORM = 'onPreRenderForm';
	public const EVENT_PRE_RENDER_FIELD = 'onPreRenderField';
	public const EVENT_PRE_RENDER_ELEMENT = 'onPreRenderElement';

	/**
	 * @param EventsRegistryInterface $events_registry
	 *
	 * @return RendererInterface
	 */
	public function setEventsRegistry( EventsRegistryInterface $events_registry ): RendererInterface;

	/**
	 * Fully render the form object into Html string.
	 *
	 * @param FormInterface $form
	 *
	 * @return string
	 */
	public function renderForm( FormInterface $form ): string;

	/**
	 * @param FieldInterface $field
	 * @param FormInterface $form
	 *
	 * @return string
	 */
	public function renderField( FieldInterface $field, FormInterface $form ): string;

	/**
	 * Render all
	 * @param ElementInterface $element
	 *
	 * @return string
	 */
	public function renderElement( ElementInterface $element ): string;

	/**
	 * Adjust the form object immediately before rendering.
	 *
	 * @param FormEvent $event
	 *
	 * @return void
	 */
	public function onPreRenderForm( FormEvent $event ): void;

	/**
	 * Adjust the field object immediately before rendering.
	 *
	 * @param FieldEvent $event
	 *
	 * @return void
	 */
	public function onPreRenderField( FieldEvent $event ): void;

	/**
	 * Adjust the element object immediately before rendering.
	 *
	 * @param ElementEvent $event
	 *
	 * @return void
	 */
	public function onPreRenderElement( ElementEvent $event ): void;

}
