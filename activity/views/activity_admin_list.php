<?php
include 'style.php';

$activity_args = array(
    'posts_per_page' => -1,
    'category' => get_option('activity_category'),
    'orderby' => 'date',
    'order' => 'DESC',
);
$all_activity = get_posts($activity_args);
?>
<div class="wrap">
	<h1>活动列表 <a href="<?php echo esc_url(Activity_Admin::activity_admin_get_url('activity_admin_add_post')); ?>" class="page-title-action">添加活动</a></h1>
	<table class="am-table am-table-hover">

		<?php
        if (!empty($all_activity)) {
            ?>
		<tr>
			<td>ID</td>
			<td>标题</td>
			<td>报名数</td>
			<td>最后修改</td>
			<td>操作</td>
		</tr>
		<?php
            foreach ($all_activity as $activity) {
                $activity_signup_count = Activity_Signup::activity_signup_count($activity->ID);
                $activity_capacity = Activity_Admin::activity_admin_get_capacity($activity->ID);
                echo '<tr>'.
                     '<td>'.$activity->ID.'</td>'.
                     '<td><a href="'.esc_url(Activity_Admin::activity_admin_get_url('activity_admin_signup_list', $activity->ID)).'">'.$activity->post_title.'</a></td>';
                if ($activity_capacity == 0) {
                    echo '<td style="color: #00ff00;">'.$activity_signup_count.'</td>';
                } else {
                    echo '<td'.($activity_signup_count / $activity_capacity >= 0.9 ? ' style="color: #ff0000;"' : ' style="color: #00ff00;"').'>'.$activity_signup_count.' / '.$activity_capacity.'</td>';
                }
                echo '<td>'.$activity->post_modified.'</td>'.
                     '<td><a href="'.esc_url(Activity_Admin::activity_admin_get_url('activity_admin_edit_post', $activity->ID)).'">编辑</a> | <a href="'.esc_url(Activity_Admin::activity_admin_get_url('activity_admin_delete_post', $activity->ID)).'">删除</a></td>'.
                     '</tr>';
            }
        } else {
            echo '<h2>没有活动！</h2>';
        }
    ?>
	</table>
</div>
