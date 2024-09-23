<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Config\Paths;

class AboutController
{
    public function __construct(
        private TemplateEngine $view = new TemplateEngine(Paths::VIEW),
    ) {}

    public function about(): void
    {
        echo $this->view->render("about.php", [
            "title" => "About",
            "dangerousData" => "<script>alert(123);</script>",
        ]);
    }
}
