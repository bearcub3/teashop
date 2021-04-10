<?php # DISPLAY SHOPPING CART PAGE.

# Access session.
session_start() ;

# Set page title and display header section.
$page_title = 'Cart' ;
include ( 'includes/header.php' ) ;

$user_id = $_SESSION[ 'user_id' ];

# Check if form has been submitted for update.
if ( $_SERVER['REQUEST_METHOD'] == 'POST' )
{
  $item_id = $_POST['item'];

  $id = (int) $item_id;
  $qty = (int) $_SESSION['cart'][$id]['quantity'];

  switch($_POST[ 'action' ]) {
    case 'remove':     
      unset ($_SESSION['cart'][$id]);

      break;
    case 'minus':
      if ( $qty > 1 ) { $_SESSION['cart'][$id]['quantity'] = $qty - 1; }
      elseif ( $qty == 1 ) { unset ($_SESSION['cart'][$id]); } 

      break;
    case 'plus':
      if ( $qty >= 0 ) { $_SESSION['cart'][$id]['quantity'] = $qty + 1; }

      break;
  }
}

echo "<div class=\"d-flex align-items-center justify-content-between mt-5 mb-2\">
        <h2 class=\"text-center\">
            <b class=\"font\">Shopping Cart</b>
        </h2>
        </div>
    <hr />";

# Display body section with a form and a table.
echo '<form action="cart.php" method="post">';
echo "<div class=\"row align-items-center\">";

# Initialize grand total variable.
$total = 0;

# Display the cart if not empty.
if (!empty($_SESSION['cart']))
{
  # Connect to the database.
  require ('connect_db.php');
  
  # Retrieve all items in the cart from the 'shop' database table.
  $q = "SELECT * FROM shop WHERE item_id IN (";
  foreach ($_SESSION['cart'] as $id => $value) { $q .= $id . ','; }
  $query = substr( $q, 0, -1 ) . ') ORDER BY item_id ASC';
  $result = mysqli_query ($dbc, $query);

  while ($row = mysqli_fetch_array ($result, MYSQLI_ASSOC))
  {
    $name = $row['item_name'];
    $price = $row['item_price'];
    $image1 = $row['item_img1'];
    $p_id = $row['item_id'];

    $quantity = $_SESSION['cart'][$p_id]['quantity'];

    $subtotal = $_SESSION['cart'][$p_id]['quantity'] * $_SESSION['cart'][$p_id]['price'];
    $total += $subtotal;

    if ($quantity >= 1)
    {
      echo "<div class=\"row align-items-center border-bottom py-3\">
              <div class=\"col-3\">
                <img src=\"$image1\" width=\"100%\" height=\"100%\" alt=\"$name image\" />
              </div>
              <div class=\"col-5\">
                <div class=\"row mb-2 font fw-bold fs-5\">$name</div>
                <div class=\"fw-light row mb-2\">Quantity</div>
                <div class=\"input-group d-flex\" style=\"margin-left:-10px; width: 150px;\">
                  <span class=\"input-group-text\">
                    <form method=\"post\">
                      <input type=\"hidden\" name=\"action\" value=\"minus\" />
                      <input type=\"hidden\" name=\"item\" value=\"$p_id\" />
                      <input type=\"submit\" href=\"#\" class=\"fs-5 border-0 px-2\" value=\"-\" style=\"background-color: #e9ecef;\"></input>
                    </form>
                  </span>
                  <input type=\"text\" size=\"3\" class=\"form-control text-center\" name=\"qty[{$p_id}]\" value=\"{$_SESSION['cart'][$p_id]['quantity']}\" aria-label=\"product quantity\" />
                  <span class=\"input-group-text\">
                    <form method=\"post\">
                      <input type=\"hidden\" name=\"action\" value=\"plus\" />
                      <input type=\"hidden\" name=\"item\" value=\"$p_id\" />
                      <input type=\"submit\" href=\"#\" class=\"fs-5 border-0 px-2\" value=\"+\" style=\"background-color: #e9ecef;\"></input>
                    </form>
                  </span>
                </div>
              </div>
              <div class=\"col-2 text-end\">
                <p class=\"mb-0\">£ $price</p>
              </div>
              <div class=\"col-2 text-end\">
                <form method=\"post\">
                  <input type=\"hidden\" name=\"action\" value=\"remove\" />
                  <input type=\"hidden\" name=\"item\" value=\"$p_id\" />
                  <button type=\"submit\" class=\"remove-btn\"><i class=\"bi bi-x-square-fill fs-4\"></i></input>
                </form>
              </div>
          </div>";
    }    
  }
  
  # Close the database connection.
  mysqli_close($dbc); 

  echo "<div class=\"row align-items-center mt-3 mb-5\">
          <div class=\"fs-5 col-4\">Total : £" .number_format($total,2). "</div>
          <div class=\"col-4 col-sm-2 ms-auto\">";

  if($user_id){
    echo "<a href=\"checkout.php?total=$total\" class=\"btn btn-outline-dark\">
            <i class=\"bi bi-bag-check fs-5 me-2\"></i>checkout
          </a>";
  } else {
    echo "<a href=\"login.php?where=cart.php\" class=\"btn btn-outline-dark\"><i class=\"bi bi-bag-check fs-5 me-2\"></i> Login to buy</a>";
  }
  
  echo "  </div>
        </div>";

  echo "  </form>
        </div>";
} else { 
  echo "<div class=\"py-3 my-3\">
          <p class=\"text-center\"><i class=\"bi bi-bag fs-1\"></i></p>
          <p class=\"text-center\">Your cart is currently empty.</p>
        </div>
        </form></div>" ; 
}


# Display footer section.
include ( 'includes/footer.html' ) ;
echo '<script src="js/noResubmission.js"></script>';
?>