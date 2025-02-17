<?php

use Core\Authenticator;

Authenticator::logout();

header('Location: /');
exit();