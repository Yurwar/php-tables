<html>
    <head>
      <link rel="stylesheet" href="style.css" type="text/css"/>
      <title>PHP Tables</title>
    </head>
    <body>
      <form action="index.php" method="post">
        <h3>Enter the amount of columns and rows in the tables</h3>
        <p>Columns: <input type="text" name="cols"></p>
        <p>Rows: <input type="text" name="rows"></p>
        <p>Every fourth <input type="checkbox" name="fill_table"></p>
        <p>Show statistic <input type="radio" name="output_type" value="show_db"></p>
        <p>Build tables <input type="radio" name="output_type" value="build_tables" checked></p>
        <p><input type="submit" value="Send"></p>
      </form>
      <?php include_once "database.php"; ?>
      <?php include_once "tables.php"; ?>
    </body>
</html>
