<?php
    require_once 'start.php';
    if(isLoggedIn() && isAdmin()) {
?>

<!DOCTYPE html>
<html >
<head>
    <title>Request Page</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</head>
<body>
    <table>
            <tr>
                <th>ItemID</th>
                <th>Description</th>
                <th>Date Created</th>
                <th>User Requested</th>
                <th>Status</th>
            </tr>
<!--Output request with description-->
<?php
    require_once ('Database.php');
    require_once ('DatabaseAPI.php');
    $dbAPI = new DatabaseAPI();

    //for loop through for loop, and display all elements
    $requests = $dbAPI->getRequests();

    foreach ($requests as $request){
        $requestID = $request['RequestID'];
        $itemID = $request['ItemID'];
        $desc = $request['Description'];
        $date = $request['DateCreated'];
        $userID = $request['UserID'];
        $user = $userID . " - " . $dbAPI->getUserFirstname($userID)['Firstname'] . " " . $dbAPI->getUserSurname($userID)['Surname'];
        $status = $request['Status'];

        echo "<tr>";
        echo "<td>$itemID</td>";
        echo "<td>$desc</td>";
        echo "<td>$date</td>";
        echo "<td>$user</td>";
        echo "<form action=\"#\" id='status'>";
        echo "<input type=\"hidden\" name='itemID' value='$itemID'/>";
        ?>
            <td>
            <select name="status" id="status" data-id="<?php echo $requestID ?>">
                <option value="Pending" <?php if($status=="Pending") echo "selected=\"selected\""; ?> >Pending</option>
                <option value="Approved" <?php if($status=="Approved") echo "selected=\"selected\""; ?>  >Approved</option>
                <option value="Rejected" <?php if($status=="Rejected") echo "selected=\"selected\""; ?>  >Rejected</option>
            </select>
            </td>
        <?php
        echo "</form>";
        echo "</tr>";
    }
?>
        <script>

            $(function(){

                $("select[name=status]").on('change', function () {

                    var id = $(this).data('id');
                    var value = $(this).find(":selected").text();

                    var data = {
                        request_id: id,
                        value: value
                    };

                    $.ajax({

                        url: "executeRequest.php",
                        type: "post",
                        data: data,
                        success: function(response){
                            console.log(response);
                        },
                        error: function(jqXHR, textStatus, errorThrown){
                            console.log(errorThrown);
                        }

                    });

                });

            });

        </script>

    </table>
    <p ><a href = "admin-home.php" > Go back to home page</a ></p >
</body>
</html>
        <?php
    }else{
        echo "Error: You aren't logged in as an Admin! Redirecting you...";
        header("Location: index.php");
    }