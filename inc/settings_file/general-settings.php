<h2>general-settings</h2>
<?php

// Inside general-settings.php
function fereq_plugin_general_settings_init()
{
    // Register setting
    register_setting('fereq_plugin_general_settings', 'fereq_plugin_option');

    // Add settings section
    add_settings_section('fereq_plugin_general_section', 'General Settings', 'fereq_plugin_general_section_callback', 'fereq-settings');

    // Add settings field
    add_settings_field('fereq_plugin_option_field', 'My Option', 'fereq_plugin_option_field_callback', 'fereq-settings', 'fereq_plugin_general_section');
}
add_action('admin_init', 'fereq_plugin_general_settings_init');

function fereq_plugin_general_section_callback()
{
    echo '<p>This is the description for the General Settings section.</p>';
}

function fereq_plugin_option_field_callback()
{
    $option_value = get_option('fereq_plugin_option');
    echo "<input type='text' name='fereq_plugin_option' value='$option_value' />";
}
