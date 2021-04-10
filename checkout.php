<?php # DISPLAY CHECKOUT PAGE.

# Access session.
session_start() ;

# Redirect if not logged in.
if ( !isset( $_SESSION[ 'user_id' ] ) ) { require ( 'login_tools.php' ) ; load() ; }

include ( 'includes/header.php' ) ;

# Check for passed total and cart.
if ( isset( $_GET['total'] ) && ( $_GET['total'] > 0 ) && (!empty($_SESSION['cart']) ) )
{
  # Open database connection.
  require ('connect_db.php');
  
  # Store buyer and order total in 'orders' database table.
  $q = "INSERT INTO orders ( user_id, total, order_date ) VALUES (". $_SESSION['user_id'].",".$_GET['total'].", NOW() ) ";
  $r = mysqli_query ($dbc, $q);
  
  # Retrieve current order number.
  $order_id = mysqli_insert_id($dbc) ;
  
  # Retrieve cart items from 'shop' database table.
  $q = "SELECT * FROM shop WHERE item_id IN (";
  foreach ($_SESSION['cart'] as $id => $value) { $q .= $id . ','; }
  $q = substr( $q, 0, -1 ) . ') ORDER BY item_id ASC';
  $r = mysqli_query ($dbc, $q);


  # Store order contents in 'order_contents' database table.
  while ($row = mysqli_fetch_array ($r, MYSQLI_ASSOC))
  {
    $query = "INSERT INTO order_contents ( order_id, item_id, quantity, price )
    VALUES ( $order_id, ".$row['item_id'].",".$_SESSION['cart'][$row['item_id']]['quantity'].",".$_SESSION['cart'][$row['item_id']]['price'].")" ;
    $result = mysqli_query($dbc,$query);
  }
  
  # Close database connection.
  mysqli_close($dbc);

  echo "
        <div class=\"row align-items-center justify-content-center mt-5 mb-5\" style=\"height: 200px;\">
          <div class=\"col-10 border rounded py-3\">
            <p class=\"fs-1 text-center\"><i class=\"bi bi-bag-check\"></i></p>
            <p class=\"fs-5 text-center\">Thanks for your order. Your Order Number Is #".$order_id."</p>
          </div>
        </div>
  ";
  # Remove cart items.  
  $_SESSION['cart'] = NULL ;
} else { 
  echo "
        <div class=\"row align-items-center justify-content-center mt-5 mb-5\" style=\"height: 200px;\">
          <div class=\"col-10 border rounded py-3\">  
            <p class=\"fs-1 text-center\"><i class=\"bi bi-bag\"></i></p>
            <p class=\"fs-5 text-center\">There are no items in your cart.</p>
          </div>
        </div>
      ";
}

# Display footer section.
include ( 'includes/footer.html' ) ;

?>