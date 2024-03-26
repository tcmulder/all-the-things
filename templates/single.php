<?php if ( isset($_GET['demo']) ) : ?>
	<style>
		.all-the-things :is(.site-header, .site-footer, .wp-block-post-title) {
			display: none !important;
		}
	</style>
<?php endif; ?>
<?php locate_template( array( 'page.php', 'index.php' ), true ); ?>
