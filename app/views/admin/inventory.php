<!doctype html>
<html lang="en">
<head>
<title>Inventory</title>
<?php
include 'app/include/navbar.php';  
?>
  
    <div class="container">
        <h1 class="row">Inventory Management System</h1>
        <div class="row">
        <form class="col-xs-4" role="search" method="POST" action="/inventory" >
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search Product ID" name="searchString" id="srch-term">
                <div class="input-group-btn">
                    <button class="btn btn-info" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                </div>
            </div>
        </form>
        <button type="button" class="btn btn-info col-xs-2" data-toggle="modal" data-target="#addModal">
            Add an Item        
        </button>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
        $('.close').click(function(){
          $(this).parents('li').remove();
        })
        });
    </script>
    <div class="modal fade" id="addModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"
                      aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title">Add a Product</h4>
            </div>
            <div class="modal-body">
                <form action="/inventory/addItem" method="POST" enctype="multipart/form-data">
                    <h4><b>Product info</b></h4>
                    
                    <label for="title">Title</label>
                    <input type="text" autofocus required id="title" placeholder="Product Title" class="form-control" name="title">
                    <br>
                    
                    <label for="brand">Brand</label>
                    <input type="text" autofocus required id="brand" placeholder="Product Brand" class="form-control" name="brand">
                    <br>
                    
                    <label for="category">Category</label>
                    <select id="category" class="form-control" name="category">
<!--                generate categories-->
                        <?=$this->loadSelectCategories()?>
                    </select>
                    <br>
                    
                    <label for="productDesc">Product Descrition</label>
                    <textarea id="productDesc" rows="4" class="form-control" name="description"></textarea>
                    <br>
                    
                    <div class="form-group">
                      <div class="input-group">
                        <label for="cost" class="sr-only">Cost</label>
                        <div class="input-group-addon">$</div>
                        <div><input type="number" pattern="\\$?(([1-9](\\d*|\\d{0,2}(,\\d{3})*))|0)(\\.\\d{1,2})?" step="any" required id="cost"
                        placeholder="Price" class="form-control" name="price" min="0"></div> 
                      </div>
                    </div>
                    
                    
                    <div class="form-group">
                      <div class="input-group">
                        <label for="discount" class="sr-only">Discount</label>
                        <div><input type="number" pattern="[1-9]?\d\.\d{4}" step="any" id="discount"
                        placeholder="Discount (xx.xx%)" class="form-control" name="discount" min="0"></div> 
                        <div class="input-group-addon">%</div>
                      </div>
                    </div>
                    
                    <label for="quantity">Product Quantity</label>
                    <input type="number" autofocus required id="quantity" placeholder="Product Quantity" class="form-control" name="quantity" min="0">
                    <br>
                    
                    <hr>
                    
                    <h4><b>Images</b></h4>
                    
                    <!-- <p>This sweet piece should take the given images and upload them to the images db for this specific product id</p>
                    <a href="http://www.w3schools.com/php/php_file_upload.asp" >Click here for PHP instructions</a> -->
                    
                    <label for="productImage"></label>
                    <input type="file" name="image" accept="image/*" id="image">
                    
                    <hr>
                    
                    <input type="submit" value="Add Selected Item" class="form-control " name="addProductSubmit">
                </form>
            </div>
          </div>
        </div>
    </div>

    <hr>
    
    <div class="container">
        
        <div class="panel-group" id="accordion" role=tablist aria-multiselectable=true>
            <?=$this->loadItems()?>
        </div>
    </div>

<?php
include 'app/include/footer.php';  
?>