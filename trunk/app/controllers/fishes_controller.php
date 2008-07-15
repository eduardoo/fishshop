<?php 
class FishesController extends AppController
{ 
	//var $uses=null;//Para que no utilice la base de datos
	var $paginate = array('limit' => 15, 'page' => 1);
	
	function disco()
	{
		
	}
	
	function display() {
	        $this->set('peces', $this->paginate('Fish'));
	
	  }
	
}
?>