<?php

namespace App\Templating;

interface TemplateRendererInterface
{
    public function render($template, $params = []);
}