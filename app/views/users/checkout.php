<!doctype html>
<html lang="en">
    <head>
        <title>Checkout</title>
        <?php
        include 'app/include/navbar.php';  
        ?>
        <script type="text/javascript">
            function changeCardType(){
                var paymentID = $('#card_type').val();
                if(paymentID == "Visa"){
                    $('#card_number').attr("pattern", "4[0-9]{12}(?:[0-9]{3})?");
                    $('#card_number').attr("placeholder", "Enter Visa number");
                    $('#testerCardNumber').html("4012888888881881 OR 4111111111111111 OR 4222222222222");
                } else if(paymentID == "Mastercard"){
                    $('#card_number').attr("pattern", "(?:5[1-5][0-9]{2}|222[1-9]|22[3-9][0-9]|2[3-6][0-9]{2}|27[01][0-9]|2720)[0-9]{12}");
                    $('#card_number').attr("placeholder", "Enter Mastercard number");
                    $('#testerCardNumber').html("5555555555554444 OR 5105105105105100");
                } else if(paymentID == "American Express"){
                    $('#card_number').attr("pattern", "3[47][0-9]{13}");
                    $('#card_number').attr("placeholder", "Enter American Express number");
                    $('#testerCardNumber').html("378282246310005 OR 371449635398431");
                } else if(paymentID == "Diners Club"){
                    $('#card_number').attr("pattern", "3(?:0[0-5]|[68][0-9])[0-9]{11}");
                    $('#card_number').attr("placeholder", "Enter Diners Club number");
                    $('#testerCardNumber').html("30569309025904 OR 38520000023237");
                } else if(paymentID == "Discover"){
                    $('#card_number').attr("pattern", "6(?:011|5[0-9]{2})[0-9]{12}");
                    $('#card_number').attr("placeholder", "Enter Discover number");
                    $('#testerCardNumber').html("6011111111111117 OR 6011000990139424");
                } else {
                    $('#card_number').attr("pattern", "(?:2131|1800|35\\d{3})\\d{11}");
                    $('#card_number').attr("placeholder", "Enter JCB number");
                    $('#testerCardNumber').html("3530111333300000 OR 3566002020360505");
                }
                $('#card_number').val("");
            }
        </script>
        <div class="modal fade" id="paymentModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Add a Payment Method</h4>
                    </div>
                    <div class="modal-body">
                        <form action="/checkout/addPayment" method="post" id="addPaymentForm">
                            <span style="font-size: 14px">Choose a card type: </span>
                            <div class="input-group">
                                <label for="card_type" class="sr-only">Card Type</label>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-credit-card secondary-color"></span>
                                </span>
                                <select required id="card_type" name="card_type" class="form-control" name="cardType" onchange="changeCardType()">
                                    <option value="Visa">Visa</option>
                                    <option value="Mastercard">Mastercard</option>
                                    <option value="American Express">American Express</option>
                                    <option value="Diners Club">Diners Club</option>
                                    <option value="Discover">Discover</option>
                                    <option value="JCB">JCB</option>
                                </select>
                            </div>
                            <hr>
                            <span style="font-size: 14px">Enter your card number:</span>
                            <div class="input-group">
                                <label for="card_number" class="sr-only">Card Type</label>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-credit-card secondary-color"></span>
                                </span>
                                <input type="text" required class="form-control" id="card_number" name="card_number" pattern="4[0-9]{12}(?:[0-9]{3})?" placeholder="Enter Visa Number" maxlength="16">
                            </div>
                            <br>
                            <p>~Test cards~</p>
                            <p id="testerCardNumber">4012888888881881 OR 4111111111111111 OR 4222222222222</p>
                            <button class="btn btn-default secondary-color secondary-border-color secondary-hover" type="submit" style="margin-top: 10px; margin-left: 70%;" name="add_payment_submit">Add Payment Method</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <h4>Make your order!</h4>
            <div id="orderORDERID" class="panel-default panel secondary-border-color">
                <div class="panel-heading secondary-color">
                    <div class="row">
                        <span class="col-xs-4">
                            New Order
                        </span>
                        <span class="text-center col-xs-4">
                            Order by: 
                            <b>
                                <span id=emailUSERID>
                                    <?=$this->getEmail()?>
                                </span>
                            </b>
                        </span>
                        <span class="col-xs-4">
                            <span class="pull-right">
                                Order Date: 
                                <b>
                                    <span id="orderDateORDERID">
                                        <?php
                                            $date = getDate();
                                            $d = $date["mday"];
                                            $m = $date['mon'];
                                            $y = $date['year'];
                                            echo $y.'/'.$m.'/'.$d;
                                        ?>
                                    </span>
                                </b>
                            </span>
                        </span>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered table-responsive table-striped">
                        <caption><span class="lead glyphicon glyphicon-shopping-cart secondary-color"> </span> Order Contents</caption>
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Discount</th>
                                <th>Discounted Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?=$this->loadProducts()?>
                        </tbody>
                    </table>
                    <div class="row">
                        <b class="pull-right" style="margin-right: 25px;">Total: <span id="total"><?=$this->getTotal()?></span></b>
                    </div>
                    <hr>
                    <form action="/checkout/confirmSale" method="post">
                        <div id="shipToDiv">
                            <span class="lead glyphicon glyphicon-home secondary-color"></span> <span>Ship To </span>
                            <div class="input-group pull-right" style="width: 1%;">
                                <label for="chooseAddress" class="sr-only">State</label>
                                <span class="input-group-addon">Choose a Different Address</span>
                                <select id="chooseAddress"  name="chooseAddress" required class="form-control" style="width: auto;">
                                    <?=$this->loadAddresses();?>
                                </select>
                            </div>
                            <br>
                        </div>
                        <hr>
                        <div id="paymentMethodDiv">
                            <div class="row">
                                <div class="col-xs-2">
                                    <span class="glyphicon glyphicon-credit-card secondary-color lead"></span> <span>Paid With </span>
                                </div>
                                <div class="col-xs-8">
                                    <div class="input-group pull-right" style="width: 1%;">
                                        <label for="choosePayment" class="sr-only">State</label>
                                        <span class="input-group-addon">Choose a Card</span>
                                        <select id="choosePayment" name="choosePayment" onchange="" required class="form-control" style="width: auto;">
                                            
                                            <?=$this->loadPayment();?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-2">
                                    <button class="btn btn-default secondary-color secondary-border secondary-hover pull-right" data-toggle="modal" data-target="#paymentModal" type="button">
                                        Add a payment method
                                    </button>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-default form-control secondary-color secondary-hover" style="border-color: black;">
                            Confirm Order :3
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <?php
    include 'app/include/footer.php';  
        ?>