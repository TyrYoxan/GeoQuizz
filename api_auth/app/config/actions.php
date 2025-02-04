<?php

use api_auth\application\actions\PostSignIn;
use api_auth\application\actions\PostSignUp;


return [
    PostSignIn::class => DI\autowire(),
    \api_auth\application\actions\TokenValidation::class => DI\autowire(),
    PostSignUp::class => DI\autowire(),
];
