<!doctype html>
<html lang="en">
<head>
<title>Home =^.^=</title>
<style>
/* Carousel base class */
body {
    height: 100%; 
    overflow: hidden;
}

.navbar {
    margin-bottom: 0px;
}

    .carousel {
        top: -20px;
    }

    .carousel-caption {
        top: 70%;
    }
.carousel,
.item,
div.active {
    height: 100%;
/*            top: -20px;*/

}

.carousel-inner {
    height: 100%;
}

.carousel-caption h1,
.carousel-caption .lead {
  margin: 0;
  line-height: 1.25;
  color: #fff;
  text-shadow: 0 1px 1px rgba(0,0,0,.4);
}

.btn-info{
    color: #FF6D9E;
    background-color: #221F1F;
    border-color: #FF6D9E;
}
    </style>
<?php
include 'app/include/navbar.php';  
?>

    <div id="myCarousel" class="carousel slide">
      <div class="carousel-inner">
        <div class="item active">
          <img src="/images/home1.jpg">
          <div class="container">
            <div class="carousel-caption">
                <div class="transparent-underlay">
              <h1>Welcome to Catmazon</h1>
              <p class="lead">The place for all your cat shopping needs</p>
                </div>
            </div>
          </div>
        </div>
        <div class="item">
          <img src="/images/home2.jpg" alt="">
          <div class="container">
            <div class="carousel-caption">
                <div class="transparent-underlay">
                    <h1>Join the family</h1>
                    <p class="lead">You and your feline friends can join the Catmazon family and have access to greats deals at all times.</p>
                    <a class="btn btn-large btn-info" href="/newUser">Sign up today</a>
                </div>
            </div>
          </div>
        </div>
        <div class="item">
          <img src="/images/home3.jpg" alt="">
          <div class="container">
            <div class="carousel-caption">
                <div class="transparent-underlay">
                    <h1>Shop our great deals</h1>
                    <p class="lead">Only the best products, at the best price.</p>
                    <a class="btn btn-large btn-info" href="/search">Shop deals</a>
                </div>
            </div>
          </div>
        </div>
      </div>
      <a class="left carousel-control" href="/#myCarousel" data-slide="prev">‹</a>
      <a class="right carousel-control" href="/#myCarousel" data-slide="next">›</a>
    </div><!-- /.carousel -->
<?php
include 'app/include/footer.php';  
?>