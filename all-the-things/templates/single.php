<?php if ( isset($_GET['demo']) ) : ?>
	<style>
		.all-the-things :is(.site-header, .site-footer, .wp-block-post-title) {
			display: none !important;
		}
	</style>
<?php endif; ?>
<?php include locate_template('page.php'); ?>
