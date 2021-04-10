<?php # DISPLAY POST MESSAGE FORM.

# Access session.
session_start() ;

# Open database connection.
require ( 'connect_db.php' ) ;

# Redirect if not logged in.
if ( !isset( $_SESSION[ 'user_id' ] ) ) { require ( 'login_tools.php' ) ; load() ; }

# Set display header section.
include ( 'includes/header.php' ) ; 

$errors = array();
$fields = ['subject', 'message', 'rates'];

$user_id = $_SESSION[ 'user_id' ];
$item_id = $_REQUEST[ 'item' ];

if($_SERVER[ 'REQUEST_METHOD' ] == 'POST') {
    switch($_POST[ 'action' ]) {
        case 'forum-submit':
            foreach ($fields as $field) {
                if (empty($_POST[$field])) 
                {
                  $errors[] = $field;
                  mysqli_close( $dbc ); 
                }
            }
            
            $subject = $_POST['subject'];
            $message = $_POST['message'];
            $rate = mysqli_real_escape_string( $dbc, trim( $_POST[ 'rates' ] ) );

            $pic1 = $_POST['picture-0'];
            $pic2 = $_POST['picture-1'];
            $pic3 = $_POST['picture-2'];

            if ( empty( $errors ) ) 
            {
                $forumQuery = "INSERT INTO forum (u_id, subject, message, img1_id, img2_id, img3_id, post_date, item_id) 
                                VALUES ('$user_id', '$subject', '$message', $pic1, $pic2, $pic3, NOW(), '$item_id')";
                $r = @mysqli_query ( $dbc, $forumQuery ) ;

                $rateQuery = "INSERT INTO product_rates (item_id, rate, rated_by) 
                                VALUES ('$item_id', '$rate', '$user_id')";
                $r = @mysqli_query ( $dbc, $rateQuery ) ;

                unset($_SESSION[ 'review_item' ]);

                $redirect = "detail.php?product_id=$item_id#discussion";
                header("Location:". $redirect);
            } 
        break;
    }
}


# Display body section.
echo '<h2>Your Review</h2>';
echo '<div class="row">';

include ( 'includes/product_detail_for_post.php' );

?>
    <form method="post">
        <input type="hidden" name="action" value="forum-submit">
        <div class="d-flex d-flex align-items-center bg-light border-bottom">
            <div class="col-sm-2 col-4 text-center">
                <label for="subject" class="text-center">Subject</label>
            </div>
            <div class="col-sm-10 col-8 py-3 ps-2 bg-white">
                <input name="subject" id="subject" type="text" maxlength="100" value="<?php if (isset($_POST['subject'])) echo $_POST['subject']; ?>" style="margin-top:5px;width: 70%">
                <?php if (in_array('subject', $errors)): ?>
                    <p class="col-9 text-warning mt-2 mb-0"><i class="bi bi-exclamation-diamond text-warning"></i> Subject must be included. Try again.</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="d-flex d-flex align-items-center bg-light border-bottom">
            <div class="col-sm-2 col-4 text-center">
                <label for="message">Message</label>
            </div>
            <div class="col-sm-10 col-8 py-3 ps-2 bg-white">
                <textarea class="col-8" name="message" id="message" rows="10" cols="50" value="<?php if (isset($_POST['message'])) echo $_POST['message']; ?>"></textarea>
                <?php if (in_array('message', $errors)): ?>
                    <p class="col-9 text-warning mt-2 mb-0"><i class="bi bi-exclamation-diamond text-warning"></i> Message must be included. Try again.</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="d-flex d-flex align-items-center bg-light border-bottom">
            <div class="col-sm-2 col-4 text-center">
                <label for="rate">Rate The Item</label>
            </div>
            <div class="col-sm-10 col-8 py-3 ps-2 bg-white">
                <div role="radiogroup" aria-label="">
                    <a href="#" class="rating" role="radio" aria-checked="false" aria-label="rate 1">
                        <i class=" bi bi-star text-warning fs-4" ></i>
                    </a>
                    <a href="#" class="rating" role="radio" aria-checked="false" aria-label="rate 2">
                        <i class="bi bi-star text-warning fs-4"></i>
                    </a>
                    <a href="#" class="rating" role="radio" aria-checked="false" aria-label="rate 3">
                        <i class="bi bi-star text-warning fs-4"></i>
                    </a>
                    <a href="#" class="rating" role="radio" aria-checked="false" aria-label="rate 4">
                        <i class="bi bi-star text-warning fs-4"></i>
                    </a>
                    <a href="#" class="rating" role="radio" aria-checked="false" aria-label="rate 5">
                        <i class="bi bi-star text-warning fs-4"></i>
                    </a>
                </div>
                <input type="hidden" name="rates" value="<?php if (isset($_POST['rates'])) echo $_POST['rates']; ?>" class="rating-value" />
                <?php if (in_array('rates', $errors)): ?>
                    <p class="col-9 text-warning mt-2 mb-0"><i class="bi bi-exclamation-diamond text-warning"></i> Rating must be included. Try again.</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="d-flex justify-content-center my-3">
            <?php 
                if(count($picture_ids) !== 0)
                {
                    foreach($picture_ids as $key=>$value) echo "<input type=\"hidden\" name=\"picture-$key\" value=\"$value\" />";
                    
                    if(count($picture_ids) < 2){
                        echo "<input type=\"hidden\" name=\"picture-1\" value=\"0\" />";
                        echo "<input type=\"hidden\" name=\"picture-2\" value=\"0\" />";
                    } elseif(count($picture_ids) < 3) {
                        echo "<input type=\"hidden\" name=\"picture-2\" value=\"0\" />";
                    }
                } else {
                    echo "<input type=\"hidden\" name=\"picture-0\" value=\"0\" />";
                    echo "<input type=\"hidden\" name=\"picture-1\" value=\"0\" />";
                    echo "<input type=\"hidden\" name=\"picture-2\" value=\"0\" />";
                }
            ?>
            <input type="hidden" value="<?php if (isset($_REQUEST['item'])) echo $_REQUEST['item'] ?>" name="item" />
            <input type="submit" value="Submit" class="btn btn-outline-dark btn-lg" />
        </div>
    </form>
</div>

<?php 
# Display footer section.
include ( 'includes/footer.html' ) ;
echo '<script src="js/rating.js"></script>';
echo '<script src="js/removeImage.js"></script>';
echo '<script src="js/noResubmission.js"></script>';
?>