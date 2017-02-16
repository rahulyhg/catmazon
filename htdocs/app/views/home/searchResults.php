<!doctype html>
<html lang="en">
<head>
<title>Search Results</title>

<?php
include 'app/include/navbar.php';  
?>	
    <div class="sidebar col-md-2 col-xs-3">
        <h3>Filter by</h3>
        <div class="panel panel-default">
            <div class="panel-heading">
                <span>Categories</span>
                <a data-toggle="collapse" href="#collapseCategories"><span class="glyphicon glyphicon-folder-open pull-right categories-span secondary-color"></span></a>
            </div>
            <div id="collapseCategories" class="panel-collapse collapse">
                <div class="panel-body">
                    <ul class="list-unstyled">
                        <?=$this->loadCategories()?>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="panel panel-default">
            <div class="panel-heading">
                <span>Price Range</span>
                <a data-toggle="collapse" href="#collapsePriceRange"><span class="glyphicon glyphicon-folder-open pull-right categories-span secondary-color"></span></a>
            </div>
            <div id="collapsePriceRange" class="panel-collapse collapse">
                <div class="panel-body">
                    <ul class="list-unstyled">
                        <?=$this->loadPriceRange()?>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="panel panel-default">
            <div class="panel-heading">
                <span>Rating</span>
                <a data-toggle="collapse" href="#collapseRating"><span class="glyphicon glyphicon-folder-open pull-right categories-span secondary-color"></span></a>
            </div>
            <div id="collapseRating" class="panel-collapse collapse">
                <div class="panel-body">
                    <ul class="list-unstyled">
                        <li><a href="search/filterBy/avg_rating/2"><img src="/images/fullStar.png"><img src="/images/emptyStar.png"><img src="/images/emptyStar.png"><img src="/images/emptyStar.png"><img src="/images/emptyStar.png"></a></li>
                        <li><a href="/search/filterBy/avg_rating/3"><img src="/images/fullStar.png"><img src="/images/halfStar.png"><img src="/images/emptyStar.png"><img src="/images/emptyStar.png"><img src="/images/emptyStar.png"></a></li>
                        <li><a href="/search/filterBy/avg_rating/4"><img src="/images/fullStar.png"><img src="/images/fullStar.png"></a><img src="/images/emptyStar.png"><img src="/images/emptyStar.png"><img src="/images/emptyStar.png"></li>
                        <li><a href="/search/filterBy/avg_rating/5"><img src="/images/fullStar.png"><img src="/images/fullStar.png"></a><img src="/images/halfStar.png"><img src="/images/emptyStar.png"><img src="/images/emptyStar.png"></li>
                        <li><a href="/search/filterBy/avg_rating/6"><img src="/images/fullStar.png"><img src="/images/fullStar.png"><img src="/images/fullStar.png"><img src="/images/emptyStar.png"><img src="/images/emptyStar.png"></a></li>
                        <li><a href="/search/filterBy/avg_rating/7"><img src="/images/fullStar.png"><img src="/images/fullStar.png"><img src="/images/fullStar.png"><img src="/images/halfStar.png"><img src="/images/emptyStar.png"></a></li>
                        <li><a href="/search/filterBy/avg_rating/8"><img src="/images/fullStar.png"><img src="/images/fullStar.png"><img src="/images/fullStar.png"><img src="/images/fullStar.png"><img src="/images/emptyStar.png"></a></li>
                        <li><a href="/search/filterBy/avg_rating/9"><img src="/images/fullStar.png"><img src="/images/fullStar.png"><img src="/images/fullStar.png"><img src="/images/fullStar.png"><img src="/images/halfStar.png"></a></li>
                        <li><a href="/search/filterBy/avg_rating/10"><img src="/images/fullStar.png"><img src="/images/fullStar.png"><img src="/images/fullStar.png"><img src="/images/fullStar.png"><img src="/images/fullStar.png"></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <form action="/search/clearFilters">
          <input type="submit" value="Clear filters" class="btn-info" />
        </form>
    </div>
    
    

    <div class="col-xs-9 col-md-10 divider-vertical">

        <div class="container">
            <div class="row">
            <div class="col-xs-12 panel-body pull-right">
              <form method="POST" action="/search/orderBy">
                Sort by: 
                <select name="orderBy" id="orderBy">
                    <option <?php if (isset($_SESSION['selectedOrder'])) echo($_SESSION['selectedOrder'] == 'titleZasc' ? "selected" : '');?> value="titleZasc">Name - Ascending</option>
                    <option <?php if (isset($_SESSION['selectedOrder'])) echo($_SESSION['selectedOrder'] == 'titleZdesc' ? "selected" : '');?> value="titleZdesc">Name - Descending</option>
                    <option <?php if (isset($_SESSION['selectedOrder'])) echo($_SESSION['selectedOrder'] == 'avg_ratingZdesc' ? "selected" : '');?> value="avg_ratingZdesc">Rating - Descending</option>
                    <option <?php if (isset($_SESSION['selectedOrder'])) echo($_SESSION['selectedOrder'] == 'avg_ratingZasc' ? "selected" : '');?> value="avg_ratingZasc">Rating - Ascending</option>
                    <option <?php if (isset($_SESSION['selectedOrder'])) echo($_SESSION['selectedOrder'] == 'priceZasc' ? "selected" : '');?> value="priceZasc">Price - Ascending</option>
                    <option <?php if (isset($_SESSION['selectedOrder'])) echo($_SESSION['selectedOrder'] == 'priceZdesc' ? "selected" : '');?> value="priceZdesc">Price - Descending</option>
                    <option <?php if (isset($_SESSION['selectedOrder'])) echo($_SESSION['selectedOrder'] == 'brandZasc' ? "selected" : '');?> value="brandZasc">Brand - Ascending</option>
                    <option <?php if (isset($_SESSION['selectedOrder'])) echo($_SESSION['selectedOrder'] == 'brandZdesc' ? "selected" : '');?> value="brandZdesc">Brand - Descending</option>
                </select>
                <input type="submit" value="Go" name="orderByButton">
              </form>
            </div>
                



            <hr>

            <div class="row">
              <?=$this->loadProducts()?>
            </div>
        </div>
    </div>
<?php
include 'app/include/footer.php';  
?>