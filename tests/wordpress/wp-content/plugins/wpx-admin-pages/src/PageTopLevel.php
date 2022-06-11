<?php

namespace WpxExampleAdminPages;

use Wpx\Admin\AdminPageBase;

class PageTopLevel extends AdminPageBase {

	/**
	 * @inheritDoc
	 */
	public function slug() {
		return 'top-level';
	}

	/**
	 * @inheritDoc
	 */
	public function title() {
		return 'Top Level';
	}

	/**
	 * @inheritDoc
	 */
	public function content() {
		echo "This is the top level page.";
	}
}
