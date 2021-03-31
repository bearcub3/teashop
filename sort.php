<?php 



if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' )
{
    $sort = mysqli_real_escape_string( $dbc, trim( $_POST[ 'sort' ] ) );
    $sortBy = $_POST[ 'sort' ];

    if ($category)
    {
        if ($sortBy == 'lowtohigh')
        {
            $query = "SELECT * FROM shop WHERE item_category='$category' ORDER BY item_price" ;
            $r = @mysqli_query ( $dbc, $query ) ;
            mysqli_close( $dbc ) ; 
    
        } elseif($sortBy == 'hightolow') {
            $query = "SELECT * FROM shop WHERE item_category='$category' ORDER BY item_price DESC" ;
            $r = @mysqli_query ( $dbc, $query ) ;
            mysqli_close( $dbc ) ; 
        } else {
            $query = "SELECT * FROM shop WHERE item_category='$category' ORDER BY item_name" ;
            $r = @mysqli_query ( $dbc, $query ) ;
            mysqli_close( $dbc ) ; 
        }

    } else {
        if ($sortBy == 'lowtohigh')
        {
            $query = "SELECT * FROM shop ORDER BY item_price" ;
            $r = @mysqli_query ( $dbc, $query ) ;
            mysqli_close( $dbc ) ; 
    
        } elseif($sortBy == 'hightolow') {
            $query = "SELECT * FROM shop ORDER BY item_price DESC" ;
            $r = @mysqli_query ( $dbc, $query ) ;
            mysqli_close( $dbc ) ; 
        } else {
            $query = "SELECT * FROM shop ORDER BY item_name" ;
            $r = @mysqli_query ( $dbc, $query ) ;
            mysqli_close( $dbc ) ; 
        }
    }
}

// sort
echo "<div class=\"d-flex align-items-center justify-content-end\">
        <form method=\"post\">
            <select name=\"sort\" id=\"sort-select\" class=\"px-1 py-1\">
                <option value=\"\">-- sort items --</option>
                <option value=\"lowtohigh\">by price - low to high</option>
                <option value=\"hightolow\">by price - high to low</option>
                <option value=\"name\">by name</option>
            </select>
        </form>
      </div>";
?>