<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Services\{TransactionService, ValidatorService};

class TransactionController
{
    public function __construct(
        private TemplateEngine $view,
        private ValidatorService $validatorService,
        private TransactionService $transactionService,
    ) {
    }

    public function list(): void
    {
        $transactions = $this->transactionService->getUserTransactions();

        echo $this->view->render("index.php", [
            "title" => "Transactions",
            "transactions" => $transactions,
        ]);
    }

    public function createView(): void
    {
        echo $this->view->render("transactions/create.php");
    }

    public function create(): void
    {
        $this->validatorService->validateTransaction($_POST);
        $this->transactionService->create($_POST);

        redirectTo("/");
    }
}
