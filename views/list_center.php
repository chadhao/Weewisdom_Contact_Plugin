<?php
include 'style.php';
$center_list = WW_Module::ww_get_center();

if (!$center_list) {
  echo '<div class="error"><p>No recorded center identified!</p></div>';
  //echo 'Can not identify any center information!';
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
            '<td>ADDRESS</td>'.
            "</tr>\n";
      $ID = 1;
      foreach ($center_list as $piece)
      {

      echo '<tr>'.
            '<td>'.$ID++.'</td>'.
            '<td>'.$piece->name.'</td>'.
            '<td>'.$piece->email.'</td>'.
            '<td>'.$piece->phone.'</td>'.
            '<td>'.$piece->address.'</td>'.
            '<td><a href='.esc_url(WW_Module::ww_manage_get_url('show_add')).'>EDIT</a> | <a href='.esc_url(WW_Module::ww_manage_get_url('process_del_center', $piece -> center_id)).'>DELETE</a></td>'.
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


