<?php 

class userPage extends Controller {

    public $user;

	public function index () {
        $this->user = $this->model('users');
        $this->user = $this->user->find($_SESSION['activeUser']);

		$this->view('users/userpage');
		home::unsetSearch();
	}
    public function editUser(){
        $id = $_SESSION['activeUser'];
        $user=$this->model('users');
        $user= $user->find($id);

        if (isset($_POST['editPasswordSubmit'])){
            $old_password = $_POST['oldPassword'];
            if(password_verify($old_password, $user->password_hash)){
                $new_password = $_POST['newPassword'];
                $confirm_password = $_POST['confirmPassword'];
                if(strcmp($new_password, $confirm_password) == 0){
                    $pass_hash = password_hash($new_password, PASSWORD_DEFAULT);
				    $user->password_hash = $pass_hash;
                    
                } else {
                    $message = 'Both new passwords do not match. Try again.';
                    echo "<script type='text/javascript'>alert('$message');</script>";
                }
            } else {
                $message = 'You have entered the wrong original password. Please try again.';
                echo "<script type='text/javascript'>alert('$message');</script>";
            }
        }

        if (isset($_POST['editInfoSubmit'])){
            $user->email = $_POST['emailEdit'];
            $user->main_phone = $_POST['homePhoneEdit'];
            $user->sec_phone = $_POST['secPhoneEdit'];

        }
        $user->update();
        $this->index();
    }

    public function loadOrders()
    {

        $sales = $this->model('sales');
        $sales = $sales->where(array('user_id'=>$_SESSION['activeUser']));

        $user=$this->model('users');
        $user=$user->find($_SESSION['activeUser']);
        $email = $user->email;
        $userID = $user->id;

        $return = '';

        foreach ($sales as $key => $sale) {
            $sale_details = $this->model('sale_details');
            $sale_details = $sale_details->where(array('sale_id'=>$sale->id));

            $payment = $this->model('payment_methods');
            $payment = $payment->find($sale->payment_id);

            $address = $this->model('addresses');
            $address = $address->find($sale->address_id);

            $return .= '<div id="order'.$sale->id.'" class="panel-default panel secondary-border-color">
                <div class="panel-heading secondary-color">
                    <div class="row">
                        <span class="col-xs-4">
                            Order ID: <b><span id=id'.$sale->id.'>'.$sale->id.'</span></b>
                        </span>
                        <span class="text-center col-xs-4">
                            Ordered by: 
                            <b>
                                <span id=email'.$userID.'>
                                    '.$email.'
                                </span>
                        </b>
                        </span>
                        <span class="col-xs-4">
                            <span class="pull-right">
                                Order Date: 
                                <b>
                                    <span id="orderDateORDERID">
                                        '.$sale->sale_date.'
                                    </span>
                        </b>
                        </span>
                        </span>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered table-responsive table-striped">
                        <caption><span class="lead glyphicon glyphicon-shopping-sale secondary-color"> </span> Order Contents</caption>
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Discount</th>
                                <th>Discounted Price</th>
                            </tr>
                        </thead>
                        <tbody>';

        $return .= $this->loadProducts($sale->id);        
                    
            $return .= ' </tbody>
                    </table>
                    <div class="row">
                        <b class="pull-right" style="margin-right: 25px;">Total: <span id="totalSALEDETAILSID">'.$this->getTotal($sale->id).'</span></b>
                    </div>
                    <hr>
                    <div>
                        <span class="glyphicon glyphicon-credit-card secondary-color lead"></span> <span>Paid With </span>
                        <br>
                        <span id="cardTitlePAYMENTID">'.$payment->card_type.'</span> <b>#****-****-****-<span id="cardNumberPAYMENTID">'.substr($payment->card_number, -4).'</span></b>.
                    </div>
                    <hr>
                    <div>
                        <span class="lead glyphicon glyphicon-home secondary-color"></span> <span>Shipped To </span>
                        <br>
                        <span id="streetADDRESSID">'.$address->street.'</span>, <span id="cityADDRESSID">'.$address->city.'</span>, '.$address->state.'<span></span>
                    </div>
                </div>
            </div>';
        }
        return $return;    

    }

    public function loadProducts($saleID) {
        $sale_detail = $this->model('sale_details');
        $sale_detail = $sale_detail->where(array('sale_id'=>$saleID));
        $return = '';
        foreach($sale_detail as $sale){
            if ($sale->quantity > 0){
                $product = $this->model('products');
                $product = $product->find($sale->product_id);

                // table gen
                $return .= '<tr id="cartDetails'.$sale->id.'">';

                //prod name col
                $return .= '<td id="productName'.$sale->id.'"><a id="link'.$product->id.'" href="/product/'.$product->id.'">';
                $return .= $product->title.'';
                $return .= '</a></td>';

                //quantity col
                $return .= '<td id="quantity'.$sale->id.'" class="text-center">';
                $return .= $sale->quantity.'';
                $return .= '</td>';

                //price col
                $return .= '<td id="price'.$sale->id.'" class="text-center">CDN$ ';
                $return .= number_format((float)$product->price, 2, '.', '');
                $return .= '</td>';

                //discount col
                $return .= '<td id="discount'.$sale->id.'" class="text-center">';
                $return .= number_format((float)$product->discount, 2, '.', '');
                $return .= '%</td>';

                //discounted price col
                $return .= '<td id="discountedPrice'.$sale->id.'" class="text-center">CDN$ ';
                $return .= number_format((float)$product->discounted_price, 2, '.', '');
                $return .= '</td>';

                $return .= '</tr>';
            }
        }
        
        return $return;
    }

    public function getTotal($saleID) {
        $sale_details = $this->model('sale_details');
        $sale_details = $sale_details->where(array('sale_id'=>$saleID));
        $total = [];
        foreach($sale_details as $sale){
            $product = $this->model('products');
            $product = $product->find($sale->product_id);
            array_push($total,floatval($sale->quantity) * floatval($product->discounted_price));
        }
        
        return number_format((float)array_sum($total), 2, '.', '');
    }

    public function loadPayment(){
        $payment_list = $this->model('payment_methods');
        $assoc_array['user_id'] = $_SESSION['activeUser'];
        $payment_list = $payment_list->where($assoc_array);
        $return ='';
        
        foreach($payment_list as $payment){
            $return .= '<div class="panel panel-default col-xs-3" id="payment'.$payment->id.'">
                    <div class="panel-body">
                        <span><span id="cardType'.$payment->id.'">'.$payment->card_type.'</span><br/> ****-****-****-<b><span id="cardNumberPAYMENTID">'.substr($payment->card_number, -4).'</span></b></span>
                    </div>
                </div>';
        }
        return $return;
    }
}
