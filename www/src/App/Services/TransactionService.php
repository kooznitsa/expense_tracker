<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;

class TransactionService
{
    public function __construct(
        private Database $db,
    ) {
    }

    public function create(array $formData): void
    {
        $this->db->query(
            "INSERT INTO transactions (user_id, description, amount, date)
            VALUES (:user_id, :description, :amount, :date)",
            [
                "user_id" => $_SESSION["user"],
                "description" => $formData["description"],
                "amount" => $formData["amount"],
                "date" => $this->formatDate($formData["date"]),
            ],
        );
    }

    public function getUserTransactions(int $length, int $offset): array
    {
        $searchTerm = addcslashes($_GET["s"] ?? "", "%_");
        $params = [
            "userId" => $_SESSION["user"],
            "description" => "%{$searchTerm}%",
        ];

        $transactions = $this->db->query(
            "SELECT *, DATE_FORMAT(date, '%Y-%m-%d') as formatted_date
            FROM transactions
            WHERE user_id = :userId
            AND description LIKE :description
            ORDER BY date DESC
            LIMIT $length OFFSET $offset",
            $params,
        )->findAll();

        $transactions = array_map(function (array $transaction) {
            $transaction["receipts"] = $this->db->query(
                "SELECT * from receipts WHERE transaction_id = :transaction_id",
                ["transaction_id" => $transaction["id"]],
            )->findAll();
            return $transaction;
        }, $transactions);

        $transactionCount = $this->db->query(
            "SELECT COUNT(*)
            FROM transactions
            WHERE user_id = :userId
            AND description LIKE :description
            ORDER BY date DESC",
            $params,
        )->count();

        return [$transactions, $transactionCount];
    }

    public function getUserTransaction(string $id): mixed
    {
        return $this->db->query(
            "SELECT *, DATE_FORMAT(date, '%Y-%m-%d') as formatted_date
            FROM transactions
            WHERE id = :id AND user_id = :userId",
            [
                "id" => $id,
                "userId" => $_SESSION["user"],
            ]
        )->find();
    }

    public function update(array $formData, int $id): void
    {
        $this->db->query(
            "UPDATE transactions
            SET description = :description, amount = :amount, date = :date
            WHERE id = :id AND user_id = :userId",
            [
                "description" => $formData["description"],
                "amount" => $formData["amount"],
                "date" => $this->formatDate($formData["date"]),
                "id" => $id,
                "userId" => $_SESSION["user"],
            ]
        );
    }

    public function delete(int $id): void
    {
        $this->db->query(
            "DELETE FROM transactions WHERE id = :id AND user_id = :userId",
            [
                "id" => $id,
                "userId" => $_SESSION["user"],
            ],
        );
    }

    private function formatDate(string $date): string
    {
        return "$date 00:00:00";
    }
}
