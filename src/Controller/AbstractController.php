<?php

namespace App\Controller;
abstract class AbstractController {
  protected function render($path, $variables):void {
    ob_start();
    extract($variables);
    include_once(__DIR__ . '/../Views/' . $path . '.view.php');
    $content = ob_get_contents();
    ob_end_clean();
    include_once(__DIR__ . '/../Views/Layouts/main.view.php');
  }
}
