<?php
include 'style.php';
$enquiry_list = WW_Module::ww_show_enquiry($_GET['center_id']);

if (!$enquiry_list)
{
  echo '<div class="error"><p>No recorded enquiry identified!</p></div>';
}
else
{
  echo '<div class="wrap">';
    echo '<table class="am-table am-table-hover">';
      echo  "<tr>\n".
            '<td>ID</td>'.
            '<td>NAME</td>'.
            '<td>EMAIL</td>'.
            '<td>PHONE</td>'.
            '<td>CENTER_ID</td>'.
            '<td>IS_CONTACTED</td>'.
            "</tr>\n";
      $ID = 1;
      foreach ($enquiry_list as $piece)
      {
             echo '<tr>'.
            '<td>'.$ID++.'</td>'.
            '<td>'.$piece->name.'</a></td>'.
            '<td>'.$piece->email.'</td>'.
            '<td>'.$piece->phone.'</td>'.
            '<td>'.$piece->center_id.'</td>'.
            '<td>'.$piece->is_contacted.'</td>'.
            '<td><a href='.esc_url(WW_Module::ww_manage_get_url('show_update_enquiry', $piece -> center_id, $piece -> enq_id)).'>EDIT</a> | <a href='.esc_url(WW_Module::ww_manage_get_url('del_enquiry', $piece -> center_id, $piece -> enq_id)).'>DELETE</a></td>'.
            '</tr>';
      }
    echo  '</table>';
  echo '</div>';
}
?>
<div>
  <br>
  <form method="post" action="<?php echo esc_url(WW_Module::ww_manage_get_url('show_add_enquiry', $_GET['center_id']));?>">
    <input type="submit" value="ADD NEW ENQUIRY">
  </form>
</div>
