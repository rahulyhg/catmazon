<!doctype html>
<html lang="en">
<head>
<title>Sign Up</title>
<?php
include 'app/include/navbar.php';  
?>
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
            
            var $chosenCountry = $('#country');
            var $states = $('#state');
            $states.empty();
            if($chosenCountry.val() == "Canada"){
                $.each(canadianProvinces, function(key, value){
                   $states.append($("<option></option>").attr("value", value).text(key)); 
                });
                $('#zip').attr('pattern','[ABCEGHJKLMNPRSTVXY][0-9][ABCEGHJKLMNPRSTVWXYZ] ?[0-9][ABCEGHJKLMNPRSTVWXYZ][0-9]');
            } else {
                $.each(americanStates, function(key, value){
                   $states.append($("<option></option>").attr("value", value).text(key)); 
                });
                $('#zip').attr('pattern','\\d{5}(?:[-\s]\\d{4})');
            }
        }
    </script>

<div class="container">
  <div class="jumbotron imaged-jumbo" style="background: #000 url('/images/signup_cat.jpg') center center;">
    <div class="transparent-underlay">
      <h1>Join the Catmazon family</h1>
      <p class="secondary-color">Just enter your information below!</p>
    </div>
  </div>  
</div>
<div class="container">
  <div class="form-group col-md-6">
    <form action="/newUser/createUser" method="POST">

      <div class="input-group input-group-lg">
        <label for="email" class="sr-only">Email:</label>
        <span class="input-group-addon"><span class="glyphicon glyphicon-envelope secondary-color" title="Enter your birth date"></span></span>
        <input type="email" autofocus required id="email"
          placeholder="Email Address" class="form-control" name="email">
      </div>
      <br>

	   <div class="input-group input-group-lg">
        <label for="password" class="sr-only">Password:</label>
        <span class="input-group-addon"><span
    class="glyphicon glyphicon-asterisk secondary-color"></span></span>
        <input type="password"  required id="password"
          placeholder="Password" class="form-control" name="password" pattern=".{6,15}" title="Must be between 6 and 15 characters.">
      </div>
      <br>

      <div class="input-group input-group-lg">
        <label for="confirmPassword" class="sr-only">Confirm Password:</label>
        <span class="input-group-addon"><span
    class="glyphicon glyphicon-ok secondary-color"></span></span>
        <input type="password"  required id="confirmPassword"
          placeholder="Confirm Password" class="form-control" pattern=".{6,15}" title="Must be between 6 and 15 characters.">
      </div>
      <br>

      <div class="input-group input-group-lg">
        <label for="firstName" class="sr-only">First Name:</label>
        <span class="input-group-addon"><span
    class="glyphicon glyphicon-user secondary-color"></span></span>
        <input type="text"  required id="firstName"
          placeholder="First Name" class="form-control" name="first_name">
      </div>
      <br>
      
      <div class="input-group input-group-lg">
        <label for="lastName" class="sr-only">Last Name:</label>
        <span class="input-group-addon"><span
    class="glyphicon glyphicon-user secondary-color"></span></span>
        <input type="text" required id="lastName"
          placeholder="Last Name" class="form-control" name="last_name">
      </div>
      <br>
      
      <div class='input-group input-group-lg date' id='datetimepicker'>
          <label for="birthDate" class="sr-only">Birth Date</label>
          <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar secondary-color"></span>
          </span>
          <input type="date" required id="birthDate" placeholder="Birth Date" class="form-control" name="birth_date" max="<?=date('Y-m-d', strtotime('-18 years'))?>" min="<?=date('Y-m-d', strtotime('-101 years'))?>"/>
      </div>
      <br>
      
      <div class="input-group input-group-lg">
        <label for="homePhone" class="sr-only">Home Phone:</label>
        <span class="input-group-addon"><span
    class="glyphicon glyphicon-phone-alt secondary-color"></span></span>
        <input type="tel" required="" id="homePhone" placeholder="Home Phone"
          pattern="(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}" class="form-control" name="main_phone">
      </div>
      <br>

      <div class="input-group input-group-lg">
        <label for="secPhone" class="sr-only">Secondary Phone:</label>
        <span class="input-group-addon"><span class="glyphicon glyphicon-phone secondary-color"></span></span>
        <input type="tel" id="secPhone" placeholder="Secondary Phone (optional)"
          pattern="(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}" class="form-control" name="sec_phone">
      </div>
      <br>
      
      <div class="input-group input-group-lg">
        <label for="country" class="sr-only">Country</label>
        <span class="input-group-addon"><span class="glyphicon glyphicon-globe secondary-color"></span></span>
        <select id="country" onchange="countryChange()" required class="form-control" name="country">
          <option>United States</option>
          <option>Canada</option>
        </select>
      </div>
      <br>

      <div class="input-group input-group-lg">
        <label for="state" class="sr-only">State</label>
        <span class="input-group-addon"><span class="glyphicon glyphicon-globe secondary-color"></span></span>
        <select id="state" required class="form-control" name="state">
          <option value="AL">Alabama</option>
          <option value="AK">Alaska</option>
          <option value="AZ">Arizona</option>
          <option value="AR">Arkansas</option>
          <option value="CA">California</option>
          <option value="CO">Colorado</option>
          <option value="CT">Connecticut</option>
          <option value="DE">Delaware</option>
          <option value="DC">District Of Columbia</option>
          <option value="FL">Florida</option>
          <option value="GA">Georgia</option>
          <option value="HI">Hawaii</option>
          <option value="id">Idaho</option>
          <option value="IL">Illinois</option>
          <option value="IN">Indiana</option>
          <option value="IA">Iowa</option>
          <option value="KS">Kansas</option>
          <option value="KY">Kentucky</option>
          <option value="LA">Louisiana</option>
          <option value="ME">Maine</option>
          <option value="MD">Maryland</option>
          <option value="MA">Massachusetts</option>
          <option value="MI">Michigan</option>
          <option value="MN">Minnesota</option>
          <option value="MS">Mississippi</option>
          <option value="MO">Missouri</option>
          <option value="MT">Montana</option>
          <option value="NE">Nebraska</option>
          <option value="NV">Nevada</option>
          <option value="NH">New Hampshire</option>
          <option value="NJ">New Jersey</option>
          <option value="NM">New Mexico</option>
          <option value="NY">New York</option>
          <option value="NC">North Carolina</option>
          <option value="ND">North Dakota</option>
          <option value="OH">Ohio</option>
          <option value="OK">Oklahoma</option>
          <option value="OR">Oregon</option>
          <option value="PA">Pennsylvania</option>
          <option value="RI">Rhode Island</option>
          <option value="SC">South Carolina</option>
          <option value="SD">South Dakota</option>
          <option value="TN">Tennessee</option>
          <option value="TX">Texas</option>
          <option value="UT">Utah</option>
          <option value="VT">Vermont</option>
          <option value="VA">Virginia</option>
          <option value="WA">Washington</option>
          <option value="WV">West Virginia</option>
          <option value="WI">Wisconsin</option>
          <option value="WY">Wyoming</option>

          <!--
            IF country = canaderh
          <option value="AB">Alberta</option>
          <option value="BC">British Columbia</option>
          <option value="MB">Manitoba</option>
          <option value="NB">New Brunswick</option>
          <option value="NL">Newfoundland and Labrador</option>
          <option value="NS">Nova Scotia</option>
          <option value="NT">Northwest Territories</option>
          <option value="NU">Nunavut</option>
          <option value="ON">Ontario</option>
          <option value="PE">Prince Edward Island</option>
          <option value="QC">Quebec</option>
          <option value="SK">Saskatchewan</option>
          <option value="YT">Yukon</option>
          -->
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
        <span class="input-group-addon"><span class="glyphicon glyphicon-home secondary-color" title="Enter your birth date"></span></span>
        <input type="text" pattern="\d{5}(?:[-\s]\d{4})?" required id="zip" placeholder="Zip Code" class="form-control" name="postal_code">
        <!--
          IF CANADA
          pattern="[ABCEGHJKLMNPRSTVXY][0-9][ABCEGHJKLMNPRSTVWXYZ] ?[0-9][ABCEGHJKLMNPRSTVWXYZ][0-9]" 
          probably a way to change that in jquery?
        -->
      </div>
      <br>

      <div class="input-group input-group-lg">
        <label for="street" class="sr-only">Street Address</label>
        <span class="input-group-addon"><span class="glyphicon glyphicon-road secondary-color" title="Enter your birth date"></span></span>
        <input type="text" id="street" required placeholder="Street Address" class="form-control" name="street">
      </div>
      <br>

      <input type="submit" value="Sign up! :3" class="form-control btn-info" name="signUpSubmit">
    </form>
  </div>

  <div class="col-md-6">
    <img src="/images/signup_cat2.jpg" alt="A second cat, very cute" class="img-rounded hidden-xs hidden-sm col-md-12">
    <div class="overlay col-md-12"></div>
  </div>
  
</div>

<?php
include 'app/include/footer.php';  
?>