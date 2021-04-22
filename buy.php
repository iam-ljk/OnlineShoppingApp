<?php
    session_start();

    include 'include/db.php';
    if(isset($_GET['chk_item_id']))
    {
        $date = date('Y-m-d h:i:s');
        $rand_num = mt_rand();

        if(isset($_SESSION['ref']))
        {

        }
        else{
            $_SESSION['ref'] = $date.'_'.$rand_num; 
        }
        
        //echo "$_SESSION[ref]";
        //echo "$_GET[chk_item_id]";

        $chk_sql = "INSERT INTO checkout (chk_item,chk_ref,chk_timing,chk_qry) VALUES ('$_GET[chk_item_id]','$_SESSION[ref]','$date', 1)";
       

        if(mysqli_query($conn,$chk_sql))
        {
            ?>
            <script>
                window.location = "buy.php";
            </script>
            <?php
        }
    }

    if(isset($_POST['order_submit']))
    {
        $name = mysqli_real_escape_string($conn,strip_tags($_POST['name']));
        $email = mysqli_real_escape_string($conn,strip_tags($_POST['email']));
        $contact = mysqli_real_escape_string($conn,strip_tags($_POST['contact']));
        $state = mysqli_real_escape_string($conn,strip_tags($_POST['state']));
        $delivery_address = mysqli_real_escape_string($conn,strip_tags($_POST['delivery_address']));
    
        echo "Jay";
        $order_ins_sql = "INSERT INTO orders (order_name,order_email,order_contact,order_state,order_delivery_address,order_checkout_ref,order_total) VALUES ('$name','$email','$contact','$state','$delivery_address','$_SESSION[ref]','$_SESSION[grand_total]')";
        mysqli_query($conn,$order_ins_sql);
    }
?>


<html>
    <head>
        <title>Shopping Card</title>
        <link rel="stylesheet" href="../CSS/jquery-ui.css">
        <link rel="stylesheet" href="css/font-awesome.css">
		<link rel="stylesheet" href="../CSS/bootstrap.css">
        <script src="../jQuery/jquery.js"></script>
        <script src="../jQuery/bootstrap.js"></script>       
        <link rel="stylesheet" href="style.css">
        <script>
            function ajax_func()
            {
                xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function()
                {
                    if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
                    {
                        document.getElementById('get_processed_data').innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.open('GET','buy_process.php',true);
                xmlhttp.send();
            }

            function del_func(chk_id)
            {
                //alert(chk_id);
                xmlhttp.onreadystatechange = function()
                {
                    if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
                    {
                        document.getElementById('get_processed_data').innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.open('GET','buy_process.php?chk_del_id='+chk_id,true);
                xmlhttp.send();
            }

            function up_chk_qty(chk_qty,chk_id)
            {
                //alert(chk_qty);
                xmlhttp.onreadystatechange = function()
                {
                    if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
                    {
                        document.getElementById('get_processed_data').innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.open('GET','buy_process.php?up_chk_qty='+chk_qty+'&up_chk_id='+chk_id,true);
                xmlhttp.send();
            }

        </script>
    </head>

    <body onload="ajax_func();">
            <?php include 'include/header.php';?>
            <div class="container">
                <div class="page header">
                    <H2 class="pull-left">Ckeck Out</H2>
                    <div class="pull-right"><button class="btn btn-success" data-toggle="modal" data-target="#proceed_modal" data-backdrop="static" data-keyboard="false" >Proceed</button></div>
                    <!-- The Proceed form Modal -->
                    <div id="proceed_modal" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <form method="post">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" id="name" name="name" class="form-control" placeholder="Full Name" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="email">Email Address</label>
                                            <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="contact">Contact Number</label>
                                            <input type="number" id="contact" name="contact" class="form-control" placeholder="Contact Number Name" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="state">State</label>
                                            <input list="states" name="state" id="state" class="form-control">
                                            <datalist id="states">
                                                <option>Washignton</option>
                                                <option>Florida</option>
                                                <option>New York</option>
                                                <option>Kansas</option>
                                                <option>Origone</option>
                                                <option>Indiana</option>
                                                <option>Ohieo</option>
                                            </datalist>
                                        </div>


                                        <div class="form-group">
                                            <label for="address" >Delivery Address</label>
                                            <textarea class="form-control" name="delivery_address"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <input type="submit" name="order_submit" class="btn btn-success btn-block btn-lg">
                                        </div>

                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    
                    <div class="clearfix"></div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Order Detail</div>
                    <div class="panel-body" id="get_processed_data">
                        


                    </div>
                </div>
            </div>
            <br><br><br><br><br>
            <?php include 'include/footer.php';?>
    </body>
    
</html>