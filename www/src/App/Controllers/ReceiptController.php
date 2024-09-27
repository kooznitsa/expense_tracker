<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Services\{ReceiptService, TransactionService, ValidatorService};

class ReceiptController
{
    public function __construct(
        private TemplateEngine $view,
        private TransactionService $transactionService,
        private ReceiptService $receiptService,
        private ValidatorService $validatorService,
    ) {
    }

    public function uploadView(array $params): void
    {
        $transaction = $this->transactionService->getUserTransaction($params['transaction']);

        if (!$transaction) {
            redirectTo("/");
        }

        echo $this->view->render("receipts/create.php");
    }

    public function upload(array $params): void
    {
        $transaction = $this->transactionService->getUserTransaction($params['transaction']);

        if (!$transaction) {
            redirectTo("/");
        }

        $receiptFile = $_FILES["receipt"] ?? null;
        $this->validatorService->validateFile($receiptFile);
        $this->receiptService->upload($receiptFile, $transaction["id"]);

        redirectTo("/");
    }

    public function download(array $params): void
    {
        $receipt = $this->verifyExistingObjects($params);
        $this->receiptService->read($receipt);
    }

    public function delete(array $params): void
    {
        $receipt = $this->verifyExistingObjects($params);
        $this->receiptService->delete($receipt);

        redirectTo("/");
    }

    private function verifyExistingObjects(array $params): array
    {
        $transaction = $this->transactionService->getUserTransaction($params["transaction"]);

        if (empty($transaction)) {
            redirectTo("/");
        }

        $receipt = $this->receiptService->getReceipt($params["receipt"]);

        if (empty($receipt)) {
            redirectTo("/");
        }

        if ($receipt["transaction_id"] !== $transaction["id"]) {
            redirectTo("/");
        }

        return $receipt;
    }
}
