<?php

// Set custom 'From' address
add_filter('wp_mail_from', 'custom_wp_mail_from');
function custom_wp_mail_from($original_email_address)
{
    return 'your_custom_email@example.com';
}

// Set custom 'From' name
add_filter('wp_mail_from_name', 'custom_wp_mail_from_name');
function custom_wp_mail_from_name($original_email_from)
{
    return 'Your Custom Name';
}
