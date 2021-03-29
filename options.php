<?php

if ($hasOption != 0)
{
    $query = "SELECT * FROM shop WHERE options_id=$hasOption";
    $options = mysqli_query($dbc, $query);

    echo "<div class=\"d-flex flex-row justify-content-start align-items-center mt-2\">
            <div><p class=\"fw-bold\">Options :</p></div>
            <div class=\"align-self-item\">";

    if ($options)
    {
        while ($row = mysqli_fetch_assoc($options))
        {
            $image1 = $row['item_img1'];
            $id = $row['item_id'];
            $name = $row['item_name'];

            echo "<a href=\"detail.php?product_id=$id\" class=\"mx-1 border border-2\"><img alt=\"$name\" src=\"$image1\" width=\"70px\" height=\"70px\" /></a>";
        }
    }
    echo '</div></div>';
}

?>