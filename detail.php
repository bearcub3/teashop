<?php
# Access session.
session_start() ;

# Set page title and display header section.
$page_title = 'Shop' ;
include ( 'includes/header.php' ) ; 

# Open database connection.
require ( 'connect_db.php' ) ;

if($_SERVER[ 'REQUEST_METHOD' ] == 'POST')
{
    $price = $_POST[ 'price' ];
    $p_id = $_REQUEST['product_id'];

    if ( isset( $_SESSION['cart'][$p_id] ) )
    { 
        $_SESSION['cart'][$p_id]['quantity']++; 
    } else {
        $_SESSION['cart'][$p_id] = array ( 'quantity' => 1, 'price' => $price ) ;
    }
}

# Retrieve items from 'shop' database table.
if (isset($_REQUEST['product_id']))
{
    $id = $_REQUEST['product_id'];
    $query = "SELECT * FROM shop WHERE item_id=$id";
    $result = mysqli_query($dbc, $query);

    if($_SESSION[ 'user_id' ])
    {
        $user_id = $_SESSION[ 'user_id' ];
        $writtenQuery = "SELECT COUNT(*) AS written
                            FROM forum
                            WHERE u_id=$user_id AND item_id=$id";
        $writtenResult = mysqli_query($dbc, $writtenQuery);
        $hasWritten = $writtenResult -> fetch_assoc();
    }

    echo '<div class="row mx-2">';

    if ($result)
    {
        while ($row = mysqli_fetch_assoc($result))
        {
            $item_id = $row['item_id'];
            $image1 = $row['item_img1'];
            $image2 = $row['item_img2'];
            $name = $row['item_name'];
            $price = $row['item_price'];
            $desc = $row['item_desc'];
            $spec = $row['item_spec'];
            $hasOption = $row['options_id'];
            $category = $row['item_category'];

            // category
            echo "<div class=\"mt-5 mb-3\"><a class=\"text-dark\" href=\"home.php\">Home</a> > <a class=\"text-dark\" href=\"category.php?category=$category\">" .$category. "</a> > <b>" .$name. "</b></div>";

            // column for images
            echo "<div class=\"col-12 col-sm-6 mb-5 gx-5\">";
            echo "<div class=\"row\"><img class=\"border image-view rounded rounded-2\" alt=\"$name\" src=\"$image1\" width=\"100%\" height=\"100%\" /></div>";
            echo "<div class=\"row mt-2\">
                    <ul class=\"product-img-list list-group list-group-horizontal list-unstyled w-100 ms-1\">
                        <li class=\"w-25\"><a href=\"#\" class=\"image-btn\"><div><img alt=\"$name\" src=\"$image1\" width=\"100%\" height=\"100%\" /></div></a></li>";
            if ($image2) echo "<li class=\"w-25 ms-2\"><a href=\"#\" class=\"image-btn\"><div><img alt=\"$name\" src=\"$image2\" width=\"100%\" height=\"100%\" /></div></a></li>";
            
            echo '</ul></div></div>';

            // column for item's detail
            echo "<div class=\"col-12 col-sm-6 mb-5 gx-5\">";
            echo "<h2 class=\"font fs-1 fw-bold\">$name</h2><hr />";
            echo "<p class=\"fs-1\">£ $price</p>";

            // total rates
            include ( 'rate_result.php' );
            
            // product options
            include ( 'options.php' );

            echo "<div class=\"mb-3 d-flex flex-row justify-content-center\">
                    <form method=\"post\" style=\"width: 100%;\">
                        <input type=\"hidden\" name=\"price\" value=\"$price\" />
                        <input style=\"width: 100%;\" type=\"submit\" class=\"fw-bold btn btn-outline-dark btn-sm py-3 add-basket\" value=\"Add to your basket\" />
                    </form>
                </div>";

            if ( isset( $_SESSION['cart'][$item_id] ) )
            { 
                $quantity = $_SESSION['cart'][$item_id]['quantity'];

                echo "<div class=\"col-12 border rounded\">
                        <div class=\"p-3\">
                            <p><i class=\"fs-5 bi bi-bag-check me-2\"></i>The item is added to your cart.</p>
                            <p>$quantity of $name</p>
                        </div>
                        <div class=\"mb-3 d-flex flex-row justify-content-center\">
                            <a class=\"btn btn-outline-dark\" href=\"cart.php\">Go to your cart</a>
                        </div>
                      </div>";
            }
            echo "</div>";

            // start of a new row
            echo "<div class=\"col-12 mb-5 gx-5\">$spec</div>";

            // discussion
            echo "<div class=\"col-12 mb-5 gx-5\">
                    <div class=\"d-flex flex-row justify-content-between\">
                        <h4 id=\"discussion\">Customer Review</h4>
                    </div>";
            

                        
            echo "<div class=\"d-flex flex-row justify-content-between mb-3\">
                    <div>Remember, One review per an ID is only allowed.</div>";

            if ( !isset( $_SESSION[ 'user_id' ] ) ) 
            {
                echo "<a href=\"login.php?product_id=$item_id\" class=\"btn btn-dark\">Login to review</a>";
            } else {
                print_r($hasWritten);

                if($hasWritten['written'] == 0)
                {   
                    echo "<a href=\"post.php?item=$item_id\" class=\"btn btn-dark\">Write a review</a>";
                }
            }

            echo "</div>";
            include('includes/discuss.php');
            
            echo "</div>";
        }
    }
    echo '</div></div>';

  # Close database connection.
  mysqli_close( $dbc ) ;

  // Check connection
  if ($dbc->connect_error) {
      die("Connection failed: " . $dbc->connect_error);
  }
} else { echo '<p>There are currently no item.</p>' ; }

# Display footer section.
include ( 'includes/footer.html' ) ;
echo '<script src="js/imageView.js"></script>';
echo '<script src="js/liking.js"></script>';
echo '<script src="js/noResubmission.js"></script>';
?>
