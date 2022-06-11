<?php

namespace WpxExampleAdminPages;

use Wpx\Admin\AdminPageBase;

class PageChild1 extends AdminPageBase {

	/**
	 * @inheritDoc
	 */
	public function slug() {
		return 'child-1';
	}

	/**
	 * @inheritDoc
	 */
	public function title() {
		return 'Child 1';
	}

	/**
	 * @inheritDoc
	 */
	public function content() {
		echo "This is the first child page.";
	}

}
