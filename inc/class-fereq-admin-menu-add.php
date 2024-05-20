<?php
class Fereq_Admin_Menu_Page_Add
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
        $this->comment_table_reply = $this->wpdb->prefix . 'fereq_store_comments_reply';
        $this->comment_table = $this->wpdb->prefix . 'fereq_store_all_comments';
        $this->plugin_add = $this->wpdb->prefix . 'fereq_store_plugin_list';

        add_action("admin_menu", array($this, "fereq_admin_menu_page_add"));
        add_action("admin_enqueue_scripts", array($this, "fereq_admin_enqueue_scripts"));

        add_action('wp_ajax_show_report_content_on_popup_action', [$this, 'show_report_content_on_popup_action_handler']);
        add_action('wp_ajax_nopriv_show_report_content_on_popup_action', [$this, 'show_report_content_on_popup_action_handler']);
        add_action('wp_ajax_show_report_comment_on_popup_action', [$this, 'show_report_comment_on_popup_action_handler']);
        add_action('wp_ajax_nopriv_show_report_comment_on_popup_action', [$this, 'show_report_comment_on_popup_action_handler']);
        add_action('wp_ajax_show_upvote_on_popup_action', [$this, 'show_upvote_on_popup_action_handler']);
        add_action('wp_ajax_nopriv_show_upvote_on_popup_action', [$this, 'show_upvote_on_popup_action_handler']);
        add_action('wp_ajax_report_status_update_action', [$this, 'report_status_update_action_handler']);
        add_action('wp_ajax_nopriv_report_status_update_action', [$this, 'report_status_update_action_handler']);
        add_action('wp_ajax_deleted_the_report_table_row_action', [$this, 'deleted_the_report_table_row_action_handler']);
        add_action('wp_ajax_nopriv_deleted_the_report_table_row_action', [$this, 'deleted_the_report_table_row_action_handler']);
        add_action('wp_ajax_add_plugin_name_to_database', [$this, 'add_plugin_name_to_database_handler']);
        add_action('wp_ajax_nopriv_add_plugin_name_to_database', [$this, 'add_plugin_name_to_database_handler']);
        add_action('wp_ajax_edit_plugin_name_to_database', [$this, 'edit_plugin_name_to_database_handler']);
        add_action('wp_ajax_nopriv_edit_plugin_name_to_database', [$this, 'edit_plugin_name_to_database_handler']);
        add_action('wp_ajax_edit_plugin_name_save_to_database', [$this, 'edit_plugin_name_save_to_database_handler']);
        add_action('wp_ajax_nopriv_edit_plugin_name_save_to_database', [$this, 'edit_plugin_name_save_to_database_handler']);
        add_action('wp_ajax_edited_plugin_name_deleted_action', [$this, 'edited_plugin_name_deleted_action_handler']);
        add_action('wp_ajax_nopriv_edited_plugin_name_deleted_action', [$this, 'edited_plugin_name_deleted_action_handler']);

        add_action('admin_init', array($this , 'style_tab_color_settings_init'));
    }

    public function fereq_admin_enqueue_scripts()
    {
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        $current_page = isset($_GET['page']) ? sanitize_text_field($_GET['page']) : '';
        wp_enqueue_script("jquery");
        wp_enqueue_style('wp-color-picker');
        if (in_array($current_page, array('features-request', 'manage-Request', 'list-plugin', 'fereq-settings')))
        {
            wp_enqueue_style('jquery-data-tablecss', FEREQ_DIR_URL . 'assets/css/jquery.dataTables.css', [], FEREQ_VERSION);
            wp_enqueue_style('fereq-bootstrap-css', FEREQ_DIR_URL . 'assets/css/bootstrap.min.css', [], FEREQ_VERSION);
            wp_enqueue_style('fereq-fontawesome-css', FEREQ_DIR_URL . 'assets/css/font-awesome.min.css', [], FEREQ_VERSION);
            wp_enqueue_style('fereq-sweetalert2-css', FEREQ_DIR_URL . 'assets/css/sweetalert2.min.css', [], FEREQ_VERSION);
            wp_enqueue_style('fereq-admin-css', FEREQ_DIR_URL . 'assets/css/admin-fereq.css', [], FEREQ_VERSION);
            wp_enqueue_script('jquery-data-tablejs', FEREQ_DIR_URL . 'assets/js/jquery.dataTables.js', [], FEREQ_VERSION, true);
            wp_enqueue_script('fereq-bootstrap-js', FEREQ_DIR_URL . 'assets/js/bootstrap.min.js', [], FEREQ_VERSION, true);
            wp_enqueue_script('fereq-sweetalert2-js', FEREQ_DIR_URL . 'assets/js/sweetalert2.all.min.js', [], FEREQ_VERSION, true);
            wp_enqueue_script('fereq-admin-js', FEREQ_DIR_URL . 'assets/js/admin-fereq.js', ['wp-color-picker'], FEREQ_VERSION, true);
        }
        $ajax_data = array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce1' => wp_create_nonce('show_report_data_into_popup'), // First nonce
            'nonce2' => wp_create_nonce('show_comment_data_into_popup'), // First nonce
            'nonce3' => wp_create_nonce('show_upvote_on_popup'),
            'nonce4' => wp_create_nonce('comment_store_database_nonce'), // First nonce
            'nonce5' => wp_create_nonce('report_status_update_nonce'), // First nonce
            'nonce6' => wp_create_nonce('deleted_the_report_table_row_nonce'), // First nonce
            'nonce7' => wp_create_nonce('add_plugin_name_to_database_nonce'), // First nonce
            'nonce8' => wp_create_nonce('edit_plugin_name_to_database_nonce'), // First nonce
            'nonce9' => wp_create_nonce('edit_plugin_name_save_to_database_nonce'), // First nonce
            'nonce10' => wp_create_nonce('edited_plugin_name_deleted_nonce'),
            'edit_comment' => wp_create_nonce('edit_comment_data_nonce'),
            'delete_comment' => wp_create_nonce('delete_comment_data_nonce'), // First nonce
        );
        wp_localize_script('fereq-admin-js', 'ajax_data', $ajax_data);

    }

    public function fereq_admin_menu_page_add()
    {
        $menuIcon = '<svg fill="#fff" width="800px" height="800px" viewBox="0 0 16 16" id="request-16px" xmlns="http://www.w3.org/2000/svg">
          <path id="Path_49" data-name="Path 49" d="M30.5,16a.489.489,0,0,1-.191-.038A.5.5,0,0,1,30,15.5V13h-.5A2.5,2.5,0,0,1,27,10.5v-8A2.5,2.5,0,0,1,29.5,0h11A2.5,2.5,0,0,1,43,2.5v8A2.5,2.5,0,0,1,40.5,13H33.707l-2.853,2.854A.5.5,0,0,1,30.5,16Zm-1-15A1.5,1.5,0,0,0,28,2.5v8A1.5,1.5,0,0,0,29.5,12h1a.5.5,0,0,1,.5.5v1.793l2.146-2.147A.5.5,0,0,1,33.5,12h7A1.5,1.5,0,0,0,42,10.5v-8A1.5,1.5,0,0,0,40.5,1ZM36,9a1,1,0,1,0-1,1A1,1,0,0,0,36,9Zm1-4a2,2,0,0,0-4,0,.5.5,0,0,0,1,0,1,1,0,1,1,1,1,.5.5,0,0,0,0,1A2,2,0,0,0,37,5Z" transform="translate(-27)"/>
        </svg>';
        add_menu_page(
            __("Features Request", "features-request"),
            __("Features Request", "features-request"),
            "manage_options",
            "features-request",
            array($this, "fereq_admin_menu_page_add_callback"),
            'data:image/svg+xml;base64,' . base64_encode($menuIcon),
            30
        );

        add_submenu_page(
            "features-request",
            __("Dashboard", "store-finder"),
            __("Dashboard", "store-finder"),
            "manage_options",
            "features-request",
            array($this, "fereq_admin_menu_page_add_callback")
        );
        add_submenu_page(
            "features-request",
            __("Manage Request", "store-finder"),
            __("Manage Request", "store-finder"),
            "manage_options",
            "manage-Request",
            array($this, "fereq_manage_request_submenu_callback")
        );

        add_submenu_page(
            "features-request",
            __("Settings", "store-finder"),
            __("Settings", "store-finder"),
            "manage_options",
            "fereq-settings",
            array($this, "fereq_plugin_settings_callback")
        );


    }




    public function fereq_plugin_settings_callback()
    {
        $current_tab = isset($_GET['tab']) ? $_GET['tab'] : 'general';
        ?>
        <div class="wrap">
            <h2>Features Request Settings</h2>
            <h2 class="nav-tab-wrapper">
                <a href="?page=fereq-settings&tab=general"
                    class="nav-tab <?php echo ($current_tab == 'general') ? 'nav-tab-active' : ''; ?>">General</a>
                <a href="?page=fereq-settings&tab=advanced"
                    class="nav-tab <?php echo ($current_tab == 'advanced') ? 'nav-tab-active' : ''; ?>">Style</a>
                <a href="?page=fereq-settings&tab=listPlugin"
                    class="nav-tab <?php echo ($current_tab == 'listPlugin') ? 'nav-tab-active' : ''; ?>">Product list</a>
                <a href="?page=fereq-settings&tab=fereq-email"
                    class="nav-tab <?php echo ($current_tab == 'fereq-email') ? 'nav-tab-active' : ''; ?>">Email</a>

            </h2>
            <div class="fereq-settings-content">
                <?php

                switch ($current_tab)
                {
                    case 'general':
                        require_once FEREQ_DIR_PATH . 'inc/settings_file/general-settings.php'; // Include general settings file
                        break;
                    case 'advanced':
                        require_once FEREQ_DIR_PATH . 'inc/settings_file/advanced-settings.php'; // Include general settings file
                        break;
                    case 'listPlugin':
                        require_once FEREQ_DIR_PATH . 'inc/settings_file/list-plugin-settings.php'; // Include general settings file
                        break;
                    case 'fereq-email':
                        require_once FEREQ_DIR_PATH . 'inc/settings_file/fereq-email-settings.php'; // Include general settings file
                        break;
                    // Add cases for other tabs here if needed
                }
                ?>
            </div>
        </div>
        <?php
    }


    public function style_tab_color_settings_init() {
        register_setting('fereq_options_group', 'fereq_options');

        add_settings_section(
            'fereq_advanced_settings_section',
            __('Advanced Settings', 'store-finder'),
            array($this, 'fereq_advanced_settings_section_callback'),
            'fereq-settings'
        );

        add_settings_field(
            'fereq_custom_setting',
            __('Custom Setting', 'store-finder'),
            array($this, 'fereq_custom_setting_callback'),
            'fereq-settings',
            'fereq_advanced_settings_section'
        );
        add_settings_field(
            'fereq_background_color',
            __('Background Color', 'store-finder'),
            array($this, 'fereq_background_color_callback'),
            'fereq-settings',
            'fereq_advanced_settings_section'
        );
    }

    public function fereq_advanced_settings_section_callback() {
        echo '<p>' . __('Advanced settings for the Features Request plugin.', 'store-finder') . '</p>';
    }

    public function fereq_custom_setting_callback() {
        $options = get_option('fereq_options');
        ?>
        <input type="text" name="fereq_options[fereq_custom_setting]" value="<?php echo isset($options['fereq_custom_setting']) ? esc_attr($options['fereq_custom_setting']) : ''; ?>">
        <?php
    }

    public function fereq_background_color_callback() {
        $options = get_option('fereq_options');
        ?>
        <input type="text" name="fereq_options[fereq_background_color]" value="<?php echo isset($options['fereq_background_color']) ? esc_attr($options['fereq_background_color']) : ''; ?>" class="fereq-color-picker">
        <?php
    }



    public function fereq_admin_menu_page_add_callback()
    {
        ?>
        <div class="wrap">
            <div class="page_header_div">
                <h2>How its Works?</h2>
            </div>
            <div class="working_div">
                <div class="work">
                    <h3>01. Add This Shortcode</h3>
                    <div class="shortcode_img_box">
                        <img src="<?php echo esc_url(FEREQ_DIR_URL . 'assets/images/features-request.png'); ?>" alt="">
                    </div>
                    <h4>Add the shortcode [features-request] on the new page or whichever page you’d like to display it.</h4>
                </div>
                <div class="work">
                    <h3>02. Manage Your Store</h3>
                    <div class="shortcode_img_box">
                        <img src="<?php echo esc_url(FEREQ_DIR_URL . 'assets/images/manage-request.png'); ?>" alt="">
                    </div>
                    <h4>Manage Your all request from manage request page.</h4>
                </div>
            </div>
        </div>
        <?php
    }
    public function fereq_manage_request_submenu_callback()
    {


        $results = wp_cache_get('store_data_' . $this->table_name);

        if (false === $results)
        {
            $query = "
                    SELECT t1.*, COALESCE(subquery.total_voting, 0) AS total_voting 
                    FROM {$this->table_name} AS t1
                    LEFT JOIN (
                        SELECT report_table_id, COUNT(vote_id) AS total_voting
                        FROM {$this->table_name_2}
                        GROUP BY report_table_id
                    ) AS subquery ON t1.id = subquery.report_table_id
                ";
            // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
            $results = $this->wpdb->get_results($query);
            wp_cache_set('store_data_' . $this->table_name, $results);
        }
        ?>
        <div class="main_div">
            <div class="page_header_title">
                <h3>Manage Request</h3>

            </div>

            <div class="manage_store_main_div">
                <table id="manageRequestTable" class="cell-border table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width:5%; text-align:center;">
                                <?php echo esc_html_e("Serial No", "features-request"); ?>
                            </th>
                            <th style="width:8%; text-align:center;">
                                <?php echo esc_html_e("Report Type", "features-request"); ?>
                            </th>
                            <th style="width:25%;text-align:center;">
                                <?php echo esc_html_e("Report Title", "features-request"); ?>
                            </th>
                            <th style="width:15%;text-align:center;">
                                <?php echo esc_html_e("Report Email", "features-request"); ?>
                            </th>
                            <th style="width:12%;text-align:center;">
                                <?php echo esc_html_e("Reported Plugin", "features-request"); ?>
                            </th>
                            <th style="width:15%;text-align:center;">
                                <?php echo esc_html_e("Report Status", "features-request"); ?>
                            </th>
                            <th style="width:20%;text-align:center;">
                                <?php echo esc_html_e("Action", "features-request"); ?>
                            </th>

                        </tr>
                    </thead>
                    <?php
                    if ($results)
                    {
                        $serialNumber = 1;
                        foreach ($results as $result)
                        {
                            ?>
                            <tr class="table_row_id_<?php echo esc_attr($result->id); ?> report_table_row">
                                <td>
                                    <?php echo esc_html($serialNumber++); ?>
                                </td>
                                <td>
                                    <div class="div_after_td">
                                        <span class="report_type">

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
                                    </div>
                                </td>
                                <td>
                                    <div class="div_after_td">
                                        <?php echo esc_html($result->report_title); ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="div_after_td">
                                        <?php echo esc_html($result->report_email); ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="div_after_td">
                                        <?php echo esc_html($result->report_plugin_name); ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="div_after_td">
                                        <?php if ($result->report_status === "exploring"): ?>
                                            <span class="report_status_exploring update_status_<?php echo esc_attr($result->id); ?>">
                                                <?php
                                                echo esc_html($result->report_status);
                                                ?>
                                            </span>
                                        <?php elseif ($result->report_status === "inprogress"): ?>
                                            <span class="report_status_inprogress update_status_<?php echo esc_attr($result->id); ?>">
                                                <?php
                                                echo esc_html($result->report_status);
                                                ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="report_status_done update_status_<?php echo esc_attr($result->id); ?>">
                                                <?php
                                                echo esc_html($result->report_status);
                                                ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="div_after_td">
                                        <ul class="action_ul">
                                            <li><span class="see_report" data-id="<?php echo esc_attr($result->id); ?>"><i
                                                        class="fa-solid fa-eye"></i></span></li>
                                            <li><span class="see_report_comment" data-id="<?php echo esc_attr($result->id); ?>"><i
                                                        class="fa-regular fa-comment"></i>
                                                    <b class="comment_updated_status_<?php echo esc_attr($result->id); ?>">
                                                        <?php
                                                        $comment_query = $this->wpdb->prepare("SELECT * FROM $this->comment_table WHERE report_table_id = %d", $result->id);
                                                        $comment_results = $this->wpdb->get_results($comment_query);
                                                        $comment_reply_query = $this->wpdb->prepare("SELECT * FROM $this->comment_table_reply WHERE report_table_id = %d", $result->id);
                                                        $comment_reply_results = $this->wpdb->get_results($comment_reply_query);
                                                        echo esc_html(count($comment_results) + count($comment_reply_results));
                                                        ?>
                                                    </b>

                                                </span></li>
                                            <li><span class="see_report_upvote" data-id="<?php echo esc_attr($result->id); ?>"><i
                                                        class="fa-solid fa-turn-up"></i>
                                                    <?php echo esc_html($result->total_voting); ?>
                                                </span></li>
                                            <li><span class="delete_report" data-id="<?php echo esc_attr($result->id); ?>"><i
                                                        class="fa-solid fa-trash-arrow-up"></i></span></li>
                                        </ul>
                                    </div>
                                </td>


                            </tr>
                            <?php
                        }
                    }
                    ?>
                    <tbody>

                    </tbody>
                </table>
                <div id="loading_overlay" class="loading_for_delete">
                    <div class="cv-spinner">
                        <span class="cspinner"></span>
                    </div>
                </div>
            </div>

            <div class="custom-model-main show_report_popup">
                <div class="custom-model-inner">
                    <div class="close-btn close_report_popup">×</div>
                    <div class="custom-model-wrap">
                        <div class="pop-up-content-wrap">
                            <div class="modal-container" id="push_report_data_into_div">

                            </div>
                            <div id="loading_overlay" class="loading_for_show_report">
                                <div class="cv-spinner">
                                    <span class="cspinner"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="bg-overlay close_report_popup_overly"></div>
            </div>
        </div>
        <?php
    }



    public function show_report_content_on_popup_action_handler()
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'show_report_data_into_popup'))
        {
            wp_send_json_error("Nonce verification failed!");
            return;
        }
        $dataId = isset($_POST['dataId']) ? sanitize_text_field($_POST['dataId']) : "";

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
                if ($fetch_results[0]->report_status === "inprogress"):
                    ?>
                    <span class="sugg show_updated_report_status">In Progress</span>
                    <?php
                elseif ($fetch_results[0]->report_status === "done"):
                    ?>
                    <span class="done show_updated_report_status">Done</span>
                    <?php
                else:
                    ?>
                    <span class="sugg show_updated_report_status">Exploring</span>
                    <?php
                endif;
                ?>
                <span class="reported_plugin_name"><?php echo esc_html($fetch_results[0]->report_plugin_name); ?></span>


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
                                    class="total_agree_vote_count_<?php echo esc_attr($fetch_results[0]->id); ?>"><?php echo esc_html($fetch_results[0]->total_agree_voting); ?></span></span>
                            <span class="downvote_icon"><i class="fa-solid fa-thumbs-down"></i><span
                                    class="total_disagree_vote_count_<?php echo esc_attr($fetch_results[0]->id); ?>"><?php echo esc_html($fetch_results[0]->total_disagree_voting); ?></span></span>
                        </div>
                        <?php
                    endif;
                    ?>
                </div>
            </div>
            <input type="hidden" name="" id="report_table_id_val" value=" <?php echo esc_attr($fetch_results[0]->id); ?>">
            <div class="update_report_status_div">
                <select name="" id="update_status_select" class="update_status_select">
                    <option value="">Update request status</option>
                    <?php
                    if ($fetch_results[0]->report_status === "inprogress"):
                        ?>
                        <option value="exploring">Exploring</option>
                        <option value="done">Done</option>
                        <?php
                    elseif ($fetch_results[0]->report_status === "done"):
                        ?>
                        <option value="exploring">Exploring</option>
                        <option value="inprogress">In Progress</option>
                        <?php
                    else:
                        ?>
                        <option value="inprogress">In Progress</option>
                        <option value="done">Done</option>
                        <?php
                    endif;
                    ?>
                </select>
                <button class="update_status_btn">Update</button>
                <p class="update_status_msg"></p>
            </div>
        </div>

        <?php

        $html = ob_get_clean();
        wp_send_json_success(array("dataId" => $dataId, 'html' => $html, "fetchRes" => $fetch_results));
        wp_die();
    }
    public function show_report_comment_on_popup_action_handler()
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'show_comment_data_into_popup'))
        {
            wp_send_json_error("Nonce verification failed!");
            return;
        }
        $dataId = isset($_POST['dataId']) ? sanitize_text_field($_POST['dataId']) : "";

        $query = $this->wpdb->prepare("SELECT * FROM {$this->table_name} WHERE id = %d ", $dataId);



        // Execute the query and fetch the results
        $fetch_results = $this->wpdb->get_results($query);

        ob_start();

        ?>
        <div class="popup_overview_details_box">
            <div class="status_tag">
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
                if ($fetch_results[0]->report_status === "inprogress"):
                    ?>
                    <span class="sugg show_updated_report_status">In Progress</span>
                    <?php
                elseif ($fetch_results[0]->report_status === "done"):
                    ?>
                    <span class="done show_updated_report_status">Done</span>
                    <?php
                else:
                    ?>
                    <span class="sugg show_updated_report_status">Exploring</span>
                    <?php
                endif;
                ?>


            </div>

            <input type="hidden" name="" id="report_table_id_val" value=" <?php echo esc_attr($fetch_results[0]->id); ?>">
            <div class="comment_box_content">
                <ul class="push_comment_into_ul">

                    <?php
                    $query = $this->wpdb->prepare("SELECT * FROM $this->comment_table WHERE report_table_id = %d", $fetch_results[0]->id);
                    $fetch_results = $this->wpdb->get_results($query);
                    if (count($fetch_results) > 0):

                        foreach ($fetch_results as $comment_list):
                            ?>

                            <li class="comment_list_div <?php echo !empty($replyMail) ? "reply_mail_ache" : "reply_mail_nai"; ?>">
                                <div class="comment_content">
                                    <h3 class="commentator_name"><i class="fa-solid fa-circle-user"></i>
                                        <?php echo esc_html($comment_list->commentator_name); ?>
                                        <span class="comment_email_span"><?php echo esc_html($comment_list->comment_email); ?></span>
                                    </h3>
                                    <p class="commentator_content">
                                        <?php echo esc_html($comment_list->comment_text); ?>
                                    </p>
                                    <div class="edit_remove_reply_div">
                                        <span class="time_stamp"> <?php echo esc_html($comment_list->comment_time); ?></span>


                                        <span class="comment_trash"
                                            data-reportId="<?php echo esc_attr($comment_list->report_table_id); ?>"
                                            data-commentId="<?php echo esc_attr($comment_list->comment_id); ?>"
                                            data-commenttype="<?php echo esc_attr($comment_list->comment_type); ?>"><i
                                                class="fa-solid fa-trash"></i></span>


                                    </div>
                                </div>
                                <ul class="reply_comment_ul">
                                    <?php
                                    $report_table_id = $comment_list->report_table_id;
                                    $comment_id = $comment_list->comment_id;
                                    $commnet_reply_query_store_comment = $this->wpdb->prepare("SELECT * FROM $this->comment_table_reply WHERE report_table_id = %d AND comment_table_id= %d", $report_table_id, $comment_id);
                                    $comment_reply_results_for_store_comment = $this->wpdb->get_results($commnet_reply_query_store_comment);
                                    foreach ($comment_reply_results_for_store_comment as $comment_reply):
                                        ?>
                                        <li
                                            class="comment_list_div <?php echo !empty($replyMail) ? "reply_mail_ache" : "reply_mail_nai"; ?>">
                                            <div class="comment_content">
                                                <h3 class="commentator_name"><i class="fa-solid fa-circle-user"></i>
                                                    <?php echo esc_html($comment_reply->commentator_name); ?><span
                                                        class="comment_email_span"><?php echo esc_html($comment_reply->comment_email); ?></span>
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
                                                        echo $comment_reply->comment_time;
                                                        ?>
                                                    </span>


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

                            <?php
                        endforeach;
                    else:
                        ?>
                        <li>No Comment Found</li>
                        <?php

                    endif;
                    ?>
                </ul>
                <div class="comment_form">
                    <textarea name="" id="comment_textarea" placeholder="Leave a comment ?" cols="30" rows="10"></textarea>
                    <div class="comment_email_require_box">
                        <input type="text" name="" placeholder="Your Name" id="comment_name_field">
                        <input type="email" name="" placeholder="Your email" id="comment_email_field" value="admin@gmail.com">
                        <button class="comment_btn">Comment</button>
                    </div>
                    <p class="comment_result_massage"></p>
                </div>
            </div>
        </div>

        <?php

        $html = ob_get_clean();
        wp_send_json_success(array("dataId" => $dataId, 'html' => $html, "fetchRes" => count($fetch_results)));
        wp_die();
    }

    public function show_upvote_on_popup_action_handler()
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'show_upvote_on_popup'))
        {
            wp_send_json_error("Nonce verification failed!");
            return;
        }
        $dataId = isset($_POST['dataId']) ? sanitize_text_field($_POST['dataId']) : "";

        $query = $this->wpdb->prepare("SELECT * FROM {$this->table_name} WHERE id = %d ", $dataId);



        // Execute the query and fetch the results
        $fetch_results = $this->wpdb->get_results($query);

        ob_start();

        ?>
        <div class="popup_overview_details_box">
            <div class="status_tag">
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
                if ($fetch_results[0]->report_status === "inprogress"):
                    ?>
                    <span class="sugg show_updated_report_status">In Progress</span>
                    <?php
                elseif ($fetch_results[0]->report_status === "done"):
                    ?>
                    <span class="done show_updated_report_status">Done</span>
                    <?php
                else:
                    ?>
                    <span class="sugg show_updated_report_status">Exploring</span>
                    <?php
                endif;
                ?>


            </div>
            <div class="popup_overview_content" bis_skin_checked="1">
                <h2 class="overView_title"><?php
                echo esc_html($fetch_results[0]->report_title);
                ?></h2>
                <p class="overview_description">
                    <?php
                    echo esc_html($fetch_results[0]->report_description);
                    ?> <a href="<?php echo esc_url($fetch_results[0]->report_url); ?>" class="overview_given_url">
                        <?php
                        echo esc_html($fetch_results[0]->report_url);
                        ?> </a>


                </p>

            </div>
            <input type="hidden" name="" id="report_table_id_val" value=" <?php echo esc_attr($fetch_results[0]->id); ?>">
            <div class="comment_box_content">
                <ul class="push_comment_into_ul">

                    <?php
                    $query = $this->wpdb->prepare("SELECT * FROM $this->table_name_2 WHERE report_table_id = %d", $fetch_results[0]->id);
                    $fetch_results = $this->wpdb->get_results($query);
                    if (count($fetch_results) > 0):

                        foreach ($fetch_results as $vote_list):
                            ?>
                            <li class="comment_list_div">
                                <div class="comment_content">
                                    <div class="vote_title_and_ans">
                                        <h3 class="commentator_name"><i class="fa-solid fa-circle-user"></i>
                                            <?php
                                            echo esc_html($vote_list->vote_email);
                                            ?>
                                        </h3>
                                        <span class="vote_agree_disagree">
                                            <?php echo esc_html(ucfirst($vote_list->vote_ans)); ?>
                                        </span>
                                    </div>
                                    <p class="commentator_content">
                                        <?php
                                        echo esc_html($vote_list->vote_feedback);
                                        ?>
                                    </p>
                                </div>
                            </li>

                            <?php
                        endforeach;
                    else:
                        ?>
                        <li>No Vote Found</li>
                        <?php

                    endif;
                    ?>
                </ul>

            </div>
        </div>

        <?php

        $html = ob_get_clean();
        wp_send_json_success(array("dataId" => $dataId, 'html' => $html, "fetchRes" => $fetch_results));
        wp_die();
    }
    public function report_status_update_action_handler()
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'report_status_update_nonce'))
        {
            wp_send_json_error("Nonce verification failed!");
            return;
        }
        $report_id = isset($_POST['report_id']) ? sanitize_text_field($_POST['report_id']) : "";
        $update_status_select = isset($_POST['update_status_select']) ? sanitize_text_field($_POST['update_status_select']) : "";

        $data_to_update = array(
            'report_status' => $update_status_select,
        );

        $where = array('id' => $report_id);

        $update_result = $this->wpdb->update(
            $this->table_name, // Table name
            $data_to_update,   // Data to update
            $where             // WHERE condition
        );

        if (false === $update_result)
        {
            $status = false;
        } else
        {
            $status = true;
        }


        wp_send_json_success(array("report_id" => $report_id, "status" => $status, "updated_status" => $update_status_select));
        wp_die();
    }
    public function deleted_the_report_table_row_action_handler()
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'deleted_the_report_table_row_nonce'))
        {
            wp_send_json_error("Nonce verification failed!");
            return;
        }
        $dataId = isset($_POST['dataId']) ? sanitize_text_field($_POST['dataId']) : "";


        $where = array('id' => $dataId);

        // Perform the deletion
        $delete_result = $this->wpdb->delete(
            $this->table_name, // Table name
            $where             // WHERE condition
        );


        if (false === $delete_result)
        {
            $status = false;
        } else
        {
            $status = true;
        }


        wp_send_json_success(array("dataId" => $dataId, "status" => $status));
        wp_die();
    }

    public function add_plugin_name_to_database_handler()
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'add_plugin_name_to_database_nonce'))
        {
            wp_send_json_error("Nonce verification failed!");
            return;
        }
        $plugin_name = isset($_POST['plugin_name']) ? sanitize_text_field($_POST['plugin_name']) : "";

        $data = array(
            'plugin_name' => $plugin_name,
        );

        $insert_result = $this->wpdb->insert(
            $this->plugin_add, // Table name
            $data        // Data to insert
        );


        if ($insert_result === false)
        {
            $status = "Error inserting data.";
        } else
        {
            // Insert successful
            $status = "Data inserted successfully.";
        }
        wp_send_json_success(array("plugin_name" => $plugin_name, 'status' => $status));
        wp_die();
    }
    public function edit_plugin_name_to_database_handler()
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'edit_plugin_name_to_database_nonce'))
        {
            wp_send_json_error("Nonce verification failed!");
            return;
        }
        $plugin_id = isset($_POST['plugin_id']) ? sanitize_text_field($_POST['plugin_id']) : "";

        $query = $this->wpdb->prepare("SELECT * FROM {$this->plugin_add} WHERE plugin_id = %d", $plugin_id);

        $plugin_data = $this->wpdb->get_row($query);

        if ($plugin_data !== null)
        {
            $plugin_name = $plugin_data->plugin_name;
            ob_start();
            ?>
            <div class="plugin_add_form">

                <label for="plugin_name">Plugin Name</label>
                <input type="text" name="plugin_name" id="plugin_name" class="edited_plugin_name"
                    value="<?php echo esc_attr($plugin_name); ?>" placeholder="Enter Plugin name">


                <button class="plugin_add_save_btn plugin_name_edit_btn">Save Changes</button>
                <p class="status_msg"></p>
            </div>
            <?php
            $html = ob_get_clean();
            $status = true;

        } else
        {
            // No data found
            $status = false;
        }

        wp_send_json_success(array("plugin_name" => $plugin_name, 'status' => $status, 'html' => $html));
        wp_die();
    }

    public function edit_plugin_name_save_to_database_handler()
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'edit_plugin_name_save_to_database_nonce'))
        {
            wp_send_json_error("Nonce verification failed!");
            return;
        }
        $edited_plugin_name = isset($_POST['edited_plugin_name']) ? sanitize_text_field($_POST['edited_plugin_name']) : "";
        $plugin_id = isset($_POST['plugin_id']) ? intval($_POST['plugin_id']) : 0;

        $data_to_update = array(
            'plugin_name' => $edited_plugin_name,
        );

        $where_update = array(
            'plugin_id' => $plugin_id,
        );


        $update_result = $this->wpdb->update(
            $this->plugin_add,
            $data_to_update,
            $where_update
        );

        if ($update_result === false)
        {
            // Update failed
            $status = "hoinai";
        } else
        {
            // Update successful
            $status = "hoise";
        }
        wp_send_json_success(array("plugin_name" => $edited_plugin_name, 'plugin_id' => $plugin_id, 'status' => $status));
        wp_die();
    }
    public function edited_plugin_name_deleted_action_handler()
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'edited_plugin_name_deleted_nonce'))
        {
            wp_send_json_error("Nonce verification failed!");
            return;
        }
        $plugin_id = isset($_POST['plugin_id']) ? sanitize_text_field($_POST['plugin_id']) : "";


        $where = array('plugin_id' => $plugin_id);

        // Perform the deletion
        $delete_result = $this->wpdb->delete(
            $this->plugin_add, // Table name
            $where             // WHERE condition
        );


        if (false === $delete_result)
        {
            $status = false;
        } else
        {
            $status = true;
        }


        wp_send_json_success(array("dataId" => $plugin_id, "status" => $status));
        wp_die();
    }
}

new Fereq_Admin_Menu_Page_Add();