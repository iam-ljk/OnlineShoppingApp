<?php include "../include/db.php";  
    if(isset($_POST['item_submit']))
    {
        //echo "alert('Hii BC/')";
        //echo "<span style='z-index:100000'>ABCD</span>";
        //$item_name= mysqli_real_escape_string($conn,strip_tages($_POST['item_image']));
        $item_name = mysqli_real_escape_string($conn,strip_tags( $_POST['item_name'])) ;
        $item_decription =  mysqli_real_escape_string($conn,$_POST['item_description']);
        $item_category =  mysqli_real_escape_string($conn,strip_tags($_POST['item_category'])) ;
        $item_qty = mysqli_real_escape_string($conn,strip_tags($_POST['item_qty'])) ;
        $item_cost =  mysqli_real_escape_string($conn,strip_tags( $_POST['item_cost']));
        $item_price =  mysqli_real_escape_string($conn,strip_tags($_POST['item_price'])) ;
        $item_discount =  mysqli_real_escape_string($conn,strip_tags($_POST['item_discount'])) ;
        $item_delivery =  mysqli_real_escape_string($conn,strip_tags($_POST['item_delivery']));
        if(isset($_FILES['item_image']['name']))
        {
            $file_name = $_FILES['item_image']['name'];
            $path_address = "../images/items/$file_name";
            $path_address_db = "images/items/$file_name";
            $img_confirm = 1;
            $file_type = pathinfo($_FILES['item_image']['name'] , PATHINFO_EXTENSION);
            if($_FILES['item_image']['size'] > 2000000)
            {
                $img_confirm = 0;
                echo 'size is very big';
            }
            if($file_type != 'jpg' && $file_type != 'png' && $file_type != 'gif')
            {
                $img_confirm = 0;
                echo 'Type is matching';
            }

            if($img_confirm == 0)
            {

            }
            else
            {
                //echo "OUT OF IF STATEMENT...";
                
                if(move_uploaded_file($_FILES['item_image']['tmp_name'],$path_address))
                {

                    //echo "<h1><b>Jay<b></h1>";
                    $item_ins_sql = "INSERT INTO items (item_image,item_title,item_desc,item_cat,item_qty,item_cost,item_price
                                    ,item_discount,item_delivery) 
                                    VALUES 
                                    ('$path_address_db','$item_name','$item_decription','$item_category','$item_qty','$item_cost'
                                    ,'$item_price','$item_discount','$item_delivery')";
                    $item_ins_run = mysqli_query($conn,$item_ins_sql);
                    /*?>
                    <script>
                    $('#add_new_item').modal('hide');
                    </script>
                    <?php*/
                }
            }
        }
        
        
    }


?>

<!DOCTYPE html>
<html>
    <head>
        <title>Item List| Admin Pannel</title>
        <link rel="stylesheet" href="../css/bootstrap.css">
        <script src="../../jQuery/jquery.js"></script>
        <script src="../../jQuery/bootstrap.js"></script>
        
        <script src="https://cdn.tiny.cloud/1/naq7sppc9mnuzly0ja6unqm7r1wuygo0uiyv6kbhlxoqgmcz/tinymce/5/tinymce.min.js" referrerpolicy="origin">
        </script>
        <script>
            tinymce.init({
            selector: 'textarea'
            });
        </script>
        
        <script>
            function get_item_list_data()
            {
                xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function()
                {
                    if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
                    {
                        document.getElementById('get_item_list_data').innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.open('GET','item_list_process.php',true);
                xmlhttp.send();
            }

            function del_item(item_id)
            {
                xmlhttp.onreadystatechange = function()
                {
                    if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
                    {
                        document.getElementById('get_item_list_data').innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.open('GET','item_list_process.php?del_item_id='+item_id,true);
                xmlhttp.send();
            }

            function edit_item()
            {
                xmlhttp.onreadystatechange = function()
                {
                    if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
                    {
                        document.getElementById('get_item_list_data').innerHTML = xmlhttp.responseText;
                    }
                }

                item_id = document.getElementById('up_item_id').value;
                item_title = document.getElementById('item_title').value;
                item_description = document.getElementById('item_description').value;
                item_category = document.getElementById('item_category').value;
                item_quantity = document.getElementById('item_qty').value;
                item_cost = document.getElementById('item_cost').value;
                item_price = document.getElementById('item_price').value;
                item_discount = document.getElementById('item_discount').value;
                item_delivery = document.getElementById('item_delivery').value;
                //alert(item_title);
                xmlhttp.open('GET','item_list_process.php?up_item_id='+item_id+'&item_title='+item_title+'&item_description='+
                                    item_description+'&item_category='+item_category+'&item_quantity = '+item_quantity+'&item_cost='+
                                    item_cost+'&item_price='+item_price+'&item_discount='+item_discount+'&item_delivery='+item_delivery
                            ,true);
                xmlhttp.send();
            }

        </script>
    </head>
    <body onload="get_item_list_data();">
        
        <?php include 'includes/header.php' ?>

        <div class="container">

            <button class="btn btn-primary btn-lg" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#add_new_item">Add new Item</button>
            <div id="add_new_item" class="modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Add new Item</h4>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>Item Image</label>
                                    <input type="file" name="item_image" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Item Name</label>
                                    <input type="text" name="item_name" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Item Description</label>
                                    <textarea   name="item_description" ></textarea>
                                    
                                </div>
                                <div class="form-group">
                                    <label>Item Category</label>
                                    <select class="form-control" name="item_category" required>
                                        <option>Select a Category</option>
                                        <?php
                                            $cat_sql = "SELECT * FROM item_cat";
                                            $cat_run = mysqli_query($conn,$cat_sql);
                                            while($cat_rows = mysqli_fetch_assoc($cat_run))
                                            {
                                                $cat_name = ucwords($cat_rows['item_name']);
                                                /*
                                                if($cat_rows['item_slug'] == '')
                                                {
                                                    $cat_slug = $cat_rows['item_slug'];
                                                }
                                                else
                                                {
                                                    $cat_slug = $cat_rows['item_name'];
                                                }*/
                                                echo "
                                                    <option>$cat_name</option>
                                                ";
                                            }

                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Item Quantity</label>
                                    <input type="number" name="item_qty" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Item Cost</label>
                                    <input type="number" name="item_cost" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Item Price</label>
                                    <input type="number" name="item_price" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Item Discount</label>
                                    <input type="number" name="item_discount" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Item Delivery</label>
                                    <input type="number" name="item_delivery" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="item_submit" class="btn btn-success btn-block">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="get_item_list_data">
                <!-- Area to get the Process Item list Data -->
            </div>
            <br><br><br><br><br><br>

        </div>
        
        <?php include 'includes/footer.php' ?>
        
    </body>
</html>