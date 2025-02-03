<?php

use auth\application\actions\PostSignIn;
use auth\application\actions\PostSignUp;


return [
    PostSignIn::class => DI\autowire(),
    \auth\application\actions\TokenValidation::class => DI\autowire(),
    PostSignUp::class => DI\autowire(),
];
