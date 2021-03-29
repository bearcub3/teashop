<?php 
# Access session.
session_start() ;

# Open database connection.
require ( 'connect_db.php' ) ;

# Retrieve items from 'shop' database table.
$q = "SELECT * FROM shop" ;
$r = mysqli_query( $dbc, $q ) ;
if ( mysqli_num_rows( $r ) > 0 )
{
    $total = $r->num_rows;
    echo "<div class=\"d-flex align-items-center justify-content-between my-3 text-secondary\">
            <h2 class=\"text-dark\">
                <b>$category</b>
            </h2>
            <div>Showing total <b>&nbsp;" . $total . "&nbsp;</b> item(s)</div>
        </div><hr />";

    // product sorting
    require ( 'sort.php' ) ;

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
            echo "<p class=\"text-dark fw-bold text-truncate border-bottom py-2\">$name</p></a>
                <p class=\"text-truncate text-secondary\">$desc</p>
                <p class=\"fs-4\">£ $price</p>
                    <a class=\"btn btn-outline-dark\" href=\"added.php?id=$id\">Add To Cart</a>";
        echo "</div>
            </div>";
    }
} else { 
    echo '<p>There are currently no items in this shop.</p>' ; 
}

mysqli_close( $dbc ) ; 
?>