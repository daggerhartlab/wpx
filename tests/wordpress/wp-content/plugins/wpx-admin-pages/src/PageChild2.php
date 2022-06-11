<?php

namespace WpxExampleAdminPages;

use Wpx\Admin\AdminPageBase;

class PageChild2 extends AdminPageBase {

	/**
	 * @inheritDoc
	 */
	public function slug() {
		return 'child-2';
	}

	/**
	 * @inheritDoc
	 */
	public function title() {
		return 'Child 2';
	}

	/**
	 * @inheritDoc
	 */
	public function menuTitle() {
		return 'Child 2 Menu Title';
	}

	/**
	 * @inheritDoc
	 */
	public function content() {
		echo "This is the second child page.";
	}

}
