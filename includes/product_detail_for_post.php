<?php # DISPLAY POST MESSAGE FORM.

# Access session.
session_start() ;

# Open database connection.
require ( 'connect_db.php' ) ;

$pageRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && ($_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0' ||  $_SERVER['HTTP_CACHE_CONTROL'] == 'no-cache'); 

// upload image file
$target_dir = "uploads/";
$uploadSuceeded = false;
$item_id;

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
    }
}

$_SESSION[ 'review_item' ] = $_REQUEST[ 'item' ];
$id = $_REQUEST[ 'item' ];

if($_SESSION[ 'review_item' ] or $id)
{
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