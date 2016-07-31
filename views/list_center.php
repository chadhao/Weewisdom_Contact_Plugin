<?php
$center_list = WW_Module::ww_get_center();
if (!$center_list) {
  echo 'Can not identify any center information!';
}
else
{
  echo '<div>';
    echo "<table>\n";
      echo  "<tr>\n".
            '<td>ID</td>'.
            '<td>NAME</td>'.
            '<td>EMAIL</td>'.
            '<td>PHONE</td>'.
            '<td>ADDRESS</td>'.
            "</tr>\n";

      foreach ($center_list as $piece) 
      {
      echo '<tr>'.
            '<td>'.$piece->center_id.'</td>'.
            '<td>'.$piece->name.'</td>'.
            '<td>'.$piece->email.'</td>'.
            '<td>'.$piece->phone.'</td>'.
            '<td>'.$piece->address.'</td>'.
            '</tr>';
      }
    echo  '</table>';
  echo '</div>';
}
?>
<form method="post" action="<?php echo esc_url(WW_Module::ww_manage_get_url('show_add'));?>">
  <input type="submit" value="ADD NEW CENTER">
</form>

<form method="post" action="<?php echo esc_url(WW_Module::ww_manage_get_url('show_delete'));?>">
  <input type="submit" value="DELETE CENTER">
</form>

