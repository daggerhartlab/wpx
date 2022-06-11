<?php
/**
 * Plugin Name: Wpx Admin Pages.
 * Version: 0.1
 */

/** @var \Composer\Autoload\ClassLoader $__autoload */
global $__autoload;
$__autoload->addPsr4('WpxExampleAdminPages\\', __DIR__ . '/src');

use WpxExampleAdminPages\PageChild1;
use WpxExampleAdminPages\PageChild2;
use WpxExampleAdminPages\PageTopLevel;

add_action('admin_menu', function() {
	$top = new PageTopLevel();
	$top->addToMenu();
	$child1 = new PageChild1();
	$child1->addToSubMenu($top, 100);
	$child2 = new PageChild2();
	$child2->addToSubMenu($top, 1);
});
