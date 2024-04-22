<?php
class FEREQFeaturesRequest
{
	public function __construct()
	{
		add_action('enqueue_block_assets', [$this, 'enqueueBlockAssets']);
		add_action('init', [$this, 'onInit']);
	}

	function enqueueBlockAssets()
	{
		wp_register_style('fontAwesome', FEREQ_DIR_URL . 'assets/css/font-awesome.min.css', [], '6.4.2'); // Icon
	}

	function onInit()
	{
		wp_register_style('fereq-features-request-style', FEREQ_DIR_URL . 'dist/style.css', ['fontAwesome'], FEREQ_VERSION); // Style
		wp_register_style('fereq-features-request-editor-style', FEREQ_DIR_URL . 'dist/editor.css', ['fereq-features-request-style'], FEREQ_VERSION); // Backend Style

		register_block_type(__DIR__, [
			'editor_style' => 'fereq-features-request-editor-style',
			'render_callback' => [$this, 'render']
		]); // Register Block

		wp_set_script_translations('fereq-features-request-editor-script', 'features-request', FEREQ_DIR_PATH . 'languages');
	}

	function render($attributes)
	{
		extract($attributes);

		wp_enqueue_style('fereq-features-request-style');
		wp_enqueue_script('fereq-features-request-script', FEREQ_DIR_URL . 'dist/script.js', ['react', 'react-dom'], FEREQ_VERSION, true);
		wp_set_script_translations('fereq-features-request-script', 'features-request', FEREQ_DIR_PATH . 'languages');




		return do_shortcode("[features-request]");
	}
}
new FEREQFeaturesRequest();