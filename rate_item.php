<?php 
# Access session.
session_start() ;

# Open database connection.
require ( 'connect_db.php' ) ;

# User Rate
if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' )
{
    $errors = array();

    $user_id = $_SESSION[ 'user_id' ];
    $userRate = mysqli_real_escape_string( $dbc, trim( $_POST[ 'rates' ] ) );
    $item_id = $_REQUEST['product_id'];

    if ( empty( $errors ) ) 
    {
        $q = "INSERT INTO product_rates (item_id, rate, rated_by) VALUES ('$item_id', '$userRate', '$user_id')";
        $r = @mysqli_query ( $dbc, $q ) ;
    }
}

// user rating
echo "<div class=\"d-flex flex-row justify-content-start align-items-center\">
<div>Your Rates : </div>
<div class=\"d-flex align-self-center\">&nbsp;";

if (isset($_SESSION['user_id']))
{
    $user_id = $_SESSION[ 'user_id' ];
    $hasRatedQuery = "SELECT rate FROM product_rates WHERE item_id=$id AND rated_by=$user_id";
    $hasRatedResult = mysqli_query($dbc, $hasRatedQuery);
    $hasUserRated = $hasRatedResult -> fetch_assoc();
    $rated = $hasUserRated['rate'];

    if (!$rated)
    {
        echo '<form action="" method="post">
            <select name="rates" id="rate-select">
                <option value="">--Please rate this item--</option>
                <option value="5">5</option>
                <option value="4">4</option>
                <option value="3">3</option>
                <option value="2">2</option>
                <option value="1">1</option>
                <option value="0">0</option>
            </select>&nbsp;<input class="btn btn-secondary btn-sm" type="submit" value="Submit">
        </form>';
    } else {
        for ($x = 0; $x < $rated; $x++)
        {
        echo '<i class="bi bi-star-fill text-warning fs-5"></i>';
        }
    }
} else {
    echo '<span>Please, <a href="login.php">Log in</a> before you rate the item.</span>';
}

echo "<hr /></div></div>";
?>