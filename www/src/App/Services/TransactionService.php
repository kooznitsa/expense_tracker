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

    public function home(): void
    {
        echo $this->view->render("index.php", [
            "title" => "Home page",
        ]);
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

    public function getUserTransactions(): array
    {
        return $this->db->query(
            "SELECT *, DATE_FORMAT(date, '%Y-%m-%d') as formatted_date
            FROM transactions
            WHERE user_id = :userId
            ORDER BY date DESC",
            ["userId" => $_SESSION["user"]],
        )->findAll();
    }
}
