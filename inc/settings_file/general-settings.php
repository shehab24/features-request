<?php
// Check if the form is submitted
if (isset($_POST['settings_save_btn']) && check_admin_referer('my_settings_action', 'my_settings_nonce')) {
    // Suggestion Form Settings
    $suggestion_settings = array(
        'sp_title_text' => sanitize_text_field($_POST['sp_title_text']),
        'sp_textarea_text' => sanitize_text_field($_POST['sp_textarea_text']),
        'sp_drop_text' => sanitize_text_field($_POST['sp_drop_text']),
        'sp_email_text' => sanitize_text_field($_POST['sp_email_text']),
        'sp_submit_button_text' => sanitize_text_field($_POST['sp_submit_button_text']),
        'sp_tab_title_text' => sanitize_text_field($_POST['sp_tab_title_text']),
    );

    // Save Suggestion Form Settings
    update_option('suggestion_settings', $suggestion_settings);

    // Issues Form Settings
    $issues_settings = array(
        'ip_title_text' => sanitize_text_field($_POST['ip_title_text']),
        'ip_textarea_text' => sanitize_text_field($_POST['ip_textarea_text']),
        'ip_drop_text' => sanitize_text_field($_POST['ip_drop_text']),
        'ip_email_text' => sanitize_text_field($_POST['ip_email_text']),
        'ip_submit_button_text' => sanitize_text_field($_POST['ip_submit_button_text']),
        'ip_tab_title_text' => sanitize_text_field($_POST['ip_tab_title_text']),
    );

    // Save Issues Form Settings
    update_option('issues_settings', $issues_settings);

    // Frontend Feedback Button Area Settings
    $feedback_button_settings = array(
        'fda_title_text' => sanitize_text_field($_POST['fda_title_text']),
        'feedback_button_text' => sanitize_text_field($_POST['feedback_button_text']),
    );

    // Save Frontend Feedback Button Area Settings
    update_option('feedback_button_settings', $feedback_button_settings);

    $redirect_url = admin_url('admin.php?page=fereq-settings&tab=general');
    wp_redirect($redirect_url);
    exit;
}

$suggestion_settings = get_option('suggestion_settings', array(
    'sp_title_text' => 'Your suggestion in one simple sentence',
    'sp_textarea_text' => 'Details',
    'sp_drop_text' => 'Drop Your Url here',
    'sp_email_text' => 'Your Email',
    'sp_submit_button_text' => 'Submit Suggestion',
    'sp_tab_title_text' => 'Suggest Improvement'
));

$issues_settings = get_option('issues_settings', array(
    'ip_title_text' => 'Briefly describe the issue you encountered',
    'ip_textarea_text' => 'Details',
    'ip_drop_text' => 'Drop Your Url here',
    'ip_email_text' => 'Your Email',
    'ip_submit_button_text' => 'Submit Issue',
    'ip_tab_title_text' => 'Report Issue'
));

$feedback_button_settings = get_option('feedback_button_settings', array(
    'fda_title_text' => 'We are Indione. Please share your experience or request a feature. We want to make the best tool possible.',
    'feedback_button_text' => 'Give Us Feedback'
));
?>

<form method="post" class="features_request_general_setting">
    <h4>Suggestion Form Settings</h4>
    <table>
        <tr>
            <td><label for="sp_title_text">Suggestion Title Placeholder Text</label></td>
            <td>
                <input type="text" id="sp_title_text" name="sp_title_text" placeholder="Enter Text" value="<?php echo esc_attr($suggestion_settings['sp_title_text']); ?>" />
            </td>
        </tr>
        <tr>
            <td><label for="sp_textarea_text">Suggestion Textarea Placeholder Text</label></td>
            <td>
                <input type="text" id="sp_textarea_text" name="sp_textarea_text" placeholder="Enter Text" value="<?php echo esc_attr($suggestion_settings['sp_textarea_text']); ?>" />
            </td>
        </tr>
        <tr>
            <td><label for="sp_drop_text">Suggestion Drop URL Placeholder Text</label></td>
            <td>
                <input type="text" id="sp_drop_text" name="sp_drop_text" placeholder="Enter Text" value="<?php echo esc_attr($suggestion_settings['sp_drop_text']); ?>" />
            </td>
        </tr>
        <tr>
            <td><label for="sp_email_text">Suggestion Your Email Placeholder Text</label></td>
            <td>
                <input type="text" id="sp_email_text" name="sp_email_text" placeholder="Enter Text" value="<?php echo esc_attr($suggestion_settings['sp_email_text']); ?>" />
            </td>
        </tr>
        <tr>
            <td><label for="sp_submit_button_text">Suggestion Submit Button Text</label></td>
            <td>
                <input type="text" id="sp_submit_button_text" name="sp_submit_button_text" placeholder="Enter Text" value="<?php echo esc_attr($suggestion_settings['sp_submit_button_text']); ?>" />
            </td>
        </tr>
        <tr>
            <td><label for="sp_tab_title_text">Suggestion Tab Title Text</label></td>
            <td>
                <input type="text" id="sp_tab_title_text" name="sp_tab_title_text" placeholder="Enter Text" value="<?php echo esc_attr($suggestion_settings['sp_tab_title_text']); ?>" />
            </td>
        </tr>
    </table>

    <h4>Issues Form Settings</h4>
    <table>
        <tr>
            <td><label for="ip_title_text">Issues Title Placeholder Text</label></td>
            <td>
                <input type="text" id="ip_title_text" name="ip_title_text" placeholder="Enter Text" value="<?php echo esc_attr($issues_settings['ip_title_text']); ?>" />
            </td>
        </tr>
        <tr>
            <td><label for="ip_textarea_text">Issues Textarea Placeholder Text</label></td>
            <td>
                <input type="text" id="ip_textarea_text" name="ip_textarea_text" placeholder="Enter Text" value="<?php echo esc_attr($issues_settings['ip_textarea_text']); ?>" />
            </td>
        </tr>
        <tr>
            <td><label for="ip_drop_text">Issues Drop URL Placeholder Text</label></td>
            <td>
                <input type="text" id="ip_drop_text" name="ip_drop_text" placeholder="Enter Text" value="<?php echo esc_attr($issues_settings['ip_drop_text']); ?>" />
            </td>
        </tr>
        <tr>
            <td><label for="ip_email_text">Issues Your Email Placeholder Text</label></td>
            <td>
                <input type="text" id="ip_email_text" name="ip_email_text" placeholder="Enter Text" value="<?php echo esc_attr($issues_settings['ip_email_text']); ?>" />
            </td>
        </tr>
        <tr>
            <td><label for="ip_submit_button_text">Issues Submit Button Text</label></td>
            <td>
                <input type="text" id="ip_submit_button_text" name="ip_submit_button_text" placeholder="Enter Text" value="<?php echo esc_attr($issues_settings['ip_submit_button_text']); ?>" />
            </td>
        </tr>
        <tr>
            <td><label for="ip_tab_title_text">Issues Tab Title Text</label></td>
            <td>
                <input type="text" id="ip_tab_title_text" name="ip_tab_title_text" placeholder="Enter Text" value="<?php echo esc_attr($issues_settings['ip_tab_title_text']); ?>" />
            </td>
        </tr>
    </table>

    <h4>Frontend Feedback Button Area Settings</h4>
    <table>
        <tr>
            <td><label for="fda_title_text">Title Placeholder Text</label></td>
            <td>
                <input type="text" id="fda_title_text" name="fda_title_text" placeholder="Enter Text" value="<?php echo esc_attr($feedback_button_settings['fda_title_text']); ?>" />
            </td>
        </tr>
        <tr>
            <td><label for="feedback_button_text">Feedback Button Text</label></td>
            <td>
                <input type="text" id="feedback_button_text" name="feedback_button_text" placeholder="Enter Text" value="<?php echo esc_attr($feedback_button_settings['feedback_button_text']); ?>" />
            </td>
        </tr>
    </table>
    <input type="hidden" name="my_settings_nonce" value="<?php echo esc_attr( wp_create_nonce('my_settings_action')); ?>">

    <input type="submit" value="Save Changes" name="settings_save_btn" class="settings_save_btn">
</form>