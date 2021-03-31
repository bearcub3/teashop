<?php # DISPLAY POST MESSAGE FORM.

# Access session.
session_start() ;

# Open database connection.
require ( 'connect_db.php' ) ;

# Redirect if not logged in.
if ( !isset( $_SESSION[ 'user_id' ] ) ) { require ( 'login_tools.php' ) ; load() ; }

# Set display header section.
include ( 'includes/header.php' ) ; 

# Display body section.
echo '<div class="row">';
if (isset($_REQUEST['item']))
{
    $id = $_REQUEST['item'];
    $query = "SELECT item_category, item_name, item_img1 FROM shop WHERE item_id=$id";
    $result = mysqli_query($dbc, $query);

    if ($result)
    {
        while ($row = mysqli_fetch_assoc($result))
        {
            $category = $row['item_category'];
            $item_name = $row['item_name'];
            $image1 = $row['item_img1'];

            echo "<div class=\"row mt-2\">
                    <div class=\"d-flex col-sm-4\">
                        <div class=\"col-4 col-md-6 col-sm-5 bg-light py-3 text-center border-bottom\">Product Category</div>
                        <div class=\"col-8 col-md-6 col-sm-7 py-3 fw-bold ps-2 border-bottom\">$category</div> 
                    </div>
                    <div class=\"d-flex align-items-center col-sm-8\">
                        <div class=\"col-4 col-sm-3 bg-light py-3 text-center border-bottom product-height\">Product Item</div>
                        <div class=\"col-8 col-sm-9 py-3 fw-bold ps-2 border-bottom\">$item_name</div>
                    </div>
                    <div class=\"d-flex col-sm-4\">
                        <div class=\"col-4 col-md-6 col-sm-5 bg-light py-3 text-center border-bottom\">Product Image</div>
                        <div class=\"col-8 col-md-6 col-sm-7 py-3 fw-bold ps-2 border-bottom\"><img alt=\"$name\" src=\"$image1\" width=\"100%\" height=\"100%\" /></div> 
                    </div>
                </div>";
        }
    }
}
?>

<form action="post_action.php" method="post" accept-charset="utf-8">
    <div class="row mt-3">
        <label for="subject" class="col-3">Subject</label>
        <input class="col-9" name="subject" id="subject" type="text" size="64" maxlength="100" value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name']; ?>">
    </div>
    <div class="row mt-3">
        <label for="message" class="col-3">Message</label>
        <textarea class="col-9" name="message" id="message" rows="5" cols="50"></textarea>
    </div>
    <div class="row my-3">
     <input class="col-5" name="submit" type="submit" value="Submit">
    </div>
</form>

<?php 
echo '</div>';

// user's rate
// require ( 'rate_item.php' ) ;

# Display footer section.
include ( 'includes/footer.html' ) ;
?>