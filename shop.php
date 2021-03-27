<?php # DISPLAY COMPLETE PRODUCTS PAGE.

# Access session.
session_start() ;

# Redirect if not logged in.
if ( !isset( $_SESSION[ 'user_id' ] ) ) { require ( 'login_tools.php' ) ; load() ; }

# Set page title and display header section.
$page_title = 'Shop' ;
include ( 'includes/header.html' ) ; 

# Open database connection.
require ( 'connect_db.php' ) ;

# Retrieve items from 'shop' database table.
$q = "SELECT * FROM shop" ;
$r = mysqli_query( $dbc, $q ) ;
if ( mysqli_num_rows( $r ) > 0 )
{
  # Display body section.
  echo '<div class="row">';
  while ( $row = mysqli_fetch_array( $r, MYSQLI_ASSOC ))
  {
    $id = $row['item_id'];
    $image = $row['item_img1'];
    $name = $row['item_name'];
    $desc = $row['item_desc'];
    $price = $row['item_price'];

    echo '<div class="col-6 col-md-3 mb-5">
            <div class="d-flex flex-column mx-2">
              <div class="thumbnail-img mb-3">';
            echo "<a href=\"detail.php?product_id=$id\">";
              echo "<img src=\"$image\" width=\"100%\" height=\"100%\">";
            echo "</a>";
          echo "</div>";
        echo "<a href=\"detail.php?product_id=$id\">";
          echo "<p class=\"text-truncate border-bottom py-2\">$name</p></a>
                <p class=\"text-truncate text-secondary\">$desc</p>
                <p class=\"fs-4\">£ $price</p>
                  <a class=\"btn btn-outline-primary\" href=\"added.php?id=$id\">Add To Cart</a>";
      echo "</div>
          </div>";
  }
  echo '</div>';
  
  # Close database connection.
  mysqli_close( $dbc ) ; 
}
# Or display message.
else { echo '<p>There are currently no items in this shop.</p>' ; }

# Display footer section.
include ( 'includes/footer.html' ) ;

?>