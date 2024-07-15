<?php

session_start();

// Check if the "Manage" link is clicked
if (isset($_GET['setting']) && $_GET['setting'] === 'suggestion_setting' && isset($_GET['tab']) && $_GET['tab'] === 'fereq-email')
{
    // Set session variable to indicate that the "Manage" link is clicked
    $_SESSION['suggestion_show'] = true;
    // unset($_SESSION['issue_show']);
} else if (isset($_GET['setting']) && $_GET['setting'] === 'issues_setting' && isset($_GET['tab']) && $_GET['tab'] === 'fereq-email')
{
    $_SESSION['issue_show'] = true;

} else if (isset($_GET['setting']) && $_GET['setting'] === 'voting_email' && isset($_GET['tab']) && $_GET['tab'] === 'fereq-email')
{
    $_SESSION['voting_show'] = true;


} else if (isset($_GET['setting']) && $_GET['setting'] === 'vote_delete_email' && isset($_GET['tab']) && $_GET['tab'] === 'fereq-email')
{
    $_SESSION['vote_delete_show'] = true;


} else if (isset($_GET['setting']) && $_GET['setting'] === 'keep_me_posted' && isset($_GET['tab']) && $_GET['tab'] === 'fereq-email')
{
    $_SESSION['keep_me_posted'] = true;


} else if (isset($_GET['setting']) && $_GET['setting'] === 'suggestion_customer_email' && isset($_GET['tab']) && $_GET['tab'] === 'fereq-email')
{
    $_SESSION['suggestion_customer_email'] = true;


} else if (isset($_GET['setting']) && $_GET['setting'] === 'issue_customer_email' && isset($_GET['tab']) && $_GET['tab'] === 'fereq-email')
{
    $_SESSION['issue_customer_email'] = true;


} else if (isset($_GET['setting']) && $_GET['setting'] === 'comment_email_setting' && isset($_GET['tab']) && $_GET['tab'] === 'fereq-email')
{
    $_SESSION['comment_email_setting'] = true;


} else if (isset($_GET['setting']) && $_GET['setting'] === 'comment_customer_email' && isset($_GET['tab']) && $_GET['tab'] === 'fereq-email')
{
    $_SESSION['comment_customer_email'] = true;


} else if (isset($_GET['setting']) && $_GET['setting'] === 'voting_email_customer' && isset($_GET['tab']) && $_GET['tab'] === 'fereq-email')
{
    $_SESSION['voting_email_customer'] = true;


} else if (isset($_GET['setting']) && $_GET['setting'] === 'voting_delete_customer' && isset($_GET['tab']) && $_GET['tab'] === 'fereq-email')
{
    $_SESSION['voting_delete_customer'] = true;


}  else if (isset($_GET['setting']) && $_GET['setting'] === 'comment_delete_admin_email_setting' && isset($_GET['tab']) && $_GET['tab'] === 'fereq-email')
{
    $_SESSION['comment_delete_admin_email_setting'] = true;


} else
{
    // If not clicked, unset the session variable
    session_unset();
}

?>


<ul class="list_of_email_template" <?php echo !empty($_SESSION) ? 'style="display: none;"' : 'style="display: block;"'; ?>>
    <li>
        <div class="email_template_div">
            <div class="icon_and_title_div">Comment Email</div>
            <div class="email_div"><?php echo esc_html(get_option("suggestion_recipient", "")); ?></div>
            <div class="manage_div"><a class="email_manage_button"
                    href="?page=fereq-settings&tab=fereq-email&setting=comment_email_setting">Manage</a>
            </div>
        </div>
    </li>
    <li>
        <div class="email_template_div">
            <div class="icon_and_title_div">Comment Delete Email</div>
            <div class="email_div"><?php echo esc_html( get_option("comment_delete_admin_email_recipient", "")); ?></div>
            <div class="manage_div"><a class="email_manage_button"
                    href="?page=fereq-settings&tab=fereq-email&setting=comment_delete_admin_email_setting">Manage</a>
            </div>
        </div>
    </li>
    <li>
        <div class="email_template_div">
            <div class="icon_and_title_div">Suggestion Email</div>
            <div class="email_div"><?php echo esc_html(get_option("suggestion_recipient", "")); ?></div>
            <div class="manage_div"><a class="email_manage_button"
                    href="?page=fereq-settings&tab=fereq-email&setting=suggestion_setting">Manage</a>
            </div>
        </div>
    </li>
    <li>
        <div class="email_template_div">
            <div class="icon_and_title_div">Issue Email</div>
            <div class="email_div"><?php echo esc_html(get_option("issue_recipient", "")); ?></div>
            <div class="manage_div"><a class="email_manage_button"
                    href="?page=fereq-settings&tab=fereq-email&setting=issues_setting">Manage</a>
            </div>
        </div>
    </li>
    <li>
        <div class="email_template_div">
            <div class="icon_and_title_div">Voting Email</div>
            <div class="email_div"><?php echo esc_html(get_option("voting_show_recipient", "")); ?></div>
            <div class="manage_div"><a class="email_manage_button"
                    href="?page=fereq-settings&tab=fereq-email&setting=voting_email">Manage</a>
            </div>
        </div>
    </li>
    <li>
        <div class="email_template_div">
            <div class="icon_and_title_div">Vote Delete Email</div>
            <div class="email_div"><?php echo esc_html(get_option("vote_delete_recipient", "")) ; ?></div>
            <div class="manage_div"><a class="email_manage_button"
                    href="?page=fereq-settings&tab=fereq-email&setting=vote_delete_email">Manage</a>
            </div>
        </div>
    </li>
    <li>
        <div class="email_template_div">
            <div class="icon_and_title_div">Keep me Posted Email</div>
            <div class="email_div">mdshehab204@gmail.com</div>
            <div class="manage_div"><a class="email_manage_button"
                    href="?page=fereq-settings&tab=fereq-email&setting=keep_me_posted">Manage</a>
            </div>
        </div>
    </li>
    <li>
        <div class="email_template_div">
            <div class="icon_and_title_div">Suggestion Email</div>
            <div class="email_div">Customer</div>
            <div class="manage_div"><a class="email_manage_button"
                    href="?page=fereq-settings&tab=fereq-email&setting=suggestion_customer_email">Manage</a>
            </div>
        </div>
    </li>
    <li>
        <div class="email_template_div">
            <div class="icon_and_title_div">Issue Email</div>
            <div class="email_div">Customer</div>
            <div class="manage_div"><a class="email_manage_button"
                    href="?page=fereq-settings&tab=fereq-email&setting=issue_customer_email">Manage</a>
            </div>
        </div>
    </li>
    <li>
        <div class="email_template_div">
            <div class="icon_and_title_div">Comment Email</div>
            <div class="email_div">Customer</div>
            <div class="manage_div"><a class="email_manage_button"
                    href="?page=fereq-settings&tab=fereq-email&setting=comment_customer_email">Manage</a>
            </div>
        </div>
    </li>
    <li>
        <div class="email_template_div">
            <div class="icon_and_title_div">Voting Email</div>
            <div class="email_div">Customer</div>
            <div class="manage_div"><a class="email_manage_button"
                    href="?page=fereq-settings&tab=fereq-email&setting=voting_email_customer">Manage</a>
            </div>
        </div>
    </li>
    <li>
        <div class="email_template_div">
            <div class="icon_and_title_div">Voting Delete Email</div>
            <div class="email_div">Customer</div>
            <div class="manage_div"><a class="email_manage_button"
                    href="?page=fereq-settings&tab=fereq-email&setting=voting_delete_customer">Manage</a>
            </div>
        </div>
    </li>
</ul>

<!-- comment admin start  -->
<div class="should_call" <?php echo isset($_SESSION['comment_email_setting']) ? 'style="display: block;"' : 'style="display: none;"'; ?>>
    <?php
    if (isset($_POST['comment_email_setting']) && $_POST['comment_email_setting'] === "comment_email_setting" && check_admin_referer('comment_email_setting_action', 'comment_email_setting_nonce'))
    {
        $comment_email_enable_disable = $_POST['comment_email_enable_disable'];
        $comment_email_recipient = $_POST['comment_email_recipient'];
        $comment_email_subject = $_POST['comment_email_subject'];
        $comment_email_email_content = $_POST['comment_email_email_content'];

        update_option("comment_email_enable_disable", $comment_email_enable_disable);
        update_option("comment_email_recipient", $comment_email_recipient);
        update_option("comment_email_subject", $comment_email_subject);
        update_option("comment_email_email_content", $comment_email_email_content);

        echo '<div id="message" class="updated inline" bis_skin_checked="1"><p><strong>Your settings have been saved.</strong></p></div>';


    } else
    {
        $get_comment_email_recipient = get_option("comment_email_recipient", "");
        if (empty($get_comment_email_recipient))
        {
            $admin_email = get_option('admin_email');
        } else
        {
            $admin_email = get_option("comment_email_recipient");
        }

        $sugg_admin_eSubject = "{commentator_name} Commented a Post";
        $sugg_admin_eContent = "Hi {admin_name},\n\nA Comment has been submitted by {commentator_email} to {post_owner_email} on the post '{post_name}'. Thank you.";

        update_option("comment_email_enable_disable", 'on');
        update_option("comment_email_recipient", $admin_email);
        update_option("comment_email_subject", $sugg_admin_eSubject);
        update_option("comment_email_email_content", $sugg_admin_eContent);
    }

    $get_comment_email_enable_disable = get_option("comment_email_enable_disable", "");
    $get_comment_email_recipient = get_option("comment_email_recipient", "");
    $get_comment_email_subject = get_option("comment_email_subject", "");
    $get_comment_email_email_content = get_option("comment_email_email_content", "");

    ?>
    <form method="post">
        <div class="input_field_email_div">
            <label for="enable_disable">Enable/Disable</label>
            <input type="checkbox" name="comment_email_enable_disable" <?php echo checked($get_comment_email_enable_disable, 'on'); ?> id="enable_disable" required>
        </div>
        <div class="input_field_email_div">
            <label for="recipient">Recipient(s)</label>
            <input type="text" name="comment_email_recipient" id="recipient"
                value="<?php echo esc_attr($get_comment_email_recipient); ?>" required>
        </div>
        <div class="input_field_email_div">
            <label for="subject">Subject</label>
            <input type="text" name="comment_email_subject" id="subject"placeholder="<?php echo esc_attr($sugg_admin_eSubject) ?>"
                value="<?php echo esc_attr($get_comment_email_subject); ?>" required>
        </div>
        <div class="input_field_email_div">
            <label for="email_content">Email Content</label>
            <textarea cols="5" rows="5" name="comment_email_email_content" id="email_content"
                required><?php echo esc_attr($get_comment_email_email_content); ?> </textarea>
        </div>
        <input type="hidden" name="comment_email_setting_nonce" value="<?php echo esc_attr(wp_create_nonce('comment_email_setting_action')); ?>">

        <button type="submit" name="comment_email_setting" value="comment_email_setting" class="save_suggestion_btn">Save</button>

    </form>
</div>
<!-- comment admin end  -->

<!-- comment delete admin form  -->
<div class="should_call" <?php echo isset($_SESSION['comment_delete_admin_email_setting']) ? 'style="display: block;"' : 'style="display: none;"'; ?>>
    <?php
    if (isset($_POST['comment_email_setting']) && $_POST['comment_email_setting'] === "comment_email_setting" && check_admin_referer('comment_delete_admin_email_setting_action', 'comment_delete_admin_email_setting_nonce'))
    {
        $comment_delete_admin_email_enable_disable = $_POST['comment_delete_admin_email_enable_disable'];
        $comment_delete_admin_email_recipient = $_POST['comment_delete_admin_email_recipient'];
        $comment_delete_admin_email_subject = $_POST['comment_delete_admin_email_subject'];
        $comment_delete_admin_email_email_content = $_POST['comment_delete_admin_email_email_content'];

        update_option("comment_delete_admin_email_enable_disable", $comment_delete_admin_email_enable_disable);
        update_option("comment_delete_admin_email_recipient", $comment_delete_admin_email_recipient);
        update_option("comment_delete_admin_email_subject", $comment_delete_admin_email_subject);
        update_option("comment_delete_admin_email_email_content", $comment_delete_admin_email_email_content);

        echo '<div id="message" class="updated inline" bis_skin_checked="1"><p><strong>Your settings have been saved.</strong></p></div>';


    } else
    {
        $get_comment_delete_admin_email_recipient = get_option("comment_delete_admin_email_recipient", "");
        if (empty($get_comment_delete_admin_email_recipient))
        {
            $admin_email = get_option('admin_email');
        } else
        {
            $admin_email = get_option("comment_delete_admin_email_recipient");
        }

        $comment_delete_admin_eSubject = "{commentator_email}  Remove his/her comment";
        $comment_delete_admin_eContent = "Hi {admin_name},\n\nA {commentator_email} has been Deleted his/her comment from the post of {post_name}. Thank you.";

        update_option("comment_delete_admin_email_enable_disable", 'on');
        update_option("comment_delete_admin_email_recipient", $admin_email);
        update_option("comment_delete_admin_email_subject", $comment_delete_admin_eSubject);
        update_option("comment_delete_admin_email_email_content", $comment_delete_admin_eContent);
    }

    $get_comment_delete_admin_email_enable_disable = get_option("comment_delete_admin_email_enable_disable", "");
    $get_comment_delete_admin_email_recipient = get_option("comment_delete_admin_email_recipient", "");
    $get_comment_delete_admin_email_subject = get_option("comment_delete_admin_email_subject", "");
    $get_comment_delete_admin_email_email_content = get_option("comment_delete_admin_email_email_content", "");

    ?>
    <form method="post">
        <div class="input_field_email_div">
            <label for="enable_disable">Enable/Disable</label>
            <input type="checkbox" name="comment_delete_admin_email_enable_disable" <?php echo checked($get_comment_delete_admin_email_enable_disable, 'on'); ?> id="enable_disable" required>
        </div>
        <div class="input_field_email_div">
            <label for="recipient">Recipient(s)</label>
            <input type="text" name="comment_delete_admin_email_recipient" id="recipient"
                value="<?php echo esc_attr($get_comment_delete_admin_email_recipient); ?>" required>
        </div>
        <div class="input_field_email_div">
            <label for="subject">Subject</label>
            <input type="text" name="comment_delete_admin_email_subject" id="subject"placeholder="<?php echo esc_attr($sugg_admin_eSubject) ?>"
                value="<?php echo esc_attr($get_comment_delete_admin_email_subject); ?>" required>
        </div>
        <div class="input_field_email_div">
            <label for="email_content">Email Content</label>
            <textarea cols="5" rows="5" name="comment_delete_admin_email_email_content" id="email_content"
                required><?php echo esc_attr($get_comment_delete_admin_email_email_content); ?> </textarea>
        </div>
        <input type="hidden" name="comment_delete_admin_email_setting_nonce" value="<?php echo esc_attr(wp_create_nonce('comment_delete_admin_email_setting_action')); ?>">

        <button type="submit" name="comment_delete_admin_email_setting" value="comment_delete_admin_email_setting" class="save_suggestion_btn">Save</button>

    </form>
</div>



<div class="should_call" <?php echo isset($_SESSION['suggestion_show']) ? 'style="display: block;"' : 'style="display: none;"'; ?>>
    <?php
    if (isset($_POST['suggestion_save']) && $_POST['suggestion_save'] === "suggestion_save")
    {
        $suggestion_enable_disable = $_POST['suggestion_enable_disable'];
        $suggestion_recipient = $_POST['suggestion_recipient'];
        $suggestion_subject = $_POST['suggestion_subject'];
        $suggestion_email_content = $_POST['suggestion_email_content'];

        update_option("suggestion_enable_disable", $suggestion_enable_disable);
        update_option("suggestion_recipient", $suggestion_recipient);
        update_option("suggestion_subject", $suggestion_subject);
        update_option("suggestion_email_content", $suggestion_email_content);

        echo '<div id="message" class="updated inline" bis_skin_checked="1"><p><strong>Your settings have been saved.</strong></p></div>';


    } else
    {
        $get_suggestion_recipient = get_option("suggestion_recipient", "");
        if (empty($get_suggestion_recipient))
        {
            $admin_email = get_option('admin_email');
        } else
        {
            $admin_email = get_option("suggestion_recipient");
        }

        $sugg_admin_eSubject = "Someone submitted a  Suggestion";
        $sugg_admin_eContent = "Hi {admin_name},\n\nA suggestion has been submitted by {customer_email} on the post '{post_name}'. Please review it promptly. Thank you.";

        update_option("suggestion_enable_disable", 'on');
        update_option("suggestion_recipient", $admin_email);
        update_option("suggestion_subject", $sugg_admin_eSubject);
        update_option("suggestion_email_content", $sugg_admin_eContent);
    }

    $get_suggestion_enable_disable = get_option("suggestion_enable_disable", "");
    $get_suggestion_recipient = get_option("suggestion_recipient", "");
    $get_suggestion_subject = get_option("suggestion_subject", "");
    $get_suggestion_email_content = get_option("suggestion_email_content", "");

    ?>
    <form method="post">
        <div class="input_field_email_div">
            <label for="enable_disable">Enable/Disable</label>
            <input type="checkbox" name="suggestion_enable_disable" <?php echo checked($get_suggestion_enable_disable, 'on'); ?> id="enable_disable" required>
        </div>
        <div class="input_field_email_div">
            <label for="recipient">Recipient(s)</label>
            <input type="text" name="suggestion_recipient" id="recipient"
                value="<?php echo esc_attr($get_suggestion_recipient); ?>" required>
        </div>
        <div class="input_field_email_div">
            <label for="subject">Subject</label>
            <input type="text" name="suggestion_subject" id="subject"placeholder="<?php echo esc_attr($sugg_admin_eSubject) ?>"
                value="<?php echo esc_attr($get_suggestion_subject); ?>" required>
        </div>
        <div class="input_field_email_div">
            <label for="email_content">Email Content</label>
            <textarea cols="5" rows="5" name="suggestion_email_content" id="email_content"
                required><?php echo esc_attr($get_suggestion_email_content); ?> </textarea>
        </div>
        <button type="submit" name="suggestion_save" value="suggestion_save" class="save_suggestion_btn">Save</button>

    </form>
</div>

<!-- admin issue from  -->
<div class="should_call" <?php echo isset($_SESSION['issue_show']) ? 'style="display: block;"' : 'style="display: none;"'; ?>>
    <?php
        if (isset($_POST['issue_save']) && $_POST['issue_save'] === "issue_save")
        {
            $issue_enable_disable = $_POST['issue_enable_disable'];
            $issue_recipient = $_POST['issue_recipient'];
            $issue_subject = $_POST['issue_subject'];
            $issue_email_content = $_POST['issue_email_content'];

            update_option("issue_enable_disable", $issue_enable_disable);
            update_option("issue_recipient", $issue_recipient);
            update_option("issue_subject", $issue_subject);
            update_option("issue_email_content", $issue_email_content);

            echo '<div id="message" class="updated inline" bis_skin_checked="1"><p><strong>Your settings have been saved.</strong></p></div>';


        } else
        {
            $get_issue_recipient = get_option("issue_recipient", "");
            if (empty($get_issue_recipient))
            {
                $admin_email = get_option('admin_email');
            } else
            {
                $admin_email = get_option("issue_recipient");
            }

            $issue_admin_eSubject = "Someone submitted a Issue";
            $issue_admin_eContent = "Hi {admin_name},\n\nA Issue has been submitted by {customer_email} on the post '{post_name}'. Please review it promptly. Thank you.";
            update_option("issue_enable_disable", 'on');
            update_option("issue_recipient", $admin_email);
            update_option("issue_subject", $issue_admin_eSubject);
            update_option("issue_email_content", $issue_admin_eContent);
        }

        $get_issue_enable_disable = get_option("issue_enable_disable", "");
        $get_issue_recipient = get_option("issue_recipient", "");
        $get_issue_subject = get_option("issue_subject", "");
        $get_issue_email_content = get_option("issue_email_content", "");

    ?>
    <form method="post">
        <div class="input_field_email_div">
            <label for="enable_disable">Enable/Disable</label>
            <input type="checkbox" name="issue_enable_disable" <?php echo checked($get_issue_enable_disable, 'on'); ?>
                id="enable_disable" required>
        </div>
        <div class="input_field_email_div">
            <label for="recipient">Recipient(s)</label>
            <input type="text" name="issue_recipient" id="recipient"
                value="<?php echo esc_attr($get_issue_recipient); ?>" required>
        </div>
        <div class="input_field_email_div">
            <label for="subject">Subject</label>
            <input type="text" name="issue_subject" id="subject" value="<?php echo esc_attr($get_issue_subject); ?>"
                required>
        </div>
        <div class="input_field_email_div">
            <label for="email_content">Email Content</label>
            <textarea cols="5" rows="5" name="issue_email_content" id="email_content"
                required><?php echo esc_attr($get_issue_email_content); ?> </textarea>
        </div>
        <button type="submit" name="issue_save" value="issue_save" class="save_suggestion_btn">Save</button>

    </form>
</div>
<div class="should_call" <?php echo isset($_SESSION['voting_show']) ? 'style="display: block;"' : 'style="display: none;"'; ?>>
<?php
        if (isset($_POST['voting_show_save']) && $_POST['voting_show_save'] === "voting_show_save")
        {
            $voting_show_enable_disable = $_POST['voting_show_enable_disable'];
            $voting_show_recipient = $_POST['voting_show_recipient'];
            $voting_show_subject = $_POST['voting_show_subject'];
            $voting_show_email_content = $_POST['voting_show_email_content'];

            update_option("voting_show_enable_disable", $voting_show_enable_disable);
            update_option("voting_show_recipient", $voting_show_recipient);
            update_option("voting_show_subject", $voting_show_subject);
            update_option("voting_show_email_content", $voting_show_email_content);

            echo '<div id="message" class="updated inline" bis_skin_checked="1"><p><strong>Your settings have been saved.</strong></p></div>';


        } else
        {
            $get_voting_show_recipient = get_option("voting_show_recipient", "");
            if (empty($get_voting_show_recipient))
            {
                $admin_email = get_option('admin_email');
            } else
            {
                $admin_email = get_option("voting_show_recipient");
            }

            $voting_email_admin_eSubject = "@{voting_email} {voting_reaction} this post";
            $voting_email_admin_eContent = "Hi {admin_username},\n\n Someone {voting_reaction} this post and the post title is:{post_title} and report type is:{report_type}";

            update_option("voting_show_enable_disable", 'on');
            update_option("voting_show_recipient", $admin_email);
            update_option("voting_show_subject", $voting_email_admin_eSubject);
            update_option("voting_show_email_content", $voting_email_admin_eContent);
        }

        $get_voting_show_enable_disable = get_option("voting_show_enable_disable", "");
        $get_voting_show_recipient = get_option("voting_show_recipient", "");
        $get_voting_show_subject = get_option("voting_show_subject", "");
        $get_voting_show_email_content = get_option("voting_show_email_content", "");

    ?>
    <form method="post">
        <div class="input_field_email_div">
            <label for="enable_disable">Enable/Disable</label>
            <input type="checkbox" name="voting_show_enable_disable" <?php echo checked($get_voting_show_enable_disable, 'on'); ?>
                id="enable_disable" required>
        </div>
        <div class="input_field_email_div">
            <label for="recipient">Recipient(s)</label>
            <input type="text" name="voting_show_recipient" id="recipient"
                value="<?php echo esc_attr($get_voting_show_recipient); ?>" required>
        </div>
        <div class="input_field_email_div">
            <label for="subject">Subject</label>
            <input type="text" name="voting_show_subject" id="subject" value="<?php echo esc_attr($get_voting_show_subject); ?>"
                required>
        </div>
        <div class="input_field_email_div">
            <label for="email_content">Email Content</label>
            <textarea cols="5" rows="5" name="voting_show_email_content" id="email_content"
                required><?php echo esc_attr($get_voting_show_email_content); ?> </textarea>
        </div>
        <button type="submit" name="voting_show_save" value="voting_show_save" class="save_suggestion_btn">Save</button>

    </form>
</div>

<!-- voting email customer  -->
<div class="should_call" <?php echo isset($_SESSION['voting_email_customer']) ? 'style="display: block;"' : 'style="display: none;"'; ?>>
<?php
        if (isset($_POST['voting_email_customer_save']) && $_POST['voting_email_customer_save'] === "voting_email_customer_save")
        {
            $voting_email_customer_enable_disable = $_POST['voting_email_customer_enable_disable'];
            $voting_email_customer_subject = $_POST['voting_email_customer_subject'];
            $voting_email_customer_email_content = $_POST['voting_email_customer_email_content'];

            update_option("voting_email_customer_enable_disable", $voting_email_customer_enable_disable);
            update_option("voting_email_customer_subject", $voting_email_customer_subject);
            update_option("voting_email_customer_email_content", $voting_email_customer_email_content);

            echo '<div id="message" class="updated inline" bis_skin_checked="1"><p><strong>Your settings have been saved.</strong></p></div>';


        } else
        {
            $voting_email_customer_eSubject = "You have voted successfully";
            $voting_email_customer_eContent = "Hi {voting_email},\n\n You {voting_reaction} this post and the post title is:{post_title} and report type is:{report_type}";

            update_option("voting_email_customer_enable_disable", 'on');
            update_option("voting_email_customer_subject", $voting_email_customer_eSubject);
            update_option("voting_email_customer_email_content", $voting_email_customer_eContent);
        }

        $get_voting_email_customer_enable_disable = get_option("voting_email_customer_enable_disable", "");
        $get_voting_email_customer_subject = get_option("voting_email_customer_subject", "");
        $get_voting_email_customer_email_content = get_option("voting_email_customer_email_content", "");

    ?>
    <form method="post">
        <div class="input_field_email_div">
            <label for="enable_disable">Enable/Disable</label>
            <input type="checkbox" name="voting_email_customer_enable_disable" <?php echo checked($get_voting_email_customer_enable_disable, 'on'); ?>
                id="enable_disable" required>
        </div>
        <div class="input_field_email_div">
            <label for="subject">Subject</label>
            <input type="text" name="voting_email_customer_subject" id="subject" placeholder="<?php echo esc_attr($voting_email_customer_eSubject); ?>" value="<?php echo esc_attr($get_voting_email_customer_subject); ?>"
                required>
        </div>
        <div class="input_field_email_div">
            <label for="email_content">Email Content</label>
            <textarea cols="5" rows="5" name="voting_email_customer_email_content" placeholder="<?php echo esc_attr($voting_email_customer_eContent); ?>" id="email_content"
                required><?php echo esc_attr($get_voting_email_customer_email_content); ?> </textarea>
        </div>
        <button type="submit" name="voting_email_customer_save" value="voting_email_customer_save" class="save_suggestion_btn">Save</button>

    </form>
</div>

<div class="should_call" <?php echo isset($_SESSION['vote_delete_show']) ? 'style="display: block;"' : 'style="display: none;"'; ?>>
<?php
        if (isset($_POST['vote_delete_save']) && $_POST['vote_delete_save'] === "vote_delete_save")
        {
            $vote_delete_enable_disable = $_POST['vote_delete_enable_disable'];
            $vote_delete_recipient = $_POST['vote_delete_recipient'];
            $vote_delete_subject = $_POST['vote_delete_subject'];
            $vote_delete_email_content = $_POST['vote_delete_email_content'];

            update_option("vote_delete_enable_disable", $vote_delete_enable_disable);
            update_option("vote_delete_recipient", $vote_delete_recipient);
            update_option("vote_delete_subject", $vote_delete_subject);
            update_option("vote_delete_email_content", $vote_delete_email_content);

            echo '<div id="message" class="updated inline" bis_skin_checked="1"><p><strong>Your settings have been saved.</strong></p></div>';


        } else
        {
            $get_vote_delete_recipient = get_option("vote_delete_recipient", "");
            if (empty($get_vote_delete_recipient))
            {
                $admin_email = get_option('admin_email');
            } else
            {
                $admin_email = get_option("vote_delete_recipient");
            }

            $admin_voting_delete_subject = "{voter_email} Removed his/her Voting ";
            $admin_voting_delete_msg = "Hi {admin_username} . {voter_email} removed his/her Vote from post title: {post_title} and report type:{report_type}  ";

            update_option("vote_delete_enable_disable", 'on');
            update_option("vote_delete_recipient", $admin_email);
            update_option("vote_delete_subject", $admin_voting_delete_subject);
            update_option("vote_delete_email_content", $admin_voting_delete_msg);
        }

        $get_vote_delete_enable_disable = get_option("vote_delete_enable_disable", "");
        $get_vote_delete_recipient = get_option("vote_delete_recipient", "");
        $get_vote_delete_subject = get_option("vote_delete_subject", "");
        $get_vote_delete_email_content = get_option("vote_delete_email_content", "");

    ?>
<form method="post">
        <div class="input_field_email_div">
            <label for="enable_disable">Enable/Disable</label>
            <input type="checkbox" name="vote_delete_enable_disable" <?php echo checked($get_vote_delete_enable_disable, 'on'); ?>
                id="enable_disable" required>
        </div>
        <div class="input_field_email_div">
            <label for="recipient">Recipient(s)</label>
            <input type="text" name="vote_delete_recipient" id="recipient"
                value="<?php echo esc_attr($get_vote_delete_recipient); ?>" required>
        </div>
        <div class="input_field_email_div">
            <label for="subject">Subject</label>
            <input type="text" name="vote_delete_subject" id="subject" value="<?php echo esc_attr($get_vote_delete_subject); ?>"
                required>
        </div>
        <div class="input_field_email_div">
            <label for="email_content">Email Content</label>
            <textarea cols="5" rows="5" name="vote_delete_email_content" id="email_content"
                required><?php echo esc_attr($get_vote_delete_email_content); ?> </textarea>
        </div>
        <button type="submit" name="vote_delete_save" value="vote_delete_save" class="save_suggestion_btn">Save</button>

    </form>
</div>

<!-- voting_delete_customer -->
<div class="should_call" <?php echo isset($_SESSION['voting_delete_customer']) ? 'style="display: block;"' : 'style="display: none;"'; ?>>
<?php
        if (isset($_POST['voting_delete_customer_save']) && $_POST['voting_delete_customer_save'] === "voting_delete_customer_save")
        {
            $voting_delete_customer_enable_disable = $_POST['voting_delete_customer_enable_disable'];
            $voting_delete_customer_subject = $_POST['voting_delete_customer_subject'];
            $voting_delete_customer_email_content = $_POST['voting_delete_customer_email_content'];

            update_option("voting_delete_customer_enable_disable", $voting_delete_customer_enable_disable);
            update_option("voting_delete_customer_subject", $voting_delete_customer_subject);
            update_option("voting_delete_customer_email_content", $voting_delete_customer_email_content);

            echo '<div id="message" class="updated inline" bis_skin_checked="1"><p><strong>Your settings have been saved.</strong></p></div>';


        } else
        {

            update_option("voting_delete_customer_enable_disable", 'on');
            update_option("voting_delete_customer_subject", "Your Vote Removed Successfully");
            update_option("voting_delete_customer_email_content", "You have remove your vote from post name:{post_name} and report type:{post_type}");
        }

        $get_voting_delete_customer_enable_disable = get_option("voting_delete_customer_enable_disable", "");
        $get_voting_delete_customer_subject = get_option("voting_delete_customer_subject", "");
        $get_voting_delete_customer_email_content = get_option("voting_delete_customer_email_content", "");

    ?>
<form method="post">
        <div class="input_field_email_div">
            <label for="enable_disable">Enable/Disable</label>
            <input type="checkbox" name="voting_delete_customer_enable_disable" <?php echo checked($get_voting_delete_customer_enable_disable, 'on'); ?>
                id="enable_disable" required>
        </div>
        <div class="input_field_email_div">
            <label for="subject">Subject</label>
            <input type="text" name="voting_delete_customer_subject" id="subject" value="<?php echo esc_attr($get_voting_delete_customer_subject); ?>"
                required>
        </div>
        <div class="input_field_email_div">
            <label for="email_content">Email Content</label>
            <textarea cols="5" rows="5" name="voting_delete_customer_email_content" id="email_content"
                required><?php echo esc_attr($get_voting_delete_customer_email_content); ?> </textarea>
        </div>
        <button type="submit" name="voting_delete_customer_save" value="voting_delete_customer_save" class="save_suggestion_btn">Save</button>

    </form>
</div>



<!-- keep me posted  -->
<div class="should_call" <?php echo isset($_SESSION['keep_me_posted']) ? 'style="display: block;"' : 'style="display: none;"'; ?>>
<?php
        if (isset($_POST['keep_me_posted_save']) && $_POST['keep_me_posted_save'] === "keep_me_posted_save")
        {
            $keep_me_posted_enable_disable = $_POST['keep_me_posted_enable_disable'];
            $keep_me_posted_recipient = $_POST['keep_me_posted_recipient'];
            $keep_me_posted_subject = $_POST['keep_me_posted_subject'];
            $keep_me_posted_email_content = $_POST['keep_me_posted_email_content'];

            update_option("keep_me_posted_enable_disable", $keep_me_posted_enable_disable);
            update_option("keep_me_posted_recipient", $keep_me_posted_recipient);
            update_option("keep_me_posted_subject", $keep_me_posted_subject);
            update_option("keep_me_posted_email_content", $keep_me_posted_email_content);

            echo '<div id="message" class="updated inline" bis_skin_checked="1"><p><strong>Your settings have been saved.</strong></p></div>';


        } else
        {
            $get_keep_me_posted_recipient = get_option("keep_me_posted_recipient", "");
            if (empty($get_keep_me_posted_recipient))
            {
                $admin_email = get_option('admin_email');
            } else
            {
                $admin_email = get_option("keep_me_posted_recipient");
            }

            update_option("keep_me_posted_enable_disable", 'on');
            update_option("keep_me_posted_recipient", $admin_email);
            update_option("keep_me_posted_subject", "Your Suggestion submitted successfully");
            update_option("keep_me_posted_email_content", "Thanks for submitting your suggestion we will review it as soon as possible");
        }

        $get_keep_me_posted_enable_disable = get_option("keep_me_posted_enable_disable", "");
        $get_keep_me_posted_recipient = get_option("keep_me_posted_recipient", "");
        $get_keep_me_posted_subject = get_option("keep_me_posted_subject", "");
        $get_keep_me_posted_email_content = get_option("keep_me_posted_email_content", "");

    ?>
<form method="post">
        <div class="input_field_email_div">
            <label for="enable_disable">Enable/Disable</label>
            <input type="checkbox" name="keep_me_posted_enable_disable" <?php echo checked($get_keep_me_posted_enable_disable, 'on'); ?>
                id="enable_disable" required>
        </div>
        <div class="input_field_email_div">
            <label for="recipient">Recipient(s)</label>
            <input type="text" name="keep_me_posted_recipient" id="recipient"
                value="<?php echo esc_attr($get_keep_me_posted_recipient); ?>" required>
        </div>
        <div class="input_field_email_div">
            <label for="subject">Subject</label>
            <input type="text" name="keep_me_posted_subject" id="subject" value="<?php echo esc_attr($get_keep_me_posted_subject); ?>"
                required>
        </div>
        <div class="input_field_email_div">
            <label for="email_content">Email Content</label>
            <textarea cols="5" rows="5" name="keep_me_posted_email_content" id="email_content"
                required><?php echo esc_attr($get_keep_me_posted_email_content); ?> </textarea>
        </div>
        <button type="submit" name="keep_me_posted_save" value="keep_me_posted_save" class="save_suggestion_btn">Save</button>

    </form>
</div>


<!-- suggestion_customer_email  -->

<div class="should_call" <?php echo isset($_SESSION['suggestion_customer_email']) ? 'style="display: block;"' : 'style="display: none;"'; ?>>
<?php
        if (isset($_POST['suggestion_customer_email']) && $_POST['suggestion_customer_email'] === "suggestion_customer_email")
        {
            $suggestion_customer_email_enable_disable = $_POST['suggestion_customer_email_enable_disable'];
            $suggestion_customer_email_subject = $_POST['suggestion_customer_email_subject'];
            $suggestion_customer_email_email_content = $_POST['suggestion_customer_email_email_content'];

            update_option("suggestion_customer_email_enable_disable", $suggestion_customer_email_enable_disable);
            update_option("suggestion_customer_email_subject", $suggestion_customer_email_subject);
            update_option("suggestion_customer_email_email_content", $suggestion_customer_email_email_content);

            echo '<div id="message" class="updated inline" bis_skin_checked="1"><p><strong>Your settings have been saved.</strong></p></div>';


        } else
        {
            $sugg_customer_eSubject = "Your Suggestion submitted successfully ";
            $sugg_customer_eContent = "Hi {customer_email}\n\nThanks for submitting your suggestion we will review it as soon as possible .
            ";
            update_option("suggestion_customer_email_enable_disable", 'on');
            update_option("suggestion_customer_email_subject", $sugg_customer_eSubject);
            
            update_option("suggestion_customer_email_email_content", $sugg_customer_eContent);
        }

        $get_suggestion_customer_email_enable_disable = get_option("suggestion_customer_email_enable_disable", "");
        $get_suggestion_customer_email_subject = get_option("suggestion_customer_email_subject", "");
        $get_suggestion_customer_email_email_content = get_option("suggestion_customer_email_email_content", "");

    ?>
<form method="post">
        <div class="input_field_email_div">
            <label for="enable_disable">Enable/Disable</label>
            <input type="checkbox" name="suggestion_customer_email_enable_disable" <?php echo checked($get_suggestion_customer_email_enable_disable, 'on'); ?>
                id="enable_disable" required>
        </div>
        <div class="input_field_email_div">
            <label for="subject">Subject</label>
            <input type="text" name="suggestion_customer_email_subject" id="subject" placeholder="<?php echo esc_attr($sugg_customer_eSubject); ?>" value="<?php echo esc_attr($get_suggestion_customer_email_subject); ?>"
                required>
        </div>
        <div class="input_field_email_div">
            <label for="email_content">Email Content</label>
            <textarea cols="5" rows="5" name="suggestion_customer_email_email_content" id="email_content" placeholder="<?php echo esc_attr($sugg_customer_eContent); ?>"
                required><?php echo esc_attr($get_suggestion_customer_email_email_content); ?> </textarea>
        </div>
        <button type="submit" name="suggestion_customer_email" value="suggestion_customer_email" class="save_suggestion_btn">Save</button>

    </form>
</div>

<!-- end suggestion email  -->


<!-- issue_customer_email -->

<div class="should_call" <?php echo isset($_SESSION['issue_customer_email']) ? 'style="display: block;"' : 'style="display: none;"'; ?>>
<?php
        if (isset($_POST['issue_customer_email']) && $_POST['issue_customer_email'] === "issue_customer_email")
        {
            $issue_customer_email_enable_disable = $_POST['issue_customer_email_enable_disable'];
            $issue_customer_email_subject = $_POST['issue_customer_email_subject'];
            $issue_customer_email_email_content = $_POST['issue_customer_email_email_content'];

            update_option("issue_customer_email_enable_disable", $issue_customer_email_enable_disable);
            update_option("issue_customer_email_subject", $issue_customer_email_subject);
            update_option("issue_customer_email_email_content", $issue_customer_email_email_content);

            echo '<div id="message" class="updated inline" bis_skin_checked="1"><p><strong>Your settings have been saved.</strong></p></div>';


        } else
        {
            $issue_customer_eSubject = "Your Issue submitted successfully ";
            $issue_customer_eContent = "Hi {customer_email}\n\nThanks for submitting your Issue we will review it as soon as possible .
            ";
            update_option("issue_customer_email_enable_disable", 'on');
            update_option("issue_customer_email_subject", $issue_customer_eSubject);
            
            update_option("issue_customer_email_email_content", $issue_customer_eContent);
        }

        $get_issue_customer_email_enable_disable = get_option("issue_customer_email_enable_disable", "");
        $get_issue_customer_email_subject = get_option("issue_customer_email_subject", "");
        $get_issue_customer_email_email_content = get_option("issue_customer_email_email_content", "");

    ?>
<form method="post">
        <div class="input_field_email_div">
            <label for="enable_disable">Enable/Disable</label>
            <input type="checkbox" name="issue_customer_email_enable_disable" <?php echo checked($get_issue_customer_email_enable_disable, 'on'); ?>
                id="enable_disable" required>
        </div>
        <div class="input_field_email_div">
            <label for="subject">Subject</label>
            <input type="text" name="issue_customer_email_subject" id="subject" placeholder="<?php echo esc_attr($sugg_customer_eSubject); ?>" value="<?php echo esc_attr($get_issue_customer_email_subject); ?>"
                required>
        </div>
        <div class="input_field_email_div">
            <label for="email_content">Email Content</label>
            <textarea cols="5" rows="5" name="issue_customer_email_email_content" id="email_content" placeholder="<?php echo esc_attr($sugg_customer_eContent); ?>"
                required><?php echo esc_attr($get_issue_customer_email_email_content); ?> </textarea>
        </div>
        <button type="submit" name="issue_customer_email" value="issue_customer_email" class="save_suggestion_btn">Save</button>

    </form>
</div>


<!-- customer comment email  -->

<div class="should_call" <?php echo isset($_SESSION['comment_customer_email']) ? 'style="display: block;"' : 'style="display: none;"'; ?>>
<?php
        if (isset($_POST['comment_customer_email']) && $_POST['comment_customer_email'] === "comment_customer_email")
        {
            $comment_customer_email_enable_disable = $_POST['comment_customer_email_enable_disable'];
            $comment_customer_email_subject = $_POST['comment_customer_email_subject'];
            $comment_customer_email_email_content = $_POST['comment_customer_email_email_content'];

            update_option("comment_customer_email_enable_disable", $comment_customer_email_enable_disable);
            update_option("comment_customer_email_subject", $comment_customer_email_subject);
            update_option("comment_customer_email_email_content", $comment_customer_email_email_content);

            echo '<div id="message" class="updated inline" bis_skin_checked="1"><p><strong>Your settings have been saved.</strong></p></div>';


        } else
        {
            $issue_customer_eSubject = "{commentator_name} comment on your post ";
            $issue_customer_eContent = "Hi {post_owner_email}\n\n A Comment has been submitted by {commentator_name} to your post at post_title: {post_title} .
            ";
            update_option("comment_customer_email_enable_disable", 'on');
            update_option("comment_customer_email_subject", $issue_customer_eSubject);
            
            update_option("comment_customer_email_email_content", $issue_customer_eContent);
        }

        $get_comment_customer_email_enable_disable = get_option("comment_customer_email_enable_disable", "");
        $get_comment_customer_email_subject = get_option("comment_customer_email_subject", "");
        $get_comment_customer_email_email_content = get_option("comment_customer_email_email_content", "");

    ?>
<form method="post">
        <div class="input_field_email_div">
            <label for="enable_disable">Enable/Disable</label>
            <input type="checkbox" name="comment_customer_email_enable_disable" <?php echo checked($get_comment_customer_email_enable_disable, 'on'); ?>
                id="enable_disable" required>
        </div>
        <div class="input_field_email_div">
            <label for="subject">Subject</label>
            <input type="text" name="comment_customer_email_subject" id="subject" placeholder="<?php echo esc_attr($sugg_customer_eSubject); ?>" value="<?php echo esc_attr($get_comment_customer_email_subject); ?>"
                required>
        </div>
        <div class="input_field_email_div">
            <label for="email_content">Email Content</label>
            <textarea cols="5" rows="5" name="comment_customer_email_email_content" id="email_content" placeholder="<?php echo esc_attr($sugg_customer_eContent); ?>"
                required><?php echo esc_attr($get_comment_customer_email_email_content); ?> </textarea>
        </div>
        <button type="submit" name="comment_customer_email" value="comment_customer_email" class="save_suggestion_btn">Save</button>

    </form>
</div>

<!-- customer comment email end  -->