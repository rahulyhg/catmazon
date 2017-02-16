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
<script type="text/javascript">
    function editInfo(email, homePhone, secPhone){
                $('#emailEdit').val(email);
                $('#homePhoneEdit').val(homePhone);
                $('#secPhoneEdit').val(secPhone);
            }

</script>
<?php if (isset($_SESSION['activeUser'])):?>
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
                    <form action="/userPage/editUser" method="post" id="changePasswordForm">
                        <span style="font-size: 14px">Enter your old password</span>
                        <div class="input-group">
                            <label for="oldPass" class="sr-only">Old Password:</label>
                            <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-fire secondary-color"></span>
                            </span>
                            <input type="password" required id="oldPass" placeholder="Old Password" class="form-control" name="oldPassword">
                        </div>
                        <hr>
                        <span style="font-size: 14px">Enter your new password</span>
                        <div class="input-group">
                            <label for="newPass" class="sr-only">New Password:</label>
                            <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-asterisk secondary-color"></span>
                            </span>
                            <input type="password" required id="newPass" placeholder="New Password" class="form-control" name="newPassword">
                        </div>
                        <br>
                        <span style="font-size: 14px">Confirm new password</span>
                        <div class="input-group">
                            <label for="newPass" class="sr-only">Confirm New Password:</label>
                            <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-ok secondary-color"></span>
                            </span>
                            <input type="password" required id="newPass" placeholder="Confirm Password" class="form-control" name="confirmPassword">
                        </div>
                        <button name="editPasswordSubmit" class="btn btn-default secondary-color secondary-border-color secondary-hover" type="submit" style="margin-top: 10px; margin-left: 70%;">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!--    This is the modify information modal. It is also the place where the user can modify the info-->
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
                    <form action="/userpage/editUser" id="modifyInfoForm" method="POST">
                        <span style="font-size: 14px">Email address</span>
                        <div class="input-group input-group">
                            <label for="emailEdit" class="sr-only">Email:</label>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-envelope secondary-color" title="Enter your birth date"></span></span>
                            <input type="email" required id="emailEdit" placeholder="Email Address" class="form-control" name="emailEdit">
                        </div>
                        <br>

                        <span style="font-size: 14px">Main Phone</span>
                        <div class="input-group">
                            <label for="homePhoneEdit" class="sr-only">Home Phone:</label>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-phone-alt secondary-color"></span></span>
                            <input type="tel" required="" id="homePhoneEdit" placeholder="Main Phone" pattern="(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}" class="form-control" name="homePhoneEdit">
                        </div>
                        <br>

                        <span style="font-size: 14px">Secondary Phone</span>
                        <div class="input-group">
                            <label for="secPhoneEdit" class="sr-only">Secondary Phone:</label>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-phone secondary-color"></span></span>
                            <input type="tel" id="secPhoneEdit" placeholder="Secondary Phone (optional)" pattern="(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}" class="form-control" name="secPhoneEdit">
                        </div>
                        <button class="btn btn-default secondary-color secondary-border-color secondary-hover" type="submit" style="margin-top: 10px; margin-left: 70%;" name="editInfoSubmit">Change Information</button>
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
                        <p class="col-xs-6">First Name: <span id="firstName"><?=$this->user->first_name?></span></p>
                        <p class="col-xs-6">Last Name: <span id="lastName"><?=$this->user->last_name?></span></p>
                    </div>
                    <div class="row">
                        <p class="col-xs-6">Birth Date: <span id="birthDate"><?=$this->user->birth_date?></span></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <h4 class="col-xs-6">Other Information</h4>

            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <p class="col-xs-6">Email: <span id="email"><?=$this->user->email?></span></p>
                        <button id="modifyInfoButton" class="btn btn-default secondary-color secondary-border-color secondary-hover col-xs-6" style="width: auto; left: 15px; top: -5px" data-toggle="modal" data-target="#infoModal" onCLick="editInfo('<?=$this->user->email?>','<?=$this->user->main_phone?>','<?=$this->user->sec_phone?>')">Modify Information 
                        <span class="glyphicon glyphicon-user"></span>

                        </button>
                    </div>
                    <div class="row">
                        <p class="col-xs-6">Main Phone: <span id="main_phone"><?=$this->user->main_phone?></span></p>
<!--                    If sec_phone == null just print it out as empty, or none, so the user can remember that he has the option to have a secondary phone number -->
                    <?php if ($this->user->sec_phone):?>
                        <p class="col-xs-6">Secondary Phone: <span id="sec_phone"><?=$this->user->sec_phone?></span></p>
                    <?php endif?>
                    </div>
                </div>
            </div>
        </div>

        <div id="userPayment" class="well">
            <h4>Payment Methods on File</h4>
            <div class="row">
<!--            Loop dis.-->
                <?=$this->loadPayment()?>
            </div>
        </div>

        <div id="userOrders" class="well">
            <h4>Past Orders</h4>
            <?=$this->loadOrders()?>
        </div>
    </div>
    <?php endif?> <!-- end if logged in -->
</body>

</html>