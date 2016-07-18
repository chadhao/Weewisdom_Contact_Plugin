<?php
include 'style.php';

$add_new = $_GET['signup_action'] == 'add' ? true : false;
$post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;
if (!$add_new) {
    $signup = Activity_Signup::activity_signup_get_signup(intval($_GET['signup_id']));
}
?>

<div class="wrap">
    <form class="am-form am-form-horizontal" method="POST" action="<?php echo esc_url(Activity_Admin::activity_admin_get_url('activity_admin_process_signup'));?>">
	     <fieldset>

	    <legend><?php echo $add_new ? '添加参与者' : '编辑参与者'; ?></legend>

	    <input type="hidden" name="is_new" value="<?php echo $add_new ? 1 : -1; ?>">
	    <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
	    <input type="hidden" name="signup_id" value="<?php echo $add_new ? 0 : intval($_GET['signup_id']); ?>">

	    <div class="am-form-group">
		<label for="fullname" class="am-u-sm-1 am-form-label">姓名</label>
		<div class="am-u-sm-11">
		    <input type="text" name="fullname" placeholder="请填写参与者姓名" value="<?php echo !$add_new ? $signup->name : ''; ?>">
		</div>
	    </div>

	    <div class="am-form-group">
		<label for="email" class="am-u-sm-1 am-form-label">E-mail</label>
		<div class="am-u-sm-11">
		    <input type="text" name="email" placeholder="请填写参与者E-mail" value="<?php echo !$add_new ? $signup->email : ''; ?>">
		</div>
	    </div>

	    <div class="am-form-group">
		<label for="phone" class="am-u-sm-1 am-form-label">电话</label>
		<div class="am-u-sm-11">
		    <input type="text" name="phone" placeholder="请填写参与者电话" value="<?php echo !$add_new ? $signup->phone : ''; ?>">
		</div>
	    </div>

	    <div class="am-form-group">
		<label for="fee_paid" class="am-u-sm-1 am-form-label">已付费</label>
		<div class="am-u-sm-11">
		    <input type="checkbox" name="fee_paid" <?php echo !$add_new ? ($signup->fee_paid == 1 ? 'checked' : '') : ''; ?>>
		</div>
	    </div>

	    <div class="am-form-group">
		<label for="is_aut_student" class="am-u-sm-1 am-form-label">AUT学生</label>
		<div class="am-u-sm-11">
		    <input type="checkbox" name="is_aut_student" <?php echo !$add_new ? ($signup->is_aut_student == 1 ? 'checked' : '') : ''; ?>>
		</div>
	    </div>

	    <div class="am-form-group">
		<label for="is_autcsa_member" class="am-u-sm-1 am-form-label">CSA会员</label>
		<div class="am-u-sm-11">
		    <input type="checkbox" name="is_autcsa_member" <?php echo !$add_new ? ($signup->is_autcsa_member == 1 ? 'checked' : '') : ''; ?>>
		</div>
	    </div>

	    <div class="am-form-group">
		<div class="am-u-sm-11 am-u-sm-offset-1">
		    <button type="submit" class="am-btn am-btn-primary am-radius">提交</button>
		</div>
	    </div>

	</fieldset>
    </form>
</div>
