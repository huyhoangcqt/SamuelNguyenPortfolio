<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<?php
global $header_renderer;
$header_renderer->render(); // Thay 'Contact Page' bằng tiêu đề trang của bạn
?>