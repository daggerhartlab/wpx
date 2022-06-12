<?php
/**
 * Plugin Name: Wpx Options Config
 * Version: 0.1
 * Dependencies: advanced-custom-fields-pro/acf.php
 */

use Composer\Autoload\ClassLoader;
use WpxExampleConfig\AdminConfigPage;

/** @var ClassLoader $__composer_class_loader */
global $__composer_class_loader;
if ($__composer_class_loader instanceof ClassLoader) {
	$__composer_class_loader->addPsr4('WpxExampleConfig\\', __DIR__ . '/src');
}

add_action('admin_menu', function() {
	$page = AdminConfigPage::create(\Wpx::getContainer());
	$page->addToMenu();
});
