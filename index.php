<?php

    include 'include/db.php';
?>

<html>
    <head>
        <title>Online Shopping</title>

        <script src="../jQuery/jquery.js"></script>
        <script src="../jQuery/jquery-ui.js"></script>
        <script src="../jQuery/jquery-color.js"></script>
        <script src="../jQuery/bootstrap.js"></script>
        <link rel="stylesheet" href="../CSS/jquery-ui.css">
        <link rel="stylesheet" href="../CSS/bootstrap.css">
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <?php

            include 'include/header.php';

        ?>
        <div class="container">
            <div class="row">

                <?php
                    $sql = "SELECT * FROM items";
                    $run = mysqli_query($conn,$sql);
                    while($rows = mysqli_fetch_assoc($run))
                    {
                        $discounted_price  = $rows['item_price'] -  $rows['item_discount'];
                        $item_title = str_replace(' ','-',$rows['item_title']);
                        echo "
                        <div class='col-md-3'>
                            <div class='col=md-12 single-item noPadding'>
                                <div class='top'><img src='$rows[item_image]' ></div>
                                <div class='bottom'>
                                    <h3 class='item-title'><a href='item.php?item_title=$item_title&item_id=$rows[item_id]'>$rows[item_title]</a></h3>
                                    <div class='pull-right cutted-price text-muted'><del>$rows[item_price]</del></div>
                                    <div class='clearfix'></div>
                                    <div class='pull-right discounted-price' >$ $discounted_price /=</div>
                                </div>
                            </div>                    
                        </div>
                        ";
                    }

                ?>
                
                
            </div>
        </div>
        <div class="clearfix"></div>
        <br><br><br><br><br>
        <?php

            include 'include/footer.php';

        ?>
    </body>
</html>