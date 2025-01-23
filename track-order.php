<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="css/track-order-style.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    
<div class="card">
    <?php
    session_start();
    include_once("config.php");
    $u_id=$_SESSION['u_id'];
    $query=mysqli_query($conn,"SELECT * from orders WHERE order_id=(SELECT MAX(order_id) FROM orders WHERE user_id='$u_id')");
    if ($query) 
    {
        $row = mysqli_fetch_assoc($query); 
        if($row!=0)
        {
            $cname = $row['name'];
            $o_id = $row['order_id'];
            $total = $row['total'];
            $status = $row['status'];
        }

    }
    if($row!=0)
    {
    ?>
    
    <div class="title">Purchase Reciept</div>
            <div class="info">
                <div class="row">
                    <div class="col-7">
                        <span id="heading">Customer Name</span><br>
                        <span id="details"><?php echo $cname;?></span>
                    </div>
                    <div class="col-5 pull-right">
                        <span id="heading">Order No.</span><br>
                        <span id="details"><?php echo $o_id;?></span>
                    </div>
                </div>      
            </div>      
            <div class="pricing">
                <div class="row">
                    <div class="col-9">
                        <span id="name">Sub Total</span>  
                    </div>
                    <div class="col-3">
                        <span id="price">₹ <?php echo $total;?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-9">
                        <span id="name">Shipping</span>
                    </div>
                    <div class="col-3">
                        <span id="price">₹ 0.00</span>
                    </div>
                </div>
            </div>
            <div class="total">
                <div class="row">
                    <div class="col-9"></div>
                    <div class="col-3"><big>₹ <?php echo $total;?></big></div>
                </div>
            </div>
            <div class="tracking">
                <div class="title">Tracking Order</div>
            </div>
            <div class="progress-track">
                <ul id="progressbar">
                <?php 
                    if($status=="panding")
                    {?>
                        <li class="step0 active " id="step1">Ordered</li>
                        <li class="step0 text-center" id="step2">Shipped</li>
                        <li class="step0 text-right" id="step3">On the way</li>
                        <li class="step0 text-right" id="step4">Delivered</li>
                <?php }
                    elseif($status=="Confirmed")
                    {?>
                        <li class="step0 active " id="step1">Ordered</li>
                        <li class="step0 active text-center" id="step2">Shipped</li>
                        <li class="step0 text-right" id="step3">On the way</li>
                        <li class="step0 text-right" id="step4">Delivered</li>
                <?php }
                    elseif($status=="Out for Delivery")
                    {?>
                        <li class="step0 active " id="step1">Ordered</li>
                        <li class="step0 active text-center" id="step2">Shipped</li>
                        <li class="step0 active text-right" id="step3">On the way</li>
                        <li class="step0 text-right" id="step4">Delivered</li>
                <?php }
                    elseif($status=="Delivered")
                    {?>
                        <li class="step0 active " id="step1">Ordered</li>
                        <li class="step0 active text-center" id="step2">Shipped</li>
                        <li class="step0 active text-right" id="step3">On the way</li>
                        <li class="step0 active text-right" id="step4">Delivered</li>
                        
                <?php }
                    elseif($status=="Cancled")
                    {?>
                        <div style="text-align:center;">
                            <h3 >ORDER CANCELED!</h3>
                            <h5>Sorry your order has been cancled</h5>
                            <h5>If you feel this is an error, please contact our <a href="contact.php">support team</a></h5>
                        </div>

                <?php } ?>                 
                        
              
                </ul>         
                
                
            </div>
            
        </div>
        <?php } 
        else
        {?>
            <div class="title"></div>
                <div class="info">
                    <div class="row">
                        <div style="text-align:center;">
                            <h3 >NO ORDER FOUND!</h3>
                            <h5>Looks like you haven't made your order yet</h5>
                            <div class="blue-button"><a href="products.php">Shop Now</a></div>
                        </div>
                    </div>      
                </div>      
            </div>
            <?php
        }
        ?>
</body>
</html>