<?php
/**
 * Plugin Name: Wpx Admin Pages.
 * Version: 0.1
 * Dependencies: advanced-custom-fields-pro/acf.php
 */

use Composer\Autoload\ClassLoader;
use WpxExampleAdminPages\AcfChildPage;
use WpxExampleAdminPages\AcfPageTopLevel;
use WpxExampleAdminPages\PageChild1;
use WpxExampleAdminPages\PageChild2;
use WpxExampleAdminPages\PageTopLevel;
use WpxExampleAdminPages\SimpleForm;

/** @var ClassLoader $__composer_class_loader */
global $__composer_class_loader;
if ($__composer_class_loader instanceof ClassLoader) {
	$__composer_class_loader->addPsr4('WpxExampleAdminPages\\', __DIR__ . '/src');
}

add_action('admin_menu', function() {
	$top = new PageTopLevel();
	$top->addToMenu();
	$child1 = new PageChild1();
	$child1->addToSubMenu($top, 100);
	$child2 = new PageChild2();
	$child2->addToSubMenu($top, 1);

	$acf_top = new AcfPageTopLevel();
	$acf_top->addToMenu();
	$acf_child = new AcfChildPage();
	$acf_child->addToSubMenu($acf_top);

	$simple_form = new SimpleForm();
	$simple_form->addToMenu();
});
