<?php
include 'style.php';
$center_list = WW_Module::ww_get_center();

if (!$center_list)
{
  echo '<div class="error"><p>No recorded center identified!</p></div>';
}
else
{
  echo '<div class="wrap">';
    echo '<table class="am-table am-table-hover">';
      echo  "<tr>\n".
            '<td>ID</td>'.
            '<td>CENTER</td>'.
            '<td>EMAIL</td>'.
            '<td>PHONE</td>'.
            '<td>ADDRESS</td>'.
            "</tr>\n";
      $ID = 1;
      foreach ($center_list as $piece)
      {
             echo '<tr>'.
            '<td>'.$ID++.'</td>'.
            '<td><a href='.esc_url(WW_Module::ww_manage_get_url('list_enquiry', $piece -> center_id)).'>'.$piece->name.'</a></td>'.
            '<td>'.$piece->email.'</td>'.
            '<td>'.$piece->phone.'</td>'.
            '<td>'.$piece->address.'</td>'.
            '<td><a href='.esc_url(WW_Module::ww_manage_get_url('show_update', $piece -> center_id)).'>EDIT</a> | <a href='.esc_url(WW_Module::ww_manage_get_url('del_center', $piece -> center_id)).'>DELETE</a></td>'.
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
