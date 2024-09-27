<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Services\DiagramService;

class DiagramController
{
    public function __construct(
        private TemplateEngine $view,
        private DiagramService $diagramService,
    ) {
    }

    public function diagram(): void
    {
        $dataPoints = $this->diagramService->getData();

        echo $this->view->render("diagram.php", [
            "title" => "Diagram",
            "dataPoints" => $dataPoints,
        ]);
    }
}
