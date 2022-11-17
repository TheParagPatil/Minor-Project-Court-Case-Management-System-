<?php
    if(isset($_POST["addcase"])){
        $casetype=($_POST["ctype"]);
        $casedetails=($_POST["cdetails"]);
        $case_status="pending";
        require("includes/db.php");
        $con;
        if ($con) {
            $clientid = $_SESSION['client_id'];
            $lawyerid = $_GET['id'];

            $stmt = $con->prepare("INSERT INTO cases(
                case_type, case_details, case_status, lawyer_id_assigned, clientforcase_id)
                VALUES(?, ?, ?, ?, ?)");
            $stmt->bind_param('sssss', $casetype, $casedetails, $case_status, $lawyerid, $clientid);
            $stmt->execute();
            if ($stmt->affected_rows === -1) {
                echo "<script>swal('Error!', 'your case $casetype has not been added!', 'error');</script>";
            } else {
                $stmt->close();
                // echo "Case Added";
                echo "<script>swal('Congratulations!', 'your case $casetype has been added!', 'success');</script>";
                // header("Location: client_dashboard.php?q=currentcase");
            }

        
        }
    }

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2">
            <h1>
                <?php echo $_SESSION["client_name"]; ?>
            </h1>
            <br>
            <ul id="side_menu" class="nav nav-pills nav-stacked">
                <li class="">
                    <a href="client_dashboard.php">
                        <span class="glyphicon glyphicon-user"></span>
                        &nbsp; Profile
                     </a>
                </li>
                <li class="">
                    <a href="client_dashboard.php?q=addcase">
                        <span class="glyphicon glyphicon-list-alt"></span>
                        &nbsp; Add case
                    </a>
                </li>
                <li class="">
                    <a href="client_dashboard.php?q=sendfeedback">
                        <span class="glyphicon glyphicon-comment"></span>
                        &nbsp; Send Feedback
                    </a>
                </li>
                <li class="">
                    <a href="client_dashboard.php?q=currentcase">
                        <span class="glyphicon glyphicon-ok"></span>
                        &nbsp; Current Case Info
                    </a>
                </li>
                <li class="">
                    <a href="client_dashboard.php?q=notifications">
                        <span class="glyphicon glyphicon-bullhorn"></span>
                        &nbsp; Notifications
                    </a>
                </li>
            </ul>
        </div>   <!--div ending of vertical nav -->

        <div class="col-sm-10" style="font-weight: bold; padding-bottom: 30px;">

            <h1>Enter Case details</h1><br>
            <form action='client_dashboard.php?q=addtocase&id=<?php echo $_GET['id']; ?>' method='post'>
                <label for='case-type'>
                    Case Type:
                </label>
                <input type='text' class='form-control'
                placeholder='Case Type' name='ctype' required><br>

                <label for='case-details'>
                    Case Details:
                </label>
                <input type='text' class='form-control'
                placeholder='Case Details' name='cdetails' required><br>

                <button class='btn btn-primary btn-lg btn-block' type='submit' name='addcase'>
                    Add Case
                </button>
            </form>

        </div>
   </div>
</div>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
