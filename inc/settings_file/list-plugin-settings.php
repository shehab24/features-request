<?php


$results = wp_cache_get('store_data_' . $this->plugin_add);

if (false === $results)
{
    $query = " SELECT * FROM " . $this->plugin_add;
    // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
    $results = $this->wpdb->get_results($query);
    wp_cache_set('store_data_' . $this->table_name, $results);
}
?>
<div class="main_div">
    <div class="page_header_title">
        <h3>Create Store</h3>
        <span class="text-white btn btn-primary add_new_plugin_btn">
            Add New </span>
    </div>
    <div class="manage_store_main_div">
        <table id="manageRequestTable" class="cell-border table table-striped table-bordered">
            <thead>
                <tr>
                    <th style="width:5%; text-align:center;">
                        <?php echo esc_html_e("Serial No", "features-request"); ?>
                    </th>
                    <th style="width:60%;text-align:center;">
                        <?php echo esc_html_e("Product Name", "features-request"); ?>
                    </th>
                    <th style="width:35%;text-align:center;">
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
                    <tr class="plugin_table_row_id_<?php echo esc_attr($result->plugin_id); ?> report_table_row">
                        <td>
                            <?php echo esc_html($serialNumber++); ?>
                        </td>
                        <td>
                            <div class="div_after_td">
                                <span class="report_type">

                                    <?php echo esc_html($result->plugin_name); ?>
                                </span>
                            </div>
                        </td>
                        <td>
                            <div class="div_after_td">
                                <ul class="action_ul">
                                    <li><span class="see_report edit_plugin_name"
                                            data-id="<?php echo esc_attr($result->plugin_id); ?>"><i
                                                class="fa-solid fa-pen-to-square"></i></span></li>


                                    <li><span class="delete_report edited_plugin_name_delete"
                                            data-id="<?php echo esc_attr($result->plugin_id); ?>"><i
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
        <div id="loading_overlay" class="loading_for_add_plugin_delete">
            <div class="cv-spinner">
                <span class="cspinner"></span>
            </div>
        </div>
    </div>

    <div class="custom-model-main add_new_plugin_popup edit_added_plugin_popup">
        <div class="custom-model-inner">
            <div class="close-btn close_add_new_popup">×</div>
            <div class="custom-model-wrap" id="edit_added_plugin_wrap">
                <div class="pop-up-content-wrap">
                    <div class="modal-container" id="edit_added_plugin">

                        <div class="plugin_add_form">

                            <label for="plugin_name">Product Name</label>
                            <input type="text" name="plugin_name" id="plugin_name" placeholder="Enter Product name">


                            <button class="plugin_add_save_btn">Save</button>
                            <p class="status_msg"></p>
                        </div>

                    </div>
                    <div id="loading_overlay" class="loading_for_add_plugin">
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