<?php # DISPLAY POST MESSAGE FORM.

# Access session.
session_start() ;

# Open database connection.
require ( 'connect_db.php' ) ;

# Redirect if not logged in.
if ( !isset( $_SESSION[ 'user_id' ] ) ) { require ( 'login_tools.php' ) ; load() ; }

# Set display header section.
include ( 'includes/header.php' ) ; 

$pageRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && ($_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0' ||  $_SERVER['HTTP_CACHE_CONTROL'] == 'no-cache'); 

// upload image file
$user_id = $_SESSION[ 'user_id' ];
$target_dir = "uploads/";
$uploadSuceeded = false;
$item_id;

$errors = array();
$fields = ['subject', 'message', 'rates'];

$picture_ids = array();

if($_SERVER[ 'REQUEST_METHOD' ] == 'POST') {
    switch($_POST[ 'action' ]) {
        case 'files':
            $target_file = array();
            $total = count($_FILES['upload']['name']);
            $tmpFilePath;
            $uploadOk = 0;

            for( $i=0 ; $i < $total ; $i++ ) {
                $tmpFilePath = $_FILES['upload']['tmp_name'][$i];
                
                if ($tmpFilePath != ""){
                    $target_file = $target_dir . basename($_FILES["upload"]["name"][$i]);

                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" || $_FILES["upload"]["size"] < 5000000) {
                        echo "<script>alert(\"File(s) is(are) not (an) image(s) or too large.\");</script>";
                        $uploadOk = 0;
                    } else {
                        $uploadOK = 1;
                    }
                }

                if($uploadOK == 1)
                {
                    if(move_uploaded_file($tmpFilePath, $target_file)) {
                        $id = $_POST["item_id"];

                        $q = "INSERT INTO forum_images (image_src, u_id, product_id) 
                                VALUES ('$target_file', '$user_id', '$id')";
                        $r = @mysqli_query ( $dbc, $q ) ;

                        $uploadSuceeded = true;
                    } else {
                        echo "<script>alert(\"Sorry, there was an error uploading your file.\");</script>";
                    }
                }
            }
        break;
        case 'delete':
            $id = $_POST["picture_id"];
            $q = "DELETE FROM forum_images WHERE fi_id=$id";
            $r = @mysqli_query ( $dbc, $q ) ;
        break;
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
            $item_id = $_REQUEST['item'];

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

                $redirect = "detail.php?product_id=$item_id#discussion";

                header("Location:". $redirect);
                mysqli_close($dbc);
                exit();
            }
        break;
    }
}


# Display body section.
echo '<h2>Your Review</h2>';
echo '<div class="row">';

if (isset($_REQUEST['item']))
{
    $id = $_REQUEST['item'];
    $query = "SELECT item_category, item_name, item_img1 FROM shop WHERE item_id=$id";
    $result = mysqli_query($dbc, $query);
    $total_rate;

    if ($result)
    {
        while ($row = mysqli_fetch_assoc($result))
        {
            $category = $row['item_category'];
            $item_name = $row['item_name'];
            $image1 = $row['item_img1'];

            echo "  <div class=\"d-flex justify-content-center col-md-6\">
                        <div class=\"col-4 bg-light py-3 text-center border-bottom\">Product Image</div>
                        <div class=\"col-8 py-3 fw-bold border-bottom\">
                            <img alt=\"$name\" src=\"$image1\" width=\"100%\" height=\"100%\" />
                        </div> 
                    </div>
                    <div class=\"col-md-6\">
                        <div class=\"d-flex\">
                            <div class=\"col-4 bg-light py-3 text-center border-bottom\">Product Category</div>
                            <div class=\"col-8 py-3 ps-2 fw-bold border-bottom\">$category</div> 
                        </div>
                        <div class=\"d-flex\">
                            <div class=\"col-4 bg-light py-3 text-center border-bottom\">Product Item</div>
                            <div class=\"col-8 py-3 ps-2 fw-bold border-bottom\">$item_name</div>
                        </div>";
            echo "              
                        <div class=\"d-flex\">
                            <div class=\"col-4 bg-light py-3 text-center border-bottom\">Upload Images</div>
                            <div class=\"col-8 py-3 ps-2 fw-bold border-bottom\">
                                <form method=\"post\" enctype=\"multipart/form-data\" class=\"d-flex flex-row\">
                                    <input type=\"hidden\" name=\"action\" value=\"files\">
                                    <input type=\"hidden\" name=\"item_id\" value=\"$id\">
                                    <input type=\"file\" name=\"upload[]\" id=\"upload\" class=\"border\" multiple />
                                    <input type=\"submit\" value=\"upload\" name=\"submit\" class=\"btn btn-outline-dark btn-sm\" />
                                </form>";

                                if($uploadSuceeded || $pageRefreshed)
                                {
                                    echo "<div class=\"d-flex flex-row my-1\">";
                                    $query = "SELECT fi_id, image_src FROM forum_images WHERE product_id=$id AND u_id=$user_id";
                                    $result = mysqli_query($dbc, $query);
                                    if ($result)
                                    {
                                        while ($row = mysqli_fetch_assoc($result))
                                        {
                                            $picture_id = $row['fi_id'];
                                            $picture_ids[] = $picture_id;

                                            $uploaded_image = $row['image_src'];

                                            echo "<div class=\"d-flex mx-1 uploaded_img\">
                                                    <form method=\"post\" id=\"delete-image\">
                                                        <input type=\"hidden\" name=\"action\" value=\"delete\">
                                                        <input type=\"hidden\" name=\"picture_id\" value=\"$picture_id\">
                                                        <a href=\"#\" class=\"remove-image position-relative\">
                                                            <i class=\"bi text-white-50 position-absolute top-0 end-0\"></i>
                                                            <img src=\"$uploaded_image\" width=\"100%\" height=\"100%\" />
                                                        </a>
                                                    </form>
                                                </div>";
                                        }
                                    }
                                    echo '</div>';
                                }

            echo "          </div>
                        </div>
                    </div>";
        }
    }
}
?>
    <form method="post">
        <input type="hidden" name="action" value="forum-submit">
        <div class="d-flex align-items-center">
            <label for="subject" class="col-sm-2 col-4 bg-light py-3 text-center border-bottom">Subject</label>
            <div class="border-bottom col-sm-10 col-8 py-3 ps-2" style="margin-top: -10px;">
                <input name="subject" id="subject" type="text" maxlength="100" value="<?php if (isset($_POST['subject'])) echo $_POST['subject']; ?>" style="margin-top:5px;width: 70%">
            </div>
        </div>
        <div class="d-flex d-flex align-items-center bg-light border-bottom">
            <div class="col-sm-2 col-4 text-center">
                <label for="message">Message</label>
            </div>
            <div class="col-sm-10 col-8 py-3 ps-2 bg-white">
                <textarea class="col-8" name="message" id="message" rows="10" cols="50" value="<?php if (isset($_POST['message'])) echo $_POST['message']; ?>"></textarea>
            </div>
        </div>
        <div class="d-flex d-flex align-items-center bg-light border-bottom">
            <div class="col-sm-2 col-4 text-center">
                <label for="rate">Rate The Item</label>
            </div>
            <div class="col-sm-10 col-8 py-2 ps-2 bg-white" role="radiogroup" aria-label="">
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
            <input class="" type="submit" value="Submit" class="btn btn-dark">
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