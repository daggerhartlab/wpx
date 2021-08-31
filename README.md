# WPX

# Examples

## Admin Pages

```php
<?php
class MyParentPage extends \Wpx\Admin\AdminPageBase {

	public function slug() {
		return 'my_parent_page';
	}

	public function title() {
		return __( 'My Parent Page' );
	}

	public function content() {
		echo 'I am a top-level page';
	}

}
```

```php
<?php
class MyChildPage extends \Wpx\Admin\AdminPageBase{

	public function slug() {
		return 'my_child_page';
	}

	public function title() {
		return __( 'My Child Page' );
	}

	public function content() {
		echo 'I am a child of the top-level page';
	}

}
```

### Registering admin pages in a plugin.

```php
<?php
add_action( 'admin_menu', function() {
	$parentPage = new MyParentPage();
	$parentPage->addToMenu();

	$childPage = new MyChildPage();
	$childPage->addToSubMenu($parentPage);
} );
```