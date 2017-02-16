<?php

class checkout extends Controller {
    public function index () {
        if (isset($_SESSION['activeUser'])) {
            $this->view('users/checkout');
        } else {
            $this->view('home/oops');
        }
        home::unsetSearch();
    }
    
    
    
    public function addPayment(){
		$payment = $this->model('payment_methods');
        
        if( isset($_POST['add_payment_submit']) && $payment->checkCardNumber($_POST['card_number'],$_SESSION['activeUser'])) {
            $payment->card_type = $_POST['card_type'];
            $payment->card_number = $_POST['card_number'];
            $payment->user_id = $_SESSION['activeUser'];
            $payment->insert();
        }
        $this->view('users/checkout');
    }
    
    public function getEmail() {
        $user=$this->model('users');
        $user=$user->find($_SESSION['activeUser']);
        $email = $user->email;
        return $email;
    }
    
    public function getTotal() {
        $cart_list = $this->model('cart_details');
        $assoc_array['user_id'] = $_SESSION['activeUser'];
        $cart_list = $cart_list->where($assoc_array);
        $total = [];
        foreach($cart_list as $cart){
            $product = $this->model('products');
            $product = $product->find($cart->product_id);
            array_push($total,floatval($cart->quantity) * floatval($product->discounted_price));
        }
        
        return number_format((float)array_sum($total), 2, '.', '');
    }
    
    public function loadAddresses(){
        $address_list = $this->model('addresses');
        $assoc_array['user_id'] = $_SESSION['activeUser'];
        $address_list = $address_list->where($assoc_array);
        $return ='';
        
        foreach($address_list as $address){
            $return .= '<option value="'.$address->id.'">'.$address->street.'</option>';
        }
        //echo $return;
        return $return;
    }
    
    public function loadPayment(){
        $payment_list = $this->model('payment_methods');
        $assoc_array['user_id'] = $_SESSION['activeUser'];
        $payment_list = $payment_list->where($assoc_array);
        $return ='';
        
        foreach($payment_list as $payment){
            $return .= '<option value="'.$payment->id.'">'.$payment->card_type.' ****-****-****-'.substr($payment->card_number, -4).'</option>';
        }
        return $return;
    }
    
    public function loadProducts() {
        $cart_list = $this->model('cart_details');
        $assoc_array['user_id'] = $_SESSION['activeUser'];
        $cart_list = $cart_list->where($assoc_array);
        $return = '';
        foreach($cart_list as $cart){
            if ($cart->quantity > 0){
                $product = $this->model('products');
                $product = $product->find($cart->product_id);

                // table gen
                $return .= '<tr id="cartDetails'.$cart->id.'">';

                //prod name col
                $return .= '<td id="productName'.$cart->id.'"><a id="link'.$product->id.'" href="/product/'.$product->id.'">';
                $return .= $product->title.'';
                $return .= '</a></td>';

                //quantity col
                $return .= '<td id="quantity'.$cart->id.'" class="text-center">';
                $return .= $cart->quantity.'';
                $return .= '</td>';

                //price col
                $return .= '<td id="price'.$cart->id.'" class="text-center">CDN$ ';
                $return .= number_format((float)$product->price, 2, '.', '');
                $return .= '</td>';

                //discount col
                $return .= '<td id="discount'.$cart->id.'" class="text-center">';
                $return .= number_format((float)$product->discount, 2, '.', '');
                $return .= '%</td>';

                //discounted price col
                $return .= '<td id="discountedPrice'.$cart->id.'" class="text-center">CDN$ ';
                $return .= number_format((float)$product->discounted_price, 2, '.', '');
                $return .= '</td>';

                $return .= '</tr>';
            }
        }
        
        return $return;
    }
    public $finalSaleID = 1;
    public function confirmSale(){
        if (isset($_POST['chooseAddress'])){
            $address_id = $_POST['chooseAddress'];
            $payment_id = $_POST['choosePayment'];
            $user_id    = $_SESSION['activeUser'];
            $date = getDate();
            $sale_date  = $date['year'].'/'.$date['mon'].'/'.$date["mday"].' '.$date['hours'].':'.$date['minutes'].':'.$date['seconds']; 
            $sale = $this->model('sales');
            $sale->user_id    = $user_id;
            $sale->payment_id = $payment_id;
            $sale->address_id = $address_id;
            $sale->sale_date  = $sale_date;
           
            $sale->insert();

            $cart_list = $this->model('cart_details');
            $assoc_array['user_id'] = $_SESSION['activeUser'];
            $cart_list = $cart_list->where($assoc_array);
            
            $added_sale = $this->model('sales');
            $arr['user_id'] = $user_id;
            $arr['payment_id'] = $payment_id;
            $arr['address_id'] = $address_id;
            $arr['sale_date'] = $sale_date;

            $added_sale = $added_sale->where($arr);

            $sale_id = $added_sale[0]->id;
            
            $this->finalSaleID = $sale_id;

            foreach($cart_list as $cart){
                if ($cart->quantity > 0){
                    $sale_detail = $this->model('sale_details');
                    $product = $this->model('products');
                    $product = $product->find($cart->product_id);

                    $sale_detail->sale_id = $sale_id;
                    $sale_detail->product_id = $product->id;
                    $sale_detail->quantity = $cart->quantity;
                    $sale_detail->price = $product->price;
                    $sale_detail->discounted_price = $product->discounted_price;
                    $sale_detail->discount = $product->discount;

                    $sale_detail->insert();

                    $product->quantity_in_stock = $product->quantity_in_stock - $cart->quantity;
                    $product->update();
                }
                    $cart->delete();
            }
        }
        $this->view('users/paymentSuccessful');
    }

    public function orderDetails()
    {
        return '<div class="container">
            <div class="jumbotron imaged-jumbo" style="background: #000 url(\'//c4.staticflickr.com/7/6092/6330704947_dd7e1b453c_b.jpg\') center center;">
                <div class="transparent-underlay">
                    <h1>Order completed!</h1>
                    <p class="secondary-color">Your order receipt is number '.$this->finalSaleID.'</p>

                </div>
            </div>  
        </div>';

    }
}