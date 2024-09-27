<?php

declare(strict_types=1);

namespace App\Config;

use Framework\App;
use App\Controllers\{
    AboutController, AuthController, DiagramController,
    ErrorController, ReceiptController, TransactionController,
};
use App\Middleware\{AuthRequiredMiddleware, GuestOnlyMiddleware};

CONST AUTH = AuthRequiredMiddleware::class;
CONST GUEST = GuestOnlyMiddleware::class;

function registerRoutes(App $app): void
{
    $app->get("/", [TransactionController::class, "list"])->add(AUTH);
    $app->get("/about", [AboutController::class, "about"]);
    $app->get("/register", [AuthController::class, "registerView"])->add(GUEST);
    $app->post("/register", [AuthController::class, "register"])->add(GUEST);
    $app->get("/login", [AuthController::class, "loginView"])->add(GUEST);
    $app->post("/login", [AuthController::class, "login"])->add(GUEST);
    $app->get("/logout", [AuthController::class, "logout"])->add(AUTH);
    $app->get("/transaction", [TransactionController::class, "createView"])->add(AUTH);
    $app->post("/transaction", [TransactionController::class, "create"])->add(AUTH);
    $app->get("/transaction/{transaction}", [TransactionController::class, "editView"])->add(AUTH);
    $app->post("/transaction/{transaction}", [TransactionController::class, "edit"])->add(AUTH);
    $app->delete("/transaction/{transaction}", [TransactionController::class, "delete"])->add(AUTH);
    $app->get("/transaction/{transaction}/receipt", [ReceiptController::class, "uploadView"])->add(AUTH);
    $app->post("/transaction/{transaction}/receipt", [ReceiptController::class, "upload"])->add(AUTH);
    $app->get("/transaction/{transaction}/receipt/{receipt}", [ReceiptController::class, "download"])->add(AUTH);
    $app->delete("/transaction/{transaction}/receipt/{receipt}", [ReceiptController::class, "delete"])->add(AUTH);
    $app->get("/diagram", [DiagramController::class, "diagram"])->add(AUTH);

    $app->setErrorHandler([ErrorController::class, "notFound"]);
}
