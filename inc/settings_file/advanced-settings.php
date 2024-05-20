<?php

if (isset($_GET['settings-updated'])) {
    add_settings_error('theme_options_messages', 'theme_options_message', __('Settings Saved', 'textdomain'), 'updated');
}

settings_errors('theme_options_messages');
?>


<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <form method="post" action="options.php">
        <?php
        settings_fields('fereq_options_group');
        do_settings_sections('fereq-settings');
        submit_button(__('Save Changes', 'store-finder'));
        ?>
    </form>
</div>

