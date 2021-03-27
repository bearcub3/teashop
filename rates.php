<?php 
# Access session.
session_start() ;

# Open database connection.
require ( 'connect_db.php' ) ;

if (isset($_REQUEST['product_id']))
{
    $id = $_REQUEST['product_id'];
    $user_id = $_SESSION[ 'user_id' ];

    $rateQuery = "SELECT AVG(rate) AS AverageRate FROM product_rates WHERE item_id=$id";
    $rateResult = mysqli_query($dbc, $rateQuery);

    if ($rateResult)
    {
        while ($row = mysqli_fetch_assoc($rateResult))
        {
            $rate = $row['AverageRate'] + 0;
            $toString = strval($rate);

            $pattern = '/\./';
            $splitRate = str_split($toString, 1);
            
            echo "<div class=\"d-flex flex-row justify-content-start align-items-center\">
                    <div>Consumers Rates : </div>
                    <div>&nbsp;";
            if ($rate > 0)
            {
                for ($x = 0; $x < $splitRate[0]; $x++)
                {
                    echo '<i class="bi bi-star-fill text-warning fs-5"></i>';
                }
                if ($splitRate[2] != 0) echo '<i class="bi bi-star-half text-warning fs-5"></i>';

                echo "&nbsp;&nbsp;<b>" . number_format((float)$rate, 1, '.', '') . "</b> out of 5";    
            } else {
                echo "Not yet rated!";
            }
            echo"</div></div>";
        }
    }
}
?>
