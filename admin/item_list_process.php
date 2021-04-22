<?php include '../include/db.php'; 
    if(isset($_REQUEST['del_item_id']))
    {
        $del_sql = "DELETE FROM items WHERE item_id = '$_REQUEST[del_item_id]'";
        $del_run = mysqli_query($conn,$del_sql);
    }

    if(isset($_REQUEST['up_item_id']))
    {
        //echo "alert('Hii BC/')";
        //echo "<span style='z-index:100000'>ABCD</span>";
        //$item_name= mysqli_real_escape_string($conn,strip_tages($_POST['item_image']));
        $item_name = mysqli_real_escape_string($conn,strip_tags( $_REQUEST['item_name'])) ;
        $item_decription =  mysqli_real_escape_string($conn,$_REQUEST['item_description']);
        $item_category =  mysqli_real_escape_string($conn,strip_tags($_REQUEST['item_category'])) ;
        $item_qty = mysqli_real_escape_string($conn,strip_tags($_REQUEST['item_qty'])) ;
        $item_cost =  mysqli_real_escape_string($conn,strip_tags( $_REQUEST['item_cost']));
        $item_price =  mysqli_real_escape_string($conn,strip_tags($_REQUEST['item_price'])) ;
        $item_discount =  mysqli_real_escape_string($conn,strip_tags($_REQUEST['item_discount'])) ;
        $item_delivery =  mysqli_real_escape_string($conn,strip_tags($_REQUEST['item_delivery']));
        $item_id = $_REQUEST['up_item_id'];
       // $item_ins_sql = "INSERT INTO items (item_title,item_desc,item_cat,item_qty,item_cost,item_price
         //                           ,item_discount,item_delivery) 
         //                           VALUES 
         //                           ('$item_name','$item_decription','$item_category','$item_qty','$item_cost'
         //                           ,'$item_price','$item_discount','$item_delivery')";
        $item_up_sql= "UPDATE items SET item_title='$item_name',item_desc='$item_decription',item_cat='$item_category',item_qty='$item_qty',item_cost='$item_cost',item_price='$item_price',item_discount='$item_discount',item_delivery='$item_delivery' WHERE item_id='$item_id'";
        
        $item_ins_run = mysqli_query($conn,$item_up_sql);        
        
    }


?>

<table class="table table-bordered table-striped">
                <thead>
                    <tr class="item-head">
                        <th>S.No</th>
                        <th>Item Image</th>
                        <th>Item Title</th>
                        <th>Item Description</th>
                        <th>Item Category</th>
                        <th>Item Qty</th>
                        <th>Item Cost</th>
                        <th>Item Discount</th>
                        <th>Item Price</th>
                        <th>Item Delivery</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sel_sql = "SELECT * FROM items";
                        $sel_run = mysqli_query($conn,$sel_sql);

                        $c = 1;
                        while($sel_rows = mysqli_fetch_assoc($sel_run))
                        {
                            $discounted_price = $sel_rows['item_price'] - $sel_rows['item_discount'];
                            echo "
                                <tr>
                                <td>$c</td>
                                <td><img src='../$sel_rows[item_image]' style='width:60px'></td>
                                <td>$sel_rows[item_title]</td>
                                <td>";echo $sel_rows['item_desc'];
                                echo "
                                </td>
                                <td>$sel_rows[item_cat]</td>
                                <td>$sel_rows[item_qty]</td>
                                <td>$sel_rows[item_cost]</td>
                                <td>$sel_rows[item_discount]</td>
                                <td>$discounted_price($sel_rows[item_price])</td>           
                                <td>$sel_rows[item_delivery]</td>
                                <td>
                                    <div class='dropdown'>
                                        <button class='btn btn-danger dropdown-toggle' data-toggle='dropdown'>Action<span class='caret'></span></button>
                                        <ul class='dropdown-menu dropdown-menu-right'>
                                            <li>
                                                <a href='#edit_modal' data-toggle='modal'>Edit</a>
                                                
                                            
                                            </li>"; ?>
                                            <li><a href="javascript:;" onclick="del_item(<?php  echo $sel_rows['item_id'];  ?>);">Delete</a></li>
                                            <?php
                                        echo "</ul>
                                    </div>
                                    <div class='modal fade' id='edit_modal'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>
                                                <div class='modal-header'>
                                                    <button class='close' data-dismiss='modal'>&times;</button>
                                                    <h4 class='modal-title'>Add new Item</h4>
                                                </div>
                                                <div class='modal-body'>
                                                    <div method='post' id=form1>
                                                        <div class='form-group'>
                                                            <label>Item Image</label>
                                                            <input type='file' id='item_image'+$sel_rows[item_id] value='$sel_rows[item_image]' class='form-control' required>
                                                        </div>
                                                        <div class='form-group'>
                                                            <label>Item Name</label>
                                                            <input type='text' id='item_title' value='$sel_rows[item_title]' class='form-control' required>
                                                        </div>
                                                        <div class='form-group'>
                                                            <label>Item Description</label>
                                                            <textarea class='form-control' value= "; ?> <?php echo "$sel_rows[item_desc]"; ?> <?php echo "id='item_description' required></textarea>
                                                        </div>
                                                        <div class='form-group'>
                                                            <label>Item Category</label>
                                                            <select class='form-control' id='item_category' required>
                                                                <option>Select a Category</option> "; 
                                                                
                                                                    $cat_sql = "SELECT * FROM item_cat";
                                                                    $cat_run = mysqli_query($conn,$cat_sql);
                                                                    while($cat_rows = mysqli_fetch_assoc($cat_run))
                                                                    {
                                                                        $cat_name = ucwords($cat_rows['item_name']);
                                                                        
                                                                        if($cat_rows['item_slug'] == '')
                                                                        {
                                                                            $cat_slug = $cat_rows['item_slug'];
                                                                        }
                                                                        else
                                                                        {
                                                                            $cat_slug = $cat_rows['item_name'];
                                                                        }

                                                                        if($cat_slug == $cat_rows['item_name'])
                                                                        {
                                                                            echo "
                                                                            <option selected value='$cat_slug'>$cat_name</option>
                                                                            ";
                                                                        }
                                                                        else
                                                                        {
                                                                            echo "
                                                                            <option value='$cat_slug'>$cat_name</option>
                                                                            ";
                                                                        }

                                                                        echo "
                                                                            <option>$cat_name</option>
                                                                            ";
                                                                        
                                                                    }

                                                                
                                                                echo "
                                                            </select>
                                                        </div>
                                                        <div class='form-group'>
                                                            <label>Item Quantity</label>
                                                            <input type='number' id='item_qty' value='$sel_rows[item_qty]' class='form-control' required>
                                                        </div>
                                                        <div class='form-group'>
                                                            <label>Item Cost</label>
                                                            <input type='number' id='item_cost' value='$sel_rows[item_cost]' class='form-control' required>
                                                        </div>
                                                        <div class='form-group'>
                                                            <label>Item Price</label>
                                                            <input type='number' id='item_price' value='$sel_rows[item_price]' class='form-control' required>
                                                        </div>
                                                        <div class='form-group'>
                                                            <label>Item Discount</label>
                                                            <input type='number' id='item_discount' value='$sel_rows[item_discount]' class='form-control' required>
                                                        </div>
                                                        <div class=form-group'>
                                                            <label>Item Delivery</label>
                                                            <input type='number' id='item_delivery' value='$sel_rows[item_delivery]' class='form-control' required>
                                                        </div>
                                                        <div class='form-group'>
                                                            <input type='hidden' id='up_item_id' value='$sel_rows[item_id]'> "; ?>
                                                            <button" onclick="edit_item();" class='btn btn-success btn-block'></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='modal-footer'>
                                                    <button class='btn btn-danger' data-dismiss='modal'>Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php
                            $c++;
                        }


                    ?>
                    
                </tbody>
            </table>