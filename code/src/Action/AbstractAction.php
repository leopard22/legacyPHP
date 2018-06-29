<?php

namespace App\Action;

use App\Templating\TemplateRendererInterface;
use Psr\Container\ContainerInterface;
use Zend\Diactoros\Response\HtmlResponse;

abstract class AbstractAction implements TemplateRendererInterface
{
    public function render($template, $params = [])
    {
        if ($params) {
            foreach ($params as $key => $val) {
                $name = $key;
                $$name = $val;
            }
        }

        ob_start();
        require dirname(dirname(dirname(__FILE__))) . '/include/' . $template;
        $content = ob_get_clean();

        ob_start();
        require dirname(dirname(dirname(__FILE__))) . '/include/template_base.php';
        return ob_get_clean();
    }
}