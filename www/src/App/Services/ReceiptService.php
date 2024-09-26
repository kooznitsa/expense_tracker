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

    public function upload(array $file): void
    {
        $fileExtension = pathinfo($file["name"], PATHINFO_EXTENSION);
        $newFileName = bin2hex(random_bytes(16)) . "." . $fileExtension;
        $uploadPath = Paths::STORAGE_UPLOADS . "/" . $newFileName;

        if (!move_uploaded_file($file["tmp_name"], $uploadPath)) {
            throw new ValidationException(["receipt" => "Failed to upload file."]);
        }
    }
}
