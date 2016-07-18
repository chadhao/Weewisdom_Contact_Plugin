<?php
$all_terms = get_terms('category', 'orderby=id&hide_empty=0');
$current_category = get_option('activity_category');
?>
<div class="wrap">
	<h1>活动设置</h1>
	<form name="activity_admin_setting" id="activity_admin_setting" method="post" action="<?php echo esc_url(Activity_Admin::activity_admin_get_url('activity_admin_setting'));?>">
		<table class="form-table">
		<tr><th scope="row"><label for="activity_category">活动分类</label></th>
			<td>
				<select name="activity_category" id="activity_category">
<?php
foreach ($all_terms as $term) {
    echo '<option value="'.$term->term_id.'"';
    if ($term->term_id == $current_category) {
        echo ' selected="selected">';
    } else {
        echo '>';
    }
    echo $term->name.'</option>';
}
?>
				</select>
				<p class="description" id="activity_category-description">请选择一个分类作为活动分类。</p>
			</td>
		</tr>
		</table>
		<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="保存"  /></p>
	</form>
</div>
