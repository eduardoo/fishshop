<?php 
uses('sanitize');
class UsersController extends AppController
{
    var $name = "Users";
    var $helpers = array('Html', 'Form');
    


    function index()
    {
       
    }
    
    function beforeFilter()
    {
        $this->__validateLoginStatus();
    }

	
    
	function registrar()
	{
		$this->pageTitle = 'Registrarse';
	
		if (!empty($this->data)) //Se ha enviado los datos del formulario registrar
		{
			$mrClean = new Sanitize();
			$this->data=$mrClean->clean($this->data);
		    $this->User->create();
		
          	if ($this->User->save($this->data)) //Ojo dos parametros más por defecto el primero de ellos para validar
			{
		       	$this->Session->write('User', $this->User->findByUsuario($this->data['User']['usuario']));
            	$this->Session->setFlash('Thank you for registering.');
        		$this->redirect('/');
    		} 
			else 
			{
	        	$this->Session->setFlash('The User could not be saved. Please, try again.');
		    }
		}
		    
	}

    function login()
    {
		$this->pageTitle = 'Login';
	//	$this->layout = 'index';
		$mrClean = new Sanitize();
        if(empty($this->data) == false)
        {
			$this->data=$mrClean->clean($this->data);
            if(($user = $this->User->validateLogin($this->data['User'])) == true)
            {
                $this->Session->write('User', $user);
                $this->Session->setFlash('You\'ve successfully logged in.');
                $this->redirect('index');
               // exit();
            }
            else
            {
                $this->Session->setFlash('Sorry, the information you\'ve entered is incorrect.');
                //exit();
            }
        }
    }
    
    function logout()
    {
        $this->Session->destroy('User');
        $this->Session->setFlash('You\'ve successfully logged out.');
        $this->redirect('login');
    }
        
    function __validateLoginStatus()
    {
        if($this->action != 'login' && $this->action != 'logout' && $this->action != 'registrar')
        {
            if($this->Session->check('User') == false)
            {
                $this->redirect('login');
                $this->Session->setFlash('The URL you\'ve followed requires you login.');
            }
        }
    }
    
}

?>