<?php

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app->error(function (Exception $exception, Request $request, $code) use ($app) {
    switch ($code) {
        case Response::HTTP_NOT_FOUND:
            $message = 'The requested page could not be found.';
            break;
        case Response::HTTP_INTERNAL_SERVER_ERROR:
            if ($exception instanceof DomainException) {
                $message = $exception->getMessage();
                $code = Response::HTTP_BAD_REQUEST;
                break;
            }
            if (true === $app['debug']) {
                return;
            }
        default:
            $message = "We are sorry, but something went terribly wrong: {$exception->getMessage()}";
            break;
    }
    return new JsonResponse(array('errors'=> explode('|', $message)), $code);
});