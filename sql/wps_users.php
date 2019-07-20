<?php
include('../config/dbConfig.php');
session_start();


if (isset($_SESSION['accessUsers'])) {  

    $query = "select * from wps_users ";
    $result = $conn->query($query);


    if ($result->num_rows > 0) {
        $rowcount = 0;
        echo "   <col width=5%><col width=20%> <col width=30%> <thead class=thead-dark ><tr>       <th style=text-align:left >SI NO.</th>
                                            <th class=nr  style=text-align:center scope=col>User Name</th>
                                            <th style=text-align:center scope=col>Name</th>
                                            <th style=text-align:center scope=col>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
        while ($row = $result->fetch_assoc()) {
            $rowcount++;
            echo "<tr><td style=text-align:left>" . $rowcount . "</td><td  style=text-align:center>" . $row["username"] . "</td>"
            . "<td style=text-align:center>" . $row["name"] . "</td>";
            echo "<td style=text-align:center>";
            ?>
            `<form  method="post" action="">    
                <input  style="display: none" value="<?php echo $row['username']; ?>" name="denyuser" id ="denyuser">
                <button  name='denyAccess' id="denyAccess" type='submit' class="btn btn-danger mb-2">Deny Access</button>
            </form>
            <?php
            echo "</td></tr>";
        }
        echo "</tbody>";
    } else {
    echo "<div class=alert alert-success>"
    . "<strong style=color:red;>No Users Found!</strong> "
    . "<a href=# class=clos data-dismiss=alert>&times;</a>"
    . "</div>";}
    unset($_SESSION['accessUsers']);
} else {
    if (isset($_SESSION['employeeName']) && ($_SESSION['employeeName']) != '') { 
        $username = $_SESSION['employeeName'];
    } else
        $username = '';

    if ($username == '')
        $sql = " SELECT username, CONCAT(first_name,' ',last_name) name from users WHERE (employee =1 )AND is_deleted = 0 ORDER BY name,username ASC";
    else
        $sql = " SELECT username, CONCAT(first_name,' ',last_name) name from users WHERE( username LIKE '$username%' "
                . "OR first_name LIKE '$username%' OR last_name LIKE '$username%') "
                . " AND (admin = 1 OR employee =1) AND is_deleted = 0 ORDER BY name,username ASC";

//echo $sql;
    $result = $conn->query($sql);


    if ($result->num_rows > 0) {
        $rowcount = 0;


        echo "   <col width=10%><col width=20%> <col width=50%> <col width=30%> <thead class=thead-dark ><tr>       <th style=text-align:left >SI NO.</th>
                                            <th class=nr  style=text-align:center scope=col>User Name</th>
                                            <th style=text-align:center scope=col>Name</th>
                                            <th style=text-align:center scope=col>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>";

        while ($row = $result->fetch_assoc()) {
            $rowcount++;
            $user[$rowcount] = $row['username'];

            echo "<tr><td style=text-align:left>" . $rowcount . "</td><td  style=text-align:center>" . $row["username"] . "</td>"
            . "<td style=text-align:center>" . $row["name"] . "</td>";

            $query = "select * from wps_users WHERE username = '$row[username]'";
//        echo $query;
            $exec = $conn->query($query);
            if ($exec->num_rows > 0) {
                echo "<td style=text-align:center>";
                ?>
                `<form  method="post" action="">    
                    <input  style="display: none" value="<?php echo $row['username']; ?>" name="denyuser" id ="denyuser">
                    <button  name='denyAccess' id="denyAccess" type='submit' class="btn btn-danger mb-2">Deny Access</button>
                </form>
                <?php
                echo "</td></tr>";
            } else {
                echo "<td style=text-align:center>";
                ?> 
                <form method="post"  action ="">
                    <input  style="display: none" value="<?php echo $row['username']; ?>" name="user" id ="user">
                    <button name='grantAccess' type="submit"  id="grantAccess"   class="btn btn-success mb-2"> Grant Access</button>
                </form>
                <?php
                echo "</td></tr>";
            }
        }



        echo "</tbody>";
    } else {

        echo "<div class=alert alert-success>"
        . "<strong style=color:red;>No Users Found!</strong> "
        . "<a href=# class=clos data-dismiss=alert>&times;</a>"
        . "</div>";
    }

    $_SESSION['employeeName'] = '';
}
$conn->close();
?>
