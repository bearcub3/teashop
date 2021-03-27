<?php
# Access session.
session_start() ;

# Redirect if not logged in.
if ( !isset( $_SESSION[ 'user_id' ] ) ) { require ( 'login_tools.php' ) ; load() ; }

# Set page title and display header section.
$page_title = 'Shop' ;
include ( 'includes/header.html' ) ; 

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

# Retrieve items from 'shop' database table.
if (isset($_REQUEST['product_id']))
{
    $id = $_REQUEST['product_id'];
    $user_id = $_SESSION[ 'user_id' ];

    $query = "SELECT * FROM shop WHERE item_id=$id";
    $result = mysqli_query($dbc, $query);

    $ratedByQuery = "SELECT rate FROM product_rates WHERE item_id=$id AND rated_by=$user_id";
    $ratedByResult = mysqli_query($dbc, $ratedByQuery);
    $hasUserRated = $ratedByResult -> fetch_assoc();

    $rated = $hasUserRated['rate'];
    
    echo '<div class="row">';
    if ($result)
    {
        while ($row = mysqli_fetch_assoc($result))
        {
            $image1 = $row['item_img1'];
            $image2 = $row['item_img2'];
            $name = $row['item_name'];
            $price = $row['item_price'];
            $desc = $row['item_desc'];
            $spec = $row['item_spec'];
            $hasOption = $row['options_id'];

            // category
            echo "<div class=\"mt-5 mb-3\">Home > Teacups > " .$name. "</div>";

            // column for images
            echo "<div class=\"col-12 col-sm-6 mb-5\">";
            echo "<div class=\"row\"><img class=\"border image-view rounded rounded-2\" alt=\"$name\" src=\"$image1\" width=\"100%\" height=\"100%\" /></div>";
            echo "<div class=\"row mt-2\">
                    <ul class=\"product-img-list list-group list-group-horizontal list-unstyled w-100 ms-1\">
                        <li class=\"w-25\"><a href=\"#\" class=\"image-btn\"><div><img alt=\"$name\" src=\"$image1\" width=\"100%\" height=\"100%\" /></div></a></li>";
            if ($image2) echo "<li class=\"w-25 ms-2\"><a href=\"#\" class=\"image-btn\"><div><img alt=\"$name\" src=\"$image2\" width=\"100%\" height=\"100%\" /></div></a></li>";
            
            echo '</ul></div></div>';

            // column for item's detail
            echo "<div class=\"col-12 col-sm-6 mb-5\">";
            echo "<h2 class=\"fs-1 fw-bold\">$name</h2><hr />";
            echo "<p class=\"fs-1\">£ $price </p>";

            // user rating
            echo "<div class=\"d-flex flex-row justify-content-start align-items-center\">
                    <div>Your Rates : </div>
                    <div>&nbsp;";
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
                        </select>&nbsp;<input class="btn btn-secondary btn-sm" type="submit" value="Submit"></form>';
            } else {
                for ($x = 0; $x < $rated; $x++)
                {
                    echo '<i class="bi bi-star-fill text-warning fs-5"></i>';
                }  
            }

            echo "</div></div>";

            // product rates
            include ('rates.php');
            
            if ($hasOption != 0)
            {
                $query = "SELECT * FROM shop WHERE options_id=$hasOption";
                $options = mysqli_query($dbc, $query);

                echo "<div class=\"d-flex flex-row justify-content-start align-items-center\">
                        <div><p class=\"fw-bold\">Options :</p></div>
                        <div>";

                if ($options)
                {
                    while ($row = mysqli_fetch_assoc($options))
                    {
                        $image1 = $row['item_img1'];
                        $id = $row['item_id'];
                        $name = $row['item_name'];

                        echo "<a href=\"detail.php?product_id=$id\" class=\"mx-1\"><img alt=\"$name\" src=\"$image1\" width=\"70px\" height=\"70px\" /></a>";
                    }
                }
                echo '</div></div>';
            }

            echo "<div class=\"row mt-5 mx-2\"><button type=\"button\" class=\"fw-bold btn btn-primary py-3\">Add to your basket</button></div>";
            echo "<div class=\"row mt-2 mx-2\"><button type=\"button\" class=\"fw-bold btn btn-outline-primary py-3\">&hearts; Add to your wishlist</button></div>";
            echo "</div></div>";

            // start of a new row
            echo "<div class=\"row justify-content-center gx-5 mb-5\">$spec</div>";

            
        }
    }
    echo '</div>';

  # Close database connection.
  mysqli_close( $dbc ) ; 

  // Check connection
  if ($dbc->connect_error) {
      die("Connection failed: " . $dbc->connect_error);
  }
} else { echo '<p>There are currently no item.</p>' ; }

# Display footer section.
include ( 'includes/footer.html' ) ;

?>
