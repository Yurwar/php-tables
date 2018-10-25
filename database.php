<?php
$connection = mysqli_connect("localhost","yurii","789456123qwe","db_tables");
if(mysqli_connect_errno()) {
  echo "Failed to connect to MySQL database. Error " . mysqli_connect_error();
}

if($_POST['cols'] != '' && $_POST['rows'] != '') {
  if($_POST['cols'] < 3
  || $_POST['rows'] < 3
  || $_POST['cols'] % 3 == 0
  || $_POST['rows'] % 3 == 0) {
    $sql = 'INSERT INTO incorrect_values(col_value, row_value, creating_date) VALUES (
      ' . $_POST['cols'] . ',
      ' . $_POST['rows'] . ',
      NOW());';
  } else {
    $sql = 'INSERT INTO correct_values(col_value, row_value, creating_date) VALUES (
      ' . $_POST['cols'] . ',
      ' . $_POST['rows'] . ',
      NOW());';
  }
}

if(isset($sql)) {
  mysqli_query($connection, $sql);
}



function print_database($connection, $table_name) {


  $output_table_name = (str_replace('_', ' ', $table_name));
  $output_table_name[0] = strtoupper($output_table_name[0]);
  echo '<h1 id="db_table_name">' . $output_table_name . '</h1>';

  $sql = 'SELECT * FROM ' . $table_name;
  $query_result = mysqli_query($connection, $sql);
  $rows_num = mysqli_num_rows($query_result);
  $cols_num = mysqli_num_fields($query_result);
  $table = '<table id="db_table">';
  $table .= '<tr><th>id</th><th>Column value</th><th>Row value</th><th>Creating date</th></tr>';
  for($i = 0; $i < $rows_num; ++$i) {
    $table .= '<tr>';
    $row = mysqli_fetch_row($query_result);
    for($j = 0; $j < 4; ++$j) {
      $table .= '<td>'.$row[$j].'</td>';
    }
    $table .= '</tr>';
  }
  $table .= '</table>';
  echo $table;
  echo '<br>';
}
if($_POST['output_type'] == 'show_db') {
  print_database($connection, 'correct_values');
  print_database($connection, 'incorrect_values');
}
?>
