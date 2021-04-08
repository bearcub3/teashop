<?php 

if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' )
{
    $sort = mysqli_real_escape_string( $dbc, trim( $_POST[ 'sort' ] ) );
    $sortBy = $_POST[ 'sort' ];
    $_SESSION[ 'sorting' ] = $sortBy;

    if ($category)
    {
        if ($sortBy == 'lowtohigh')
        {
            $query = "SELECT * FROM shop WHERE item_category='$category' ORDER BY item_price" ;
            $r = @mysqli_query ( $dbc, $query ) ;
    
        } elseif($sortBy == 'hightolow') {
            $query = "SELECT * FROM shop WHERE item_category='$category' ORDER BY item_price DESC" ;
            $r = @mysqli_query ( $dbc, $query ) ;
        } else {
            $query = "SELECT * FROM shop WHERE item_category='$category' ORDER BY item_name" ;
            $r = @mysqli_query ( $dbc, $query ) ;
        }

    } else {
        if ($sortBy == 'lowtohigh')
        {
            $query = "SELECT * FROM shop ORDER BY item_price" ;
            $r = @mysqli_query ( $dbc, $query ) ;
    
        } elseif($sortBy == 'hightolow') {
            $query = "SELECT * FROM shop ORDER BY item_price DESC" ;
            $r = @mysqli_query ( $dbc, $query ) ;
        } else {
            $query = "SELECT * FROM shop ORDER BY item_name" ;
            $r = @mysqli_query ( $dbc, $query ) ;
        }
    }
}

if(!empty($_SESSION[ 'sorting' ]))
{
    $sort = mysqli_real_escape_string( $dbc, trim( $_SESSION[ 'sorting' ] ) );
    $sortBy = $_SESSION[ 'sorting' ];

    if ($category)
    {
        if ($sortBy == 'lowtohigh')
        {
            $query = "SELECT * FROM shop WHERE item_category='$category' ORDER BY item_price" ;
            $r = @mysqli_query ( $dbc, $query ) ;
    
        } elseif($sortBy == 'hightolow') {
            $query = "SELECT * FROM shop WHERE item_category='$category' ORDER BY item_price DESC" ;
            $r = @mysqli_query ( $dbc, $query ) ;
        } else {
            $query = "SELECT * FROM shop WHERE item_category='$category' ORDER BY item_name" ;
            $r = @mysqli_query ( $dbc, $query ) ;
        }

    } else {
        if ($sortBy == 'lowtohigh')
        {
            $query = "SELECT * FROM shop ORDER BY item_price" ;
            $r = @mysqli_query ( $dbc, $query ) ;
    
        } elseif($sortBy == 'hightolow') {
            $query = "SELECT * FROM shop ORDER BY item_price DESC" ;
            $r = @mysqli_query ( $dbc, $query ) ;
        } else {
            $query = "SELECT * FROM shop ORDER BY item_name" ;
            $r = @mysqli_query ( $dbc, $query ) ;
        }
    }
}

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