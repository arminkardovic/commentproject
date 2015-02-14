<?php
abstract class baseController{

		protected $load;

		public function __construct(){
			$this->load = new Load;
		}
		abstract public function index($args = false);

	}

	
?>