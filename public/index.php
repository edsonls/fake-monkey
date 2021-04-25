<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();


$app->post(
  '/v2/buyers/{id}/signatures/{purchaseId}/unapprove',
  function (Request $request, Response $response, $args) {
    $data = ['sponsorSignatureStatus' => randomStatus()];
    $payload = json_encode($data, JSON_THROW_ON_ERROR);
    $response->getBody()->write($payload);
    $log = [
      "args" => $args,
      "response" => $data,
      "headers" => pegaHeaders($request),
    ];
    salvaLog("unapprove", $log);
    return $response
      ->withHeader('Content-Type', 'application/json')
      ->withStatus(202);
  }
);

$app->post(
  '/v2/buyers/{id}/signatures/{purchaseId}/approve',
  function (Request $request, Response $response, $args) {
    $data = ['sponsorSignatureStatus' => randomStatus()];
    $payload = json_encode($data, JSON_THROW_ON_ERROR);
    $response->getBody()->write($payload);
    $log = [
      "args" => $args,
      "response" => $data,
      "headers" => pegaHeaders($request),
    ];
    salvaLog("approve", $log);
    return $response
      ->withHeader('Content-Type', 'application/json')
      ->withStatus(202);
  }
);

$app->post(
  '/v2/buyers/{id}/purchases/{purchaseId}/custodies-response',
  function (Request $request, Response $response, $args) {
    $status = [
      'APPROVED',
      'UNAPPROVED',
    ];
    $body = $request->getBody();
    $data = [
      'items' => [
        [
          'id' => (string)random_int(0, 1235478),
          'installment' => random_int(0, 1235478),
          'status' => $status[array_rand($status)],
        ],
        [
          'id' => (string)random_int(0, 1235478),
          'installment' => random_int(0, 1235478),
          'status' => $status[array_rand($status)],
        ],
        [
          'id' => (string)random_int(0, 1235478),
          'installment' => random_int(0, 1235478),
          'status' => $status[array_rand($status)],
        ],
        [
          'id' => (string)random_int(0, 1235478),
          'installment' => random_int(0, 1235478),
          'status' => $status[array_rand($status)],
        ],
      ],
      '_links' => [
        [
          'href' => 'google.com',
          'rel' => 'tt',
          'template' => true,
          'type' => 'algumacoisa',
        ],
        [
          'href' => 'google.com',
          'rel' => 'tt',
          'template' => true,
          'type' => 'algumacoisa',
        ],
        [
          'href' => 'google.com',
          'rel' => 'tt',
          'template' => true,
          'type' => 'algumacoisa',
        ],
        [
          'href' => 'google.com',
          'rel' => 'tt',
          'template' => true,
          'type' => 'algumacoisa',
        ],

      ],
    ];
    $payload = json_encode($data, JSON_THROW_ON_ERROR);
    $response->getBody()->write($payload);
    $log = [
      "args" => $args,
      "response" => $data,
      "body" => json_decode($body->getContents(), true, 512, JSON_THROW_ON_ERROR),
      "headers" => pegaHeaders($request),
    ];
    salvaLog("custodies-response", $log);
    return $response
      ->withHeader('Content-Type', 'application/json')
      ->withStatus(200);
  }
);


$app->post(
  '/oauth/token',
  function (Request $request, Response $response) {
    parse_str($request->getBody()->getContents(), $data);
    $data = (object)$data;
    $body = (json_encode($data, JSON_THROW_ON_ERROR));
    $data = [
      'access_token' => '8bf8047e-eb30-45cb-9145-73c759f2a594',
      'token_type' => 'bearer',
      'refresh_token' => 'ed6f1cca-2d0f-4341-b7d1-82f9a21171d7',
      'expires_in' => 430507,
      'scope' => 'api',
    ];
    $payload = json_encode($data, JSON_THROW_ON_ERROR);
    $response->getBody()->write($payload);
    $log = [
      "body" => $body,
      "headers" => pegaHeaders($request),
      "response" => $data,
    ];
    salvaLog("login", $log);
    return $response
      ->withHeader('Content-Type', 'application/json')
      ->withStatus(200);
  }
);
$app->run();

function randomStatus(): string
{
  $status = [
    'NOT_REQUIRED',
    'NOT-CARRIED',
    'WAITING',
    'APPROVED',
    'UNAPPROVED',
  ];
  return $status[array_rand($status)];
}

function salvaLog(string $log_name, $data): void
{
  $log = new Logger('Logs');
  $log->pushHandler(new StreamHandler("../logs/$log_name.log"));
  $log->info(
    "end-point->$log_name",
    $data,
  );
}

function pegaHeaders(Request $request): array
{
  $headers = $request->getHeaders();
  $resp = [];
  foreach ($headers as $name => $values) {
    $resp[$name] = $values;
  }
  return $resp;
}