<?php 


class inventory extends Controller {
    public function index () {
        if (isset($_POST['editProductSubmit']))
        {
            editItem($_POST['editId']);
        }
        if (isset($_SESSION['is_admin'])){
            $this->view('admin/inventory');
        } else {
            $this->view('home/oops');
        }
        home::unsetSearch();
    }

    public function loadItems() {
        $products = $this->model('products');
        if (isset($_POST['searchString'])){
            $products = $products->find($_POST['searchString']);
            //$products = $products->preparedStmt('WHERE LOWER(title) LIKE :searchString', array('searchString'=> strtolower('%'.$_POST['searchString'].'%'))); 
            if (!$products){
                return 'No products found with the selected ID'; 
            }
        } else { 
            $products = $products->findAll();
        }

        $return_string = ''; 
        foreach ($products as $value) {
            if (count($products) ==1)
                $value = $products;
            $itemId = $value->id;
            $qos = $value->quantity_in_stock;
            $return_string .= '<div class="panel panel-';
            if ($qos > 0){
                $return_string .= 'default">';
            } else {
                $return_string .= 'danger">'; 
            }
            $return_string .='<div class="panel-heading" role="tab" id="heading'.$itemId.'">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#'.$itemId.'" aria-expanded="false" aria-controls="'.$itemId.'">
                          '.$itemId.' | '.$value->title.' <span class="pull-right">Quantity: '.$qos.'</span>
                        </a>
                    </h4>
                </div>
                <div id="'.$itemId.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading'.$itemId.'">
                    <div class="panel-body">
                        <div class="row ">
                            <div class="col-xs-6">
                                <div class="panel panel-default secondary-border-color">
                                    <div class="panel-body">
                                        <h4><b>Modify quantity</b></h4>
                                        <form action="/inventory/editItem/'.$itemId.'" method="POST">
                                            <div class="input-group">
                                                <input type="number" class="form-control" placeholder="Enter a new quantity" name="quantity" id="prodQuantity" value="'.$qos.'">
                                                <div class="input-group-btn">
                                                    <button class="btn btn-default secondary-border-color secondary-hover" type="submit" name="chgQtySubmit"><span class="glyphicon glyphicon-floppy-disk secondary-color"></span></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="panel panel-default secondary-border-color">
                                    <div class="panel-body">
                                        <h4><b>Modify Product Discount</b></h4>
                                        <form action="/inventory/editItem/'.$itemId.'" method="POST">
                                            <div class="input-group">
                                                <input type="number" pattern="[1-9]?\d\.\d{4}" step="any" required id="discount"
                                placeholder="Discount (xx.xx%)" value="'.$value->discount.'" class="form-control" name="discount">
                                                <div class="input-group-addon">%</div>
                                                <div class="input-group-btn">
                                                    <button class="btn btn-default secondary-border-color secondary-hover" type="submit" name="addDiscountSubmit"><span class="glyphicon glyphicon-floppy-disk secondary-color"></span></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="panel panel-default secondary-border-color">
                            <div class="panel-body">
                                <h4><b>Modify Product Information</b></h4>
                                <form action="/inventory/editItem/'.$itemId.'" method="POST">
                                    <label for="title">Title</label>
                                    <input type="text" autofocus required id="title" placeholder="Product Title" class="form-control" name="title" value="'.$value->title.'">
                                    <br>

                                    <label for="brand">Brand</label>
                                    <input type="text" autofocus required id="brand" placeholder="Product Brand" class="form-control" name="brand" value="'.$value->brand.'">
                                    <br>

                                    <label for="category">Category</label>
                                    <select id="category" class="form-control" name="category" value="'.$value->category_id.'">';

            $return_string .= $this->loadSelectCategories();
            $return_string .='</select>
                                    <br>

                                    <label for="productDesc">Product Description</label>
                                    <textarea id="productDesc" rows="4" class="form-control" name="description">'.$value->description.'</textarea>
                                    <br>

                                    <label for="cost" class="sr-only">Cost</label>
                                    <div class="form-group">
                                      <div class="input-group">
                                        <div class="input-group-addon">$</div>
                                        <div><input type="number" pattern="\\$?(([1-9](\\d*|\\d{0,2}(,\\d{3})*))|0)(\\.\\d{1,2})?" step="any" required id="cost"
                                        placeholder="Amount" class="form-control" name="price" value="'.$value->price.'"></div> 
                                      </div>
                                    </div>
                                    <input type="text" hidden value = "'.$itemId.'" name="editId" />
                                    <input type="submit" value="Accept Modifications" class="form-control secondary-color secondary-border-color secondary-hover" name="editProductSubmit">
                                </form>
                            </div>
                        </div>
                        <div class="panel secondary-border-color panel-default">
                            <div class="panel-body">
                                <h4 id="del"><b>Add image</b></h4>
                                <form action="/inventory/addImage" method="post" enctype="multipart/form-data">
                                    <p>Be warned, file limit is set to 75KB per image.</p>
                                    <label for="image"></label>
                                    <input type="hidden" name="getID" value="'.$itemId.'">
                                    <input type="file" class="col-xs-6" name="image" accept="image/*">
                                    <input type="submit" name="addImageButton" id="addImageButton" class="btn btn-danger secondary-border-color secondary-hover" value="Add Picture">
                                </form>
                                <hr>
                            </div>
                        </div>
                        <div class="panel panel-default secondary-border-color">
                            <div class="panel-body">
                                <h4 id="del"><b>Delete Images</b></h4>
                                <ul class="list-unstyled">'.$this->loadImages($itemId).'
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
            if (count($products) == 1)
                break;
        }

        return $return_string;
    }

    public function loadSelectCategories() {
        return Home::loadCategories();
    }

    public function addImage(){
        if(isset($_POST['addImageButton'])){
            if ($_FILES['image']['size'] == 0){
                $message = 'Please choose an image.';
                echo "<script type='text/javascript'>alert('$message');</script>";
            } else {
                if($_FILES['image']['size'] > 75000){
                    $message = 'The image was too big, maximum upload size is 75KB.';
                    echo "<script type='text/javascript'>alert('$message');</script>";
                } else { 
                    if(getimagesize($_FILES['image']['tmp_name'])){
                        $image= addslashes($_FILES['image']['tmp_name']);
                        $name= addslashes($_FILES['image']['name']);
                        $image = file_get_contents($image);
                        $image = base64_encode($image);
                    }
                    $id = $_POST['getID'];

                    $images = $this->model('images');
                    $images->product_id = $id;
                    $images->name = $name;
                    $images->image = $image;
                    $images->insert();
                }
            }
            
        }
        $this->view('admin/inventory');     
    }

    public function loadImages ($id) {

        $images = $this->model('images');
        $assoc_array["product_id"] = $id;
        $img_list = $images->where($assoc_array);
        $return_string = ''; 

        foreach($img_list as $image){
            $return_string .= '<li class="col-xs-4">
                                    <div class="thumbnail">
                                      <a class="close" href="/inventory/deleteImage/'.$image->id.'">×</a>'.$image->id.'<img src="data:image;base64,'.$image->image.'"></div></li>';
        }

        return $return_string;
    }

    public function addItem () {
        if (isset($_POST['addProductSubmit'])){
            $product = $this->model('products');

            //check if there is a product with this title
            ($product->checkTitle($_POST['title'])) ? $product->title = $_POST['title'] : $this->view('admin/inventory');
            $product->brand = $_POST['brand'];
            $product->category_id = $_POST['category'];
            $product->description = $_POST['description'];
            $product->price = $_POST['price'];
            $product->quantity_in_stock = $_POST['quantity'];
            $product->discount = $_POST['discount'];
            $product->insert();


            if(getimagesize($_FILES['image']['tmp_name'])){
                $image= addslashes($_FILES['image']['tmp_name']);
                $name= addslashes($_FILES['image']['name']);
                $image = file_get_contents($image);
                $image = base64_encode($image);
            }

            $folder="/xampp/htdocs/images/";


            $arr['title'] = $_POST['title'];
            $foundProduct = $product->where($arr);
            $id = $foundProduct[0]->id;

            $images = $this->model('images');
            $images->product_id = $id;
            $images->name = $name;
            $images->image = $image;
            $images->insert();

        }
        $this->view('admin/inventory');
    }



    public function editItem($id) {
        $product = $this->model('products');
        $product = $product->find($id);
        if (isset($_POST['editProductSubmit'])){
            //check if there is a product with this title
            if ($_POST['title'] != $product->title)
                ($product->checkTitle($_POST['title'])) ? $product->title = $_POST['title'] : $this->view('admin/inventory');
            $product->brand = $_POST['brand'];
            $product->category_id = $_POST['category'];
            $product->description = $_POST['description'];
            $product->price = $_POST['price'];
        }
        if (isset($_POST['addDiscountSubmit'])){
            $product->discount = $_POST['discount'];
        }
        if (isset($_POST['chgQtySubmit'])){
            $product->quantity_in_stock = $_POST['quantity'];
        }

        $product->update();
        $this->view('admin/inventory');
    }

    public function deleteImage($id){
        $images = $this->model('images');
        $images = $images->find($id);
        $images->delete();
        $this->view('admin/inventory');
    }
}