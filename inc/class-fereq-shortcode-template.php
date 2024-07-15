<?php
global $wpdb;
$table_name = $wpdb->prefix . "fereq_store_reports";
$plugin_list = $wpdb->prefix . 'fereq_store_plugin_list';
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


<div class="features_request_main_div">
    <div class="features_request_header_div">
        <h3 class="feedback_title">
        <?php echo esc_html($feedback_button_settings['fda_title_text']); ?>
        </h3>
        <button class="feedback_btn"><?php echo esc_html($feedback_button_settings['feedback_button_text']); ?></button>

    </div>

    <div class="custom-model-main popup_for_add_data">
        <div class="custom-model-inner">
            <div class="close-btn add_data">×</div>
            <div class="custom-model-wrap">
                <div class="pop-up-content-wrap">
                    <div class="modal-container">
                        <header>
                            <div id="material-tabs">
                                <a id="tab1-tab" href="#tab1" class="active"><?php echo esc_html($issues_settings['ip_tab_title_text']); ?></a>
                                <a id="tab2-tab" href="#tab2"><?php echo esc_html($suggestion_settings['sp_tab_title_text']); ?>
                                </a>
                            </div>
                        </header>

                        <div class="tab-content">
                            <div id="tab1" class="feedback_tab">
                                <form method="post" id="issues_form">

                                    <select name="issues_plugin_name" id="" required>
                                        <option value="">Select Any</option>
                                        <?php
                                        $query = " SELECT * FROM " . $this->plugin_add;
                                        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
                                        // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
                                        $results = $this->wpdb->get_results($query);

                                        foreach ($results as $result):
                                            ?>
                                            <option value="<?php echo esc_attr($result->plugin_name); ?>">
                                                <?php echo esc_html($result->plugin_name); ?>
                                            </option>
                                            <?php

                                        endforeach;
                                        ?>
                                    </select>
                                    <input type="text" name="issues_title" id=""
                                        placeholder="<?php echo esc_html($issues_settings['ip_title_text']); ?>" required>
                                    <textarea name="issues_massage" id="" cols="30" rows="10" placeholder="<?php echo esc_html($issues_settings['ip_textarea_text']); ?>"
                                        required></textarea>
                                    <input type="url" name="issues_url" id="" placeholder="<?php echo esc_html($issues_settings['ip_drop_text']); ?>">
                                    <input type="email" name="issues_email" id="" placeholder="<?php echo esc_html($issues_settings['ip_email_text']); ?>" required>
                                    <div class="submit_private_div">
                                        <input type="checkbox" name="submit_privately" class="submit_privately_input"
                                            id="submit_privately">
                                        <label for="submit_privately" class="submit_privately">Submit privately to
                                            our
                                            team</label>
                                    </div>
                                    <button type="submit" class="submit_btn"><?php echo esc_html($issues_settings['ip_submit_button_text']); ?></button>
                                </form>
                                <p class="submisson_msg"></p>
                            </div>
                            <div id="tab2" class="feedback_tab">
                                <form method="post" id="suggestion_form">
                                    <select name="suggestion_plugin_name" id="" required>
                                        <option value="">Select Any </option>
                                        <?php
                                        $query = " SELECT * FROM " . $this->plugin_add;
                                        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
                                        // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
                                        $results = $this->wpdb->get_results($query);

                                        foreach ($results as $result):
                                            ?>
                                            <option value="<?php echo esc_attr($result->plugin_name); ?>">
                                                <?php echo esc_html($result->plugin_name); ?>
                                            </option>
                                            <?php

                                        endforeach;
                                        ?>
                                    </select>
                                    <input type="text" name="suggestion_title" id=""
                                        placeholder="<?php echo esc_attr($suggestion_settings['sp_title_text']); ?>" required>
                                    <textarea name="suggestion_massage" id="" cols="30" rows="10" placeholder="<?php echo esc_attr($suggestion_settings['sp_textarea_text']); ?>"
                                        required></textarea>
                                    <input type="url" name="suggestion_url" id="" placeholder="<?php echo esc_attr($suggestion_settings['sp_drop_text']); ?>">
                                    <input type="email" name="suggestion_email" id="" placeholder="<?php echo esc_attr($suggestion_settings['sp_email_text']); ?>" required>
                                    <div class="submit_private_div">
                                        <input type="checkbox" name="submit_privately" class="submit_privately_input"
                                            id="submit_privately_2">
                                        <label for="submit_privately_2" class="submit_privately">Submit privately to
                                            our
                                            team</label>
                                    </div>
                                    <button type="submit" class="submit_btn"><?php echo esc_html($suggestion_settings['sp_submit_button_text']); ?></button>
                                </form>
                                <p class="for_suggestion"></p>
                            </div>
                            <div id="loading_overlay">
                                <div class="cv-spinner">
                                    <span class="cspinner"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="bg-overlay add_data"></div>
    </div>
    <div class="features_request_body">

        <div class="container">
            <div class="tabs">
                <!-- Sign In -->
                <input type="radio" class="tabs__button" name="signForm" id="exploring" checked />
                <label class="tabs__text" for="exploring">Exploring</label>
                <div class="tabs__content">
                    <ul class="show_store_exploring_database_data filter_store_ul_data">

                        <?php
                        $table_name = sanitize_key($this->table_name);
                        $table_name_2 = sanitize_key($this->table_name_2);
                  //phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
                  $sanitized_table_name = sanitize_key($table_name);
                  $sanitized_table_name_2 = sanitize_key($table_name_2);
                   //phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
                  $query = $this->wpdb->prepare("SELECT t1.*, COALESCE(subquery.total_agree_voting, 0) AS total_agree_voting, COALESCE(subquery.total_disagree_voting, 0) AS total_disagree_voting FROM {$sanitized_table_name} AS t1 LEFT JOIN (SELECT report_table_id, SUM(CASE WHEN vote_ans = 'agree' THEN 1 ELSE 0 END) AS total_agree_voting, SUM(CASE WHEN vote_ans = 'disagree' THEN 1 ELSE 0 END) AS total_disagree_voting FROM {$sanitized_table_name_2} GROUP BY report_table_id) AS subquery ON t1.id = subquery.report_table_id WHERE t1.report_status = %s AND t1.submit_privately != %s", 'exploring', 'on');
                  


                        // Execute the query and fetch the results
                         // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
                        $fetch_results = $this->wpdb->get_results($query);

                        ob_start();
                        foreach ($fetch_results as $result):
                            $insertion_time_str = $result->inserted_time;
                            //phpcs:ignore WordPress.DateTime.RestrictedFunctions.date_date
                            $current_date = date("Y-m-d");
                             //phpcs:ignore WordPress.DateTime.RestrictedFunctions.date_date
                            $insertion_date = date("Y-m-d", strtotime($insertion_time_str));
                            ?>
                            <li class="show_content_popup_btn" data-id="<?php echo esc_attr($result->id); ?>"
                                data-tabType="exploring">
                                <input type="hidden"
                                    value="<?php echo esc_attr(($insertion_date == $current_date) ? "new" : "old"); ?>">
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

                                            $voting_status = ($result->total_agree_voting > 0 || $result->total_disagree_voting > 0) ? 'popular' : 'not_popular';

                                            ?>
                                            <input type="hidden" name="popular" value="<?php echo esc_attr($voting_status) ;  ?>" />
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
                                            $comment_query = $this->wpdb->prepare("SELECT * FROM {$this->comment_table} WHERE report_table_id = %d", $result->id);
                                          // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
                                            $comment_results = $this->wpdb->get_results($comment_query);
                                             //phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
                                            $commnet_reply_query_total = $this->wpdb->prepare("SELECT * FROM {$this->comment_table_reply} WHERE report_table_id = %d", $result->id);
                                             // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
                                            $comment_reply_results_total = $this->wpdb->get_results($commnet_reply_query_total);
                                            echo esc_html(count($comment_results) + count($comment_reply_results_total));
                                            ?>
                                        </b>
                                    </div>

                                </div>
                            </li>

                            <?php
                        endforeach;
                        $html = ob_get_clean();
                        //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                        printf($html);
                        ?>
                    </ul>
                    <div class="custom-model-main show_data_into_popup">
                        <div class="custom-model-inner">
                            <div class="close-btn show_data">×</div>
                            <div class="custom-model-wrap">
                                <div class="pop-up-content-wrap">
                                    <div class="modal-container" id="push_exploring_popup_data">

                                    </div>

                                </div>
                            </div>
                            <div id="loading_overlay" class="loading_for_show_popup_data">
                                <div class="cv-spinner">
                                    <span class="cspinner"></span>
                                </div>
                            </div>
                        </div>
                        <div class="bg-overlay show_data"></div>
                    </div>
                </div>
                <div class="filtering_main_div">
                    <div class="filtering_content">
                        <div class="filtering filtering_one">
                            <ul>
                                <li><button class="filter_button" data-value="popular">Popular</button></li>
                                <li><button class="filter_button" data-value="new">New</button></li>
                                <li><button class="filter_tag" data-value="issue">#Issue</button></li>
                                <li><button class="filter_tag" data-value="suggestion">#Suggestion</button></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Sign Up -->
                <input type="radio" class="tabs__button" name="signForm" id="in_progress" />
                <label class="tabs__text" for="in_progress">In Progress</label>
                <div class="tabs__content">
                    <ul class="show_store_inprogress_database_data filter_store_ul_data">
                        <?php
                        $table_name = sanitize_key($this->table_name);
                        $table_name_2 = sanitize_key($this->table_name_2);
                        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching
                        // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
                        $query = $this->wpdb->prepare("SELECT t1.*, COALESCE(subquery.total_agree_voting, 0) AS total_agree_voting, COALESCE(subquery.total_disagree_voting, 0) AS total_disagree_voting FROM {$table_name} AS t1 LEFT JOIN (SELECT report_table_id, SUM(CASE WHEN vote_ans = 'agree' THEN 1 ELSE 0 END) AS total_agree_voting, SUM(CASE WHEN vote_ans = 'disagree' THEN 1 ELSE 0 END) AS total_disagree_voting FROM {$table_name_2} GROUP BY report_table_id) AS subquery ON t1.id = subquery.report_table_id WHERE t1.report_status = %s AND t1.submit_privately != %s", 'inprogress', 'on');
                        

                        // Execute the query and fetch the results
                         // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
                        $fetch_results = $this->wpdb->get_results($query);

                        ob_start();
                        foreach ($fetch_results as $result):
                            $insertion_time_str = $result->inserted_time;
                             //phpcs:ignore WordPress.DateTime.RestrictedFunctions.date_date
                            $current_date = date("Y-m-d");
                             //phpcs:ignore WordPress.DateTime.RestrictedFunctions.date_date
                            $insertion_date = date("Y-m-d", strtotime($insertion_time_str));
                            ?>
                            <li class="show_content_popup_btn" data-id="<?php echo esc_attr($result->id); ?>"
                                data-tabType="inprogress">
                                <input type="hidden"
                                    value="<?php echo esc_attr(($insertion_date == $current_date) ? "new" : "old"); ?>">
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
                                            $voting_status = ($result->total_agree_voting > 0 || $result->total_disagree_voting > 0) ? 'popular' : 'not_popular';

                                            ?>
                                            <input type="hidden" name="popular" value="<?php echo esc_attr($voting_status );  ?>" />
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
                                            $comment_query = $this->wpdb->prepare("SELECT * FROM {$this->comment_table} WHERE report_table_id = %d", $result->id);
                                            // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
                                            $comment_results = $this->wpdb->get_results($comment_query);
                                              //phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
                                            $commnet_reply_query_total = $this->wpdb->prepare("SELECT * FROM {$this->comment_table_reply} WHERE report_table_id = %d", $result->id);
                                            // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
                                            $comment_reply_results_total = $this->wpdb->get_results($commnet_reply_query_total);
                                            echo esc_html(count($comment_results) + count($comment_reply_results_total));
                                            ?>
                                        </b>
                                    </div>
                                </div>
                            </li>

                            <?php
                        endforeach;
                        $html = ob_get_clean();
                         //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                        printf($html);
                        ?>

                    </ul>
                    <div class="custom-model-main show_data_into_popup">
                        <div class="custom-model-inner">
                            <div class="close-btn show_data">×</div>
                            <div class="custom-model-wrap">
                                <div class="pop-up-content-wrap">
                                    <div class="modal-container" id="push_inprogress_popup_data">

                                    </div>

                                </div>
                            </div>
                            <div id="loading_overlay" class="loading_for_show_popup_data">
                                <div class="cv-spinner">
                                    <span class="cspinner"></span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-overlay show_data"></div>
                    </div>
                </div>
                <!-- Sign Up -->
                <input type="radio" class="tabs__button" name="signForm" id="done" />
                <label class="tabs__text" for="done">Done</label>
                <div class="tabs__content">
                    <ul class="show_store_done_database_data filter_store_ul_data">
                        <?php
                  $table_name = sanitize_key($this->table_name);
                  $table_name_2 = sanitize_key($this->table_name_2);
                  
                  // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
                  $query = $this->wpdb->prepare("SELECT t1.*, COALESCE(subquery.total_agree_voting, 0) AS total_agree_voting, COALESCE(subquery.total_disagree_voting, 0) AS total_disagree_voting FROM {$table_name} AS t1 LEFT JOIN (SELECT report_table_id, SUM(CASE WHEN vote_ans = 'agree' THEN 1 ELSE 0 END) AS total_agree_voting, SUM(CASE WHEN vote_ans = 'disagree' THEN 1 ELSE 0 END) AS total_disagree_voting FROM {$table_name_2} GROUP BY report_table_id) AS subquery ON t1.id = subquery.report_table_id WHERE t1.report_status = %s AND t1.submit_privately != %s", 'done', 'on');
                  
                        // Execute the query and fetch the results
                         // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
                        $fetch_results = $this->wpdb->get_results($query);

                        ob_start();
                        foreach ($fetch_results as $result):
                            $insertion_time_str = $result->inserted_time;
                             //phpcs:ignore WordPress.DateTime.RestrictedFunctions.date_date
                            $current_date = date("Y-m-d");
                             //phpcs:ignore WordPress.DateTime.RestrictedFunctions.date_date
                            $insertion_date = date("Y-m-d", strtotime($insertion_time_str));
                            ?>
                            <li class="show_content_popup_btn" data-id="<?php echo esc_attr($result->id); ?>"
                                data-tabType="done">
                                <input type="hidden"
                                    value="<?php echo esc_attr(($insertion_date == $current_date) ? "new" : "old"); ?>">
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
                                            $voting_status = ($result->total_agree_voting > 0 || $result->total_disagree_voting > 0) ? 'popular' : 'not_popular';

                                            ?>
                                            <input type="hidden" name="popular" value="<?php echo esc_attr($voting_status );  ?>" />
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
                                            $comment_query = $this->wpdb->prepare("SELECT * FROM {$this->comment_table} WHERE report_table_id = %d", $result->id);
                                             // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
                                            $comment_results = $this->wpdb->get_results($comment_query);
                                            //phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
                                            $commnet_reply_query_total = $this->wpdb->prepare("SELECT * FROM {$this->comment_table_reply} WHERE report_table_id = %d", $result->id);
                                            // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
                                            $comment_reply_results_total = $this->wpdb->get_results($commnet_reply_query_total);
                                            echo esc_html(count($comment_results) + count($comment_reply_results_total));
                                            ?>
                                        </b>
                                    </div>
                                </div>
                            </li>

                            <?php
                        endforeach;
                        $html = ob_get_clean();
                    //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                        printf($html);
                        ?>
                    </ul>
                    <div class="custom-model-main show_data_into_popup">
                        <div class="custom-model-inner">
                            <div class="close-btn show_data">×</div>
                            <div class="custom-model-wrap">
                                <div class="pop-up-content-wrap">
                                    <div class="modal-container" id="push_done_popup_data">

                                    </div>

                                </div>
                            </div>
                            <div id="loading_overlay" class="loading_for_show_popup_data">
                                <div class="cv-spinner">
                                    <span class="cspinner"></span>
                                </div>
                            </div>
                        </div>
                        <div class="bg-overlay show_data"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>