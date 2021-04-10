<?php 
$_SESSION[ 'sort' ] = "";

if($_SERVER[ 'REQUEST_METHOD' ] == 'POST')
{
    if($_POST[ 'action' ] == 'basket')
    {
        $price = $_POST[ 'price' ];
        $p_id = $_POST['id'];
    
        if ( isset( $_SESSION['cart'][$p_id] ) )
        { 
            $_SESSION['cart'][$p_id]['quantity']++; 
        } else {
            $_SESSION['cart'][$p_id] = array ( 'quantity' => 1, 'price' => $price ) ;
        }
    }
}

$total = $r->num_rows;
    
echo "<div class=\"d-flex align-items-center justify-content-between my-3 text-secondary\">
        <h2 class=\"text-dark\">
            <b class=\"font\">$category</b>
        </h2>
        <div>Showing total <b>&nbsp;" . $total . "&nbsp;</b> item(s)</div>
    </div><hr />";

// product sorting
require ( 'sort.php' ) ;

if ( mysqli_num_rows( $r ) > 0 )
{
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
                echo "<div class=\"d-flex flex-row align-items-center font text-dark fs-6 fw-bold border-bottom mb-3\" style=\"height: 80px;\">$name</div></a>
                    <p class=\"text-truncate text-secondary\">$desc</p>
                    <p class=\"fs-4\">£ $price</p>
                    <form method=\"post\" style=\"width: 100%;\">
                        <input type=\"hidden\" name=\"action\" value=\"basket\" />
                        <input type=\"hidden\" name=\"id\" value=\"$id\" />
                        <input type=\"hidden\" name=\"price\" value=\"$price\" />
                        <input style=\"width: 100%;\" type=\"submit\" class=\"fw-bold btn btn-outline-dark btn-sm add-basket\" value=\"Add to your basket\" />
                    </form>";
            echo "</div>
                </div>";
    }
} else { 
    echo '<p>There are currently no items in this shop.</p>' ; 
}

mysqli_close( $dbc ) ; 
?>