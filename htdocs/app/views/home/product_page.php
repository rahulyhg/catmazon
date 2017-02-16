<!doctype html>
<html lang="en">
<head>
<title><?=$this->getTitle()?></title>
<style>
        .carousel-inner img{
            min-height: 300px;
            max-width: 100%;
        }
</style>
<?php
include 'app/include/navbar.php';  
?>

<!--    You can ignore this, this is just a script so that the carousel stops friggin moving all the friggin time-->
    <script type="text/javascript">
        $(document).ready(function() {
            if($("#addToCart").height() > $("#productPrice").height()){
                $(".carousel-inner img").css("height", $("#addToCart").height());
            } else {
                $(".carousel-inner img").css("height", $("#productPrice").height());
            }
            
        });
    </script>
    
    <div class="container">
        <div class="row">
            <div id="productCarousel" class="carousel slide col-xs-3 col-md-4" data-ride="carousel">

            <div class="carousel-inner" role="listbox">
                <?=$this->loadImages()?>
            </div>

            <!-- Controls -->
            <a class="left carousel-control" href="#productCarousel" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#productCarousel" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

            <div id="productPrice" class="col-xs-6 col-md-5">
<!--                Pretty self explanatory, put product title here -->
                <strong><p id="productTitle" class="lead"><?=$this->product->title?></p></strong>
<!--                The a link should take you back to the search page with a query for that brand name. It is also generated from the brand column on the table -->
                <p><small>by <a id="productBrand" href="/search/brands/<?=$this->product->brand?>"><?=$this->product->brand?></a></small></p>
                <div id="prodPriceRating">
                    <span id="prodPriceRatingStars" data-container="body" ddata-content="Popup with option trigger" rel="popover" data-placement="bottom" data-original-title="Individual Ratings" data-html="true">
                    <?php if ($this->starRating) echo home::getStarRating($this->starRating) ?>
               
                        
                        <script> 
/*                          This is the script that runs to make the popover appear when a user hovers the stars. The content should be generated through php.*/
                            $("#prodPriceRatingStars").popover({ 
                                trigger: "hover", 
                                content: '<?=$this->loadSingleRatings()?>'    
                            }); 
                        </script>
                    </span>
                    <span id="linkToComments" class="pull-right">
                        <a href="#commentSection">Take a look at the Reviews!</a>
                    </span>
                </div>
                <br>
<!- -                Here is where you pull the prices.-->             
                <p><?php if ($this->product->discount > 0): ?>
                    <span id="discountPrice">CDN$ <?=number_format((float)$this->product->price, 2, '.', '')?></span>
                <?php endif ?>
                    <span id="currentPrice">CDN$ <?=number_format((float)$this->product->discounted_price, 2, '.', '')?></span></p>
            </div>
            
            <div id="addToCart" class="col-xs-3 col-md-3" >
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Cart Management
                    </div>
                    <div class="panel-body">
<!--                        Form for adding to cart-->
                        <form action="/cart/add" class="form-inline" method="POST">
                            <div class="form-group">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="input-group">
                                    <label for="cost" class="sr-only">Product Quantity</label>
                                    <div class="input-group-addon">
                                        Quantity
                                    </div>
                                    <div>
                                        <input style="max-width: 70%"type="number" id="quantity" required class="form-control"   name="addQuantity" min="0" max="<?php if ($this->product->quantity_in_stock > 9): ?>9<?php else: ?><?=$this->product->quantity_in_stock?><?php endif ?>">
                                        
                                        <input type="text" name="addId" hidden value="<?=$this->productId?>">
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <button type="submit" class="btn btn-default secondary-color secondary-border-color secondary-hover center-block" name="addBtn" 
                            <?php if ($this->product->quantity_in_stock == 0): ?>
                                disabled> Product out of stock.
                            <?php elseif (isset($_SESSION['activeUser'])): ?>
                              > Add to <span class="glyphicon glyphicon-shopping-cart secondary-color" >  
                            <?php else: ?>
                               disabled> Log in to add products to your cart.
                            <?php endif ?></span></button>
                        </form>

                    </div>
                </div>
            </div>
            
        </div>
        
        <div class="row">
            <hr>
            <div id="productDescription">
                <p class="lead">Product Description</p>
<!--                Use the following to add the description text. -->
                <p id="productDescriptionText"><?=$this->product->description?></p>
            </div> 
        </div>
        
        <div class="row">
            <hr>
            <div id="commentSection">
                <p class="lead">Customer Reviews</p>
    <!--        IF HAS COMMENTS-->
                <?php if ($this->getComments()):?>
                <div class="row container">
                    <div id="ratingSection" class="col-xs-8">

                        Breakdown of Ratings <br>
                        <?=$this->loadSingleRatings()?>
                    </div>
<!--                IF LOGGED IN-->
                    <?php if (isset($_SESSION['activeUser'])):?>
                
                    <div id="commentButtonSection" class="col-xs-4">
                        <br><br>
                        <a href="#addCommentSection" style="color: white;"><button class="btn btn-danger" >Add a comment</button></a>
                    </div>
                    <?php endif ?>
<!--                END ID LOGGED IN -->

                </div>
                <hr>
                <div id="commentSection">
                    <?=$this->getComments()?>                    
                </div>
                <?php endif ?>
<!--            END IF HASCOMMENTS      -->
<!--            IF LOGGED IN-->
                <?php if (isset($_SESSION['activeUser'])):?>
                    
                <hr>
                <div id="addCommentSection">
                    <p class="lead">Add a Comment</p>
<!--                This form should add a rating in accordance to the User's ID and the product found on this page.-->
                    <form id="addCommentForm" action="#" method="POST">
                        <label for="ratingSelectAdd">Select a rating for this product: </label>
                        <select id="ratingSelectAdd" class="form-control" style="width: auto;" name="selectRating" required>
                            <option value="1">1 &#9733;&#9734;&#9734;&#9734;&#9734;</option>
                            <option value="2">2 &#9733;&#9733;&#9734;&#9734;&#9734;</option>
                            <option value="3">3 &#9733;&#9733;&#9733;&#9734;&#9734;</option>
                            <option value="4">4 &#9733;&#9733;&#9733;&#9733;&#9734;</option>
                            <option value="5">5 &#9733;&#9733;&#9733;&#9733;&#9733;</option>
                        </select>
                        <br>
                        <label for="commentTextAdd">What do you have to say about it? </label>
                        <textarea id="commentTextAdd" maxlength="255" rows="4" class="form-control" name="commentText"></textarea>
                        <br>
                        <input type="submit" value="Submit Comment" class="form-control  pull-right btn btn-info" style="width: auto;" name="addCommentSubmit">
                    </form>
                    <br>
                    <br>
                </div>
                <?php endif ?>
<!--            END IF LOGGED IN-->
            </div>
        </div>
    </div>
</body>
</html>