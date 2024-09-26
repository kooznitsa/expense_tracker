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
        $page = $_GET["p"] ?? 1;
        $page = (int) $page;
        $length = 3;
        $offset = ($page - 1) * $length;
        $searchTerm = $_GET["s"] ?? null;
        [$transactions, $transactionCount] = $this->transactionService->getUserTransactions($length, $offset);
        $lastPage = ceil($transactionCount / $length);
        $pages = $lastPage ? range(1, $lastPage) : [];
        $pageLinks = array_map(
            fn($pageNum) => http_build_query(["p" => $pageNum, "s" => $searchTerm]),
            $pages,
        );

        echo $this->view->render("index.php", [
            "title" => "Transactions",
            "transactions" => $transactions,
            "currentPage" => $page,
            "previousPageQuery" => http_build_query([
                "p" => $page - 1,
                "s" => $searchTerm,
            ]),
            "lastPage" => $lastPage,
            "nextPageQuery" => http_build_query([
                "p" => $page + 1,
                "s" => $searchTerm,
            ]),
            "pageLinks" => $pageLinks,
            "searchTerm" => $searchTerm,
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
