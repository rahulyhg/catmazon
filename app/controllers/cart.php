<?php 

class cart extends Controller {
	private $cart_details;
	// private $cookieCart;
	// private static $cookieId = 0;


	public function index () {
		$this->cart_details = $this->model('cart_details');
		//$this->cookieCart = isset($_COOKIE["catmazon_anon_cart"]) ? json_decode($_COOKIE['catmazon_anon_cart']) : array();
		if (isset($_COOKIE["catmazon_anon_cart"])){
		 	echo 'cookie: ';
		 	print_r(json_decode($_COOKIE['catmazon_anon_cart']));
		} else {'no cookie';}

		if (isset($_POST['changeQuantity']))
			$this->updateQty($_POST['changeQuantity'], $_POST['new_qty']);
		if (isset($_POST['deleteBtn']))
			$this->removeItem($_POST['deleteBtn']);
		if (isset($_POST['clearCart']))
			$this->clearCart();

		$this->view('home/cart');
		home::unsetSearch();
	}

	public function cartCount() {
		return home::cartCount();
	}

	public function loadCart() {
        $this->cart_details = $this->model('cart_details');
		$items_list = array();
		$return = '';
		if (isset($_SESSION['activeUser'])){
			$items_list = $this->cart_details->where(array('user_id' => $_SESSION['activeUser']));
		// } else {
		// 	$items_list = $this->cookieCart;
		 }
		if (!$items_list){
			$return = '<h4>No items in your cart! Why not add some? Browse our categories:</h4> ';
			$return .= home::loadCategories();
			return $return;
		}
		$product = $this->model('products');
		
		foreach ($items_list as $key => $value) {
		
		$product = $product->find($value->product_id);
        $images = $this->model('images');
        $assoc_array["product_id"] = $value->product_id;  
        $img_list = $images->where($assoc_array);
            
			$return .= '<div id="cartDetails'.$product->id.'" class="well col-xs-12">
	                <div class="col-xs-3"><img src="';
            if($img_list)
                $return.= 'data:image;base64,'.$img_list[0]->image;
                
                $return.='" style="max-width: 100%; class="img-rounded">
	                </div>
	                <div class="col-xs-6"><a href="/product/'.$product->id.'">
	                    <h4 id="title'.$product->id.'">'.$product->title.'</h4></a>

	                    <small>Ships from and sold by <b><span id="brand'.$product->id.'">'.$product->brand.'</span></b></small>
	                    <br><br>
	                    <p>';
             if ($product->quantity_in_stock == 0){
                 $return .= '<b>Out of stock!</b>';
             } else {
                if ($product->discount > 0)
                    $return .= '<span class="thumb-discount">CDN$ '.number_format((float)$product->price, 2, '.', '').'</span>';

                $return .= '<span class="thumb-price">CDN$ '.number_format((float)$product->discounted_price, 2, '.', '').'</span>';
             }
	               $return .=  '</div>
	                <div class="col-xs-3">
	                    <div class="row" style="height:50px;">
	                        <form action="#" method="POST">
	                            <div class="input-group">
	                                <label for="quantity'.$product->id.'" class="sr-only">Quantity of '.$product->id.'</label>
	                                <span class="input-group-addon">Quantity:</span>
	                                <input type="number" id="quantity'.$product->id.'" required class="form-control" min="0" value="';
            if ($product->quantity_in_stock == 0){
                 $return .= '0" style="border: 1px solid red;"' ;
                $value->quantity = 0;
                $value->update();
            } else {$return.=$value->quantity;}
            
                $return .='" name="new_qty" max=';
                            
            if ($product->quantity_in_stock > 9) {
                        $return .= '9';}
            else {$return .= $product->quantity_in_stock;}
            if ($product->quantity_in_stock == 0){
                 $return .= ' value=0 ';
            }
                        $return .='>';
            
                            $return .='<span class="input-group-btn">
	                                	<button type="submit" class="btn btn-default secondary-color pull-right" name="changeQuantity" value="'.$value->id.'"><span class="glyphicon glyphicon-floppy-save"></span></button>
	                                </span>
	                            </div>
	                        </form>
	                    </div>
	                    <div class="row">
	                        <form action="#" method="POST">
	                            <button type="submit" class="btn btn-danger pull-right" style="margin-top: 20px;" name="deleteBtn" value="'.$value->id.'">
	                                Delete Item <span class="glyphicon glyphicon-remove-circle"></span>
	                            </button>
	                        </form>
	                    </div>
	                </div>
	            </div>';
		}
		return $return;
	}

	public function add()
	{
        $this->cart_details = $this->model('cart_details');

		if (isset($_POST['addBtn'])){
			$product_id = $_POST['addId'];
			$quantity = $_POST['addQuantity'];
			// $found = false;
			
			if (isset($_SESSION['activeUser'])){
				$user = $_SESSION['activeUser'];
				$isInCart = $this->cart_details->where(array('user_id' =>$user,'product_id'=>$product_id));
				if ($isInCart){
					$this->cart_details->quantity = $quantity;
					$this->cart_details->update();
                    $this->index();
                    return true;
				}
				$this->cart_details->user_id = $user;
				$this->cart_details->quantity = $quantity;
				$this->cart_details->product_id = $product_id;
				$this->cart_details->insert();
			// } else if  (isset($_COOKIE["catmazon_anon_cart"])){
			// 	foreach ($this->cookieCart as $key => $val) {     
			// 		if($val["id"] === $product_id) {      
			// 			$found = true;
			// 			$val["quantity"] ++ ;
			// 			break;
			// 		} 
			// 	} 
			// } else {
			// 	if (!$found)$this->cookieCart[] = array('product_id'=>$product_id,'id'=>$product_id,'quantity'=>$quantity);
			// 	$cookie_contents = json_encode($this->cookieCart);
			// 	$_COOKIE['catmazon_anon_cart'] = $cookie_contents; 	
				}else {$message = "Please login to manage your cart!";
                echo "<script type='text/javascript'>alert('$message');</script>";
				}
		}
		$this->index();
	}
	
	public function updateQty($id, $qty)
	{
		if (isset($_SESSION['activeUser'])){
			$this->cart_details = $this->cart_details->find($id);
			$this->cart_details->quantity = $qty;
			$this->cart_details->update();

		// } else {

		// 	foreach ($this->cookieCart as $key => $val) {     
		// 		if($val["id"] === $id) {      
		// 			$val["quantity"] = $qty;
		// 			break;
		// 		} 
		// 	} 
		// 	$cookie_contents = json_encode($this->cookieCart); 
		// 	$_COOKIE['catmazon_anon_cart'] = $cookie_contents;
		}
	}

	public function removeItem($id)
	{
		if (isset($_SESSION['activeUser'])){
			$this->cart_details->find($id)->delete();
		// } else {
		// 	foreach ($this->cookieCart as $key => $val) {
		//       	if($val["id"] === $id) {
		//             unset($this->cookieCart[$val]);
		//             break;    
		//         } 
		//     } 
		//     $cookie_contents = json_encode($this->cookieCart); 
		//     $_COOKIE['catmazon_anon_cart'] = $cookie_contents;
		}

	}

	public function clearCart()
	{
		if (isset($_SESSION['activeUser'])){
			$this->cart_details = $this->cart_details->where(array('user_id'=>$_SESSION['activeUser']));
			foreach ($this->cart_details as $key => $value) {
				$value->delete();
			}

		// } else {
		//    unset($_COOKIE["catmazon_anon_cart"]);    
		 }
	}
}