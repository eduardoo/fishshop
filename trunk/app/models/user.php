<?php 
class User extends AppModel
{
    var $name = 'User';
    
	var $validate = array(
	 'usuario' => array(
	 			'alphanumeric' => array(
	 									'rule' => 'alphaNumeric',
	 									'required' => true,
	 									'message' => 'Usuario solo se aceptan letras y numeros'
	 									),
	 			'between' => array(
	 								'rule' => array('between', 5, 15),
	 								'message' => 'Usuario entre 5 y 15 caracteres'
	 								),
				'usuariounico'=> array(
									'rule'=>'isUnique',
									'message'=>'Usuario no admitido por favor eliga otro'
					
									)
	 					),
	 'clave' => array(
	 					'rule' => array('minLength', '6'),
	 					'message' => 'Clave de minimo seis caracteres'
	 					),			
	 'correo' => array ('rule'=>'email',
						'message'=>'Correo no valido'
						)
	);

	function beforeSave()
	{
		$this->data['User']['clave'] = md5($this->data['User']['clave']);
		return true;
	}

    function validateLogin($data)
    {
        $user = $this->find(array('usuario' => $data['usuario'], 'clave' => md5($data['clave'])), array('id', 'usuario'));
        if(empty($user) == false)
            return $user['User'];
        return false;
    }
    
}
?>