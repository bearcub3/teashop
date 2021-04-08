<?php # DISPLAY COMPLETE PRODUCTS PAGE.
# Access session.
session_start() ;

# Open database connection.
require ( 'connect_db.php' ) ;
# Retrieve items from 'shop' database table.
$query = "SELECT * FROM shop" ;
$r = mysqli_query( $dbc, $query ) ;

# Set display header section.
include ( 'includes/header.php' ) ; 
include ( 'includes/event.php' ) ; 

# Display body section.
echo '<div class="row">';

include ( 'includes/thumbnail.php' ) ; 

echo '</div>';

# Display footer section.
include ( 'includes/footer.html' ) ;

echo '<script src="js/submitForm.js"></script>';
echo '<script src="js/noResubmission.js"></script>';
?>