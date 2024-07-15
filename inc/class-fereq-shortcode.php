<?php

class Features_Request_Shortcode
{
    private $table_name;
    private $table_name_2;
    private $comment_table;
    private $comment_table_reply;
    private $plugin_add;
    private $wpdb;
    public function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table_name = $this->wpdb->prefix . 'fereq_store_reports';
        $this->table_name_2 = $this->wpdb->prefix . 'fereq_store_all_voteing';
        $this->comment_table = $this->wpdb->prefix . 'fereq_store_all_comments';
        $this->comment_table_reply = $this->wpdb->prefix . 'fereq_store_comments_reply';
        $this->plugin_add = $this->wpdb->prefix . 'fereq_store_plugin_list';

        add_shortcode("features-request", [$this, "features_request_shortcode_callback"]);
        add_action("wp_enqueue_scripts", [$this, "frontend_scripts_callback"]);
        add_action('wp_ajax_issues_submitted_form_action', [$this, 'issues_submitted_form_action_handler']);
        add_action('wp_ajax_nopriv_issues_submitted_form_action', [$this, 'issues_submitted_form_action_handler']);
        add_action('wp_ajax_suggestion_submitted_form_action', [$this, 'suggestion_submitted_form_action_handler']);
        add_action('wp_ajax_nopriv_suggestion_submitted_form_action', [$this, 'suggestion_submitted_form_action_handler']);
        add_action('wp_ajax_get_store_explore_data_from_database_action', [$this, 'get_store_explore_data_from_database_action_handler']);
        add_action('wp_ajax_nopriv_get_store_explore_data_from_database_action', [$this, 'get_store_explore_data_from_database_action_handler']);
        add_action('wp_ajax_get_store_inprogress_data_from_database_action', [$this, 'get_store_inprogress_data_from_database_action_handler']);
        add_action('wp_ajax_nopriv_get_store_inprogress_data_from_database_action', [$this, 'get_store_inprogress_data_from_database_action_handler']);
        add_action('wp_ajax_get_store_done_data_from_database_action', [$this, 'get_store_done_data_from_database_action_handler']);
        add_action('wp_ajax_nopriv_get_store_done_data_from_database_action', [$this, 'get_store_done_data_from_database_action_handler']);
        add_action('wp_ajax_popup_content_showing_after_click_action', [$this, 'popup_content_showing_after_click_action_handler']);
        add_action('wp_ajax_nopriv_popup_content_showing_after_click_action', [$this, 'popup_content_showing_after_click_action_handler']);
        add_action('wp_ajax_voting_store_database_action', [$this, 'voting_store_database_action_handler']);
        add_action('wp_ajax_nopriv_voting_store_database_action', [$this, 'voting_store_database_action_handler']);
        add_action('wp_ajax_comment_store_database_action', [$this, 'comment_store_database_action_handler']);
        add_action('wp_ajax_nopriv_comment_store_database_action', [$this, 'comment_store_database_action_handler']);
        add_action('wp_ajax_remove_vote_from_database_action', [$this, 'remove_vote_from_database_action_handler']);
        add_action('wp_ajax_nopriv_remove_vote_from_database_action', [$this, 'remove_vote_from_database_action_handler']);
        add_action('wp_ajax_edit_comment_data_action', [$this, 'edit_comment_data_action_handler']);
        add_action('wp_ajax_nopriv_edit_comment_data_action', [$this, 'edit_comment_data_action_handler']);
        add_action('wp_ajax_update_comment_data_action', [$this, 'update_comment_data_action_handler']);
        add_action('wp_ajax_nopriv_update_comment_data_action', [$this, 'update_comment_data_action_handler']);
        add_action('wp_ajax_delete_comment_data_action', [$this, 'delete_comment_data_action_handler']);
        add_action('wp_ajax_nopriv_delete_comment_data_action', [$this, 'delete_comment_data_action_handler']);
        add_action('wp_ajax_voting_email_checking_action', [$this, 'voting_email_checking_action_handler']);
        add_action('wp_ajax_nopriv_voting_email_checking_action', [$this, 'voting_email_checking_action_handler']);


    }



    public function frontend_scripts_callback()
    {
        if ( ! is_admin() ) { 
            wp_enqueue_script("jquery");
            wp_enqueue_style("fereq-frontend-css", FEREQ_DIR_URL . "assets/css/frontend-fereq.css", [], FEREQ_VERSION, 'screen');
            wp_enqueue_style("fereq-fontawesome-css", FEREQ_DIR_URL . "assets/css/font-awesome.min.css", [], FEREQ_VERSION, 'screen');
            wp_enqueue_style('fereq-sweetalert2-css', FEREQ_DIR_URL . 'assets/css/sweetalert2.min.css', [], FEREQ_VERSION);
            wp_enqueue_script('fereq-sweetalert2-js', FEREQ_DIR_URL . 'assets/js/sweetalert2.all.min.js', [], FEREQ_VERSION, true);
            wp_enqueue_script("fereq-frontend-js", FEREQ_DIR_URL . "assets/js/frontend-fereq.js", [], FEREQ_VERSION, true);
        }
        
        $ajax_data = array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce1' => wp_create_nonce('suggestion_submission_nonce'), // First nonce
            'nonce2' => wp_create_nonce('issues_submission_nonce'), // Second nonce
            'nonce3' => wp_create_nonce('get_store_explore_data_from_database_nonce'), // Second nonce
            'nonce4' => wp_create_nonce('get_store_inprogress_data_from_database_nonce'), // Second nonce
            'nonce5' => wp_create_nonce('get_store_done_data_from_database_nonce'), // Second nonce
            'nonce6' => wp_create_nonce('popup_content_showing_after_click_action_nonce'), // Second nonce
            'nonce7' => wp_create_nonce('voting_store_database_nonce'), // Second nonce
            'nonce8' => wp_create_nonce('comment_store_database_nonce'), // Second nonce
            'nonce9' => wp_create_nonce('remove_vote_from_database_nonce'), // Second nonce
            'edit_comment' => wp_create_nonce('edit_comment_data_nonce'), // Second nonce
            'update_comment' => wp_create_nonce('update_comment_data_nonce'), // Second nonce
            'delete_comment' => wp_create_nonce('delete_comment_data_nonce'), // Second nonce
            'vote_email_check' => wp_create_nonce('voting_email_checking_nonce'), // Second nonce
        );
        wp_localize_script('fereq-frontend-js', 'ajax_data', $ajax_data);
    }

    public function features_request_shortcode_callback()
    {
        ob_start();
        $options = get_option('fereq_options');
        $fereq_background_color = isset($options['fereq_background_color']) ? $options['fereq_background_color'] : 'rgb(244 244 245)';
        $button_bg_color = isset($options['fereq_button_background_color']) ?esc_attr($options['fereq_button_background_color']) : '#333';
        $button_text_color = isset($options['fereq_button_text_color']) ? esc_attr($options['fereq_button_text_color']) : '#fff';
        $fereq_like_button_background_color = isset($options['fereq_like_button_background_color']) ? $options['fereq_like_button_background_color'] : '#dfdfdf';
        $fereq_like_button_text_color = isset($options['fereq_like_button_text_color']) ? $options['fereq_like_button_text_color'] : '#333';
        $fereq_all_title_font_size = isset($options['fereq_all_title_font_size']) ? $options['fereq_all_title_font_size'] . 'px' : '16px';
        $fereq_all_title_font_color = isset($options['fereq_all_title_font_color']) ? $options['fereq_all_title_font_color'] : '#333';
        $fereq_all_paragraph_font_size = isset($options['fereq_all_paragraph_font_size']) ? $options['fereq_all_paragraph_font_size'] . 'px' : '14px';
        $fereq_all_paragraph_font_color = isset($options['fereq_all_paragraph_font_color']) ? $options['fereq_all_paragraph_font_color'] : '#333';

        $filter_button_text_default =  isset($options['fereq_button_text_color']) ? esc_attr($options['fereq_button_text_color']) : "#333";
        echo '<style scoped>' . PHP_EOL;

        echo 'button.filter_button.active {
            background-color: ' . esc_attr($button_bg_color) . ' !important;
            color: ' . esc_attr($button_text_color) . ' !important;
        }' . PHP_EOL;
        
        echo 'button.filter_button {
            background-color: ' . esc_attr($fereq_background_color) . ' !important;
            color: ' . esc_attr($filter_button_text_default) . ' !important;
        }' . PHP_EOL;
        
        echo 'button.filter_tag.active {
            background-color: ' . esc_attr($button_bg_color) . ' !important;
            color: ' . esc_attr($button_text_color) . ' !important;
        }' . PHP_EOL;
        
        echo 'button.filter_tag {
            background-color: ' . esc_attr($fereq_background_color) . ' !important;
            color: ' . esc_attr($filter_button_text_default) . ' !important;
        }' . PHP_EOL;
        
        echo 'button.feedback_btn {
            background-color: ' . esc_attr($button_bg_color) . ' !important;
            color: ' . esc_attr($button_text_color) . ' !important;
        }' . PHP_EOL;
        
        echo 'button.comment_btn {
            background-color: ' . esc_attr($button_bg_color) . ' !important;
            color: ' . esc_attr($button_text_color) . ' !important;
        }' . PHP_EOL;
        
        echo 'button.vote_btn {
            background-color: ' . esc_attr($button_bg_color) . ' !important;
            color: ' . esc_attr($button_text_color) . ' !important;
        }' . PHP_EOL;
        
        echo 'div.feedback_tab button[type="submit"] {
            background-color: ' . esc_attr($button_bg_color) . ' !important;
            color: ' . esc_attr($button_text_color) . ' !important;
        }' . PHP_EOL;
        
        echo 'div.features_request_header_div {
            background-color: ' . esc_attr($fereq_background_color) . ' !important;
            color: ' . esc_attr($fereq_all_paragraph_font_color) . ' !important;
        }' . PHP_EOL;
        
        echo '.features_request_body .tabs__content ul .filtering_data {
            background-color: ' . esc_attr($fereq_background_color) . ' !important;
            color: ' . esc_attr($fereq_all_paragraph_font_color) . ' !important;
        }' . PHP_EOL;
        
        echo 'div.features_request_header_div .feedback_title {
            color: ' . esc_attr($fereq_all_title_font_color) . ' !important;
            font-size: ' . esc_attr($fereq_all_title_font_size) . ' !important;
        }' . PHP_EOL;
        
        echo 'div.filtering_data_content h3 {
            color: ' . esc_attr($fereq_all_title_font_color) . ' !important;
            font-size: ' . esc_attr($fereq_all_title_font_size) . ' !important;
        }' . PHP_EOL;
        
        echo 'div.filtering_data_content h3 span {
            color: #333 !important;
            font-size: inherit;
        }' . PHP_EOL;
        
        echo 'div.filtering_data_content p {
            color: ' . esc_attr($fereq_all_paragraph_font_color) . ' !important;
            font-size: ' . esc_attr($fereq_all_paragraph_font_size) . ' !important;
        }' . PHP_EOL;
        
        echo 'span.upvote_icon, span.downvote_icon {
            background-color: ' . esc_attr($fereq_like_button_background_color) . ' !important;
            color: ' . esc_attr($fereq_like_button_text_color) . ' !important;
        }' . PHP_EOL;
        
        echo '</style>' . PHP_EOL;
        
    
        require_once FEREQ_DIR_PATH . 'inc/class-fereq-shortcode-template.php';
    
        $html = ob_get_clean();
    
        return $html;
    }
    


    public function issues_submitted_form_action_handler()
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'issues_submission_nonce'))
        {
            wp_send_json_error("Nonce verification failed!");
            return;
        }

        $form_data = isset($_POST['formData']) ? wp_unslash($_POST['formData']) : []; // Retrieve form data
        parse_str($form_data, $form_array);

        // Sanitize each input value
        $issues_plugin_name = isset($form_array['issues_plugin_name']) ? sanitize_text_field($form_array['issues_plugin_name']) : '';
        $issues_title = isset($form_array['issues_title']) ? sanitize_text_field($form_array['issues_title']) : '';
        $issues_massage = isset($form_array['issues_massage']) ? sanitize_text_field($form_array['issues_massage']) : '';
        $issues_url = isset($form_array['issues_url']) ? sanitize_text_field($form_array['issues_url']) : '';
        $issues_email = isset($form_array['issues_email']) ? sanitize_text_field($form_array['issues_email']) : '';
        $submit_privately = isset($form_array['submit_privately']) ? sanitize_text_field($form_array['submit_privately']) : '';
        $report_type = sanitize_text_field("issues_submit");
        $report_status = sanitize_text_field("exploring");
        $vote_ans = sanitize_text_field("agree");

        $data = array(
            'report_type' => $report_type,
            'report_plugin_name' => $issues_plugin_name,
            'report_title' => $issues_title,
            'report_description' => $issues_massage,
            'report_url' => $issues_url,
            'report_email' => $issues_email,
            'report_status' => $report_status,
            'submit_privately' => $submit_privately,
        );
        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
        $result = $this->wpdb->insert($this->table_name, $data);
        if ($result !== false)
        {
            $get_issue_customer_email_enable_disable = get_option("issue_customer_email_enable_disable", "");
            $get_issue_customer_email_subject = get_option("issue_customer_email_subject", "");
            $get_issue_customer_email_email_content = get_option("issue_customer_email_email_content", "");

            $email_massage =  str_replace('{customer_email}', $issues_email, $get_issue_customer_email_email_content);

            if($get_issue_customer_email_enable_disable === "on"){
                $to = $issues_email;
                $subject = $get_issue_customer_email_subject;
                $message = $email_massage;
                $headers[] = 'Content-Type: text/html; charset=UTF-8';

                // Send the email
                $success = wp_mail($to, $subject, $message, $headers);

                if($success){
                    $get_issue_enable_disable = get_option("issue_enable_disable", "");
                    $get_issue_recipient = get_option("issue_recipient", "");
                    $get_issue_subject = get_option("issue_subject", "");
                    $get_issue_email_content = get_option("issue_email_content", "");

                    $admins = get_users(array('role' => 'administrator'));

                    if (!empty($admins)) {
                        $admin_username = $admins[0]->user_login;
                    } else {
                        $admin_username = "Admin";
                    }

                    $admin_email_massage =  str_replace(
                        array('{admin_name}', '{customer_email}' , '{post_name}'),
                        array($admin_username, $issues_email , $issues_title ),
                        $get_issue_email_content
                    );

                    if($get_issue_enable_disable === "on"){
                        $to = $get_issue_recipient;
                        $subject = $get_issue_subject;
                        $message = $admin_email_massage;
                        $headers[] = 'Content-Type: text/html; charset=UTF-8';

                        // Send the email
                        $ad_success = wp_mail($to, $subject, $message, $headers);

                         if($ad_success){
                            $status = true;
                         }
                    }
                }
            }

            $status = true;

        } else
        {
            $status = false;
        }


        wp_send_json_success(array("status" => $status));
        wp_die();

    }
    public function suggestion_submitted_form_action_handler()
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'suggestion_submission_nonce'))
        {
            wp_send_json_error("Nonce verification failed!");
            return;
        }

        $form_data = isset($_POST['formData']) ? wp_unslash($_POST['formData']) : []; // Retrieve form data
        parse_str($form_data, $form_array);

        // Sanitize each input value
        $suggestion_plugin_name = isset($form_array['suggestion_plugin_name']) ? sanitize_text_field($form_array['suggestion_plugin_name']) : '';
        $suggestion_title = isset($form_array['suggestion_title']) ? sanitize_text_field($form_array['suggestion_title']) : '';
        $suggestion_massage = isset($form_array['suggestion_massage']) ? sanitize_text_field($form_array['suggestion_massage']) : '';
        $suggestion_url = isset($form_array['suggestion_url']) ? sanitize_text_field($form_array['suggestion_url']) : '';
        $suggestion_email = isset($form_array['suggestion_email']) ? sanitize_text_field($form_array['suggestion_email']) : '';
        $submit_privately = isset($form_array['submit_privately']) ? sanitize_text_field($form_array['submit_privately']) : '';
        $report_type = sanitize_text_field("suggestion_submit");
        $report_status = sanitize_text_field("exploring");
        $vote_ans = sanitize_text_field("agree");

        $data = array(
            'report_type' => $report_type,
            'report_plugin_name' => $suggestion_plugin_name,
            'report_title' => $suggestion_title,
            'report_description' => $suggestion_massage,
            'report_url' => $suggestion_url,
            'report_email' => $suggestion_email,
            'report_status' => $report_status,
            'submit_privately' => $submit_privately,
        );
        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
        $result = $this->wpdb->insert($this->table_name, $data);
        if ($result !== false)
        {
            $get_suggestion_customer_email_enable_disable = get_option("suggestion_customer_email_enable_disable", "");
            $get_suggestion_customer_email_subject = get_option("suggestion_customer_email_subject", "");
            $get_suggestion_customer_email_email_content = get_option("suggestion_customer_email_email_content", "");

            $email_massage =  str_replace('{customer_email}', $suggestion_email, $get_suggestion_customer_email_email_content);

            if($get_suggestion_customer_email_enable_disable === "on"){
                $to = $suggestion_email;
                $subject = $get_suggestion_customer_email_subject;
                $message = $email_massage;
                $headers[] = 'Content-Type: text/html; charset=UTF-8';

                // Send the email
                $success = wp_mail($to, $subject, $message, $headers);

                if($success){
                    $get_suggestion_enable_disable = get_option("suggestion_enable_disable", "");
                    $get_suggestion_recipient = get_option("suggestion_recipient", "");
                    $get_suggestion_subject = get_option("suggestion_subject", "");
                    $get_suggestion_email_content = get_option("suggestion_email_content", "");

                    $admins = get_users(array('role' => 'administrator'));

                    if (!empty($admins)) {
                        $admin_username = $admins[0]->user_login;
                    } else {
                        $admin_username = "Admin";
                    }

                    $admin_email_massage =  str_replace(
                        array('{admin_name}', '{customer_email}' , '{post_name}'),
                        array($admin_username, $suggestion_email , $suggestion_title ),
                        $get_suggestion_email_content
                    );

                    if($get_suggestion_enable_disable === "on"){
                        $to = $get_suggestion_recipient;
                        $subject = $get_suggestion_subject;
                        $message = $admin_email_massage;
                        $headers[] = 'Content-Type: text/html; charset=UTF-8';

                        // Send the email
                        $ad_success = wp_mail($to, $subject, $message, $headers);

                         if($ad_success){
                            $status = true;
                         }
                    }
                }
            }
            
            
          

        } else
        {
            $status = false;
        }


        wp_send_json_success(array("status" => $status));
        wp_die();

    }


    public function get_store_explore_data_from_database_action_handler()
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'get_store_explore_data_from_database_nonce'))
        {
            wp_send_json_error("Nonce verification failed!");
            return;
        }
        $sanitized_table_name = sanitize_key($this->table_name);
        $sanitized_table_name_2 = sanitize_key($this->table_name_2);
          //phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
            $query = $this->wpdb->prepare("SELECT t1.*,  COALESCE(subquery.total_agree_voting, 0) AS total_agree_voting,  COALESCE(subquery total_disagree_voting, 0) AS total_disagree_voting FROM {$sanitized_table_name} AS t1 LEFT JOIN ( SELECT report_table_id,   SUM(CASE WHEN vote_ans = 'agree' THEN 1 ELSE 0 END) AS total_agree_voting, SUM(CASE WHEN vote_ans = 'disagree' THEN 1 ELSE 0 END) AS total_disagree_voting FROM {$sanitized_table_name_2} GROUP BY report_table_id ) AS subquery ON t1.id = subquery.report_table_id WHERE t1.report_status = %s AND t1.submit_privately != %s ", 'exploring', 'on');



        // Execute the query and fetch the results
        //phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
        $fetch_results = $this->wpdb->get_results($query);

        ob_start();
        foreach ($fetch_results as $result):
            $insertion_time_str = $result->inserted_time;
              //phpcs:ignore WordPress.DateTime.RestrictedFunctions.date_date
            $current_date = date("Y-m-d");
              //phpcs:ignore WordPress.DateTime.RestrictedFunctions.date_date
            $insertion_date = date("Y-m-d", strtotime($insertion_time_str));
            ?>
            <li class="show_content_popup_btn" data-id="<?php echo esc_attr($result->id); ?>">
                <input type="hidden" value="<?php echo esc_attr(($insertion_date == $current_date) ? "new" : "old"); ?>">
                <div class="filtering_data">
                    <div class="filtering_data_content">
                        <h3><span>

                                <?php
                                if ($result->report_type == "issues_submit")
                                {
                                    echo esc_html("Issue");
                                } else
                                {
                                    echo esc_html("Suggestion");

                                }
                                ?>
                            </span>
                            <?php echo esc_html($result->report_title); ?>
                        </h3>
                        <p>
                            <?php echo esc_html(wp_trim_words($result->report_description, 12, '.')); ?>
                        </p>
                        <?php
                        if ($result->report_type == "suggestion_submit"):
                            ?>
                            <input type="hidden" name="popular" value="<?php echo ($result->total_agree_voting > 0 || $result->total_disagree_voting > 0) ? "popular" : "not_popular"; ?>" />
                            <div class="upvote_downvote_div">
                                <span class="upvote_icon"><i class="fa-solid fa-thumbs-up"></i>
                                    <span
                                        class="total_agree_vote_count_<?php echo esc_attr($result->id); ?>"><?php echo esc_html($result->total_agree_voting); ?></span></span>
                                <span class="downvote_icon"><i class="fa-solid fa-thumbs-down"></i><span
                                        class="total_disagree_vote_count_<?php echo esc_attr($result->id); ?>"><?php echo esc_html($result->total_disagree_voting); ?></span></span>
                            </div>
                            <?php
                        endif;
                        ?>
                    </div>
                    <div class="filtering_comment">
                        <i class="fa-regular fa-comment"></i>
                        <b class="comment_updated_status_<?php echo esc_attr($result->id); ?>">
                            <?php
                            //phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
                            $comment_query = $this->wpdb->prepare("SELECT * FROM $this->comment_table WHERE report_table_id = %d", $result->id);
                           //phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
                            $comment_results = $this->wpdb->get_results($comment_query);
                            echo esc_html(count($comment_results));
                            ?>
                        </b>
                    </div>
                </div>
            </li>

            <?php
        endforeach;
        $html = ob_get_clean();



        wp_send_json_success(array("fetchData" => $fetch_results, "html" => $html));
        wp_die();
    }

    public function get_store_inprogress_data_from_database_action_handler()
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'get_store_inprogress_data_from_database_nonce'))
        {
            wp_send_json_error("Nonce verification failed!");
            return;
        }
       $table_name =  sanitize_key($this->table_name);
       $table_name_2 =   sanitize_key($this->table_name_2);
        
        //phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
        $query = $this->wpdb->prepare("SELECT t1.*, COALESCE(subquery.total_agree_voting, 0) AS total_agree_voting, COALESCE(subquery.total_disagree_voting, 0) AS total_disagree_voting FROM {$table_name} AS t1 LEFT JOIN (SELECT report_table_id, SUM(CASE WHEN vote_ans = 'agree' THEN 1 ELSE 0 END) AS total_agree_voting, SUM(CASE WHEN vote_ans = 'disagree' THEN 1 ELSE 0 END) AS total_disagree_voting FROM {$table_name_2} GROUP BY report_table_id) AS subquery ON t1.id = subquery.report_table_id WHERE t1.report_status = 'inprogress' AND t1.submit_privately != 'on'");



        // Execute the query and fetch the results
        //phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
        $fetch_results = $this->wpdb->get_results($query);

        ob_start();
        foreach ($fetch_results as $result):
            $insertion_time_str = $result->inserted_time;
            //phpcs:ignore WordPress.DateTime.RestrictedFunctions.date_date
            $current_date = date("Y-m-d");
            //phpcs:ignore WordPress.DateTime.RestrictedFunctions.date_date
            $insertion_date = date("Y-m-d", strtotime($insertion_time_str));
            ?>
            <li class="show_content_popup_btn" data-id="<?php echo esc_attr($result->id); ?>">
                <input type="hidden" value="<?php echo esc_attr(($insertion_date == $current_date) ? "new" : "old"); ?>">
                <div class="filtering_data">
                    <div class="filtering_data_content">
                        <h3><span>

                                <?php
                                if ($result->report_type == "issues_submit")
                                {
                                    echo esc_html("Issue");
                                } else
                                {
                                    echo esc_html("Suggestion");

                                }
                                ?>
                            </span>
                            <?php echo esc_html($result->report_title); ?>
                        </h3>
                        <p>
                            <?php echo esc_html(wp_trim_words($result->report_description, 12, '.')); ?>
                        </p>
                        <?php
                        if ($result->report_type == "suggestion_submit"):

                            ?>
                            <input type="hidden" name="popular" value="<?php echo ($result->total_agree_voting > 0 || $result->total_disagree_voting > 0) ? "popular" : "not_popular"; ?>" />

                            <div class="upvote_downvote_div">
                                <span class="upvote_icon"><i class="fa-solid fa-thumbs-up"></i>
                                    <span
                                        class="total_agree_vote_count_<?php echo esc_attr($result->id); ?>"><?php echo esc_html($result->total_agree_voting); ?></span></span>
                                <span class="downvote_icon"><i class="fa-solid fa-thumbs-down"></i><span
                                        class="total_disagree_vote_count_<?php echo esc_attr($result->id); ?>"><?php echo esc_html($result->total_disagree_voting); ?></span></span>
                            </div>
                            <?php
                        endif;
                        ?>
                    </div>
                    <div class="filtering_comment">
                        <i class="fa-regular fa-comment"></i>
                        <b class="comment_updated_status_<?php echo esc_attr($result->id); ?>">
                            <?php
                            //phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
                            $comment_query = $this->wpdb->prepare("SELECT * FROM $this->comment_table WHERE report_table_id = %d", $result->id);
                           //phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
                            $comment_results = $this->wpdb->get_results($comment_query);
                            echo esc_html(count($comment_results));
                            ?>
                        </b>
                    </div>
                </div>
            </li>

            <?php
        endforeach;
        $html = ob_get_clean();



        wp_send_json_success(array("fetchData" => $fetch_results, "html" => $html));
        wp_die();
    }

    public function get_store_done_data_from_database_action_handler()
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'get_store_done_data_from_database_nonce'))
        {
            wp_send_json_error("Nonce verification failed!");
            return;
        }

$table_name = sanitize_key($this->table_name);
$table_name_2 = sanitize_key($this->table_name_2);
//phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
$query = $this->wpdb->prepare("SELECT t1.*, COALESCE(subquery.total_agree_voting, 0) AS total_agree_voting, COALESCE(subquery.total_disagree_voting, 0) AS total_disagree_voting FROM {$table_name} AS t1 LEFT JOIN (SELECT report_table_id, SUM(CASE WHEN vote_ans = 'agree' THEN 1 ELSE 0 END) AS total_agree_voting, SUM(CASE WHEN vote_ans = 'disagree' THEN 1 ELSE 0 END) AS total_disagree_voting FROM {$table_name_2} GROUP BY report_table_id) AS subquery ON t1.id = subquery.report_table_id WHERE t1.report_status = 'done' AND t1.submit_privately != 'on'");


        // Execute the query and fetch the results
        //phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
        $fetch_results = $this->wpdb->get_results($query);

        ob_start();
        foreach ($fetch_results as $result):
            $insertion_time_str = $result->inserted_time;
              //phpcs:ignore WordPress.DateTime.RestrictedFunctions.date_date
            $current_date = date("Y-m-d");
              //phpcs:ignore WordPress.DateTime.RestrictedFunctions.date_date
            $insertion_date = date("Y-m-d", strtotime($insertion_time_str));
            ?>
            <li class="show_content_popup_btn" data-id="<?php echo esc_attr($result->id); ?>">
                <input type="hidden" value="<?php echo esc_attr(($insertion_date == $current_date) ? "new" : "old"); ?>">
                <div class="filtering_data">
                    <div class="filtering_data_content">
                        <h3><span>

                                <?php
                                if ($result->report_type == "issues_submit")
                                {
                                    echo esc_html("Issue");
                                } else
                                {
                                    echo esc_html("Suggestion");

                                }
                                ?>
                            </span>
                            <?php echo esc_html($result->report_title); ?>
                        </h3>
                        <p>
                            <?php echo esc_html(wp_trim_words($result->report_description, 12, '.')); ?>
                        </p>
                        <?php
                        if ($result->report_type == "suggestion_submit"):
                            ?>
                            <input type="hidden" name="popular" value="<?php echo ($result->total_agree_voting > 0 || $result->total_disagree_voting > 0) ? "popular" : "not_popular"; ?>" />
                            <div class="upvote_downvote_div">
                                <span class="upvote_icon"><i class="fa-solid fa-thumbs-up"></i>
                                    <span
                                        class="total_agree_vote_count_<?php echo esc_attr($result->id); ?>"><?php echo esc_html($result->total_agree_voting); ?></span></span>
                                <span class="downvote_icon"><i class="fa-solid fa-thumbs-down"></i><span
                                        class="total_disagree_vote_count_<?php echo esc_attr($result->id); ?>"><?php echo esc_html($result->total_disagree_voting); ?></span></span>
                            </div>
                            <?php
                        endif;
                        ?>
                    </div>
                    <div class="filtering_comment">
                        <i class="fa-regular fa-comment"></i>
                        <b class="comment_updated_status_<?php echo esc_attr($result->id); ?>">
                            <?php
                            //phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
                            $comment_query = $this->wpdb->prepare("SELECT * FROM $this->comment_table WHERE report_table_id = %d", $result->id);
                          //phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
                            $comment_results = $this->wpdb->get_results($comment_query);
                            echo esc_html(count($comment_results));
                            ?>
                        </b>

                    </div>
                </div>
            </li>

            <?php
        endforeach;
        $html = ob_get_clean();



        wp_send_json_success(array("fetchData" => $fetch_results, "html" => $html));
        wp_die();
    }

    public function popup_content_showing_after_click_action_handler()
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'popup_content_showing_after_click_action_nonce'))
        {
            wp_send_json_error("Nonce verification failed!");
            return;
        }

        $dataId = isset($_POST['dataId']) ? sanitize_text_field($_POST['dataId']) : "";
        $tabType = isset($_POST['tabType']) ? sanitize_text_field($_POST['tabType']) : "";

        $table_name = sanitize_key($this->table_name);
        $table_name_2 = sanitize_key($this->table_name_2);
        //phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
        $query = $this->wpdb->prepare("SELECT t1.*, COALESCE(subquery.total_agree_voting, 0) AS total_agree_voting, COALESCE(subquery.total_disagree_voting, 0) AS total_disagree_voting FROM {$table_name} AS t1 LEFT JOIN (SELECT report_table_id, SUM(CASE WHEN vote_ans = 'agree' THEN 1 ELSE 0 END) AS total_agree_voting, SUM(CASE WHEN vote_ans = 'disagree' THEN 1 ELSE 0 END) AS total_disagree_voting FROM {$table_name_2} GROUP BY report_table_id) AS subquery ON t1.id = subquery.report_table_id WHERE t1.id = %d", $dataId);




        // Execute the query and fetch the results
        //phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
        $fetch_results = $this->wpdb->get_results($query);



        ob_start();

        ?>
        <div class="popup_overview_details_box">
            <div class="status_tag">
                <span class="reported_plugin_name"><?php echo esc_html($fetch_results[0]->report_plugin_name); ?></span>
                <span>
                    <?php
                    if ($fetch_results[0]->report_type === "suggestion_submit")
                    {
                        echo esc_html("Suggestion");
                    } else
                    {
                        echo esc_html("Issue");
                    }
                    ?>
                </span>
                <?php
                if ($tabType === "inprogress"):
                    ?>
                    <span class="sugg">In Progress</span>
                    <?php
                endif;
                if ($tabType === "done"):
                    ?>
                    <span class="done">Done</span>
                    <?php
                endif;
                ?>



            </div>
            <div class="popup_overview_content">
                <h2 class="overView_title">
                    <?php echo esc_html($fetch_results[0]->report_title); ?>
                </h2>
                <p class="overview_description">
                    <?php
                    echo esc_html($fetch_results[0]->report_description);

                    if (!empty($fetch_results[0]->report_url)):
                        ?>
                        <a href="<?php echo esc_url($fetch_results[0]->report_url); ?>" class="overview_given_url">
                            <?php echo esc_html($fetch_results[0]->report_url); ?>
                        </a>
                        <?php
                    endif;

                    ?>


                </p>

            </div>
            <div class="popup_overview_extra_content">
                <div class="voted_done_and_counting_box">
                    <?php
                    if ($fetch_results[0]->report_type == "suggestion_submit"):
//phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
                        $voting_query = $this->wpdb->prepare(" SELECT * FROM $this->table_name_2 WHERE report_table_id = %d ", $fetch_results[0]->id);
                        //phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
                        $voting_results = $this->wpdb->get_results($voting_query);
                        $cookieValueId = isset($_COOKIE['voting_cookie_set']) ? $_COOKIE['voting_cookie_set'] : '';
                        ?>
                        <div class="upvote_downvote_div upvote_downvote_div_in_popup">
                            <span
                                class="upvote_icon voting_span <?php
                                  
                                 if($cookieValueId == $fetch_results[0]->id){
                                    echo esc_attr($voting_results[0]->vote_ans == "agree" ? "active" : "disabled");
                                 }else{
                                    echo esc_attr($voting_results[0]->vote_ans == "agree" ? "" : "");
                                 }
                                 ?>"
                                data-name="agree"><i class="fa-solid fa-thumbs-up"></i>
                                <span
                                    class="total_agree_vote_count_<?php echo esc_attr($dataId); ?>"><?php echo esc_html($fetch_results[0]->total_agree_voting); ?></span></span>
                            <span
                                class="downvote_icon voting_span <?php 
                                if($cookieValueId == $fetch_results[0]->id){
                                    echo esc_attr($voting_results[0]->vote_ans == "disagree" ? "active" : "disabled");
                                 }else{
                                    echo esc_attr($voting_results[0]->vote_ans == "disagree" ? "active" : "");
                                 }
                                ?>"
                                data-name="disagree"><i class="fa-solid fa-thumbs-down"></i><span
                                    class="total_disagree_vote_count_<?php echo esc_attr($dataId); ?>"><?php echo esc_html($fetch_results[0]->total_disagree_voting); ?></span></span>
                        </div>


                        <?php
                     
                        if ($cookieValueId == $fetch_results[0]->id):
                            ?>
                            <span class="after_voting_done_msg">
                                <p>You have Voted</p>
                                <p class='remove_vote_btn'>Remove vote</p>
                            </span>
                            <?php
                        endif;
                        ?>

                        <?php
                    endif;
                    ?>
                </div>
                <?php
                if ($fetch_results[0]->report_type == "suggestion_submit"):

                    $cookieValueId = isset($_COOKIE['voting_cookie_set']) ? $_COOKIE['voting_cookie_set'] : '';
                    if ($cookieValueId != $fetch_results[0]->id):

                        ?>

                        <div class="agree_disagree_hidden_div">
                            <label for="hidden_div_content">What is your Feedback For this Suggestion?
                                <span> (Optional.
                                    Only seen by our team)</span></label>
                            <textarea name="" placeholder="Your Feedback" id="hidden_div_content" cols="30" rows="10"></textarea>
                            <div class="hidden_div_vote_options">
                                <input type="email" name="" placeholder="Your Email" id="voting_email_field">
                                <div class="keep_me_posted_div">
                                    <label for="keep_me_posted">Keep Me Posted</label>
                                    <input type="checkbox" name="" placeholder="Keep me Posted" id="keep_me_posted">
                                </div>
                                <button class="vote_btn">Vote</button>
                            </div>
                            <p class="submittes_result_massage"></p>
                        </div>
                        <?php
                    endif;
                endif;
                ?>
            </div>
            <input type="hidden" name="" id="report_table_id_val" value=" <?php echo esc_attr($fetch_results[0]->id); ?>">
            <div class="comment_box_content">
                <ul class="push_comment_into_ul">

                    <?php
                    //phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
                    $query = $this->wpdb->prepare("SELECT * FROM $this->comment_table WHERE report_table_id = %d", $fetch_results[0]->id);
                  //phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
                    $comment_results = $this->wpdb->get_results($query);

                    foreach ($comment_results as $comment_list):
                        $commentMail = $comment_list->comment_email;
                        $replyMail = $comment_list->reply_to;
                        ?>
                        <li class="comment_list_div <?php echo !empty($replyMail) ? "reply_mail_ache" : "reply_mail_nai"; ?>">
                            <div class="comment_content">
                                <h3 class="commentator_name"><i class="fa-solid fa-circle-user"></i>
                                    <?php
                                    if (empty($comment_list->commentator_name))
                                    {

                                        if ($comment_list->comment_email === "admin@gmail.com")
                                        {
                                            echo esc_html("Admin");
                                        } else
                                        {
                                            echo esc_html($comment_list->comment_email);
                                        }

                                    } else
                                    {
                                        echo esc_html($comment_list->commentator_name);
                                    }

                                    ?>
                                </h3>
                                <p class="commentator_content">
                                    <?php
                                    echo esc_html($comment_list->comment_text);
                                    ?>
                                </p>

                                <div class="edit_remove_reply_div">
                                    <span class="time_stamp">
                                        <?php
                                        $datetime1 = new DateTime($comment_list->comment_time);
                                        $datetime2 = new DateTime();
                                        $interval = $datetime1->diff($datetime2);

                                        // Get the difference in days and minutes
                                        $days = $interval->days;
                                        $minutes = $interval->days * 24 * 60 + $interval->h * 60 + $interval->i;
                                        echo esc_html($comment_list->comment_time);
                                        ?>
                                    </span>
                                    <span class="comment_edit"
                                        data-reportId="<?php echo esc_attr($comment_list->report_table_id); ?>"
                                        data-commentId="<?php echo esc_attr($comment_list->comment_id); ?>"
                                        data-commenttype="<?php echo esc_attr($comment_list->comment_type); ?>"><i class=" fa-solid
                                        fa-pen-to-square"></i></span>
                                    <span class="comment_trash"
                                        data-reportId="<?php echo esc_attr($comment_list->report_table_id); ?>"
                                        data-commentId="<?php echo esc_attr($comment_list->comment_id); ?>"
                                        data-commenttype="<?php echo esc_attr($comment_list->comment_type); ?>"><i
                                            class="fa-solid fa-trash"></i></span>
                                    <span
                                        class="comment_reply_icon comment_reply_<?php echo esc_attr($comment_list->comment_id); ?> <?php echo !empty($replyMail) ? "reply_hidden" : "reply_show"; ?>  "
                                        data-commentator="<?php echo esc_attr($comment_list->commentator_name); ?>"
                                        data-reportId="<?php echo esc_attr($comment_list->report_table_id); ?>"
                                        data-replymail="<?php echo esc_attr($comment_list->comment_email); ?>"
                                        data-commentId="<?php echo esc_attr($comment_list->comment_id); ?>"><i
                                            class="fa-solid fa-reply"></i></span>

                                </div>

                            </div>

                            <ul class="reply_comment_ul">
                                <?php
                                //phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
                                $commnet_reply_query = $this->wpdb->prepare("SELECT * FROM $this->comment_table_reply WHERE report_table_id = %d AND comment_table_id= %d" ,$fetch_results[0]->id, $comment_list->comment_id);
                              //phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
                                $comment_reply_results = $this->wpdb->get_results($commnet_reply_query);
                                foreach ($comment_reply_results as $comment_reply):
                                    ?>
                                    <li
                                        class="comment_list_div <?php echo !empty($replyMail) ? "reply_mail_ache" : "reply_mail_nai"; ?>">
                                        <div class="comment_content">
                                            <h3 class="commentator_name"><i class="fa-solid fa-circle-user"></i>
                                                <?php

                                                echo esc_html($comment_reply->commentator_name);
                                                ?>
                                            </h3>
                                            <p class="commentator_content">
                                                <?php
                                                echo esc_html($comment_reply->comment_text);
                                                ?>
                                            </p>
                                            <div class="edit_remove_reply_div">
                                                <span class="time_stamp">
                                                    <?php
                                                    $datetime1 = new DateTime($comment_reply->comment_time);
                                                    $datetime2 = new DateTime();
                                                    $interval = $datetime1->diff($datetime2);

                                                    // Get the difference in days and minutes
                                                    $days = $interval->days;
                                                    $minutes = $interval->days * 24 * 60 + $interval->h * 60 + $interval->i;
                                                    echo esc_html($comment_reply->comment_time);
                                                    ?>
                                                </span>
                                                <span class="comment_edit"
                                                    data-reportId="<?php echo esc_attr($comment_reply->report_table_id); ?>"
                                                    data-commentId="<?php echo esc_attr($comment_reply->comment_table_id); ?>"
                                                    data-commenttype="<?php echo esc_attr($comment_reply->comment_type); ?>"><i class=" fa-solid
                                        fa-pen-to-square"></i></span>
                                                <span class="comment_trash"
                                                    data-reportId="<?php echo esc_attr($comment_reply->report_table_id); ?>"
                                                    data-commentId="<?php echo esc_attr($comment_reply->comment_table_id); ?>"
                                                    data-commenttype="<?php echo esc_attr($comment_reply->comment_type); ?>"><i
                                                        class="fa-solid fa-trash"></i></span>


                                            </div>
                                        </div>
                                    </li>
                                    <?php
                                endforeach;
                                ?>

                            </ul>

                        </li>

                    <?php endforeach; ?>
                </ul>
                <div class="comment_form">
                    <span class="leave_comment_title">Leave a Comment</span>
                    <textarea name="" id="comment_textarea" placeholder="Enter Comment Details" cols="30" rows="10"></textarea>
                    <div class="comment_email_require_box">
                        <input type="text" name="" placeholder="Your Name" id="comment_name_field">
                        <input type="email" name="" placeholder="Your email" id="comment_email_field">
                        <button class="comment_btn" data-comment-type="comment">Comment</button>
                    </div>
                    <p class="comment_result_massage"></p>
                </div>
            </div>
        </div>

        <?php

        $html = ob_get_clean();
        wp_send_json_success(array("dataId" => $dataId, 'tabType' => $tabType, 'html' => $html, "fetchRes" => $voting_results));
        wp_die();

    }

    public function voting_store_database_action_handler()
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'voting_store_database_nonce'))
        {
            wp_send_json_error("Nonce verification failed!");
            return;
        }
        $email_value = isset($_POST['email_value']) ? sanitize_text_field($_POST['email_value']) : "";
        $textArea = isset($_POST['textArea']) ? sanitize_text_field($_POST['textArea']) : "";
        $select = isset($_POST['select']) ? sanitize_text_field($_POST['select']) : "";
        $report_table_id_val = isset($_POST['report_table_id_val']) ? sanitize_text_field($_POST['report_table_id_val']) : "";
        $keep_me_posted = isset($_POST['keep_me_posted']) ? sanitize_text_field($_POST['keep_me_posted']) : "";
        $data = array(
            'report_table_id' => $report_table_id_val,
            'vote_ans' => $select,
            'vote_feedback' => $textArea,
            'keep_me_posted' => $keep_me_posted,
            'vote_email' => $email_value,
        );
        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
        //phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
        $result = $this->wpdb->insert($this->table_name_2, $data);
        if ($result !== false)
        {
            setcookie("voting_cookie_set", $report_table_id_val, time() + (365 * 24 * 60 * 60), "/");
            //phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
            $report_query = $this->wpdb->prepare("SELECT * FROM $this->table_name WHERE id = %d", $report_table_id_val);
            //phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
            $report_fetch_results = $this->wpdb->get_results($report_query);

            $get_voting_email_customer_enable_disable = get_option("voting_email_customer_enable_disable", "");
            $get_voting_email_customer_subject = get_option("voting_email_customer_subject", "");
            $get_voting_email_customer_email_content = get_option("voting_email_customer_email_content", "");

            if($get_voting_email_customer_enable_disable){
                if($select =="agree"){
                    $voting_reaction = "Like";
                }else{
                    $voting_reaction = "Dislike";
                }
                $voting_customer_msg = str_replace(
                    array('{voting_email}', '{voting_reaction}' , '{post_title}' , '{report_type}'),
                    array($email_value, $voting_reaction , $report_fetch_results[0]->report_title, $report_fetch_results[0]->report_type),
                    $get_voting_email_customer_email_content
                );
                $to = $email_value;
                $subject = $get_voting_email_customer_subject;
                $message = $voting_customer_msg;
                $headers[] = 'Content-Type: text/html; charset=UTF-8';

                // Send the email
                $voting_customer_status = wp_mail($to, $subject, $message, $headers);
                if($voting_customer_status){

                    $get_voting_show_enable_disable = get_option("voting_show_enable_disable", "");
                    $get_voting_show_recipient = get_option("voting_show_recipient", "");
                    $get_voting_show_subject = get_option("voting_show_subject", "");
                    $get_voting_show_email_content = get_option("voting_show_email_content", "");

                    $admin_voting_show_subject = str_replace(
                        array('{voting_email}', '{voting_reaction}'),
                        array($email_value, $voting_reaction ),
                        $get_voting_show_subject
                    );
                    
                    $admins = get_users(array('role' => 'administrator'));

                    if (!empty($admins)) {
                        $admin_username = $admins[0]->user_login;
                    } else {
                        $admin_username = "Admin";
                    }
                    $admin_voting_show_msg = str_replace(
                        array('{admin_username}', '{voting_reaction}' , '{post_title}' , '{report_type}'),
                        array($admin_username, $voting_reaction , $report_fetch_results[0]->report_title, $report_fetch_results[0]->report_type),
                        $get_voting_show_email_content
                    );
                    if($get_voting_show_enable_disable){
                        $admin_to = $get_voting_show_recipient ;
                        $admin_subject = $admin_voting_show_subject;
                        $admin_message = $admin_voting_show_msg;
                        $admin_headers[] = 'Content-Type: text/html; charset=UTF-8';
                        $voting_admin_status = wp_mail($admin_to, $admin_subject, $admin_message, $admin_headers);

                        if($voting_admin_status){
                            $post_owner_to = $report_fetch_results[0]->report_email ;
                            $post_owner_subject = "Someone ".$voting_reaction ." Your post ";
                            $post_owner_msg = "Hi ".$report_fetch_results[0]->report_email ."\n\n Someone ".$voting_reaction . " your post post title is ".$report_fetch_results[0]->report_title." and report type is : ".$report_fetch_results[0]->report_type;
                            $post_owner_headers[] = 'Content-Type: text/html; charset=UTF-8';
                            $voting_post_owner_status = wp_mail($post_owner_to, $post_owner_subject, $post_owner_msg, $post_owner_headers);
                        }
        
                    }
                    
                }

               
            }

            

                    // Sanitize the table name
            $sanitized_table_name_2 = sanitize_key($this->table_name_2);

            // Prepare the query
            //phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
            $query = $this->wpdb->prepare("SELECT COUNT(CASE WHEN vote_ans = 'agree' THEN 1 END) AS agree_count, COUNT(CASE WHEN vote_ans = 'disagree' THEN 1 END) AS disagree_count FROM {$sanitized_table_name_2} WHERE report_table_id = %d", $report_table_id_val);

            //phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
            $fetch_results = $this->wpdb->get_results($query);
            $total_agree_voting = $fetch_results[0]->agree_count;
            $total_disagree_voting = $fetch_results[0]->disagree_count;
            $status = true;
        } else
        {
            $status = false;
        }

        ob_start();
        ?>
        <span class="after_voting_done_msg">
                <p>You have Voted</p>
                <p class='remove_vote_btn'>Remove vote</p>
        </span>
        <?php
        $voting_done_msg_html = ob_get_clean();

        wp_send_json_success(array("status" => $status, "total_agree_voting" => $total_agree_voting, "total_disagree_voting" => $total_disagree_voting, "fetch_result" => $fetch_results , 'voting_done_msg_html'=>$voting_done_msg_html));
        wp_die();

    }

    public function comment_store_database_action_handler()
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'comment_store_database_nonce'))
        {
            wp_send_json_error("Nonce verification failed!");
            return;
        }
        $comment_email_field = isset($_POST['comment_email_field']) ? sanitize_text_field($_POST['comment_email_field']) : "";
        $comment_type = isset($_POST['comment_type']) ? sanitize_text_field($_POST['comment_type']) : "";
        $commentator_name = isset($_POST['commentator_name']) ? sanitize_text_field($_POST['commentator_name']) : "";
        $requestFrom = isset($_POST['requestFrom']) ? sanitize_text_field($_POST['requestFrom']) : "";
        $commentReplyMail = isset($_POST['commentReplyMail']) ? sanitize_text_field($_POST['commentReplyMail']) : "";
        $cTextarea = isset($_POST['cTextarea']) ? sanitize_text_field($_POST['cTextarea']) : "";
        $report_table_id_val = isset($_POST['report_table_id_val']) ? sanitize_text_field($_POST['report_table_id_val']) : "";
        $commentId = isset($_POST['commentId']) ? sanitize_text_field($_POST['commentId']) : "";
//phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
        $report_query = $this->wpdb->prepare("SELECT * FROM $this->table_name WHERE id = %d", $report_table_id_val);
        //phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
        $report_fetch_results = $this->wpdb->get_results($report_query);
        //phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
        $comment_parent_query = $this->wpdb->prepare("SELECT * FROM $this->comment_table WHERE comment_id = %d", $commentId);
        //phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
        $comm_parent_fetch_results = $this->wpdb->get_results($comment_parent_query);
        if ($comment_type == "reply")
        {
            $data = array(
                'comment_table_id' => $commentId,
                'report_table_id' => $report_table_id_val,
                'comment_text' => $cTextarea,
                'comment_type' => $comment_type,
                'commentator_name' => $commentator_name,
                'comment_email' => $comment_email_field,
            );
            $result = $this->wpdb->insert($this->comment_table_reply, $data);

            if ($result)
            {
                $to = $comm_parent_fetch_results[0]->comment_email;
                $subject = "@" . $commentator_name . ' replied your Comment';
                $message = 'You have got a reply from this post (' . $report_fetch_results[0]->report_title . ') and report type is (' . $report_fetch_results[0]->report_type . ')';
                $headers[] = 'Content-Type: text/html; charset=UTF-8';

                // Send the email
                $success = wp_mail($to, $subject, $message, $headers);

                if ($success)
                {
                    $after_rep_to = $comment_email_field;
                    $after_rep_subject = 'You replied to @'.$comm_parent_fetch_results[0]->commentator_name.'';
                    $after_rep_message = 'You have replied on this post (' . $report_fetch_results[0]->report_title . ') and comment author is (' . $comm_parent_fetch_results[0]->commentator_name . ')';
                    $after_rep_headers[] = 'Content-Type: text/html; charset=UTF-8';

                    // Send the email
                    $after_rep_success = wp_mail($after_rep_to, $after_rep_subject, $after_rep_message, $after_rep_headers);

                    if($after_rep_success){
                        $get_comment_email_enable_disable = get_option("comment_email_enable_disable", "");
                        $get_comment_email_recipient = get_option("comment_email_recipient", "");
                        $get_comment_email_subject = get_option("comment_email_subject", "");
                        $get_comment_email_email_content = get_option("comment_email_email_content", "");

                        $admins = get_users(array('role' => 'administrator'));

                        if (!empty($admins)) {
                            $admin_username = $admins[0]->user_login;
                        } else {
                            $admin_username = "Admin";
                        }
                        $cadmin_subject =  str_replace('{commentator_name}', $commentator_name, $get_comment_email_subject);
                        $cadmin_message = str_replace(
                            array('{admin_name}', '{commentator_email}', '{post_owner_email}' , '{post_name}'),
                            array($admin_username, $comment_email_field ,$report_fetch_results[0]->report_email,$report_fetch_results[0]->report_title ),
                            $get_comment_email_email_content
                        );

                        if($get_comment_email_enable_disable == "on"){
                            $to = $get_comment_email_recipient;
                            $subject = $cadmin_subject;
                            $message = $cadmin_message;
                            $headers[] = 'Content-Type: text/html; charset=UTF-8';
        
                            // Send the email
                            $success = wp_mail($to, $subject, $message, $headers);
                        }
                    }
                }
            }
        } else
        {
            $data = array(
                'report_table_id' => $report_table_id_val,
                'comment_text' => $cTextarea,
                'comment_type' => $comment_type,
                'commentator_name' => $commentator_name,
                'comment_email' => $comment_email_field,
            );
            $result = $this->wpdb->insert($this->comment_table, $data);

            if ($result)
            {
                $get_comment_customer_email_enable_disable = get_option("comment_customer_email_enable_disable", "");
                $get_comment_customer_email_subject = get_option("comment_customer_email_subject", "");
                $get_comment_customer_email_email_content = get_option("comment_customer_email_email_content", "");

                $customer_comment_author_subject = str_replace('{commentator_name}', $commentator_name, $get_comment_customer_email_subject); 
                $customer_comment_author_msg =  str_replace(
                    array('{post_owner_email}', '{commentator_name}' , '{post_title}'),
                    array($report_fetch_results[0]->report_email, $commentator_name , $report_fetch_results[0]->report_title),
                    $get_comment_customer_email_email_content
                );

                if($get_comment_customer_email_enable_disable == "on"){
                    $ca_to = $report_fetch_results[0]->report_email;
                    $ca_subject = $customer_comment_author_subject;
                    $ca_message = $customer_comment_author_msg;
                    $ca_headers[] = 'Content-Type: text/html; charset=UTF-8';
    
                    // Send the email
                    $ca_success = wp_mail($ca_to, $ca_subject, $ca_message, $ca_headers);
                    if($ca_success){
                        $ct_to = $comment_email_field;
                        $ct_subject = 'Your Comment submitted successfully';
                        $ct_message = 'You have commented on this post (' . $report_fetch_results[0]->report_title . ') and report type is (' . $report_fetch_results[0]->report_type . ')';
                        $ct_headers[] = 'Content-Type: text/html; charset=UTF-8';
    
                        // Send the email
                        $ct_success = wp_mail($ct_to, $ct_subject, $ct_message, $ct_headers);

                        if($ct_success){
                            $get_comment_email_enable_disable = get_option("comment_email_enable_disable", "");
                            $get_comment_email_recipient = get_option("comment_email_recipient", "");
                            $get_comment_email_subject = get_option("comment_email_subject", "");
                            $get_comment_email_email_content = get_option("comment_email_email_content", "");

                            $admins = get_users(array('role' => 'administrator'));

                            if (!empty($admins)) {
                                $admin_username = $admins[0]->user_login;
                            } else {
                                $admin_username = "Admin";
                            }
                            $cadmin_subject =  str_replace('{commentator_name}', $commentator_name, $get_comment_email_subject);
                            $cadmin_message = str_replace(
                                array('{admin_name}', '{commentator_email}', '{post_owner_email}' , '{post_name}'),
                                array($admin_username, $comment_email_field ,$report_fetch_results[0]->report_email,$report_fetch_results[0]->report_title ),
                                $get_comment_email_email_content
                            );

                            if($get_comment_email_enable_disable == "on"){
                                $to = $get_comment_email_recipient;
                                $subject = $cadmin_subject;
                                $message = $cadmin_message;
                                $headers[] = 'Content-Type: text/html; charset=UTF-8';
            
                                // Send the email
                                $success = wp_mail($to, $subject, $message, $headers);
                            }
                        }
                    }
                }

                
            }

        }


        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery

        if ($result !== false)
        {
            //phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
            $query = $this->wpdb->prepare("SELECT * FROM $this->comment_table WHERE report_table_id = %d", $report_table_id_val);
            //phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
            $fetch_results = $this->wpdb->get_results($query);
            ob_start();
            foreach ($fetch_results as $comment):
                $commentMail = $comment->comment_email;
                $replyMail = $comment->reply_to;
                ?>
                <li class="comment_list_div <?php echo !empty($replyMail) ? "reply_mail_ache" : "reply_mail_nai"; ?>">
                    <div class="comment_content">
                        <h3 class="commentator_name"><i class="fa-solid fa-circle-user"></i>

                            <?php
                            if ($requestFrom === "admin")
                            {
                                echo esc_html($comment->commentator_name);
                                ?>
                                <span class="comment_email_span"><?php echo esc_html($comment->comment_email); ?></span>
                                <?php

                            } else
                            {
                                if (empty($comment->commentator_name) && $comment->comment_email === "admin@gmail.com")
                                {
                                    echo esc_html("Admin");
                                } else
                                {
                                    echo esc_html($comment->commentator_name);
                                }

                            }

                            ?>
                        </h3>
                        <p class="commentator_content">
                            <?php echo esc_html($comment->comment_text); ?>
                        </p>
                        <div class="edit_remove_reply_div">
                            <span class="time_stamp"> <?php echo esc_html($comment->comment_time); ?></span>

                            <?php if ($requestFrom === "admin"): ?>


                                <span class="comment_trash" data-reportId="<?php echo esc_attr($comment->report_table_id); ?>"
                                    data-commentId="<?php echo esc_attr($comment->comment_id); ?>"
                                    data-commenttype="<?php echo esc_attr($comment->comment_type); ?>"><i
                                        class="fa-solid fa-trash"></i></span>
                            <?php else: ?>

                                <span class="comment_edit" data-reportId="<?php echo esc_attr($comment->report_table_id); ?>"
                                    data-commentId="<?php echo esc_attr($comment->comment_id); ?>"
                                    data-commenttype="<?php echo esc_attr($comment->comment_type); ?>"><i
                                        class="fa-solid fa-pen-to-square"></i></span>

                                <span class="comment_trash" data-reportId="<?php echo esc_attr($comment->report_table_id); ?>"
                                    data-commentId="<?php echo esc_attr($comment->comment_id); ?>"
                                    data-commenttype="<?php echo esc_attr($comment->comment_type); ?>"><i
                                        class="fa-solid fa-trash"></i></span>

                                <span
                                    class="comment_reply_icon comment_reply_<?php echo esc_attr($comment->comment_id); ?> <?php echo !empty($replyMail) ? "reply_hidden" : "reply_show"; ?> "
                                    data-commentator="<?php echo esc_attr($comment->commentator_name); ?>"
                                    data-reportId="<?php echo esc_attr($comment->report_table_id); ?>"
                                    data-commentId="<?php echo esc_attr($comment->comment_id); ?>"><i class="fa-solid fa-reply"></i></span>


                            <?php endif; ?>

                        </div>
                    </div>
                    <ul class="reply_comment_ul">
                        <?php
                        $report_table_id = $comment->report_table_id;
                        $comment_id = $comment->comment_id;
                        //phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
                        $commnet_reply_query_store_comment = $this->wpdb->prepare("SELECT * FROM $this->comment_table_reply WHERE report_table_id = %d AND comment_table_id= %d", $report_table_id, $comment_id);
                      //phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
                        $comment_reply_results_for_store_comment = $this->wpdb->get_results($commnet_reply_query_store_comment);
                        foreach ($comment_reply_results_for_store_comment as $comment_reply):
                            ?>
                            <li class="comment_list_div <?php echo !empty($replyMail) ? "reply_mail_ache" : "reply_mail_nai"; ?>">
                                <div class="comment_content">
                                    <h3 class="commentator_name"><i class="fa-solid fa-circle-user"></i>
                                        <?php

                                        echo esc_html($comment_reply->commentator_name);
                                        ?>
                                    </h3>
                                    <p class="commentator_content">
                                        <?php
                                        echo esc_html($comment_reply->comment_text);
                                        ?>
                                    </p>
                                    <div class="edit_remove_reply_div">
                                        <span class="time_stamp">
                                            <?php
                                            $datetime1 = new DateTime($comment_reply->comment_time);
                                            $datetime2 = new DateTime();
                                            $interval = $datetime1->diff($datetime2);

                                            // Get the difference in days and minutes
                                            $days = $interval->days;
                                            $minutes = $interval->days * 24 * 60 + $interval->h * 60 + $interval->i;
                                            echo esc_html($comment_reply->comment_time);
                                            ?>
                                        </span>
                                        <?php if ($requestFrom === "admin"): ?>
                                            <span class="comment_trash" data-reportId="<?php echo esc_attr($comment_reply->report_table_id); ?>"
                                                data-commentId="<?php echo esc_attr($comment_reply->comment_table_id); ?>"
                                                data-commenttype="<?php echo esc_attr($comment_reply->comment_type); ?>"><i
                                                    class="fa-solid fa-trash"></i></span>

                                        <?php else: ?>

                                            <span class="comment_edit" data-reportId="<?php echo esc_attr($comment_reply->report_table_id); ?>"
                                                data-commentId="<?php echo esc_attr($comment_reply->comment_table_id); ?>"
                                                data-commenttype="<?php echo esc_attr($comment_reply->comment_type); ?>"><i
                                                    class="fa-solid fa-pen-to-square"></i></span>

                                            <span class="comment_trash" data-reportId="<?php echo esc_attr($comment_reply->report_table_id); ?>"
                                                data-commentId="<?php echo esc_attr($comment_reply->comment_table_id); ?>"
                                                data-commenttype="<?php echo esc_attr($comment_reply->comment_type); ?>"><i
                                                    class="fa-solid fa-trash"></i></span>


                                        <?php endif; ?>
                                    </div>
                                </div>
                            </li>
                            <?php
                        endforeach;
                        ?>

                    </ul>
                </li>

                <?php
                //phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
                $commnet_reply_query_total = $this->wpdb->prepare("SELECT * FROM $this->comment_table_reply WHERE report_table_id = %d", $report_table_id);
              //phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
                $comment_reply_results_total = $this->wpdb->get_results($commnet_reply_query_total);
            endforeach;
            $comment_html = ob_get_clean();

            $status = true;
        } else
        {
            $status = false;
        }

        wp_send_json_success(array("status" => $status, "commenting_details" => (count($fetch_results) + count($comment_reply_results_total)), "comment_html" => $comment_html, "success" => $success));
        wp_die();

    }

    public function remove_vote_from_database_action_handler()
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'remove_vote_from_database_nonce'))
        {
            wp_send_json_error("Nonce verification failed!");
            return;
        }
        $report_table_id_val = isset($_POST['report_table_id_val']) ? sanitize_text_field($_POST['report_table_id_val']) : "";
        $voter_email = isset($_POST['voter_email']) ? sanitize_text_field($_POST['voter_email']) : "";
        // Prepare the data to delete based on the report_table_id
        $where = array(
            'report_table_id' => $report_table_id_val,
        );


        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
        $result = $this->wpdb->delete($this->table_name_2, $where);
        setcookie("voting_cookie_set", "", time() - 1, "/");

      

        if ($result != false)
        {
                        // Sanitize the table name
            $sanitized_table_name_2 = sanitize_key($this->table_name_2);

            // phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching
            //phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
            $vote_count_query = $this->wpdb->prepare("SELECT COUNT(CASE WHEN vote_ans = 'agree' THEN 1 END) AS agree_count, COUNT(CASE WHEN vote_ans = 'disagree' THEN 1 END) AS disagree_count FROM {$sanitized_table_name_2} WHERE report_table_id = %d", $report_table_id_val);

            //phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
            $vote_count_result = $this->wpdb->get_results($vote_count_query);
            $total_agree_voting = $vote_count_result[0]->agree_count;
            $total_disagree_voting = $vote_count_result[0]->disagree_count;


            $get_voting_delete_customer_enable_disable = get_option("voting_delete_customer_enable_disable", "");
            $get_voting_delete_customer_subject = get_option("voting_delete_customer_subject", "");
            $get_voting_delete_customer_email_content = get_option("voting_delete_customer_email_content", "");
    //phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
            $report_query = $this->wpdb->prepare("SELECT * FROM $this->table_name  WHERE id = %d", $report_table_id_val);
            //phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
            $report_fetch_results = $this->wpdb->get_results($report_query);
    
            $customer_voting_delete_message = str_replace(
                array('{post_name}', '{post_type}'),
                array($report_fetch_results[0]->report_title, $report_fetch_results[0]->report_type),
                $get_voting_delete_customer_email_content
            );
    
    
            if($get_voting_delete_customer_enable_disable){
                $customer_to = $voter_email;
                $customer_subject = $get_voting_delete_customer_subject;
                $customer_message = $customer_voting_delete_message;
                $customer_headers[] = 'Content-Type: text/html; charset=UTF-8';
                $voting_delete_customer_status = wp_mail($customer_to, $customer_subject, $customer_message, $customer_headers);
    
                if($voting_delete_customer_status){
                    $get_vote_delete_enable_disable = get_option("vote_delete_enable_disable", "");
                    $get_vote_delete_recipient = get_option("vote_delete_recipient", "");
                    $get_vote_delete_subject = get_option("vote_delete_subject", "");
                    $get_vote_delete_email_content = get_option("vote_delete_email_content", "");

                    $admin_voting_subject_text = str_replace(
                        array('{voter_email}'),
                        array($voter_email),
                        $get_vote_delete_subject
                    );

                    $admins = get_users(array('role' => 'administrator'));

                            if (!empty($admins)) {
                                $admin_username = $admins[0]->user_login;
                            } else {
                                $admin_username = "Admin";
                            }
                    $admin_voting_message_text = str_replace(
                        array('{admin_username}' , '{voter_email}' , '{post_title}', '{report_type}'),
                        array($admin_username ,$voter_email , $report_fetch_results[0]->report_title, $report_fetch_results[0]->report_type ),
                        $get_vote_delete_email_content
                    );

                    if($get_vote_delete_enable_disable){
                        $admin_voting_to = $get_vote_delete_recipient;
                        $admin_voting_subject = $admin_voting_subject_text;
                        $admin_voting_message = $admin_voting_message_text;
                        $admin_voting_headers[] = 'Content-Type: text/html; charset=UTF-8';
                        $voting_delete_admin_voting_status = wp_mail($admin_voting_to, $admin_voting_subject, $admin_voting_message, $admin_voting_headers);

                        if($voting_delete_admin_voting_status){
                            $post_owner_voting_to = $report_fetch_results[0]->report_email;
                            $post_owner_voting_subject = "Someone remove vote from your post";
                            $post_owner_voting_message = "Hi , ".$report_fetch_results[0]->report_email." . Someone removed vote from your post . Post Title is:".$report_fetch_results[0]->report_title."";
                            $post_owner_voting_headers[] = 'Content-Type: text/html; charset=UTF-8';
                            $voting_delete_post_owner_voting_status = wp_mail($post_owner_voting_to, $post_owner_voting_subject, $post_owner_voting_message, $post_owner_voting_headers);
                        }
                    }
                }
            }
            $status = true;
        } else
        {
            $status = false;
        }

        ob_start() ;
        ?>
        <div class="agree_disagree_hidden_div">
            <label for="hidden_div_content">What is your Feedback For this Suggestion?
                <span> (Optional.
                    Only seen by our team)</span></label>
            <textarea name="" placeholder="Your Feedback" id="hidden_div_content" cols="30" rows="10"></textarea>
            <div class="hidden_div_vote_options">
                <input type="email" name="" placeholder="Your Email" id="voting_email_field">
                <div class="keep_me_posted_div">
                    <label for="keep_me_posted">Keep Me Posted</label>
                    <input type="checkbox" name="" placeholder="Keep me Posted" id="keep_me_posted">
                </div>
                <button class="vote_btn">Vote</button>
            </div>
            <p class="submittes_result_massage"></p>
        </div>
       <?php

       $voting_html =  ob_get_clean();

        wp_send_json_success(array("report_table_id_val" => $report_table_id_val, "total_agree_voting" => $total_agree_voting, "total_disagree_voting" => $total_disagree_voting, "status" => $status , 'voting_html'=>$voting_html));
        wp_die();
    }

    public function edit_comment_data_action_handler()
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'edit_comment_data_nonce'))
        {
            wp_send_json_error("Nonce verification failed!");
            return;
        }
        $report_table_id_val = isset($_POST['reportId']) ? sanitize_text_field($_POST['reportId']) : "";
        $commentId = isset($_POST['commentId']) ? sanitize_text_field($_POST['commentId']) : "";
        $commenttype = isset($_POST['commenttype']) ? sanitize_text_field($_POST['commenttype']) : "";
        $comment_email = isset($_POST['comment_email']) ? sanitize_text_field($_POST['comment_email']) : "";

        if ($commenttype == "comment")
        {
            //phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
            $query = $this->wpdb->prepare("SELECT * FROM $this->comment_table WHERE report_table_id = %d AND comment_id= %d AND comment_email= %s", $report_table_id_val, $commentId, $comment_email);
            //phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
            $fetch_results = $this->wpdb->get_results($query);
        } else
        {
            //phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
            $query = $this->wpdb->prepare("SELECT * FROM $this->comment_table_reply WHERE report_table_id = %d AND comment_table_id= %d AND comment_email= %s", $report_table_id_val, $commentId, $comment_email);
           //phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
            $fetch_results = $this->wpdb->get_results($query);
        }

        if ($fetch_results)
        {
            $status = true;
        } else
        {
            $status = false;
        }
        wp_send_json_success(array("data_all_data" => $fetch_results, 'commenttype' => $commenttype, "status" => $status));
        wp_die();
    }

    public function voting_email_checking_action_handler()
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'voting_email_checking_nonce'))
        {
            wp_send_json_error("Nonce verification failed!");
            return;
        }
        $report_table_id_val = isset($_POST['reportId']) ? sanitize_text_field($_POST['reportId']) : "";
        $voting_email = isset($_POST['voting_email']) ? sanitize_text_field($_POST['voting_email']) : "";
//phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
        $voting_email_query = $this->wpdb->prepare("SELECT * FROM $this->table_name_2 WHERE report_table_id = %d AND vote_email= %s", $report_table_id_val, $voting_email);
       //phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
        $voting_email_result = $this->wpdb->get_results($voting_email_query);
        

        if ($voting_email_result)
        {
            $status = true;
        } else
        {
            $status = false;
        }
        wp_send_json_success(array("data_all_data" => $voting_email_result,  "status" => $status));
        wp_die();
    }
    public function update_comment_data_action_handler()
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'update_comment_data_nonce'))
        {
            wp_send_json_error("Nonce verification failed!");
            return;
        }
        $report_table_id_val = isset($_POST['reportId']) ? sanitize_text_field($_POST['reportId']) : "";
        $commentId = isset($_POST['commentId']) ? sanitize_text_field($_POST['commentId']) : "";
        $commenttype = isset($_POST['commenttype']) ? sanitize_text_field($_POST['commenttype']) : "";
        $comment_email = isset($_POST['comment_email']) ? sanitize_text_field($_POST['comment_email']) : "";
        $textareaValue = isset($_POST['textareaValue']) ? sanitize_text_field($_POST['textareaValue']) : "";
        $nameValue = isset($_POST['nameValue']) ? sanitize_text_field($_POST['nameValue']) : "";
//phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
        $report_query = $this->wpdb->prepare("SELECT * FROM $this->table_name WHERE id = %d", $report_table_id_val);
        //phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared   
        $report_fetch_results = $this->wpdb->get_results($report_query);

        if ($commenttype == "comment")
        {

            $data_to_update = array(
                'comment_text' => $textareaValue,
                'commentator_name' => $nameValue,
            );

            $where = array(
                'comment_id' => $commentId,
                'report_table_id' => $report_table_id_val,
                'comment_email' => $comment_email,
            );

            $update_result = $this->wpdb->update(
                $this->comment_table, // Table name
                $data_to_update,   // Data to update
                $where             // WHERE condition
            );
        } else
        {

            $data_to_update = array(
                'comment_text' => $textareaValue,
                'commentator_name' => $nameValue,
            );

            $where = array(
                'comment_table_id' => $commentId,
                'report_table_id' => $report_table_id_val,
                'comment_email' => $comment_email,
            );

            $update_result = $this->wpdb->update(
                $this->comment_table_reply, // Table name
                $data_to_update,   // Data to update
                $where             // WHERE condition
            );
        }

        if ($update_result)
        {

            $commentator_to = $comment_email;
            $commentator_subject = "You have  Edit your comment";
            $commentator_message = "Hi ".$comment_email." , You edited your comment from post_title:".$report_fetch_results[0]->report_title." . ";
            $commentator_headers[] = 'Content-Type: text/html; charset=UTF-8';
            $commentator_status = wp_mail($commentator_to, $commentator_subject, $commentator_message, $commentator_headers);

            if($commentator_status){
                $post_owner_to = $report_fetch_results[0]->report_email;
                $post_owner_subject = "Someone edited a comment from your post";
                $post_owner_message = "Hi ".$report_fetch_results[0]->report_email." , Someone edit a comment from your post and  post_title is:".$report_fetch_results[0]->report_title." . ";
                $post_owner_headers[] = 'Content-Type: text/html; charset=UTF-8';
                $post_owner_status = wp_mail($post_owner_to, $post_owner_subject, $post_owner_message, $post_owner_headers);

                if($post_owner_status){
                    $get_comment_edit_admin_email_recipient = get_option("comment_delete_admin_email_recipient", "");

                    $admins = get_users(array('role' => 'administrator'));

                    if (!empty($admins)) {
                        $admin_username = $admins[0]->user_login;
                    } else {
                        $admin_username = "Admin";
                    }


                   
                        $admin_to = $get_comment_edit_admin_email_recipient;
                        $admin_subject = "@".$comment_email." Edit a commnent";
                        $admin_message ="Hi , ".$admin_username.". @ ".$comment_email." Edit a comment from a post and post name is:".$report_fetch_results[0]->report_title." ";
                        $admin_headers[] = 'Content-Type: text/html; charset=UTF-8';
                        $admin_status = wp_mail($admin_to, $admin_subject, $admin_message, $admin_headers);
                    

                    
                }
            }

          
//phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
            $query = $this->wpdb->prepare("SELECT * FROM $this->comment_table WHERE report_table_id = %d", $report_table_id_val);
           //phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
            $fetch_results = $this->wpdb->get_results($query);
            ob_start();
            foreach ($fetch_results as $comment):
                $commentMail = $comment->comment_email;
                $replyMail = $comment->reply_to;
                ?>
                <li class="comment_list_div <?php echo !empty($replyMail) ? "reply_mail_ache" : "reply_mail_nai"; ?>">
                    <div class="comment_content">
                        <h3 class="commentator_name"><i class="fa-solid fa-circle-user"></i>

                            <?php

                            if (empty($comment->commentator_nam) && $comment->comment_email === "admin@gmail.com")
                            {
                                echo esc_html("Admin");
                            } else
                            {
                                echo esc_html($comment->commentator_name);
                            }



                            ?>
                        </h3>
                        <p class="commentator_content">
                            <?php echo esc_html($comment->comment_text); ?>
                        </p>
                        <div class="edit_remove_reply_div">
                            <span class="time_stamp"> <?php echo esc_html($comment->comment_time); ?></span>

                            <span class="comment_edit" data-reportId="<?php echo esc_attr($comment->report_table_id); ?>"
                                data-commentId="<?php echo esc_attr($comment->comment_id); ?>"
                                data-commenttype="<?php echo esc_attr($comment->comment_type); ?>"><i
                                    class="fa-solid fa-pen-to-square"></i></span>

                            <span class="comment_trash" data-reportId="<?php echo esc_attr($comment->report_table_id); ?>"
                                data-commentId="<?php echo esc_attr($comment->comment_id); ?>"
                                data-commenttype="<?php echo esc_attr($comment->comment_type); ?>"><i
                                    class="fa-solid fa-trash"></i></span>

                            <span
                                class="comment_reply_icon comment_reply_<?php echo esc_attr($comment->comment_id); ?> <?php echo !empty($replyMail) ? "reply_hidden" : "reply_show"; ?> "
                                data-commentator="<?php echo esc_attr($comment->commentator_name); ?>"
                                data-reportId="<?php echo esc_attr($comment->report_table_id); ?>"
                                data-commentId="<?php echo esc_attr($comment->comment_id); ?>"><i class="fa-solid fa-reply"></i></span>

                        </div>
                    </div>
                    <ul class="reply_comment_ul">
                        <?php
                        $report_table_id = $comment->report_table_id;
                        $comment_id = $comment->comment_id;
                        //phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
                        $commnet_reply_query_store_comment = $this->wpdb->prepare("SELECT * FROM $this->comment_table_reply WHERE report_table_id = %d AND comment_table_id= %d", $report_table_id, $comment_id);
                      //phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
                        $comment_reply_results_for_store_comment = $this->wpdb->get_results($commnet_reply_query_store_comment);
                        foreach ($comment_reply_results_for_store_comment as $comment_reply):
                            ?>
                            <li class="comment_list_div <?php echo !empty($replyMail) ? "reply_mail_ache" : "reply_mail_nai"; ?>">
                                <div class="comment_content">
                                    <h3 class="commentator_name"><i class="fa-solid fa-circle-user"></i>
                                        <?php

                                        echo esc_html($comment_reply->commentator_name);
                                        ?>
                                    </h3>
                                    <p class="commentator_content">
                                        <?php
                                        echo esc_html($comment_reply->comment_text);
                                        ?>
                                    </p>
                                    <div class="edit_remove_reply_div">
                                        <span class="time_stamp">
                                            <?php
                                            $datetime1 = new DateTime($comment_reply->comment_time);
                                            $datetime2 = new DateTime();
                                            $interval = $datetime1->diff($datetime2);

                                            // Get the difference in days and minutes
                                            $days = $interval->days;
                                            $minutes = $interval->days * 24 * 60 + $interval->h * 60 + $interval->i;
                                            echo esc_html($comment_reply->comment_time);
                                            ?>
                                        </span>

                                        <span class="comment_edit" data-reportId="<?php echo esc_attr($comment_reply->report_table_id); ?>"
                                            data-commentId="<?php echo esc_attr($comment_reply->comment_table_id); ?>"
                                            data-commenttype="<?php echo esc_attr($comment_reply->comment_type); ?>"><i
                                                class="fa-solid fa-pen-to-square"></i></span>

                                        <span class="comment_trash" data-reportId="<?php echo esc_attr($comment_reply->report_table_id); ?>"
                                            data-commentId="<?php echo esc_attr($comment_reply->comment_table_id); ?>"
                                            data-commenttype="<?php echo esc_attr($comment_reply->comment_type); ?>"><i
                                                class="fa-solid fa-trash"></i></span>



                                    </div>
                                </div>
                            </li>
                            <?php
                        endforeach;
                        ?>

                    </ul>
                </li>

                <?php
                //phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
                $commnet_reply_query_total = $this->wpdb->prepare("SELECT * FROM $this->comment_table_reply WHERE report_table_id = %d", $report_table_id);
               //phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
                $comment_reply_results_total = $this->wpdb->get_results($commnet_reply_query_total);
            endforeach;
            $comment_html = ob_get_clean();
            $status = true;

        } else
        {
            $status = false;
        }
        wp_send_json_success(array("comment_html" => $comment_html, "total_count_comment" => (count($fetch_results) + count($comment_reply_results_total)), "status" => $status));
        wp_die();
    }
    public function delete_comment_data_action_handler()
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'delete_comment_data_nonce'))
        {
            wp_send_json_error("Nonce verification failed!");
            return;
        }
        $report_table_id_val = isset($_POST['reportId']) ? sanitize_text_field($_POST['reportId']) : "";
        $commentId = isset($_POST['commentId']) ? sanitize_text_field($_POST['commentId']) : "";
        $commenttype = isset($_POST['commenttype']) ? sanitize_text_field($_POST['commenttype']) : "";
        $comment_email = isset($_POST['comment_email']) ? sanitize_text_field($_POST['comment_email']) : "";
        $requestFrom = isset($_POST['requestFrom']) ? sanitize_text_field($_POST['requestFrom']) : "";
//phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
        $report_query = $this->wpdb->prepare("SELECT * FROM $this->table_name WHERE id = %d", $report_table_id_val);
        //phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared  
        $report_fetch_results = $this->wpdb->get_results($report_query);
        if ($commenttype == "comment")
        {
            $where = array(
                'comment_id' => $commentId,
                'report_table_id' => $report_table_id_val,
                'comment_email' => $comment_email,
            );

            $update_result_new = $this->wpdb->delete(
                $this->comment_table, // Table name  
                $where             // WHERE condition
            );

            if ($update_result_new)
            {
                $reply_table_where = array(
                    'comment_table_id' => $commentId,
                    'report_table_id' => $report_table_id_val,
                );
                $update_result = $this->wpdb->delete(
                    $this->comment_table_reply, // Table name
                    $reply_table_where             // WHERE condition
                );

                if ($update_result == false)
                {
                    $update_result = true;
                }
            }


        } else
        {
            $where = array(
                'comment_table_id' => $commentId,
                'report_table_id' => $report_table_id_val,
                'comment_email' => $comment_email,
            );

            $update_result = $this->wpdb->delete(
                $this->comment_table_reply, // Table name
                $where             // WHERE condition
            );
        }

        if ($update_result)
        {


            $commentator_to = $comment_email;
            $commentator_subject = "You have successfully delete your comment";
            $commentator_message = "Hi ".$comment_email." , You deleted your comment from post_title:".$report_fetch_results[0]->report_title." . ";
            $commentator_headers[] = 'Content-Type: text/html; charset=UTF-8';
            $commentator_status = wp_mail($commentator_to, $commentator_subject, $commentator_message, $commentator_headers);

            if($commentator_status){
                $post_owner_to = $report_fetch_results[0]->report_email;
                $post_owner_subject = "Someone Deleted a comment from your post";
                $post_owner_message = "Hi ".$report_fetch_results[0]->report_email." , Someone deleted a comment from your post and  post_title is:".$report_fetch_results[0]->report_title." . ";
                $post_owner_headers[] = 'Content-Type: text/html; charset=UTF-8';
                $post_owner_status = wp_mail($post_owner_to, $post_owner_subject, $post_owner_message, $post_owner_headers);

                if($post_owner_status){
                    $get_comment_delete_admin_email_enable_disable = get_option("comment_delete_admin_email_enable_disable", "");
                    $get_comment_delete_admin_email_recipient = get_option("comment_delete_admin_email_recipient", "");
                    $get_comment_delete_admin_email_subject = get_option("comment_delete_admin_email_subject", "");
                    $get_comment_delete_admin_email_email_content = get_option("comment_delete_admin_email_email_content", "");

                    $comment_delete_admin_subject = str_replace(
                        array('{commentator_email}' ),
                        array($comment_email  ),
                        $get_comment_delete_admin_email_subject
                    );

                    $admins = get_users(array('role' => 'administrator'));

                    if (!empty($admins)) {
                        $admin_username = $admins[0]->user_login;
                    } else {
                        $admin_username = "Admin";
                    }
                    $comment_delete_admin_message = str_replace(
                        array('{admin_name}', '{commentator_email}',  '{post_name}' ),
                        array($admin_username,$comment_email , $report_fetch_results[0]->report_title),
                        $get_comment_delete_admin_email_email_content
                    );

                    if($get_comment_delete_admin_email_enable_disable){
                        $admin_to = $get_comment_delete_admin_email_recipient;
                        $admin_subject = $comment_delete_admin_subject;
                        $admin_message = $comment_delete_admin_message;
                        $admin_headers[] = 'Content-Type: text/html; charset=UTF-8';
                        $admin_status = wp_mail($admin_to, $admin_subject, $admin_message, $admin_headers);
                    }

                    
                }
            }
//phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
            $query = $this->wpdb->prepare("SELECT * FROM $this->comment_table WHERE report_table_id = %d", $report_table_id_val);
          //phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
            $fetch_results = $this->wpdb->get_results($query);
            ob_start();
            foreach ($fetch_results as $comment):
                $commentMail = $comment->comment_email;
                $replyMail = $comment->reply_to;
                ?>
                <li class="comment_list_div <?php echo !empty($replyMail) ? "reply_mail_ache" : "reply_mail_nai"; ?>">
                    <div class="comment_content">
                        <h3 class="commentator_name"><i class="fa-solid fa-circle-user"></i>

                            <?php

                            if (empty($comment->commentator_nam) && $comment->comment_email === "admin@gmail.com")
                            {
                                echo esc_html("Admin");
                            } else
                            {
                                echo esc_html($comment->commentator_name);
                            }




                            ?>
                        </h3>
                        <p class="commentator_content">
                            <?php echo esc_html($comment->comment_text); ?>
                        </p>
                        <div class="edit_remove_reply_div">
                            <span class="time_stamp"> <?php echo esc_html($comment->comment_time); ?></span>
                            <?php if ($requestFrom == "admin"): ?>
                                <span class="comment_trash" data-reportId="<?php echo esc_attr($comment->report_table_id); ?>"
                                    data-commentId="<?php echo esc_attr($comment->comment_id); ?>"
                                    data-commenttype="<?php echo esc_attr($comment->comment_type); ?>"><i
                                        class="fa-solid fa-trash"></i></span>
                            <?php else: ?>

                                <span class="comment_edit" data-reportId="<?php echo esc_attr($comment->report_table_id); ?>"
                                    data-commentId="<?php echo esc_attr($comment->comment_id); ?>"
                                    data-commenttype="<?php echo esc_attr($comment->comment_type); ?>"><i
                                        class="fa-solid fa-pen-to-square"></i></span>

                                <span class="comment_trash" data-reportId="<?php echo esc_attr($comment->report_table_id); ?>"
                                    data-commentId="<?php echo esc_attr($comment->comment_id); ?>"
                                    data-commenttype="<?php echo esc_attr($comment->comment_type); ?>"><i
                                        class="fa-solid fa-trash"></i></span>

                                <span
                                    class="comment_reply_icon comment_reply_<?php echo esc_attr($comment->comment_id); ?> <?php echo !empty($replyMail) ? "reply_hidden" : "reply_show"; ?> "
                                    data-commentator="<?php echo esc_attr($comment->commentator_name); ?>"
                                    data-reportId="<?php echo esc_attr($comment->report_table_id); ?>"
                                    data-commentId="<?php echo esc_attr($comment->comment_id); ?>"><i class="fa-solid fa-reply"></i></span>


                            <?php endif; ?>

                        </div>
                    </div>
                    <ul class="reply_comment_ul">
                        <?php
                        $report_table_id = $comment->report_table_id;
                        $comment_id = $comment->comment_id;
                        //phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
                        $commnet_reply_query_store_comment = $this->wpdb->prepare("SELECT * FROM $this->comment_table_reply WHERE report_table_id = %d AND comment_table_id= %d", $report_table_id, $comment_id);
                       //phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
                        $comment_reply_results_for_store_comment = $this->wpdb->get_results($commnet_reply_query_store_comment);
                        foreach ($comment_reply_results_for_store_comment as $comment_reply):
                            ?>
                            <li class="comment_list_div <?php echo !empty($replyMail) ? "reply_mail_ache" : "reply_mail_nai"; ?>">
                                <div class="comment_content">
                                    <h3 class="commentator_name"><i class="fa-solid fa-circle-user"></i>
                                        <?php

                                        echo esc_html($comment_reply->commentator_name);
                                        ?>
                                    </h3>
                                    <p class="commentator_content">
                                        <?php
                                        echo esc_html($comment_reply->comment_text);
                                        ?>
                                    </p>
                                    <div class="edit_remove_reply_div">
                                        <span class="time_stamp">
                                            <?php
                                            $datetime1 = new DateTime($comment_reply->comment_time);
                                            $datetime2 = new DateTime();
                                            $interval = $datetime1->diff($datetime2);

                                            // Get the difference in days and minutes
                                            $days = $interval->days;
                                            $minutes = $interval->days * 24 * 60 + $interval->h * 60 + $interval->i;
                                            echo esc_html($comment_reply->comment_time);
                                            ?>
                                        </span>


                                        <?php if ($requestFrom == "admin"): ?>
                                            <span class="comment_trash" data-reportId="<?php echo esc_attr($comment_reply->report_table_id); ?>"
                                                data-commentId="<?php echo esc_attr($comment_reply->comment_table_id); ?>"
                                                data-commenttype="<?php echo esc_attr($comment_reply->comment_type); ?>"><i
                                                    class="fa-solid fa-trash"></i></span>

                                        <?php else: ?>

                                            <span class="comment_trash" data-reportId="<?php echo esc_attr($comment_reply->report_table_id); ?>"
                                                data-commentId="<?php echo esc_attr($comment_reply->comment_table_id); ?>"
                                                data-commenttype="<?php echo esc_attr($comment_reply->comment_type); ?>"><i
                                                    class="fa-solid fa-trash"></i></span>
                                            <span class="comment_edit" data-reportId="<?php echo esc_attr($comment_reply->report_table_id); ?>"
                                                data-commentId="<?php echo esc_attr($comment_reply->comment_table_id); ?>"
                                                data-commenttype="<?php echo esc_attr($comment_reply->comment_type); ?>"><i
                                                    class="fa-solid fa-pen-to-square"></i></span>

                                        <?php endif; ?>

                                    </div>
                                </div>
                            </li>
                            <?php
                        endforeach;
                        ?>

                    </ul>
                </li>

                <?php
                //phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
                $commnet_reply_query_total = $this->wpdb->prepare("SELECT * FROM $this->comment_table_reply WHERE report_table_id = %d", $report_table_id);
              //phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
                $comment_reply_results_total = $this->wpdb->get_results($commnet_reply_query_total);
            endforeach;
            $comment_html = ob_get_clean();
            $status = true;

        } else
        {
            $status = false;
        }

        wp_send_json_success(array("update_result" => $update_result, "comment_html" => $comment_html, "total_count_comment" => (count($fetch_results) + count($comment_reply_results_total)), "status" => $status));

        wp_die();
    }
}

new Features_Request_Shortcode();