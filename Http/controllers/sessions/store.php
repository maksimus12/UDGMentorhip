<?php 

use Core\Authenticator;
use Http\Forms\LoginForm;


$email = $_POST['email'];
$password = $_POST['password'];

$form = new LoginForm();

if($form->validate($email, $password))
    {

        if((new Authenticator)->attempt($email, $password))
        {
            redirect('/');
        }
    }
        $form->error('email', "Wrong email or password");
    }

    return view('sessions/create.view.php',[
        'errors' => $form->errors()
    ]);





