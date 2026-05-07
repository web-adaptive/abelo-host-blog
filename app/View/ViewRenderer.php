<?php

declare(strict_types=1);

namespace App\View;

use Smarty\Smarty;

final class ViewRenderer
{
    public function render(string $template, array $data = []): string
    {
        $smarty = new Smarty();
        $smarty->setTemplateDir(dirname(__DIR__, 2) . '/resources/views');
        $smarty->setCompileDir(dirname(__DIR__, 2) . '/storage/smarty/compile');
        $smarty->setCacheDir(dirname(__DIR__, 2) . '/storage/smarty/cache');

        foreach ($data as $key => $value) {
            $smarty->assign($key, $value);
        }

        return $smarty->fetch($template);
    }
}
