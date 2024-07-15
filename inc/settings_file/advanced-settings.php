<?php
//phpcs:ignore WordPress.Security.NonceVerification.Recommended
if (isset($_GET['settings-updated'])) {
    add_settings_error('theme_options_messages', 'theme_options_message', __('Settings Saved', 'features-request'), 'updated');
}

settings_errors('theme_options_messages');
?>


<div class="wrap">

    <form method="post" action="options.php">
    
        <?php
        settings_fields('fereq_options_group');
        do_settings_sections('fereq-settings');
        submit_button(__('Save Changes', 'store-finder'));
        
        ?>
        

    </form>
</div>