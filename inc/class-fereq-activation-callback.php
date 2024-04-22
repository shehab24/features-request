<?php
class Features_Request_Activation
{
    public function __construct()
    {
        $this->activation_features_request_callback();


    }


    public function activation_features_request_callback()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . 'fereq_store_reports';
        $table_name_2 = $wpdb->prefix . 'fereq_store_all_voteing';
        $comment_table = $wpdb->prefix . 'fereq_store_all_comments';
        $plugin_list_table = $wpdb->prefix . 'fereq_store_plugin_list';

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id INT NOT NULL AUTO_INCREMENT,
            report_type VARCHAR(55) NOT NULL,
            report_plugin_name VARCHAR(250) NOT NULL,
            report_title VARCHAR(55) NOT NULL,
            report_description LONGTEXT NOT NULL,
            report_url VARCHAR(55) NOT NULL,
            report_email VARCHAR(55) NOT NULL,
            report_status VARCHAR(25) NOT NULL,
            submit_privately VARCHAR(20)  NOT NULL,
            inserted_time TIMESTAMP  NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

        $sql2 = "CREATE TABLE IF NOT EXISTS $table_name_2 (
            vote_id INT NOT NULL AUTO_INCREMENT,
            report_table_id INT NOT NULL,
            vote_ans VARCHAR(50) NOT NULL,
            vote_feedback VARCHAR(255) NOT NULL,
            keep_me_posted VARCHAR(55) NOT NULL,
            vote_email VARCHAR(50) NOT NULL,
            PRIMARY KEY (vote_id)
        ) $charset_collate;";

        $sql3 = "CREATE TABLE IF NOT EXISTS $comment_table (
            comment_id INT NOT NULL AUTO_INCREMENT,
            report_table_id INT NOT NULL,
            comment_text MEDIUMTEXT NOT NULL,
            comment_email VARCHAR(50) NOT NULL,
            PRIMARY KEY (comment_id)
        ) $charset_collate;";

        $sql4 = "CREATE TABLE IF NOT EXISTS $plugin_list_table (
            plugin_id INT NOT NULL AUTO_INCREMENT,
            plugin_name VARCHAR(250) NOT NULL,
            PRIMARY KEY (plugin_id)
        ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
        dbDelta($sql2);
        dbDelta($sql3);
        dbDelta($sql4);
    }
}