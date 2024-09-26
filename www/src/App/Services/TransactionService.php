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
                "date" => "{$formData['date']} 00:00:00",
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
}
