<?php

class products extends PDOLayer {
	public $avg_rating;
	public $brand;
	public $category_id;
	public $description;
	public $discount;
	public $discounted_price;
	public $five_star;
	public $four_star;
	public $id;
	public $one_star;
	public $price;
	public $quantity_in_stock;
	public $three_star;
	public $title;
	public $two_star;

	public function __construct() {
		PDOLayer::__construct();
	}

	public function checkTitle ($title){
		$assoc_array['title'] = $title;
        $isUnique = $this->where($assoc_array);
        if (count($isUnique) == 0){            
            return true;
        } else {
            //display an alert if the admin tries to add a product with a name already in our database
            $message = "Product name already exists!";
            echo "<script type='text/javascript'>alert('$message');</script>";
            return false;
        }
	}
}

?>