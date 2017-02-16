<!doctype html>
<html lang="en">
<head>
<title>My Page</title>
<style>
        .secondary-color {
            color: #FF6D9E;
        }
        
        .secondary-border-color {
            border-color: #FF6D9E;
        }
        
        .secondary-hover:hover {
            color: #FF6D9E;
            background-color: #221F1F;
            border-color: #FF6D9E;
        }
        
    </style>
<?php
include 'app/include/navbar.php';  
?>

<!--This modal contains the change password form. It's gonna have some sweet hash check-->
    <div class="modal fade" id="passwordModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Change Password</h4>
                </div>
                <div class="modal-body">
                    <form action="#" id="changePasswordForm">
                        <span style="font-size: 14px">Enter your old password</span>
                        <div class="input-group">
                            <label for="oldPass" class="sr-only">Old Password:</label>
                            <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-fire secondary-color"></span>
                            </span>
                            <input type="password" required id="oldPass" placeholder="Old Password" class="form-control" name="password">
                        </div>
                        <hr>
                        <span style="font-size: 14px">Enter your new password</span>
                        <div class="input-group">
                            <label for="newPass" class="sr-only">New Password:</label>
                            <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-asterisk secondary-color"></span>
                            </span>
                            <input type="password" required id="newPass" placeholder="New Password" class="form-control" name="password">
                        </div>
                        <br>
                        <span style="font-size: 14px">Confirm new password</span>
                        <div class="input-group">
                            <label for="newPass" class="sr-only">Confirm New Password:</label>
                            <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-ok secondary-color"></span>
                            </span>
                            <input type="password" required id="newPass" placeholder="Confirm Password" class="form-control" name="password">
                        </div>
                        <button type="button" class="btn btn-default secondary-color secondary-border-color secondary-hover" type="submit" style="margin-top: 10px; margin-left: 70%;">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!--    This is the modify information modal. It is also the place where the user can -->
    <div class="modal fade" id="infoModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Modify Information</h4>
                </div>
                <div class="modal-body">
                    <form action="#" id="modifyInfoForm">
                        <span style="font-size: 14px">Email address</span>
                        <div class="input-group input-group">
                            <label for="email" class="sr-only">Email:</label>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-envelope secondary-color" title="Enter your birth date"></span></span>
                            <input type="email" required id="email" placeholder="Email Address" class="form-control" name="email">
                        </div>
                        <br>

                        <span style="font-size: 14px">Main Phone</span>
                        <div class="input-group">
                            <label for="homePhone" class="sr-only">Home Phone:</label>
                            <span class="input-group-addon"><span
                                                                      class="glyphicon glyphicon-phone-alt secondary-color"></span></span>
                            <input type="tel" required="" id="homePhone" placeholder="Main Phone" pattern="(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}" class="form-control" name="main_phone">
                        </div>
                        <br>

                        <span style="font-size: 14px">Secondary Phone</span>
                        <div class="input-group">
                            <label for="secPhone" class="sr-only">Secondary Phone:</label>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-phone secondary-color"></span></span>
                            <input type="tel" id="secPhone" placeholder="Secondary Phone (optional)" pattern="(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}" class="form-control" name="sec_phone">
                        </div>
                        <button type="button" class="btn btn-default secondary-color secondary-border-color secondary-hover" type="submit" style="margin-top: 10px; margin-left: 70%;">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <h3>User Page</h3>
        <div id="userInfo" class="well">
            <div class="row">
                <h4 class="col-xs-5 col-md-6">Personal Information</h4>
<!--            This should link to the edit addresses page-->
                <form action="editAddress/">
                    <button id="addressButton" class="btn btn-default col-xs-3 col-md-2 secondary-color secondary-border-color secondary-hover" style="width: auto; margin-left:13px;" type="submit">View Addresses <span class="glyphicon glyphicon-home"></span></button>
                </form>

                <!--Random spacer, ignore-->
                <div class="col-xs-1"></div>

<!--            This opens the change password form modal-->
                <button id="changePassButton" class="btn btn-default col-xs-3 secondary-color secondary-border-color secondary-hover" style="width: auto;" data-toggle="modal" data-target="#passwordModal">Change Password <span class="glyphicon glyphicon-asterisk"></span></button>
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <p class="col-xs-6">First Name: <span id="firstName">Joe</span></p>
                        <p class="col-xs-6">Last Name: <span id="lastName">Doe</span></p>
                    </div>
                    <div class="row">
                        <p class="col-xs-6">Birth Date: <span id="birthDate">01/12/1990</span></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <h4 class="col-xs-6">Other Information</h4>

            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <p class="col-xs-6">Email: <span id="email">joedoe@gmail.com</span></p>
                        <button id="modifyInfoButton" class="btn btn-default secondary-color secondary-border-color secondary-hover col-xs-6" style="width: auto; left: 15px; top: -5px" data-toggle="modal" data-target="#infoModal">Modify Information <span class="glyphicon glyphicon-user"></span></button>
                    </div>
                    <div class="row">
                        <p class="col-xs-6">Main Phone: <span id="">(555) 555-5555</span></p>
<!--                    If sec_phone == null just print it out as empty, or none, so the user can remember that he has the option to have a secondary phone number -->
                        <p class="col-xs-6">Secondary Phone: <span id="lastName">(111) 111-1111</span></p>
                    </div>
                </div>
            </div>
        </div>

        <div id="userPayment" class="well">
            <h4>Payment Methods on File</h4>
            <div class="row">
<!--            Loop dis. PAYMENTID is the id of the -->
                <div class="panel panel-default col-xs-3" id="paymentPAYMENTID">
                    <div class="panel-body">
                        <span><span id="cardTypePAYMENTID">Mastercard</span> ****-****-****-<b><span id="cardNumberPAYMENTID">5567</span></b></span>
                    </div>
                </div>
            </div>
        </div>

        <div id="userOrders" class="well">
            <h4>Past Orders</h4>
<!--        Loop this shit. ORDERID is replaced by the order id of the current order-->
            <div id="orderORDERID" class="panel-default panel secondary-border-color">
                <div class="panel-heading secondary-color">
                    <div class="row">
                        <span class="col-xs-4">
                            Order ID: <b><span id=idORDERID>4</span></b>
                        </span>
                        <span class="text-center col-xs-4">
                            Ordered by: 
                            <b>
                                <span id=emailUSERID>
                                    joedoe@gmail.com
                                </span>
                        </b>
                        </span>
                        <span class="col-xs-4">
                            <span class="pull-right">
                                Order Date: 
                                <b>
                                    <span id="orderDateORDERID">
                                        09/10/2016
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
<!--                        LOOP HERE. obv SALEDETAILSID is what it is-->
                            <tr id="saleDetailsSALEDETAILSID">
                                <td id="productNameSALEDETAILSID"><a id="linkPRODUCTID" href="#">Bright Green Bouncy Ball</a></td>
                                <td id="quantitySALEDETAILSID" class="text-center">2</td>
                                <td id="priceSALEDETAILSID" class="text-center">CDN$ 40.00</td>
                                <td id="discountSALEDETAILSID" class="text-center">50.00%</td>
                                <td id="discountedPriceSALEDETAILSID" class="text-center">CDN$ 20.00</td>
                            </tr>
<!--                        END LOOP HERE -->

                            <tr id="saleDetailsSALEDETAILSID">
                                <td id=""><a id="" href="#">Yellow Plush Teddy Bear</a></td>
                                <td id="" class="text-center">1</td>
                                <td id="" class="text-center">CDN$ 80.00</td>
                                <td id="" class="text-center">10.00%</td>
                                <td id="" class="text-center">CDN$ 72.00</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <b class="pull-right" style="margin-right: 25px;">Total: <span id="totalSALEDETAILSID">CDN$ 92.00</span></b>
                    </div>
                    <hr>
                    <div>
                        <span class="glyphicon glyphicon-credit-card secondary-color lead"></span> <span>Paid With </span>
                        <br>
                        <span id="cardTitlePAYMENTID">Mastercard</span> <b>#****-****-****-<span id="cardNumberPAYMENTID"></span></b>.
                    </div>
                    <hr>
                    <div>
                        <span class="lead glyphicon glyphicon-home secondary-color"></span> <span>Shipped To </span>
                        <br>
                        <span id="streetADDRESSID">555, 5th avenue</span>, <span id="cityADDRESSID">Laval</span>, <span></span>
                    </div>
                </div>
            </div>
<!--        END LOOP THIS SHIT-->
        </div>
    </div>
</body>

</html>