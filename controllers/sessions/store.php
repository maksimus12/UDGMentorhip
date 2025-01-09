<?php 


use Core\App;
use Core\Database;
use Core\Validator;

$db = App::resolve(Database::class);

$email = $_POST['email'];
$password = $_POST['password'];
$errors = [];

if(!Validator::email($email)){
    $errors['email'] = 'Provide a valid email';
}

if(!Validator::string($password,)){
    $errors['password'] = 'Provide a valid password';
}

if(!empty($errors)){
    return view('sessions/create.view.php',[
        'errors' => $errors
    ]);
}

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


