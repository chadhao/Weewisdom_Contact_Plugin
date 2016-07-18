<?php
include 'style.php';

$add_new = $_GET['post_action'] == 'add' ? true : false;
$post_id = $add_new ? 0 : intval($_GET['post_id']);
$the_post = !$add_new ? get_post($post_id) : null;
$the_post_meta = !$add_new ? Activity_Admin::activity_admin_get_post_meta($post_id) : null;
if (!$add_new) {
    $signup_time = new DateTime($the_post_meta->signup_time);
    $activity_time = new DateTime($the_post_meta->activity_time);
    $the_post_meta_signup_date = date_format($signup_time, 'Y-m-d');
    $the_post_meta_signup_time = date_format($signup_time, 'H:i');
    $the_post_meta_activity_date = date_format($activity_time, 'Y-m-d');
    $the_post_meta_activity_time = date_format($activity_time, 'H:i');
}
?>

<div class="wrap">
	<form class="am-form" method="post" action="<?php echo esc_url(Activity_Admin::activity_admin_get_url('activity_admin_process_post'));?>">
		<fieldset>

			<legend><?php echo $add_new ? '添加活动' : '编辑活动'; ?></legend>

			<input type="hidden" name="is_new" id="is_new" value="<?php echo $add_new ? 1 : -1; ?>">
			<input type="hidden" name="post_id" id="post_id" value="<?php echo $add_new ? 'new' : $_GET['post_id']; ?>">

			<div class="am-g-collapse">
				<div class="am-form-group am-g">
					<label for="title">活动标题 <span class="am-badge am-badge-danger am-round">必填</span></label>
					<input type="text" name="title" id="title" placeholder="请填写活动标题" value="<?php echo !$add_new ? $the_post->post_title : ''; ?>">
				</div>

				<div class="am-form-group am-g">
					<label for="location">活动地点 <span class="am-badge am-badge-danger am-round">必填</span></label>
					<input type="text" name="location" id="location" placeholder="请填写活动地点" value="<?php echo !$add_new ? $the_post_meta->location : ''; ?>">
				</div>

				<div class="am-form-group am-g">
					<label for="activity_datetime">活动时间 <span class="am-badge am-badge-danger am-round">必填</span></label>
					<div id="activity_datetime">
						<span class="am-u-sm-2" style="padding-left: 0;"><input type="text" name="activity_date" id="activity_date" placeholder="请选择活动日期" value="<?php echo !$add_new ? $the_post_meta_activity_date : ''; ?>" class="am-form-field" data-am-datepicker readonly></span>
						<select name="activity_time" id="activity_time" data-am-selected="{maxHeight: 200}">
                        <?php
                        for ($i = 0; $i < 144; ++$i) {
                            $the_time = sprintf('%02d', floor($i / 6)).':'.sprintf('%02d', floor($i % 6 * 10));
                            echo '<option value="'.$the_time.':00"';
                            echo $the_time == $the_post_meta_activity_time ? ' selected>' : '>';
                            echo $the_time.'</option>';
                        }
                        ?>
						</select>
					</div>
				</div>

				<div class="am-form-group  am-g">
					<label for="fee_member">会员收费 <span class="am-badge am-round">选填</span></label>
					<input type="text" name="fee_member" id="fee_member" placeholder="请填写活动费用，免费请留空" value="<?php echo !$add_new ? $the_post_meta->member_fee : ''; ?>">
				</div>

				<div class="am-form-group am-g">
					<label for="fee_nonmember">非会员收费 <span class="am-badge am-round">选填</span></label>
					<input type="text" name="fee_nonmember" id="fee_nonmember" placeholder="请填写活动费用，免费请留空" value="<?php echo !$add_new ? $the_post_meta->nonmember_fee : ''; ?>">
				</div>

                <div class="am-form-group am-g">
					<label for="max_capacity">最大参与人数 <span class="am-badge am-round">选填</span></label>
					<input type="text" name="max_capacity" id="max_capacity" placeholder="请填写最大参与人数，不限人数请留空" value="<?php echo !$add_new ? $the_post_meta->max_capacity : ''; ?>">
				</div>

				<div class="am-form-group am-g">
					<label for="signup_datetime">报名截止时间 <span class="am-badge am-badge-danger am-round">必填</span></label>
					<div id="signup_datetime">
						<span class="am-u-sm-2" style="padding-left: 0;"><input type="text" name="signup_date" id="signup_date" placeholder="请选择报名截止日期" value="<?php echo !$add_new ? $the_post_meta_signup_date : ''; ?>" class="am-form-field" data-am-datepicker readonly></span>
						<select name="signup_time" id="signup_time" data-am-selected="{maxHeight: 200}">
						<?php
                            for ($i = 0; $i < 144; ++$i) {
                                $the_time = sprintf('%02d', floor($i / 6)).':'.sprintf('%02d', floor($i % 6 * 10));
                                echo '<option value="'.$the_time.':00"';
                                echo $the_time == $the_post_meta_signup_time ? ' selected>' : '>';
                                echo $the_time.'</option>';
                            }
                        ?>
						</select>
					</div>
				</div>

				<div class="am-form-group am-g">
					<label for="signup_method">报名方式 <span class="am-badge am-badge-danger am-round">必填</span></label>
					<textarea name="signup_method" id="signup_method" rows="3" placeholder="请填写报名方式"><?php echo !$add_new ? $the_post_meta->signup_method : ''; ?></textarea>
				</div>

				<div class="am-form-group am-g">
					<label for="poster">活动海报 <span class="am-badge am-round">选填</span> <a class="am-badge am-badge-secondary am-round" href="<?php echo home_url('/wp-admin/media-new.php'); ?>" target="_blank">上传</a></label>
					<input type="text" name="poster" id="poster" placeholder="请上传活动海报，并填写海报URL" value="<?php echo !$add_new ? $the_post_meta->poster : ''; ?>">
				</div>

				<div class="am-form-group am-g">
					<label for="activity_detail">活动详情 <span class="am-badge am-badge-danger am-round">必填</span></label>
					<?php
                        wp_editor(!$add_new ? $the_post->post_content : '', 'activity_detail');
                    ?>
				</div>

				<p style="float: right;"><button type="submit" class="am-btn am-btn-primary am-radius">提交</button></p>
			</div>

		</fieldset>
	</form>
</div>
