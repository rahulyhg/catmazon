<?php  
class App 
{

	protected $controller = 'home';

	protected $method = 'index';

	protected $params = [];

	public function __construct()
	{
		$url = $this->parseUrl();
		//checks if first part of url is a valid controller
		if(file_exists('app/controllers/' . $url[0].'.php')){
			$this->controller = $url[0];
			unset($url[0]);//remove the controller value from the array
		}

		require_once 'app/controllers/'.$this->controller.'.php';

		$this->controller = new $this->controller;

		//checks if second part of url is a valid method in the controller
		if (isset($url[1])){
			if (method_exists($this->controller, $url[1]))
			{
				$this->method = $url[1];
				unset($url[1]);//remove the method value from the array
			}
		}

		//since now the array is supposed to have only the remaining parameters values (excluding method and controller) we reorder the array starting at 0 again, and store it in $params
		$this->params = $url ? array_values($url) : [];

		//calls the controller.method with the parameters in $params
		call_user_func_array([$this->controller, $this->method], $this->params);
	}

	//add all the values from the url in $url
	public function parseUrl(){
		if (isset($_GET['url'])){
			return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
		}
	}
}

?>