<?php
global $wpdb;
$table_name = $wpdb->prefix.'activity_meta';
$activity_result = $wpdb->get_var("SELECT signup_time FROM $table_name WHERE post_id = $post->ID");
$activity_signup_time = new DateTime($activity_result);
$datetime_now = new DateTime(current_time('mysql'));
?>
<div class="fusion-row" style="margin: 0;max-width: 600px;">
    <h4 style="border-bottom: 1px solid #aaa;">活动报名</h4>
    <?php
    if ($datetime_now > $activity_signup_time):
        echo '<p>该活动线上报名已截止！线下报名以及关于活动的其他问题，请联系活动负责人。</p>';
    else:
    ?>
    <style type="text/css">
    .activity_signup_form p span input {
        margin: 0;
        border: 1px solid #aaa;
        background: #fff;
    }
    .activity_signup_form p span input[type=checkbox] {
        padding: 0!important;
        border: 1px solid #aaa;
        background: #fff;
        cursor: pointer;
        height: 16px;
        width: 16px;
        text-align: center;
        vertical-align: middle;
        -webkit-appearance: none;
    }
    .activity_signup_form p span input[type=checkbox]:checked:before {
        content: "X";
        font-weight: bold;
        color: #1e8cbe;
    }
    .activity_signup_form p button {
        cursor: pointer;
        padding: 10px 20px;
        font-size: 16px;
        font-weight: bold;
        color: #50586b;
        border-radius: 2px;
        border: 1px solid #50586b;
        background: none;
    }
    </style>
    <form class="activity_signup_form" method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="action" value="activity_signup">
        <input type="hidden" name="frontend" value="1">
        <input type="hidden" name="is_new" value="1">
        <input type="hidden" name="post_id" value="<?php echo $post->ID; ?>">
        <p>
            姓名<small>（必填）</small><br>
            <span><input type="text" name="fullname" placeholder="请填写您的姓名" value=""></span>
        </p>
        <p>
            联系电话<small>（必填）</small><br>
            <span><input type="text" name="phone" placeholder="请填写您的联系方式" value=""></span>
        </p>
        <p>
            E-mail<br>
            <span><input type="email" name="email" placeholder="请填写您的E-mail" value=""></span>
        </p>
        <p>
            <span><input type="checkbox" name="is_aut_student"></span> 我是AUT在读学生
        </p>
        <p>
            <span><input type="checkbox" name="is_autcsa_member"></span> 我是AUTCSA会员
        </p>
        <p><button type="submit">报名</button></p>
    </form>
    <?php endif; ?>
</div>
