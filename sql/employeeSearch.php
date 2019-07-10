<?php
include('../config/dbConfig.php');

if (isset($_POST['employeeName'])) {
//Search box value assigning to $Name variable.
    $Name = $_POST['employeeName'];
//Search query.

    $Query = "SELECT CONCAT(employees.first_name,' ',employees.middle_name,' ',employees.last_name) Name FROM employees "
            . "WHERE employee_number LIKE '%$Name%' OR first_name LIKE '%$Name%' OR last_name LIKE '%$Name%' OR  middle_name  LIKE '%$Name%' ORDER BY '$Name' DESC; ";
//echo $Query;

//Query execution
    $ExecQuery = MySQLi_query($conn, $Query);
//Creating unordered list to display result.
    echo '
<ul>
   ';
    //Fetching result from database.
    while ($Result = MySQLi_fetch_array($ExecQuery)) {
        ?>
        <!-- Creating unordered list items.
             Calling javascript function named as "fill" found in "script.js" file.
             By passing fetched result as parameter. -->
        <li onclick='fill("<?php echo $Result['Name']; ?>")'>
            <a>
                <!-- Assigning searched result in "Search box" in "search.php" file. -->
                <?php echo "<option value=".$Result['Name'].">"; ?>
        </li></a>
        <!-- Below php code is just for closing parenthesis. Don't be confused. -->
        <?php
    }
}
?>
</ul>
