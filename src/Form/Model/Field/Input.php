<?php

namespace Wpx\Form\Model\Field;

use Wpx\Form\Model\FieldTypeBase;

class Input extends FieldTypeBase {

	/*
	 * Input types.
	 */
	public const TYPE_BUTTON = 'button';
	public const TYPE_CHECKBOX = 'checkbox';
	public const TYPE_COLOR = 'color';
	public const TYPE_DATE = 'date';
	public const TYPE_DATETIME_LOCAL = 'datetime-local';
	public const TYPE_EMAIL = 'email';
	public const TYPE_FILE = 'file';
	public const TYPE_HIDDEN = 'hidden';
	public const TYPE_IMAGE = 'image';
	public const TYPE_MONTH = 'month';
	public const TYPE_NUMBER = 'number';
	public const TYPE_PASSWORD = 'password';
	public const TYPE_RADIO = 'radio';
	public const TYPE_RANGE = 'range';
	public const TYPE_RESET = 'reset';
	public const TYPE_SEARCH = 'search';
	public const TYPE_SUBMIT = 'submit';
	public const TYPE_TEL = 'tel';
	public const TYPE_TEXT = 'text';
	public const TYPE_TIME = 'time';
	public const TYPE_URL = 'url';
	public const TYPE_WEEK = 'week';

	/*
	 * All types for loops and validation.
	 */
	protected $types = [
		self::TYPE_BUTTON,
		self::TYPE_CHECKBOX,
		self::TYPE_COLOR,
		self::TYPE_DATE,
		self::TYPE_DATETIME_LOCAL,
		self::TYPE_EMAIL,
		self::TYPE_FILE,
		self::TYPE_HIDDEN,
		self::TYPE_IMAGE,
		self::TYPE_MONTH,
		self::TYPE_NUMBER,
		self::TYPE_PASSWORD,
		self::TYPE_RADIO,
		self::TYPE_RANGE,
		self::TYPE_RESET,
		self::TYPE_SEARCH,
		self::TYPE_SUBMIT,
		self::TYPE_TEL,
		self::TYPE_TEXT,
		self::TYPE_TIME,
		self::TYPE_URL,
		self::TYPE_WEEK,
	];

	/**
	 * @inheritDoc
	 */
	public static function id(): string {
		return 'field_input';
	}

	/**
	 * @inheritDoc
	 */
	public static function defaultElementTag(): string {
		return 'input';
	}

}
