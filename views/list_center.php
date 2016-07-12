<?php
$center_list = WW_Module::ww_get_center();
if(!$center_list)
{
	echo "Can not identify any center information!";
}
?>
<div>
  <table>
    <tr>
      <td>center_id</td>
      <td>name</td>
      <td>email</td>
      <td>phone</td>
      <td>address</td>
    </tr>
    <?php
      foreach ($list as $piece) {
        echo '<tr>'.
        '<td>'.$piece->center_id.'</td>'.
        '<td>'.$piece->name.'</td>'.
        '<td>'.$piece->email.'</td>'.
        '<td>'.$piece->phone.'</td>'.
        '<td>'.$piece->address.'</td>'.
      }
     ?>
  </table>
</div>