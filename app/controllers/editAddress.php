<?php 

class editAddress extends Controller {
    public function index () {
        if (isset($_SESSION['activeUser'])){
            $this->view('users/editAddress');
        } else {
            $this->view('home/oops');
        }
        home::unsetSearch();
    }

    public function addAddress() {
        $address = $this->model('addresses');
        $assoc_array['user_id'] = $_SESSION['activeUser'];
        $address_list = $address->where($assoc_array);

        if( isset($_POST['add_address_submit'])) {

            $address->city = $_POST['city'];
            $address->country = $address_list[0]->country;;
            $address->postal_code = $_POST['postal_code'];
            $address->state = $_POST['state'];
            $address->street = $_POST['street'];
            $address->user_id = $_SESSION['activeUser'];
            $address->insert();
        }

        $this->view('users/editAddress');
    }

    public function deleteAddress($id) {
        $address = $this->model('addresses');
        $address = $address->find($id);
        $address->delete();

        $this->view('users/editAddress');

    }

    public function modifyAddress() {
        $address = $this->model('addresses');
        $address = $address->find(_POST('addressIDEdit'));
        
        //TO BE CONTINUED
        


        $this->view('users/editAddress');

    }

    //returns the country of residence of the user
    public function getCountry(){
        $address = $this->model('addresses');
        $assoc_array['user_id'] = $_SESSION['activeUser'];
        $this->address_list = $address->where($assoc_array);
        return $this->address_list[0]->country.'';
    }

    public function loadAddresses() {
        $address = $this->model('addresses');
        $assoc_array['user_id'] = $_SESSION['activeUser'];
        $this->address_list = $address->where($assoc_array);
        $return_string = ''; 
        //generates a string that will be output in the View 
        //loops through the addresses for this user and makes one entry for each, with a delete button only if there is more than one value
        for ($i=0; $i < count($this->address_list) ; $i++) { 
            $return_string = $return_string.'<div class="input-group input-group-lg">
            <input type="text" id="'.$this->address_list[$i]->id.'" readonly value="'.$this->address_list[$i]->street.', '.$this->address_list[$i]->city.', '.$this->address_list[$i]->state.'" class="form-control"><span class="input-group-btn"><button type="button" class="btn btn-default  secondary-color secondary-border-color secondary-hover"><span class="glyphicon glyphicon-pencil secondary-color" onCLick="editAddress('.$this->address_list[$i]->id.',\''.$this->address_list[$i]->street.'\',\''.$this->address_list[$i]->city.'\',\''.$this->address_list[$i]->state.'\',\''.$this->address_list[$i]->country.'\',\''.$this->address_list[$i]->postal_code.'\')" data-toggle="modal" data-target="#editModal"</button></span>
            '; 
            if (count($this->address_list) > 1) {
                $return_string = $return_string.'<span class="input-group-btn"><button type="button" class="btn btn-default secondary-border-color secondary-hover"><span class="glyphicon glyphicon-remove" style="color:red;" onCLick="location.href=\'/editAddress/deleteAddress/'.$this->address_list[$i]->id.'\'"></span></button>';
            }
            $return_string = $return_string.'</span></div>';
        }

        return $return_string;
    }
}