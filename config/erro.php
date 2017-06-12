<?php

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app->error(function (DomainException $exception, Request $request, $code) use ($app) {
    return new JsonResponse(array('errors'=> explode('|', $exception->getMessage())), Response::HTTP_BAD_REQUEST);
});