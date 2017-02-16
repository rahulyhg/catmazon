<?php 

class product extends Controller {

    public $productId;
    public $product;
    public $starRating;
    public $ratings;

    public function index ($id) {
        $this->productId = $id;
        $this->product = $this->model('products');
        $this->product = $this->product->find($id);
        if (isset($_POST['addCommentSubmit']))
            $this->addComment();
        if (isset($_POST['deleteCommentBtn']))
            $this->deleteComment($_POST['deleteCommentBtn']);

 
        
        
        $this->starRating = $this->product->avg_rating;
        $this->ratings = $this->model('ratings');
        $this->ratings = $this->ratings->where(array('product_id'=>$this->productId));

        $this->view('home/product_page');
            home::unsetSearch();
    }
   
    public function getTitle(){
        return $this->product->title;
    }

    public function getComments()
    {
        $return = '';
        
        if ($this->ratings){
            $user = $this->model('users');

            foreach ($this->ratings as $key => $value) {
                if ($value->comment) {
                    $user=$user->find($value->user_id);
                    $return.='<div id="comment'.$value->product_id.$value->user_id.'" class="well">
                                <span id="rating'.$value->product_id.$value->user_id.'">';
                    $return.= home::getStarRating($value->star_rating);
                    $return.= '</span>';
                    
                    if (isset($_SESSION['is_admin'])) { //if user is an admin, show a delete button
                        $return.='<form method="POST" action="#">
                                     <span><button class="btn btn-default glyphicon glyphicon-remove pull-right" style="color: red; border-color:white;" name="deleteCommentBtn" value="'.$value->user_id.'"></button></span>
                                  </form>';
                    }
                                    
                    $return.=      '<p><h6>By <span id="'.$value->user_id.'">'.$user->first_name.'</span></h6></p>
                                    <p id="description'.$value->product_id.$value->user_id.'">'.$value->comment.'</p>
                                </div>';
                }
            }
        }

        return $return;
    }

    public function loadSingleRatings()
    {   
        $return = '';
        
        $return .= '<img src="/images/fullStar.png"><img src="/images/fullStar.png"><img src="/images/fullStar.png"><img src="/images/fullStar.png"><img src="/images/fullStar.png"> x ';
        $return .= ($this->product->five_star)>0 ? $this->product->five_star : 0;
        $return .=              '<br><img src="/images/fullStar.png"><img src="/images/fullStar.png"><img src="/images/fullStar.png"><img src="/images/fullStar.png"><img src="/images/emptyStar.png"> x ';
        $return .= ($this->product->four_star)>0 ? $this->product->four_star : 0;
        $return .=              '<br><img src="/images/fullStar.png"><img src="/images/fullStar.png"><img src="/images/fullStar.png"><img src="/images/emptyStar.png"><img src="/images/emptyStar.png"> x ';
        $return .= ($this->product->three_star)>0 ? $this->product->three_star : 0;
        $return .=              '<br><img src="/images/fullStar.png"><img src="/images/fullStar.png"><img src="/images/emptyStar.png"><img src="/images/emptyStar.png"><img src="/images/emptyStar.png"> x ';
        $return .= ($this->product->two_star)>0 ? $this->product->two_star : 0;
        $return .=              '<br><img src="/images/fullStar.png"><img src="/images/emptyStar.png"><img src="/images/emptyStar.png"><img src="/images/emptyStar.png"><img src="/images/emptyStar.png"> x ';
        $return .= ($this->product->one_star)>0 ? $this->product->one_star : 0;
        $return .=              '<br>';
    return $return;

    }
    
    public function loadImages(){
        $images = $this->model('images');
        $assoc_array['product_id'] = $this->productId;
        $image_list = $images->where($assoc_array);
        $return = "";
        
        foreach($image_list as $key=>$image){
            if($key==0){
                $return .= '<div class="item active"><img src="data:image;base64,'.$image->image.'"></div>';       
            } else {
                $return .= '<div class="item"><img src="data:image;base64,'.$image->image.'"></div>';
            }
        }
        
        return $return;
        
    }
    public function addComment(){
        $rating = $this->model('ratings');

        if (isset($_POST['commentText']))
            $rating->comment = $_POST['commentText'];
        $rating->product_id = $this->productId;
        $rating->star_rating = $_POST['selectRating'];
        $rating->user_id = $_SESSION['activeUser'];

        if (!($rating->alreadyCommented())){
            $rating->insert();
            switch ($_POST['selectRating']){
                case 1: $this->product->one_star = $this->product->one_star +1;
                break;
                case 2: $this->product->two_star = $this->product->two_star +1;
                break;
                case 3: $this->product->three_star = $this->product->three_star +1;
                break;
                case 4: $this->product->four_star = $this->product->four_star +1;
                break;
                case 5: $this->product->five_star = $this->product->five_star +1;
                break;
            }
            $this->updateAvgRating();

        }
        else {
            $message = "You are only allowed one comment per product";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }  

        //$this->index($this->productId);    
    }

    public function updateAvgRating()
    {
            $count_ratings = $this->model('ratings');
            $count_ratings = $count_ratings->where(array('product_id'=>$this->productId));
            if (count($count_ratings != 0)){
                $rating_list[] = 0;
                foreach ($count_ratings as $key => $value) {
                    $rating_list[] = $value->star_rating;
                }
                $avg = array_sum($rating_list) / (count($rating_list)-1);
                $this->product->avg_rating = $avg;
            } else {
                $this->product->avg_rating = 0;
            }
            $this->product->update();
    }

    public function deleteComment($userID)
    {
        $rating = $this->model('ratings');

        $rating = $rating->where(array('user_id'=>$userID,'product_id'=>$this->productId))[0];

        switch ($rating->star_rating){
                case 1: $this->product->one_star = $this->product->one_star -1;
                break;
                case 2: $this->product->two_star = $this->product->two_star -1;
                break;
                case 3: $this->product->three_star = $this->product->three_star -1;
                break;
                case 4: $this->product->four_star = $this->product->four_star -1;
                break;
                case 5: $this->product->five_star = $this->product->five_star -1;
                break;
            }


        $rating->deleteRating();
        $this->updateAvgRating();

        //$this->index;    

    }
}