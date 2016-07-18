<?php
include 'style.php';

$post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;

$list = Activity_Signup::activity_signup_get_list($post_id);
?>

<div class="wrap">
  <h1><?php echo $post_id == 0 ? 'No Activity' : get_the_title($post_id); ?> <a href="<?php echo esc_url(Activity_Admin::activity_admin_get_url('activity_admin_add_signup', $post_id)); ?>" class="page-title-action">添加参与者</a></h1>
  <table class="am-table am-table-hover">
    <?php
    if ($post_id != 0) {
        ?>
     <tr style="text-align:center;">
       <td>ID</td>
       <td>姓名</td>
       <td>E-mail</td>
       <td>电话</td>
       <td>是否付费</td>
       <td>AUT学生</td>
       <td>CSA会员</td>
       <td>最后修改</td>
       <td>操作</td>
     </tr>
     <?php
       $ID = 1;
        foreach ($list as $piece) {
            echo '<tr style="text-align:center;">'.
             '<td>'.$ID++.'</td>'.
             '<td>'.$piece->name.'</td>'.
             '<td>'.$piece->email.'</td>'.
             '<td>'.$piece->phone.'</td>'.
             '<td>'.($piece->fee_paid ? '<span class="am-icon-check"></span>' : ' ').'</td>'.
             '<td>'.($piece->is_aut_student ? '<span class="am-icon-check"></span>' : ' ').'</td>'.
             '<td>'.($piece->is_autcsa_member ? '<span class="am-icon-check"></span>' : ' ').'</td>'.
             '<td>'.$piece->time.'</td>'.
             '<td><a href="'.esc_url(Activity_Admin::activity_admin_get_url('activity_admin_edit_signup', $_GET['post_id'], $piece->id)).'">编辑</a> | <a href="'.esc_url(Activity_Admin::activity_admin_get_url('activity_admin_delete_signup', $_GET['post_id'], $piece->id)).'">删除</a></td>'.
             '</tr>';
        }
    } else {
        echo '<h2>No Results！</h2>';
    }
    ?>
  </table>
</div>
