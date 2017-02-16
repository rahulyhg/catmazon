<?php 

class search extends Controller {
    private $SQL = " ";
    private $array = array();

    public function index () {

        $this->navbarSearch();
        $this->view('home/searchResults');
    }
    
    private function navbarSearch () {
        if (isset ($_POST['searchString'])){
            if  (isset($_SESSION['filterBy']) ||
                    isset($_SESSION['filterKey']) || 
                    isset($_SESSION['filterByPrice']) || 
                    isset($_SESSION['filterByCategory']) || 
                    isset($_SESSION['filterByRating']))
                $this->clearFilters();
            $searchString = strtolower('%'.$_POST['searchString'].'%');
            $_SESSION['searchString'] = $searchString;
        }
    }

   public function brands($string)
    {
        $_SESSION['searchString'] = ($string);
        $this->view('home/searchResults');
    }
    
    public function loadProducts(){
        $productList = $this->effectuateSearch();
        $return = '';

        if (count($productList) == 0){
            $return = "Sorry, we have no products to show with this criteria.";
        }

        $images = $this->model('images');
        
        foreach ($productList as $key => $value) {
        $assoc_array["product_id"] = $value->id;
        $img_list = $images->where($assoc_array);
            
            

            $return .= '<div class="col-xs-3" id="'.$key.'">
                        <div class="panel panel-default">
                          <div class="panel-body"><img src="';
            
            if($img_list)
                $return.= 'data:image;base64,'.$img_list[0]->image;
                
                $return.='" style="max-width: 100%;">';
                           
            
                          $return .= '</div>
                          <div class="panel-footer">
                            <a href="/product/'.$value->id.'", format, args)">'.ucwords($value->title).'</a>
                              <br/>
                              <h6>by '.ucwords($value->brand).'</h6>';
            $return .= home::getStarRating($value->avg_rating);
            $return .= '<br/>' ;            
            if ($value->discount > 0)
                $return .= '<span class="thumb-discount">CDN$ '.number_format((float)$value->price, 2, '.', '').'</span>';
           
            $return .= '<span class="thumb-discounted_price">CDN$ '.number_format((float)$value->discounted_price, 2, '.', '').'</span>';

            $return .= '   </div>
                        </div>
                    </div>';
            if ((($key+1) % 4 == 0) && ($key != 0)){
            $return .= '</div>
                        <div class="row">';
            }
        }
        return $return;
    }


    public function loadCategories() {
        return home::loadCategories();
    }

    public function loadPriceRange(){
        $product = $this->model('products');
        $product = $product->preparedStmt(' ORDER BY discounted_price DESC',array());
        $maxPrice = $product[0]->discounted_price;
        $resultString = '<li><a href="/search/filterBy/discounted_price/0_10">Under $10</a></li>';

        if ($maxPrice > 10) $resultString .= '<li><a href="/search/filterBy/discounted_price/10_50">$10 - $50</a></li>';
        if ($maxPrice > 50) $resultString .= '<li><a href="/search/filterBy/discounted_price/50_100">$50 - $100</a></li>';
        if ($maxPrice > 100) $resultString .= '<li><a href="/search/filterBy/discounted_price/100_250">$100 - $250</a></li>';
        if ($maxPrice > 250) $resultString .= '<li><a href="/search/filterBy/discounted_price/250_99999">$250 and above</a></li>';
        return $resultString;
    }

    public function filterBy($column, $searchKey){
        $_SESSION['filterBy'] = 1;
        if ($column == 'discounted_price'){
                $_SESSION['filterByPrice'] = true;
                $lohi = explode('_', $searchKey);
                $_SESSION["filterByPriceLow"] = $lohi[0];
                $_SESSION["filterByPriceHigh"] = $lohi[1];
        }
        if  ($column == 'category'){
            $_SESSION['filterByCategory'] = $searchKey;
        }
        if ($column == 'avg_rating'){
            $maxRating = ($searchKey/2) - 0.1;
            $_SESSION["filterByRating"] = $maxRating;
        }
        $this->index();
    }

    public function getFilterSQL (){
        $return = '';
        if (isset($_SESSION['filterByPrice']))
        { 
            $return .= 'discounted_price between ? and ? ';
            array_push($this->array, $_SESSION["filterByPriceLow"], $_SESSION["filterByPriceHigh"]);
            if (isset( $_SESSION['filterByCategory']) || isset( $_SESSION['filterByRating'])) $return .= 'AND ';
        }
        if (isset( $_SESSION['filterByCategory']))
        {
            array_push($this->array, $_SESSION['filterByCategory']);
            $return .= 'category_id = ? ';
            if (isset( $_SESSION['filterByRating'])) $return .= 'AND ';
        }
        if (isset( $_SESSION['filterByRating'])) {
            array_push($this->array, $_SESSION['filterByRating']);
            $return .= 'avg_rating > ? ';
        }
        return $return;
    }

    public function orderBy(){
        if (isset($_POST['orderBy'])){
            $_SESSION["selectedOrder"] = $_POST['orderBy'];
            $orderBy = explode('Z', $_POST['orderBy']);
            $_SESSION["orderBy"] = $orderBy[0];
            $_SESSION["ascOrDesc"] = $orderBy[1];
        }
        $this->index();
        return "ORDER BY ". $_SESSION['orderBy'] ." ".$_SESSION["ascOrDesc"];
    }

    public function clearFilters() {
        unset($_SESSION['filterBy']);
        unset($_SESSION['filterKey']);
        unset($_SESSION['filterByPrice']);
        unset($_SESSION['filterByCategory']);
        unset($_SESSION['filterByRating']);
        unset($_SESSION['filterByPriceHigh']);
        unset($_SESSION['filterByPriceLow']);

        $this->index();
    }

    private function effectuateSearch (){
        $products = $this->model('products');
        $this->SQL = ' ';
        if (isset($_SESSION['searchString'])){
            array_push($this->array, $_SESSION['searchString'], $_SESSION['searchString'], $_SESSION['searchString']);
            $this->SQL .= 'WHERE (LOWER(title) LIKE ? OR LOWER(brand) LIKE ? OR LOWER(description) LIKE ? )';
            if (isset($_SESSION['filterBy'])){
                $this->SQL .= 'AND '.$this->getFilterSQL();
            }
        }
        else if (isset($_SESSION['filterBy'])){ 
            $this->SQL .= ' WHERE '.$this->getFilterSQL();
        }
        if (isset($_SESSION['orderBy']))
            $this->SQL .= $this->orderBy();
        
//         echo ' session: ';
//         print_r($_SESSION);
//         echo ' this array: ';
//         print_r($this->array);
//         echo ' SQL: ';
//         print_r($this->SQL);
//        
        return $products->preparedStmt($this->SQL, $this->array);
    }
}
