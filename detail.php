<?php
# Access session.
session_start() ;

include ( 'includes/header.php' ) ; 

# Open database connection.
require ( 'connect_db.php' ) ;

$user_id = $_SESSION[ 'user_id' ];

if($_SERVER[ 'REQUEST_METHOD' ] == 'POST')
{
    $price = $_POST[ 'price' ];
    $p_id = $_REQUEST['product_id'];

    if ( isset( $_SESSION['cart'][$p_id] ) && $price )
    { 
        $_SESSION['cart'][$p_id]['quantity']++; 
    } else {
        $_SESSION['cart'][$p_id] = array ( 'quantity' => 1, 'price' => $price ) ;
    }

    $post_id = $_REQUEST[ 'post_id' ];

    if ( $_POST[ 'action' ] == 'delete' )
    {
        $product_id = $_POST[ 'item_id' ];

        $deletePost = "DELETE FROM forum WHERE post_id=$post_id";
        $r = mysqli_query($dbc, $deletePost);

        $deleteImages = "DELETE FROM forum_images WHERE u_id=$user_id AND product_id=$product_id";
        $r = mysqli_query($dbc, $deleteImages);

        $deleteLikes = "DELETE FROM discussion_likes WHERE p_id=$post_id";
        $r = mysqli_query($dbc, $deleteLikes);

        $deleteRate = "DELETE FROM product_rates WHERE item_id=$product_id AND rated_by=$user_id";
        $r = mysqli_query($dbc, $deleteRate);
    }

    // only a logged in user can do/undo the like discussion.
    if ( $user_id && $_POST[ 'action' ] === 'like' ) {
        $q = "SELECT liked_by, p_id 
                FROM discussion_likes 
                WHERE liked_by=$user_id AND p_id=$post_id";

        $hasUserLiked = mysqli_query($dbc, $q);
        $result = $hasUserLiked -> fetch_assoc();

        if (count($result))
        {
            $cancelLike = "DELETE FROM discussion_likes 
                            WHERE liked_by=$user_id AND p_id=$post_id";
            $row = @mysqli_query ( $dbc, $cancelLike ) ;
        } else {
            $like = "INSERT INTO discussion_likes (liked_by, p_id)
                        VALUES ($user_id, $post_id)";
            $row = @mysqli_query ( $dbc, $like ) ;
        }
    }
}

# Retrieve items from 'shop' database table.
if (isset($_REQUEST['product_id']))
{
    $id = $_REQUEST['product_id'];
    $query = "SELECT * FROM shop WHERE item_id=$id";
    $result = mysqli_query($dbc, $query);

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

            if ( isset( $_SESSION['cart'][$item_id] ) ) { 
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

            // Review
            echo "<div class=\"col-12 mb-5 gx-5\">
                    <div class=\"d-flex flex-row justify-content-between\">
                        <h4 id=\"discussion\">Customer Review</h4>
                    </div>";
            
            echo "<div class=\"d-flex flex-row justify-content-between mb-3\">
                    <div>Remember, One review per an ID is only allowed.</div>"; 

            $id = $_REQUEST['product_id'];

            if ( !$user_id ) 
            {
                echo "<a href=\"login.php?product_id=$item_id\" class=\"btn btn-outline-dark\">Login to review</a>";
            } else {
                // to check weather users have written forum or not
                $writtenQuery = "SELECT COUNT(*) AS written
                                    FROM forum
                                    WHERE u_id=$user_id AND item_id=$id";
                $writtenResult = mysqli_query($dbc, $writtenQuery);
                $hasWritten = $writtenResult -> fetch_assoc();

                if($hasWritten['written'] == 0) echo "<a href=\"post.php?item=$item_id\" class=\"btn btn-outline-dark\">Write a review</a>";
            }

            echo "</div>";

            // for product reviews
            $forumQuery = "SELECT f.post_id, u.first_name, f.subject, f.message, f.post_date, f.img1_id, f.img2_id, f.img3_id, f.u_id
                            FROM forum f
                            JOIN users u
                            ON u.user_id = f.u_id
                            WHERE f.item_id=$id
                            GROUP BY f.post_id, u.first_name, f.subject, f.message, f.post_date";
            $forumResult = mysqli_query($dbc, $forumQuery);

            if (mysqli_num_rows( $forumResult ) > 0) {
                while ($row = mysqli_fetch_assoc($forumResult)) {

                    $post_id = $row['post_id'];
                    $name = $row['first_name'];
                    $subject = $row['subject'];
                    $message = $row['message'];
                    $date = $row['post_date'];
                    $img1 = $row['img1_id'];
                    $img2 = $row['img2_id'];
                    $img3 = $row['img3_id'];
                    $u_id = $row['u_id'];

                    echo "
                        <div class=\"d-flex flex-row justify-content-start align-items-center bg-light\">
                            <div class=\"col-6 col-sm-3\"><p class=\"fw-bold mx-3 my-3\">$name</p></div>
                            <div class=\"col-6 col-sm-9\"><p class=\"fw-light mx-3 my-3 text-end\">$date</p></div>
                        </div>
                        <div class=\"d-flex flex-row justify-content-start align-items-center bg-light\">";

                    // include ( 'includes/authenticated_discussion.php' );
                    // if there is any likes for a discussion
                    $hasLikes = "SELECT COUNT(d.like_id) as total_likes
                    FROM discussion_likes d
                    WHERE d.p_id=$post_id";

                    $hasLikesResult = mysqli_query($dbc, $hasLikes);
                    $hasLikesNums = $hasLikesResult -> fetch_assoc();
                    $total_likes = $hasLikesNums['total_likes'];
                    // This is to show whether a user liked a discussion or not by the colour of heart icons. 
                    // only logged in user will be able to see it. 
                    if ($user_id) {
                        $hasUserLikedQuery = "SELECT d.liked_by, d.p_id, f.post_id
                                                FROM discussion_likes d
                                                JOIN forum f
                                                ON d.p_id = f.post_id
                                                WHERE d.liked_by=$user_id AND d.p_id=$post_id
                                                GROUP BY f.post_id";
                        $hasUserLikedResult = mysqli_query($dbc, $hasUserLikedQuery);

                        echo "<div class=\"col-sm-10 col-8 ps-3 my-3\"><p>$subject</p></div>
                            <div class=\"col-sm-1 col-2 my-3 d-flex flex-row justify-content-end\">
                                <form action=\"$PHP_SELF#discussion\" method=\"POST\">
                                    <input type=\"hidden\" value=\"$post_id\" name=\"post_id\">
                                    <input type=\"hidden\" value=\"like\" name=\"action\">
                                    <button type=\"submit\" class=\"liking\">";
                        
                        $row = $hasUserLikedResult -> fetch_assoc();

                        if ($row['liked_by'] == $user_id)
                        {
                            echo "<i class=\"bi bi-heart-fill text-danger\"></i>";
                        } else {
                            echo "<i class=\"bi bi-heart text-danger\"></i>";
                        }

                        echo "      </button>
                                </form>
                            <div class=\"ms-2\">
                                <p class=\"fw-light mb-0\">$total_likes</p>
                            </div>
                        </div>";

                    } else {
                        // only for unauthenticated users
                        echo "<div class=\"col-10 ms-3 my-3\"><p>$subject</p></div>
                                <div class=\"col-2 my-3 d-flex flex-row justify-content-start\">
                                    <form action=\"#discussion\" method=\"POST\">
                                        <input type=\"hidden\" value=\"$post_id\" name=\"post_id\">
                                        <input type=\"hidden\" value=\"like\" name=\"action\">
                                        <button type=\"button\" class=\"liking\" data-bs-toggle=\"modal\" data-bs-target=\"#exampleModal\">
                                            <i class=\"bi bi-heart text-danger\"></i>
                                        </button>
                                    </form>
                                <div class=\"ms-2\">
                                    <p class=\"fw-light mb-0\">$total_likes</p>
                                </div></div>
                        
                            <div class=\"modal fade\" id=\"exampleModal\" tabindex=\"-1\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\"> 
                                <div class=\"modal-dialog modal-dialog-centered\">
                                    <div class=\"modal-content\">
                                    <div class=\"modal-header\">
                                        <h5 class=\"modal-title\" id=\"exampleModalLabel\">An unauthenticated user</h5>
                                        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>
                                    </div>
                                    <div class=\"modal-body\">
                                        <p>Please log in first.</p>
                                    </div>
                                    <div class=\"modal-footer\">
                                        <button type=\"button\" class=\"btn btn-dark\" data-bs-dismiss=\"modal\">Close</button>
                                    </div>
                                    </div>
                                </div>
                            </div>";
                    }

                    // Reviews only can be deleted by its authenticated writer.
                    if ($u_id == $user_id)
                    {
                        echo "<div class=\"col-sm-1 col-2 my-3 d-flex flex-row align-items-center justify-content-center\">
                                <form method=\"post\">
                                    <input type=\"hidden\" value=\"delete\" name=\"action\">
                                    <input type=\"hidden\" value=\"$post_id\" name=\"post_id\">
                                    <input type=\"hidden\" value=\"$id\" name=\"item_id\">
                                    <button type=\"submit\" class=\"deleting\"><i class=\"bi bi-trash\"></i></button>
                                </form>
                            </div>";
                    }

                    echo "</div>
                        <div class=\"d-flex flex-row justify-content-center align-items-center bg-light\">";

                    if($img1 != 0) {
                        $q = "SELECT image_src FROM forum_images WHERE fi_id=$img1";
                        $r = mysqli_query($dbc, $q);
                        $row = $r -> fetch_assoc();
                        $src = $row['image_src'];

                        echo "<ul class=\"list-unstyled d-flex mx-3\">";
                        echo "<li>
                                <div class=\"ms-2\">
                                    <img src=\"$src\" alt=\"customer image\" width=\"100%\" height=\"100%\" />
                                </div>
                            </li>";
                    } 

                    if($img2 != 0) {
                        $q = "SELECT image_src FROM forum_images WHERE fi_id=$img2";
                        $r = mysqli_query($dbc, $q);
                        $row = $r -> fetch_assoc();
                        $src = $row['image_src'];

                        echo "<li>
                                <div class=\"ms-2\">
                                    <img src=\"$src\" alt=\"customer image\" width=\"100%\" height=\"100%\" />
                                </div>
                            </li>";
                    } 

                    if($img3 != 0) {
                        $q = "SELECT image_src FROM forum_images WHERE fi_id=$img3";
                        $r = mysqli_query($dbc, $q);
                        $row = $r -> fetch_assoc();
                        $src = $row['image_src'];

                        echo "<li>
                                <div class=\"ms-2\">
                                    <img src=\"$src\" alt=\"customer image\" width=\"100%\" height=\"100%\" />
                                </div>
                            </li>";
                    }
                
                    // if users didn't uploade any images
                    if ($img1 == 0)
                    {
                        echo "<div class=\"col ms-3 mb-3\">$message</div>
                            </div>
                            <hr class=\"my-0\" />";
                    } else {
                        // if users uploaded any images
                        echo "
                            </ul>
                        </div>
                        <div class=\"col bg-light ps-3 pb-3\">
                            $message
                        </div>
                        <hr class=\"my-0\" />";
                    }
                }
            } else {
                echo "
                    <div class=\"bg-light px-3 py-3\">
                        <p class=\"text-center mb-0\">There is no review for this item yet.</p>
                    </div>";
            }
            
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
