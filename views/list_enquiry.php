<?php
include 'style.php';
$enquiry_list = WW_Module::ww_show_enquiry();

echo '<h1>'.$enquiry_list.'</h1>';

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
//            '<td><a href='.esc_url(WW_Module::ww_manage_get_url('show_update', $piece -> center_id)).'>EDIT</a> | <a href='.esc_url(WW_Module::ww_manage_get_url('del_center', $piece -> center_id)).'>DELETE</a></td>'.
            '</tr>';
      }
    echo  '</table>';
  echo '</div>';
}
?>
<div>
  <br>
  <form method="post" action="<?php echo esc_url(WW_Module::ww_manage_get_url('show_add'));?>">
    <input type="submit" value="ADD NEW CENTER">
  </form>
</div>
