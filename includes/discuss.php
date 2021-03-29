<?php 

if (isset($_REQUEST['product_id']))
{
    $id = $_REQUEST['product_id'];
    $query = "SELECT * FROM forum WHERE item_id=$id";
    $result = mysqli_query($dbc, $query);

    if (mysqli_num_rows( $result ) > 0)
    {
        while ($row = mysqli_fetch_assoc($result))
        {
            $name = $row['first_name'];
            $subject = $row['subject'];
            $message = $row['message'];
            $date = $row['post_date'];

            echo "
                <div class=\"d-flex flex-row justify-content-start align-items-center bg-light\">
                    <div class=\"col-6 col-sm-3\"><p class=\"fw-bold mx-3 my-3\">$name</p></div>
                    <div class=\"col-6 col-sm-9\"><p class=\"fw-light mx-3 my-3 text-end\">$date</p></div>
                </div>
                <div class=\"d-flex flex-row justify-content-start align-items-center bg-light\">
                    <div class=\"mx-3 my-3\"><p>$subject</p></div>    
                </div>
                <hr class=\"my-0\" />";
        }
    } else {
        echo "
            <div>
                <p>There is no discussion for this item yet.</p>
            </div>";
    }

    mysqli_close( $dbc ) ;

    // Check connection
    if ($dbc->connect_error) {
        die("Connection failed: " . $dbc->connect_error);
    }
} else { echo '<p>There are currently no item.</p>' ; }

?>