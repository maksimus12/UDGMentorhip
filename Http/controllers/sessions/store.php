<?php 


use Core\App;
use Core\Database;
use Http\Forms\LoginForm;


$db = App::resolve(Database::class);

$email = $_POST['email'];
$password = $_POST['password'];

$form = new LoginForm();

if(!$form->validate($email,$password)){
    return view('sessions/create.view.php',[
        'errors' => $form->errors()
    ]);
};


$user = $db->query('select * from users where email = :email', [
    'email' => $email,
])->find();


if($user){
    if(password_verify($password, $user['password'])){
        login([
            'user_id' => $user['id'],
            'email' => $email,
            'user_role' => $user['role']
        ]);
        header('Location: /');
        exit();
    }
}
return view('sessions/create.view.php', [
    'errors' => [
        'email' => 'Wrong email or password'
        ]
    ]);


