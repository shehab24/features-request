<?php

class Features_Request_Shortcode
{
    private $table_name;
    private $table_name_2;
    private $comment_table;
    private $plugin_add;
    private $wpdb;
    public function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table_name = $this->wpdb->prefix . 'fereq_store_reports';
        $this->table_name_2 = $this->wpdb->prefix . 'fereq_store_all_voteing';
        $this->comment_table = $this->wpdb->prefix . 'fereq_store_all_comments';
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


    }



    public function frontend_scripts_callback()
    {
        wp_enqueue_script("jquery");
        wp_enqueue_style("fereq-frontend-css", FEREQ_DIR_URL . "assets/css/frontend-fereq.css", [], FEREQ_VERSION, 'screen');
        wp_enqueue_style("fereq-fontawesome-css", FEREQ_DIR_URL . "assets/css/font-awesome.min.css", [], FEREQ_VERSION, 'screen');
        wp_enqueue_script("fereq-frontend-js", FEREQ_DIR_URL . "assets/js/frontend-fereq.js", [], FEREQ_VERSION, true);
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
        );
        wp_localize_script('fereq-frontend-js', 'ajax_data', $ajax_data);
    }

    public function features_request_shortcode_callback()
    {
        ob_start();

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

            $inserted_id = $this->wpdb->insert_id;
            $comment_data = array(
                'report_table_id' => $inserted_id,
                'vote_ans' => $vote_ans,
                'vote_feedback' => $suggestion_massage,
                'vote_email' => $suggestion_email,
            );
            $comment_result = $this->wpdb->insert($this->table_name_2, $comment_data);
            if ($comment_result !== false)
            {
                $status = true;
            } else
            {
                $status = false;
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

        $query = $this->wpdb->prepare(" SELECT t1.*, 
                COALESCE(subquery.total_agree_voting, 0) AS total_agree_voting,
                COALESCE(subquery.total_disagree_voting, 0) AS total_disagree_voting
            FROM {$this->table_name} AS t1
            LEFT JOIN (
                SELECT report_table_id, 
                    SUM(CASE WHEN vote_ans = 'agree' THEN 1 ELSE 0 END) AS total_agree_voting,
                    SUM(CASE WHEN vote_ans = 'disagree' THEN 1 ELSE 0 END) AS total_disagree_voting
                FROM {$this->table_name_2}
                GROUP BY report_table_id
            ) AS subquery ON t1.id = subquery.report_table_id
            WHERE t1.report_status = %s
            AND t1.submit_privately != %s
        ", 'exploring', 'on');




        // Execute the query and fetch the results
        $fetch_results = $this->wpdb->get_results($query);

        ob_start();
        foreach ($fetch_results as $result):
            $insertion_time_str = $result->inserted_time;
            $current_date = date("Y-m-d");
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
                            $comment_query = $this->wpdb->prepare("SELECT * FROM $this->comment_table WHERE report_table_id = %d", $result->id);
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

        $query = $this->wpdb->prepare(" SELECT t1.*, 
                COALESCE(subquery.total_agree_voting, 0) AS total_agree_voting,
                COALESCE(subquery.total_disagree_voting, 0) AS total_disagree_voting
            FROM {$this->table_name} AS t1
            LEFT JOIN (
                SELECT report_table_id, 
                    SUM(CASE WHEN vote_ans = 'agree' THEN 1 ELSE 0 END) AS total_agree_voting,
                    SUM(CASE WHEN vote_ans = 'disagree' THEN 1 ELSE 0 END) AS total_disagree_voting
                FROM {$this->table_name_2}
                GROUP BY report_table_id
            ) AS subquery ON t1.id = subquery.report_table_id
            WHERE t1.report_status = %s
            AND t1.submit_privately != %s
        ", 'inprogress', 'on');


        // Execute the query and fetch the results
        $fetch_results = $this->wpdb->get_results($query);

        ob_start();
        foreach ($fetch_results as $result):
            $insertion_time_str = $result->inserted_time;
            $current_date = date("Y-m-d");
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
                            $comment_query = $this->wpdb->prepare("SELECT * FROM $this->comment_table WHERE report_table_id = %d", $result->id);
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

        $query = $this->wpdb->prepare(" SELECT t1.*, 
                COALESCE(subquery.total_agree_voting, 0) AS total_agree_voting,
                COALESCE(subquery.total_disagree_voting, 0) AS total_disagree_voting
            FROM {$this->table_name} AS t1
            LEFT JOIN (
                SELECT report_table_id, 
                    SUM(CASE WHEN vote_ans = 'agree' THEN 1 ELSE 0 END) AS total_agree_voting,
                    SUM(CASE WHEN vote_ans = 'disagree' THEN 1 ELSE 0 END) AS total_disagree_voting
                FROM {$this->table_name_2}
                GROUP BY report_table_id
            ) AS subquery ON t1.id = subquery.report_table_id
            WHERE t1.report_status = %s
            AND t1.submit_privately != %s
            ", 'done', 'on');

        // Execute the query and fetch the results
        $fetch_results = $this->wpdb->get_results($query);

        ob_start();
        foreach ($fetch_results as $result):
            $insertion_time_str = $result->inserted_time;
            $current_date = date("Y-m-d");
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
                            $comment_query = $this->wpdb->prepare("SELECT * FROM $this->comment_table WHERE report_table_id = %d", $result->id);
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

        $query = $this->wpdb->prepare("
        SELECT t1.*, 
               COALESCE(subquery.total_agree_voting, 0) AS total_agree_voting,
               COALESCE(subquery.total_disagree_voting, 0) AS total_disagree_voting
        FROM {$this->table_name} AS t1
        LEFT JOIN (
            SELECT report_table_id, 
                   SUM(CASE WHEN vote_ans = 'agree' THEN 1 ELSE 0 END) AS total_agree_voting,
                   SUM(CASE WHEN vote_ans = 'disagree' THEN 1 ELSE 0 END) AS total_disagree_voting
            FROM {$this->table_name_2}
            GROUP BY report_table_id
        ) AS subquery ON t1.id = subquery.report_table_id
        WHERE t1.id = %d
    ", $dataId);




        // Execute the query and fetch the results
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


                        ?>
                        <div class="upvote_downvote_div">
                            <span class="upvote_icon"><i class="fa-solid fa-thumbs-up"></i>
                                <span
                                    class="total_agree_vote_count_<?php echo esc_attr($dataId); ?>"><?php echo esc_html($fetch_results[0]->total_agree_voting); ?></span></span>
                            <span class="downvote_icon"><i class="fa-solid fa-thumbs-down"></i><span
                                    class="total_disagree_vote_count_<?php echo esc_attr($dataId); ?>"><?php echo esc_html($fetch_results[0]->total_disagree_voting); ?></span></span>
                        </div>

                        <span class="after_voting_done_msg">
                            <?php
                            $cookieValueId = isset($_COOKIE['voting_cookie_set']) ? $_COOKIE['voting_cookie_set'] : '';
                            if ($cookieValueId == $fetch_results[0]->id)
                            {
                                echo esc_html("You have Voted");
                            }
                            ?>
                        </span>
                        <?php
                    endif;
                    ?>
                </div>
                <?php
                if ($fetch_results[0]->report_type == "suggestion_submit"):

                    $cookieValueId = isset($_COOKIE['voting_cookie_set']) ? $_COOKIE['voting_cookie_set'] : '';
                    if ($cookieValueId != $fetch_results[0]->id):

                        ?>
                        <select name="agree_disagree_select" id="agree_disagree_select" class="agree_disagree_select">
                            <option value="">Do you Like/Dislike This Suggestion ?</option>
                            <option value="agree">Like</option>
                            <option value="disagree">Dislike</option>
                        </select>
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
                    $query = $this->wpdb->prepare("SELECT * FROM $this->comment_table WHERE report_table_id = %d", $fetch_results[0]->id);
                    $comment_results = $this->wpdb->get_results($query);

                    foreach ($comment_results as $comment_list):
                        ?>
                        <li class="comment_list_div">
                            <div class="comment_content">
                                <h3 class="commentator_name"><i class="fa-solid fa-circle-user"></i>
                                    <?php
                                    $emailPattern = '/^\S+@\S+\.\S+$/';
                                    if (preg_match($emailPattern, $comment_list->comment_email))
                                    {
                                        // If it's a valid email, apply the substr operation
                                        list($local, $domain) = explode('@', $comment_list->comment_email);
                                        echo substr($local, 0, 1) . str_repeat('*', strlen($local) - 1) . '@' . $domain;
                                    } else
                                    {
                                        // If it's not a valid email, print it as it is
                                        echo $comment_list->comment_email;
                                    }
                                    ?>
                                </h3>
                                <p class="commentator_content">
                                    <?php
                                    echo esc_html($comment_list->comment_text);
                                    ?>
                                </p>
                            </div>
                        </li>

                    <?php endforeach; ?>
                </ul>
                <div class="comment_form">
                    <textarea name="" id="comment_textarea" placeholder="Leave a comment ?" cols="30" rows="10"></textarea>
                    <div class="comment_email_require_box">
                        <input type="email" name="" placeholder="Your email" id="comment_email_field">
                        <button class="comment_btn">Comment</button>
                    </div>
                    <p class="comment_result_massage"></p>
                </div>
            </div>
        </div>

        <?php

        $html = ob_get_clean();
        wp_send_json_success(array("dataId" => $dataId, 'tabType' => $tabType, 'html' => $html, "fetchRes" => $fetch_results));
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
        $result = $this->wpdb->insert($this->table_name_2, $data);
        if ($result !== false)
        {
            setcookie("voting_cookie_set", $report_table_id_val, time() + (5 * 24 * 60 * 60), "/");

            $query = $this->wpdb->prepare("SELECT 
                    COUNT(CASE WHEN vote_ans = 'agree' THEN 1 END) AS agree_count,
                    COUNT(CASE WHEN vote_ans = 'disagree' THEN 1 END) AS disagree_count
                FROM $this->table_name_2 
                WHERE report_table_id = %d
            ", $report_table_id_val);
            $fetch_results = $this->wpdb->get_results($query);
            $total_agree_voting = $fetch_results[0]->agree_count;
            $total_disagree_voting = $fetch_results[0]->disagree_count;
            $status = true;
        } else
        {
            $status = false;
        }

        wp_send_json_success(array("status" => $status, "total_agree_voting" => $total_agree_voting, "total_disagree_voting" => $total_disagree_voting, "fetch_result" => $fetch_results));
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
        $requestFrom = isset($_POST['requestFrom']) ? sanitize_text_field($_POST['requestFrom']) : "";
        $cTextarea = isset($_POST['cTextarea']) ? sanitize_text_field($_POST['cTextarea']) : "";
        $report_table_id_val = isset($_POST['report_table_id_val']) ? sanitize_text_field($_POST['report_table_id_val']) : "";
        $data = array(
            'report_table_id' => $report_table_id_val,
            'comment_text' => $cTextarea,
            'comment_email' => $comment_email_field,
        );
        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
        $result = $this->wpdb->insert($this->comment_table, $data);
        if ($result !== false)
        {

            $query = $this->wpdb->prepare("SELECT * FROM $this->comment_table WHERE report_table_id = %d", $report_table_id_val);
            $fetch_results = $this->wpdb->get_results($query);
            ob_start();
            foreach ($fetch_results as $comment):
                ?>
                <li class="comment_list_div">
                    <div class="comment_content">
                        <h3 class="commentator_name"><i class="fa-solid fa-circle-user"></i>

                            <?php
                            if ($requestFrom === "publicUser")
                            {
                                $emailPattern = '/^\S+@\S+\.\S+$/';
                                if (preg_match($emailPattern, $comment->comment_email))
                                {
                                    // If it's a valid email, apply the substr operation
                                    list($local, $domain) = explode('@', $comment->comment_email);
                                    echo substr($local, 0, 1) . str_repeat('*', strlen($local) - 1) . '@' . $domain;
                                } else
                                {
                                    // If it's not a valid email, print it as it is
                                    echo $comment->comment_email;
                                }
                            } else
                            {
                                echo esc_html($comment->comment_email);
                            }

                            ?>
                        </h3>
                        <p class="commentator_content">
                            <?php echo esc_html($comment->comment_text); ?>
                        </p>
                    </div>
                </li>

                <?php

            endforeach;
            $comment_html = ob_get_clean();

            $status = true;
        } else
        {
            $status = false;
        }

        wp_send_json_success(array("status" => $status, "commenting_details" => count($fetch_results), "comment_html" => $comment_html));
        wp_die();

    }
}

new Features_Request_Shortcode();