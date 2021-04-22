<?php
    session_start();
    include 'include/db.php';

    if(isset($_REQUEST['chk_del_id']))
    {
        $chk_del_sql = "DELETE FROM checkout WHERE chk_id = '$_REQUEST[chk_del_id]'";
        $chk_del_run = mysqli_query($conn,$chk_del_sql);
    }

    if(isset($_REQUEST['up_chk_qty']))
    {
        $up_chk_qty_sql = "UPDATE checkout SET chk_qry = '$_REQUEST[up_chk_qty]' WHERE chk_id  = '$_REQUEST[up_chk_id]'";
        $up_chk_run_run = mysqli_query($conn,$up_chk_qty_sql);
    }

    $i = 0;
    $total = 0;
    $delivery_charges = 0;

    
    //$chk_sel_sql = "SELECT * FROM checkout WHERE chk_ref = '$_SESSION[ref]'";
    $chk_sel_sql = "SELECT * FROM checkout c JOIN items i ON c.chk_item = i.item_id WHERE c.chk_ref = '$_SESSION[ref]'";
    $chk_sel_run = mysqli_query($conn,$chk_sel_sql);
    $c = 1;

    echo "
    <table class='table'>
    <thead>
        <tr>
            <th>S.no</th>
            <th>Product</th>
            <th>Qty</th>
            <th width='5%'>Delete</th>
            <th class='text-right'>Price</th>
            <th class='text-right'>Total</th>
            
        </tr>
    </thead>
    <tbody>
    ";
        
   



    while($chk_sel_rows = mysqli_fetch_assoc($chk_sel_run))
    {
        $discounted_price = $chk_sel_rows['item_price'] - $chk_sel_rows['item_discount'];
        $sub_total = $discounted_price * $chk_sel_rows['chk_qry'];
        $total+= $sub_total;
        $delivery_charges+= $chk_sel_rows['item_delivery'];
        echo "
            <tr>
                <td>$c</td>
                <td>$chk_sel_rows[item_title]</td> 
        "; ?>
                <td><input type='number' style='width:45px' min="1"  onblur="up_chk_qty(this.value,'<?php echo $chk_sel_rows['chk_id']; ?> ') ;"     value="<?php echo $chk_sel_rows['chk_qry'] ?>"></td>
                <td><button class="btn btn-danger btn-sn" onclick="del_func(<?php echo $chk_sel_rows['chk_id'] ?>);">Delete</button></td>
                <?php
                echo " 
                <td class='text-right'><b>$discounted_price</b></td>
                <td class='text-right'><b>$total</b></td>
            </tr> ";
         
        $c++;
    }
    $_SESSION['grand_total'] = $grand_total= $total + $delivery_charges;

    echo "
    </tbody>
    </table>
    <table class='table'>
        <thead>
            <tr>
                <th class='text-center' colspan='2'>Order Summaey</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>SubTotal</td>
                <td class='text-right'><b>$total</b></td>
            </tr>
            <tr>
                <td>Delivary Charges</td>
                <td class='text-right'><b>$delivery_charges</b></td>
            </tr>
            <tr>
                <td> Grand Total</td>
                <td class='text-right'><b>$_SESSION[grand_total]</b></td>
            </tr>
        
        </tbody>
    </table>

    ";
?>