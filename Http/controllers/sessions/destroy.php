<?php

use Core\Authenticator;

Authenticator::logout();
//logout();
header('Location: /');
exit();