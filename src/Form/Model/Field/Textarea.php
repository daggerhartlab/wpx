<?php

namespace Wpx\Form\Model\Field;

use Wpx\Form\Model\FieldTypeBase;

class Textarea extends FieldTypeBase {

	/**
	 * @inheritDoc
	 */
	public static function id(): string {
		return 'field_textarea';
	}

	/**
	 * @inheritDoc
	 */
	public static function defaultElementTag(): string {
		return 'textarea';
	}

}
