<?php 

class searchbackup extends Controller {
    private $SQL = " ";

    public function index () {
        //unset($_SESSION);
        //$_SESSION[':searchString'] = '%%';
        //$_SESSION['selectedOrder']='titleZasc';

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
            echo $searchString;
            $_SESSION['searchString'] = $searchString;
        }
    }

    public function loadProducts(){
        $productList = $this->effectuateSearch();
        $return = '';

        if (count($productList) == 0){
            $return = "Sorry, we have no products to show with this criteria.";
        }

        foreach ($productList as $key => $value) {
            $return .= '<div class="col-xs-3" id="'.$key.'">
                        <div class="panel panel-default">
                          <div class="panel-body">';
                           // <img src=""style="max-width: 100%;">
                          $return .= '</div>
                          <div class="panel-footer">
                            <a href="">'.ucwords($value->title).'</a>
                              <br/>
                              <h6>by '.ucwords($value->brand).'</h6>';
            if ($value->avg_rating){
                $fullCount=10; 
                $tensrate =  $value->avg_rating * 10;
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
            $return .= '<br/>' ;            
            if ($value->discount)
                $return .= '<span class="thumb-discount">CDN$ '.number_format((float)$value->price, 2, '.', '').'</span>';
           
            $return .= '<span class="thumb-price">CDN$ '.number_format((float)$value->discounted_price, 2, '.', '').'</span>';

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
        $product = $product->preparedStmt(' ORDER BY price DESC',array());
        $maxPrice = $product[0]->price;
        $resultString = '<li><a href="/search/filterBy/price/0_10">Under $10</a></li>';

        if ($maxPrice > 10) $resultString .= '<li><a href="/search/filterBy/price/10_50">$10 - $50</a></li>';
        if ($maxPrice > 50) $resultString .= '<li><a href="/search/filterBy/price/50_100">$50 - $100</a></li>';
        if ($maxPrice > 100) $resultString .= '<li><a href="/search/filterBy/price/100_250">$100 - $250</a></li>';
        if ($maxPrice > 250) $resultString .= '<li><a href="/search/filterBy/price/250_99999">$250 and above</a></li>';
        return $resultString;
    }

    public function filterBy($column, $searchKey){
        $_SESSION['filterBy'] = true;
        $return = '';
        if ($column == 'price'){
                $_SESSION['filterByPrice'] = true;
                $lohi = explode('_', $searchKey);
                $_SESSION["filterByPriceLow"] = $lohi[0];
                $_SESSION["filterByPriceHigh"] = $lohi[1];
        }
        if  ($column == 'category'){
            $_SESSION['filterByCategory'] = $searchKey;
        }
        if ($column == 'avg_rating'){
            $maxRating = $searchKey/2;
            $_SESSION["filterByRating"] = $maxRating;
        }
        $this->index();
    }

    public function getFilterSQL (){
        $return = '';
        if (isset($_SESSION['filterByPrice']))
        { 
            $return .= 'price between :filterByPriceLow and :filterByPriceHigh ';
            if (isset( $_SESSION['filterByCategory']) || isset( $_SESSION['filterByRating'])) $return .= 'AND ';
        }
        if (isset( $_SESSION['filterByCategory']))
        {
            $return .= 'category_id = :filterByCategory ';
            if (isset( $_SESSION['filterByRating'])) $return .= 'AND ';
        }
        if (isset( $_SESSION['filterByRating'])) {
            $return .= 'avg_rating > :filterByRating ';
        }
        return $return;
    }

    public function orderBy(){
        if (isset($_POST['orderBy'])){
            $_SESSION['selectedOrder'] = $_POST['orderBy'];
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

        $this->index();
    }

    private function effectuateSearch (){
        $products = $this->model('products');
        $this->SQL = ' ';
        if (isset($_SESSION['searchString'])){
            
            $this->SQL .= 'WHERE LOWER(title) LIKE :searchString OR LOWER(brand) LIKE :searchString OR LOWER(description) LIKE :searchString ';
            if (isset($_SESSION['filterBy']))
                $this->SQL .= 'AND '.$this->getFilterSQL();
        }
        else if (isset($_SESSION['filterBy'])){ 
            $this->SQL .= ' WHERE '.$this->getFilterSQL();
        }
        if (isset($_SESSION['orderBy']))
            $this->SQL .= $this->orderBy();
        
        echo ' session: ';
        print_r($_SESSION);
        echo ' SQL: ';
        print_r($this->SQL);
        
        return $products->preparedStmt($this->SQL, $_SESSION);
    }
}
