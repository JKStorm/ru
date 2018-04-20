<?php

use App\Middleware\RequestBodyValidator;
use App\Middleware\SubmitValidator;

/** Endpoint that receives XML data */
$app->post('/submit', '\App\SubmitController:index')
    ->add(new RequestBodyValidator())
    ->add(new SubmitValidator());

/** Endpoint that serves API requests */
$app->get('/api/match-data/football/{matchID}', '\App\APIController:football');
