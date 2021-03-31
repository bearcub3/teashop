<?php # DISPLAY COMPLETE PRODUCTS PAGE.

# Access session.
session_start() ;

# Set display header section.
include ( 'includes/header.php' ) ; 

# Open database connection.
require ( 'connect_db.php' ) ;

$category = $_REQUEST['category'];

// category
echo "<div class=\"mt-5 mb-3\">Home > <b>" .$category. " </b></div>";

$query = "SELECT * FROM shop WHERE item_category='$category'";
$r = mysqli_query($dbc, $query);

echo '<div class="row">';
include ('includes/thumbnail.php');
echo '</div>';

// Check connection
if ($dbc->connect_error) {
    die("Connection failed: " . $dbc->connect_error);
}

include ( 'includes/footer.html' ) ;

echo '<script src="js/submitForm.js"></script>';
echo '<script src="js/noResubmission.js"></script>';
?>

