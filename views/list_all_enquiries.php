<?php
include 'style.php';
$enq_list = WW_Module::ww_get_enquiry();
if (!$enq_list)
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
            '<td>CENTER</td>'.
            '<td>CONTACTED</td>'.
            "</tr>\n";
      $ID = 1;
      foreach ($enq_list as $piece)
      {
            echo '<tr>'.
            '<td>'.$ID++.'</td>'.
            '<td>'.$piece->name.'</a></td>'.
            '<td>'.$piece->email.'</td>'.
            '<td>'.$piece->phone.'</td>'.
            '<td>'.$piece->centerName.'</td>'.
            '<td>'.($piece->is_contacted == 0 ? 'No' : 'Yes').'</td>'.
            '</tr>';
      }
    echo  '</table>';
  echo '</div>';
}
?>
