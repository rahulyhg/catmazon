<!doctype html>
<html lang="en">
<head>
<title>Cart</title>

<?php
include 'app/include/navbar.php';  
?>
    <style>
        
        .sidebar-outer {
            margin-top: 50px;
            position: relative;
        }

        @media (min-width: 768px) {
        .sidebar {
            position: fixed;
        }
    }
    </style>
    <div class="col-xs-9">
        <div class="container">
            <span class="lead">Cart Details</span>
            <hr>
            <h5>Items in your cart: <?=$this->cartCount()?></h4>
            <?=$this->loadCart()?>
            
        </div> 
    </div>
<?php if (isset($_SESSION['activeUser'])): ?>
    <div class="col-xs-3 sidebar-outer">
        <div class="panel panel-default sidebar text-center">
            <div class="panel-heading">
                Order Now!
            </div>
            <div class="panel-body">
                Think your cat will be happy?
                <br>
                <br>
                <br>
                <form action="/checkout" method="POST">
                    <button id="addressButton" class="btn btn-default secondary-color secondary-border-color secondary-hover" type="submit">
                        Checkout
                        <span class="glyphicon glyphicon-ok-circle secondary-color"></span>
                    </button>
                    <br>
                    <br>
                </form>
            </div>
            <div class="panel-footer">
            <form method="POST" action="#">
                <button id="addressButton" class="btn btn-danger secondary-border-color" type="submit" name="clearCart">
                    Empty Cart
                    <span class="glyphicon glyphicon-ban-circle"></span>
                </button>
            </div>
        </div>
    </div>
<?php endif?>

</body>

</html>