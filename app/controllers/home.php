<?php 
class Home extends Controller {
	
	public function index () {

		$this->view('home/index');
		//$this->unsetSearch();
	}

	public function login () {
		$user=$this->model('users');
		if( isset($_POST['email'])) {
			$email = $_POST['email'];
			$entered_password = $_POST['password'];
			$assoc_array['email'] = $email;
			$findUser = $user->where($assoc_array);
			if ( count($findUser) != 0){
                if(password_verify($entered_password, $findUser[0]->password_hash)){
                    $_SESSION['activeUser'] = $findUser[0]->id;
                    $_SESSION['activeUserFName'] = $findUser[0]->first_name;
                    if ($findUser[0]->is_admin == 1)
                        $_SESSION['is_admin'] = 1;
                } else {
                	$message = 'Username/password incorrect. Try again.';
                	echo "<script type='text/javascript'>alert('$message');</script>";
                }

			}
		}
		$this->view('home/index');
	}

	public function logout () {
		if (isset($_SESSION['activeUser']))
		{
			unset($_SESSION['activeUser']);
			unset($_SESSION['activeUserFName']);
		}
		if (isset($_SESSION['is_admin']))
			unset($_SESSION['is_admin']);

		$this->view('home/index');

	}

	public static function loadCategories() {
        $categories = Controller::model('categories');
		$category_list = $categories->findAll();
		$return_string = ''; 
        
        foreach ($category_list as $key => $value) {
            $return_string .= '<a href="/search/filterBy/category/'.$value->id.'"><option value='.$value->id.'>'.$value->category_name.'</option></a>';
        }

        return $return_string;
    }

    public static function cartCount() {
		if (isset($_SESSION['activeUser'])){
			$cart_details = Controller::model('cart_details');
			$cart_details = $cart_details->where(array('user_id' => $_SESSION['activeUser']));
			return (count($cart_details));
		} else if (isset($_COOKIE["catmazon_anon_cart"])){
			return count(json_decode($_COOKIE["catmazon_anon_cart"]));
		}
		else return 0;
	}

	public static function unsetSearch(){
		unset($_SESSION['filterBy']);
        unset($_SESSION['filterKey']);
        unset($_SESSION['filterByPrice']);
        unset($_SESSION['filterByCategory']);
        unset($_SESSION['filterByRating']);
        unset($_SESSION['searchString']);
        unset($_SESSION['filterByPriceHigh']);
        unset($_SESSION['filterByPriceLow']);
        unset($_SESSION['selectedOrder']);
        unset($_SESSION["orderBy"]);
        unset($_SESSION["ascOrDesc"]);
	}

	public static function getStarRating($avg_rating){
		$return = '';
		if ($avg_rating && $avg_rating >= 1){
            $fullCount=10; 
            $tensrate =  $avg_rating * 10;
            for ($i=0; $i < 5; $i++) { 
                if ($fullCount <= $tensrate){
                    $return .= '<img src="/images/fullStar.png">';
                    $fullCount += 10;
                } else if (($fullCount - $tensrate) < 5){
                    $return .= '<img src="/images/halfStar.png">';
                    $fullCount+=10;
                } else {
                    $return .= '<img src="/images/emptyStar.png">';
                }
            }
        }
       return $return;
	}
}
?>