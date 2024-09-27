<?php

declare(strict_types=1);

namespace App\Services;

use DateTime;
use Framework\Database;

class DiagramService
{
    public function __construct(
        private Database $db,
    ) {
    }

    public function getData(): array
    {
        $dataPoints = [];

        $result = $this->db->query(
            "WITH CTE AS (
                 SELECT DATE_FORMAT(date, '%Y-%m') month, SUM(amount) sum_
                 FROM transactions
                 WHERE user_id = :userId
                 AND YEAR(date) = YEAR(CURDATE())
                 GROUP BY month
             )
             SELECT month, sum_
             FROM CTE
             ORDER BY month",
            ["userId" => $_SESSION["user"]],
        )->findAll();

        foreach ($result as $row) {
            $month = explode("-", $row["month"])[1];
            $month = DateTime::createFromFormat('!m', $month)->format("F");
            $dataPoints[] = ["label" => $month, "y" => $row["sum_"]];
        }

        return $dataPoints;
    }
}
