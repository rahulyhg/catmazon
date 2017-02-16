<!doctype html>
<html lang="en">
    <head>
        <title>Edit Addresses</title>
        <?php
        include 'app/include/navbar.php';  
        $url = $_SERVER['REQUEST_URI'];
        if (stristr($url,'addaddress') !== false) {
        ?>
        <div class="container">
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                The address was added!
            </div>
        </div>
        <?php } else if (stristr($url,'deleteaddress') !== false){ ?>
        <div class="container">
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                The address was deleted!
            </div>
        </div>
        <?php } ?>
        <div class="container">
            <div class="jumbotron imaged-jumbo" style="background: #000 url('/images/addAddress.jpg') center center;">
                <div class="transparent-underlay">
                    <h1>Where does your kitty live?</h1>
                    <p class="secondary-color">Enter and remove addresses below</p>
                </div>
            </div>  
        </div>
        <script type="text/javascript">

            function countryChange(){
                var canadianProvinces = {
                    "Alberta": "AB",
                    "British Columbia": "BC",
                    "Manitoba": "MB",
                    "New Brunswick": "NB",
                    "Newfoundland and Labrador": "NL",
                    "Nova Scotia": "NS",
                    "Northwest Territories": "NT",
                    "Nunavut": "NU",
                    "Ontario": "ON",
                    "Prince Edward Island": "PE",
                    "Quebec": "QC",
                    "Saskatchewan": "SK",
                    "Yukon": "YT"
                };

                var americanStates = {
                    "Alabama": "AL",
                    "Alaska": "AK",
                    "Arizona": "AZ",
                    "Arkansas": "AR",
                    "California": "CA",
                    "Colorado": "CO",
                    "Connecticut": "CT",
                    "Delaware": "DE",
                    "District Of Columbia": "DC",
                    "Florida": "FL",
                    "Georgia": "GA",
                    "Hawaii": "HI",
                    "Idaho": "id",
                    "Illinois": "IL",
                    "Indiana": "IN",
                    "Iowa": "IA",
                    "Kansas": "KS",
                    "Kentucky": "KY",
                    "Louisiana": "LA",
                    "Maine": "ME",
                    "Maryland": "MD",
                    "Massachusetts": "MA",
                    "Michigan": "MI",
                    "Minnesota": "MN",
                    "Mississippi": "MS",
                    "Missouri": "MO",
                    "Montana": "MT",
                    "Nebraska": "NE",
                    "Nevada": "NV",
                    "New Hampshire": "NH",
                    "New Jersey": "NJ",
                    "New Mexico": "NM",
                    "New York": "NY",
                    "North Carolina": "NC",
                    "North Dakota": "ND",
                    "Ohio": "OH",
                    "Oklahoma": "OK",
                    "Oregon": "OR",
                    "Pennsylvania": "PA",
                    "Rhode Island": "RI",
                    "South Carolina": "SC",
                    "South Dakota": "SD",
                    "Tennessee": "TN",
                    "Texas": "TX",
                    "Utah": "UT",
                    "Vermont": "VT",
                    "Virginia": "VA",
                    "Washington": "WA",
                    "West Virginia": "WV",
                    "Wisconsin": "WI",
                    "Wyoming": "WY" 
                };

                var $chosenCountry = '<?=$this->getCountry()?>';
                var $states = $('#state');
                var $states2 = $('#state2');
                $states.empty();
                if($chosenCountry == "Canada"){
                    $.each(canadianProvinces, function(key, value){
                        $states.append($("<option></option>").attr("value", value).text(key)); 
                    });
                    $.each(canadianProvinces, function(key, value){
                        $states2.append($("<option></option>").attr("value", value).text(key)); 
                    });
                    $('#zip').attr('pattern','[ABCEGHJKLMNPRSTVXY][0-9][ABCEGHJKLMNPRSTVWXYZ] ?[0-9][ABCEGHJKLMNPRSTVWXYZ][0-9]');
                    $('#zip2').attr('pattern','[ABCEGHJKLMNPRSTVXY][0-9][ABCEGHJKLMNPRSTVWXYZ] ?[0-9][ABCEGHJKLMNPRSTVWXYZ][0-9]');
                } else {
                    $.each(americanStates, function(key, value){
                        $states.append($("<option></option>").attr("value", value).text(key)); 
                    });
                    $.each(americanStates, function(key, value){
                        $states2.append($("<option></option>").attr("value", value).text(key)); 
                    });
                    $('#zip').attr('pattern','\\d{5}(?:[-\s]\\d{4})');
                    $('#zip2').attr('pattern','\\d{5}(?:[-\s]\\d{4})');
                }
            }
            $( document ).ready( countryChange );

            function editAddress(addressID, street, city, state, country, postal_code){
                $('#editAddressID').val(addressID);
                $('#state2').val(state);
                $('#city2').val(city);
                $('#street2').val(street);
                $('#editCountry').val(country);
                $('#zip2').val(postal_code);
            }
        </script>

        <div class="modal fade" id="editModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Edit an Address</h4>
                    </div>
                    <div class="modal-body">
                        <form action="/editAddress/modifyAddress" method="POST" >
                            <div class="input-group input-group-lg">
                                <label for="state2" class="sr-only">State</label>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-globe secondary-color"></span></span>
                                <select id="state2" required class="form-control" name="state2">

                                </select>
                            </div>
                            <br>
                            <input type="hidden" id="editAddressID" name="addressIDEdit">
                            <!-- <input type="hidden" id="editCountry" name="countryEdit"> -->
                            <div class="input-group input-group-lg">
                                <label for="city2" class="sr-only">City</label>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-home secondary-color" title="Enter your birth date"></span></span>
                                <input type="text" id="city2" required placeholder="City" class="form-control" name="city2">
                            </div>
                            <br>

                            <div class="input-group input-group-lg">
                                <label for="zip2" class="sr-only">Zip Code</label>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-home secondary-color"></span></span>
                                <input type="text" pattern="\d{5}(?:[-\s]\d{4})?" required id="zip2" placeholder="Zip Code" class="form-control" name="postal_code2">

                            </div>
                            <br>

                            <div class="input-group input-group-lg">
                                <label for="street2" class="sr-only">Street Address</label>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-road secondary-color"></span></span>
                                <input type="text" id="street2" required placeholder="Street Address" class="form-control" name="street2">
                            </div>
                            <br>

                            <input type="submit" value="Modify Address" class="form-control btn btn-default secondary-color secondary-border-color secondary-hover" name="add_address_submit">
                        </form>
                    </div>
                </div>
            </div>
        </div>    
        <div class="container">
            <div class="form-group col-md-6">
                <form action="/editAddress/addAddress" method="POST" >
                    <div class="input-group input-group-lg">
                        <label for="state" class="sr-only">State</label>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-globe secondary-color"></span></span>
                        <select id="state" required class="form-control" name="state">

                        </select>
                    </div>
                    <br>

                    <div class="input-group input-group-lg">
                        <label for="city" class="sr-only">City</label>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-home secondary-color" title="Enter your birth date"></span></span>
                        <input type="text" id="city" required placeholder="City" class="form-control" name="city">
                    </div>
                    <br>

                    <div class="input-group input-group-lg">
                        <label for="zip" class="sr-only">Zip Code</label>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-home secondary-color"></span></span>
                        <input type="text" pattern="\d{5}(?:[-\s]\d{4})?" required id="zip" placeholder="Zip Code" class="form-control" name="postal_code">
                        
                    </div>
                    <br>

                    <div class="input-group input-group-lg">
                        <label for="street" class="sr-only">Street Address</label>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-road secondary-color"></span></span>
                        <input type="text" id="street" required placeholder="Street Address" class="form-control" name="street">
                    </div>
                    <br>

                    <input type="submit" value="Add a house! =^.^=" class="form-control btn btn-default secondary-color secondary-border-color secondary-hover" name="add_address_submit">
                </form>
            </div>
            <div class="form-group col-md-6">
                <div class="panel panel-default">
                    <div class="container"><h2>Remove old addresses</h2></div>
                    <div class="panel-body">
                        <!-- Generate a list of all addresses in the account here, with an if statement -->

                        <?=$this->loadAddresses()?>

                    </div>
                </div>
            </div>
        </div>


        <?php
    include 'app/include/footer.php';  
        ?>