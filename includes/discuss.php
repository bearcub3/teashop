<?php 
# Access session.
session_start() ;

# Open database connection.
require ( 'connect_db.php' ) ;

if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' )
{
    $user_id = $_SESSION[ 'user_id' ];
    $post_id = $_REQUEST[ 'post_id' ];

    // // only a logged in user can do/undo the like discussion.
    if ( $user_id ) 
    {
        $q = "SELECT liked_by, post_id 
                FROM discussion_likes 
                WHERE liked_by=$user_id AND post_id=$post_id";

        $hasUserLiked = mysqli_query($dbc, $q);
        $result = $hasUserLiked -> fetch_assoc();

        if (count($result))
        {
            $cancelLike = "DELETE FROM discussion_likes 
                            WHERE liked_by=$user_id AND post_id=$post_id";
            $row = @mysqli_query ( $dbc, $cancelLike ) ;
        } elseif(count($result) == 0) {
            $like = "INSERT INTO discussion_likes (liked, liked_by, post_id)
                        VALUES (1, $user_id, $post_id)";
            $row = @mysqli_query ( $dbc, $like ) ;
        }

    } else {
        echo '<script>alert(\'Please login first\')</script>';
    }
}

if (isset($_REQUEST['product_id']))
{
    $id = $_REQUEST['product_id'];
    $query = "SELECT f.post_id, f.first_name, f.subject, f.message, f.post_date, COUNT(liked_by) AS total_likes 
                FROM forum f
                JOIN discussion_likes d
                ON f.post_id = d.post_id
                WHERE f.item_id=$id
                GROUP BY f.post_id, f.first_name, f.subject, f.message, f.post_date";
    $result = mysqli_query($dbc, $query);

    // This is to show whether a user liked a discussion or not by the colour of heart icons. 
    // only logged in user will be able to see it. 
    if ($_SESSION[ 'user_id' ])
    {
        $user_id = $_SESSION[ 'user_id' ];
        $hasUserLikedQuery = "SELECT d.post_id 
                                FROM discussion_likes d
                                JOIN forum f
                                ON f.post_id = d.post_id
                                WHERE liked_by=$user_id";
        $hasUserLikedResult = mysqli_query($dbc, $hasUserLikedQuery);

        if ($hasUserLikedResult)
        {
            $postLikedByUser = $hasUserLikedResult -> fetch_assoc();
        }
    }

    if (mysqli_num_rows( $result ) > 0)
    {
        while ($row = mysqli_fetch_assoc($result))
        {
            $post_id = $row['post_id'];
            $name = $row['first_name'];
            $subject = $row['subject'];
            $message = $row['message'];
            $date = $row['post_date'];
            $total_likes = $row['total_likes'];

            echo "
                <div class=\"d-flex flex-row justify-content-start align-items-center bg-light\">
                    <div class=\"col-6 col-sm-3\"><p class=\"fw-bold mx-3 my-3\">$name</p></div>
                    <div class=\"col-6 col-sm-9\"><p class=\"fw-light mx-3 my-3 text-end\">$date</p></div>
                </div>
                <div class=\"d-flex flex-row justify-content-start align-items-center bg-light\">
                    <div class=\"col-9 ms-3 my-3\"><p>$subject</p></div>
                    <div class=\"col-2 my-3 d-flex flex-row justify-content-end\">
                        <form action=\"$PHP_SELF#discussion\" method=\"POST\">
                            <input type=\"hidden\" value=\"$post_id\" name=\"post_id\">
                            <button type=\"submit\" class=\"liking\">";

                            if ($user_id)
                            {
                                if ($postLikedByUser['post_id'] == $post_id)
                                {
                                    echo "<i class=\"bi bi-heart-fill text-danger\"></i>";
                                } else {
                                    echo "<i class=\"bi bi-heart text-danger\"></i>";
                                }
                            } else {
                                echo "<i class=\"bi bi-heart text-danger\"></i>";
                            }

            echo "          </button>
                        </form>
                    <div class=\"ms-2\">
                        <p class=\"fw-light\">$total_likes</p>
                    </div>
                </div>    
            </div>
            <hr class=\"my-0\" />";
        }
    } else {
        echo "
            <div>
                <p>There is no discussion for this item yet.</p>
            </div>";
    }
} else { echo '<p>There are currently no item.</p>' ; }
?>