<?php 
# Access session.
session_start() ;

# Open database connection.
require ( 'connect_db.php' ) ;

if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' )
{
    $user_id = $_SESSION[ 'user_id' ];
    $post_id = $_REQUEST[ 'post_id' ];

    // only a logged in user can do/undo the like discussion.
    if ( $user_id && $_POST[ 'action' ] === 'like' ) 
    {
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
    } else if ( $_POST[ 'action' ] === 'like' && !$user_id ) {
        echo '<script>alert(\'Please login first\')</script>';
    }

    if ( $_POST[ 'action' ] == 'delete')
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
}

if (isset($_REQUEST['product_id']))
{
    $id = $_REQUEST['product_id'];
    $query = "SELECT f.post_id, u.first_name, f.subject, f.message, f.post_date, f.img1_id, f.img2_id, f.img3_id, f.u_id
                FROM forum f
                JOIN users u
                ON u.user_id = f.u_id
                WHERE f.item_id=$id
                GROUP BY f.post_id, u.first_name, f.subject, f.message, f.post_date";
    $result = mysqli_query($dbc, $query);

    if (mysqli_num_rows( $result ) > 0)
    {
        while ($row = mysqli_fetch_assoc($result))
        {
            $post_id = $row['post_id'];
            $name = $row['first_name'];
            $subject = $row['subject'];
            $message = $row['message'];
            $date = $row['post_date'];
            $img1 = $row['img1_id'];
            $img2 = $row['img2_id'];
            $img3 = $row['img3_id'];
            $u_id = $row['u_id'];

            // if there is any likes for a discussion
            $hasLikes = "SELECT COUNT(d.like_id) as total_likes
                            FROM discussion_likes d
                            WHERE d.p_id=$post_id";

            $hasLikesResult = mysqli_query($dbc, $hasLikes);
            $hasLikesNums = $hasLikesResult -> fetch_assoc();
            $total_likes = $hasLikesNums['total_likes'];

            // This is to show whether a user liked a discussion or not by the colour of heart icons. 
            // only logged in user will be able to see it. 
            if ($_SESSION[ 'user_id' ])
            {
                $hasUserLikedQuery = "SELECT d.liked_by, d.p_id, f.post_id
                                        FROM discussion_likes d
                                        JOIN forum f
                                        ON d.p_id = f.post_id
                                        WHERE d.liked_by=$user_id AND d.p_id=$post_id
                                        GROUP BY f.post_id";
                $hasUserLikedResult = mysqli_query($dbc, $hasUserLikedQuery);
            }

            echo "
                <div class=\"d-flex flex-row justify-content-start align-items-center bg-light\">
                    <div class=\"col-6 col-sm-3\"><p class=\"fw-bold mx-3 my-3\">$name</p></div>
                    <div class=\"col-6 col-sm-9\"><p class=\"fw-light mx-3 my-3 text-end\">$date</p></div>
                </div>
                <div class=\"d-flex flex-row justify-content-start align-items-center bg-light\">";



            if($user_id)
            {   
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

                if ($u_id == $user_id)
                {
                    echo "<div class=\"col-sm-1 col-2 my-3 d-flex flex-row align-items-center justify-content-center\">
                            <form method=\"post\">
                                <input type=\"hidden\" value=\"$post_id\" name=\"post_id\">
                                <input type=\"hidden\" value=\"$id\" name=\"item_id\">
                                <input type=\"hidden\" value=\"delete\" name=\"action\">
                                <button type=\"submit\" class=\"deleting\"><i class=\"bi bi-trash\"></i></button>
                            </form>
                        </div>";
                }
            } else {
                echo "<div class=\"col-10 ms-3 my-3\"><p>$subject</p></div>
                    <div class=\"col-2 my-3 d-flex flex-row justify-content-start\">
                        <form action=\"$PHP_SELF#discussion\" method=\"POST\">
                            <input type=\"hidden\" value=\"$post_id\" name=\"post_id\">
                            <input type=\"hidden\" value=\"like\" name=\"action\">
                            <button type=\"submit\" class=\"liking\">
                                <i class=\"bi bi-heart text-danger\"></i>
                            </button>
                        </form>
                        <div class=\"ms-2\">
                            <p class=\"fw-light mb-0\">$total_likes</p>
                        </div></div>";
            }

            echo "
            </div>
            <div class=\"d-flex flex-row justify-content-center align-items-center bg-light\">";
            
            if ($img1 != 0) echo "<ul class=\"list-unstyled d-flex mx-3\">";
            if($img1 != 0)
            {
                $q = "SELECT image_src FROM forum_images WHERE fi_id=$img1";
                $r = mysqli_query($dbc, $q);
                $row = $r -> fetch_assoc();

                $src = $row['image_src'];
                echo "<li><div class=\"ms-2\"><img src=\"$src\" alt=\"customer image\" width=\"100%\" height=\"100%\" /></div></li>";
            } 
            if($img2 != 0) {
                $q = "SELECT image_src FROM forum_images WHERE fi_id=$img2";
                $r = mysqli_query($dbc, $q);
                $row = $r -> fetch_assoc();

                $src = $row['image_src'];
                echo "<li><div class=\"ms-2\"><img src=\"$src\" alt=\"customer image\" width=\"100%\" height=\"100%\" /></div></li>";
            } 
            if($img3 != 0) {
                $q = "SELECT image_src FROM forum_images WHERE fi_id=$img3";
                $r = mysqli_query($dbc, $q);
                $row = $r -> fetch_assoc();

                $src = $row['image_src'];
                echo "<li><div class=\"ms-2\"><img src=\"$src\" alt=\"customer image\" width=\"100%\" height=\"100%\" /></div></li>";
            }
        
            if ($img1 == 0)
            {
                echo "<div class=\"col ms-3 mb-3\">$message</div>
                    </div>
                    <hr class=\"my-0\" />";
            } else {
                echo "      </ul>
                    </div>
                    <div class=\"col bg-light ps-3 pb-3\">
                        $message
                    </div>
                ";
                echo "<hr class=\"my-0\" />";
            }
        }
    } else {
        echo "
            <div class=\"bg-light px-3 py-3\">
                <p class=\"text-center mb-0\">There is no review for this item yet.</p>
            </div>";
    }
} else { echo '<p>There are currently no item.</p>' ; }
?>