<?php

namespace Wpx\Form\Event;

interface EventInterface {

	/*
	 * Render events.
	 */
	public const EVENT_PRE_RENDER_FORM = 'onPreRenderForm';
	public const EVENT_PRE_RENDER_CONTROL = 'onPreRenderControl';
	public const EVENT_PRE_RENDER_FIELD = 'onPreRenderField';
	public const EVENT_PRE_RENDER_ELEMENT = 'onPreRenderElement';

}
