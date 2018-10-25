<?php

$cols = ($_POST['cols'] == '') ? 7 : $_POST['cols'];
$rows = ($_POST['rows'] == '') ? 7 : $_POST['rows'];

$table1 = $table2 = $table3 = $table4 = '<table id="outputTables">';

$fill_every_fourth = (isset($_POST['fill_table'])) ? True : False;

function fill_table($cff, $fill_every_fourth) {
  return (($cff % 4 == 0) && $fill_every_fourth ? 'Fourth cell' : '');
}

if(isset($_POST['output_type'])) {
  if($_POST['output_type'] == 'build_tables') {
    if($cols < 3
    || $rows < 3
    || $rows % 3 == 0
    || $cols % 3 == 0) {
      echo '<h1>Incorrect input!<h1>';
    } else {

      echo '<h1>Table #1</h1>';
      $cff = 0;
      for($i = 0; $i < $rows; $i++) {

        $table1 .= '<tr>';
        if($i === 0) {

          $table1 .= '<td colspan="'
          . ($cols - $i)
          . '">'
          .fill_table(++$cff, $fill_every_fourth)
          . '</td>';

        } else if($i < min($rows, $cols)) {

          $table1 .= '<td rowspan="'
          . ($rows - $i)
          . '">'
          . fill_table(++$cff, $fill_every_fourth)
          . '</td>';

          $table1 .= '<td colspan="'
          . ($cols - $i)
          . '">'
          .fill_table(++$cff, $fill_every_fourth)
          . '</td>';

        } else if($i == $cols) {
          $table1 .= '<td rowspan="'
          . ($rows - $i)
          . '">'
          . fill_table(++$cff, $fill_every_fourth)
          . '</td>';
          break;
        }
        $table1 .= '</tr>';
      }
      $table1 .= '</table>';
      echo $table1;

      echo '<h1>Table #2</h1>';
      $cff = 0;
      for($i = 0; $i < $rows; $i++) {

        $table2 .= '<tr>';

        if($i > min($rows, $cols) - 1) continue;

        if($i === min($rows, $cols) - 1) {

          $table2 .= '<td '
          . ($cols < $rows ? 'row' : 'col')
          . 'span='
          . (max($rows, $cols) - $i)
          . '">'
          . fill_table(++$cff, $fill_every_fourth)
          . '</td>';

        }  else if($i === $rows - 1) {

          $table2 .= '<td>'
          . fill_table(++$cff, $fill_every_fourth)
          . '</td>';

        } else {

          $table2 .= '<td rowspan='
          . ($rows - $i)
          . '">'
          . fill_table(++$cff, $fill_every_fourth)
          . '</td>';

          $table2 .= '<td colspan="'
          . ($cols - $i - 1)
          . '">'
          . fill_table(++$cff, $fill_every_fourth)
          . '</td>';

        }
        $table2 .= '</tr>';
      }
      $table2 .= '</table>';
      echo $table2;

      echo '<h1>Table #3</h1>';
      $cff = 0;
      for($i = 0; $i < $rows; $i++) {
        $cur_sum = 0;
        $table3 .= '<tr>';

        if($i % 2 == 1) {
          $table3 .= '<td>'
          . fill_table(++$cff, $fill_every_fourth)
          . '</td>';
          $cur_sum += 1;
        }

        for($j = 0; $j < floor(($cols - $cur_sum) / 2); $j++) {
          $table3 .= '<td colspan="2">'
          . fill_table(++$cff, $fill_every_fourth)
          . '</td>';
        }

        $cur_sum += (floor(($cols - $cur_sum) / 2) * 2);

        if($cur_sum != $cols) {
          $table3 .= '<td>'
          . fill_table(++$cff, $fill_every_fourth)
          . '</td>';
        }

        $table3 .= '</tr>';
      }
      $table3 .= '</table>';
      echo $table3;

      echo '<h1>Table #4</h2>';
      $cff = 0;
      $table4 .= '<tr>';
      $sum_in_first_col = 3;
      $next_span = 3;

      for($i = 0; $i < $cols; $i++) {
        $table4 .= '<td rowspan="'
        . $next_span
        . '">'
        . fill_table(++$cff, $fill_every_fourth)
        . '</td>';

        $next_span = 3 - (($rows - $next_span) % 3);
      }
      $inc = ($rows - floor($rows / 3) * 3) == 2 ? 1 : -1;
      $shift = 3 - (($rows - 3) % 3);
      $table4 .= '</tr>';

      for($i = 1; $i < $rows; $i++) {
        $table4 .= '<tr>';

        for($j = 0; $j + $shift <= $cols - 1; $j += 3) {
          $table4 .= '<td rowspan="'
          . min(3, $rows - $i)
          . '">'
          . fill_table(++$cff, $fill_every_fourth)
          . '</td>';
        }

        $shift += $inc;

        if($shift == 3) {
          $shift = 0;
        }

        if($shift == -1) {
          $shift = 2;
        }

        $table4 .= '</tr>';
      }
      echo $table4;
    }
  }
}

?>
