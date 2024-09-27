<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;
use App\Config\Paths;
use Framework\Exceptions\ValidationException;

class ReceiptService
{
    public function __construct(
        private Database $db,
    ) {
    }

    public function upload(array $file, int $transactionId): void
    {
        $fileExtension = pathinfo($file["name"], PATHINFO_EXTENSION);
        $newFileName = bin2hex(random_bytes(16)) . "." . $fileExtension;
        $uploadPath = Paths::STORAGE_UPLOADS . "/" . $newFileName;

        if (!move_uploaded_file($file["tmp_name"], $uploadPath)) {
            throw new ValidationException(["receipt" => "Failed to upload file."]);
        }

        $this->db->query(
            "INSERT INTO receipts (transaction_id, original_filename, storage_filename, media_type)
            VALUES(:transaction_id, :original_filename, :storage_filename, :media_type)",
            [
                "transaction_id" => $transactionId,
                "original_filename" => $file["name"],
                "storage_filename" => $newFileName,
                "media_type" => $file["type"],
            ],
        );
    }

    public function getReceipt(string $id): array
    {
        return $this->db->query(
            "SELECT * FROM receipts WHERE id = :id",
            ["id" => $id],
        )->find();
    }

    public function read(array $receipt): void
    {
        $filePath = $this->getFilePath($receipt);

        if (!file_exists($filePath)) {
            redirectTo("/");
        }

        header("Content-Disposition: inline;filename={$receipt['original_filename']}");
        header("Content-Type: {$receipt['media_type']}");

        readfile($filePath);
    }

    public function delete(array $receipt): void
    {
        $filePath = $this->getFilePath($receipt);
        unlink($filePath);

        $this->db->query(
            "DELETE FROM receipts WHERE id = :id",
            ["id" => $receipt["id"]],
        );
    }

    private function getFilePath(array $receipt): string
    {
        return Paths::STORAGE_UPLOADS . "/" . $receipt["storage_filename"];
    }
}
