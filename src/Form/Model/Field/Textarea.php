<?php

namespace Wpx\Form\Model\Field;

use Wpx\Form\Model\FieldBase;

class Textarea extends FieldBase {

	/**
	 * @inheritDoc
	 */
	public static function getDefaultElementTag(): string {
		return 'textarea';
	}

}
