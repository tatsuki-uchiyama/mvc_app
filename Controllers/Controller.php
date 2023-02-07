<?php

class Controller
{
    public function view(string $template, array $params = []): void
    {
        $Smarty = new Smarty();
        $Smarty->template_dir = ROOT_PATH.'Views';
        $Smarty->compile_dir  = ROOT_PATH.'Views/compile';
        $Smarty->escape_html = true;
        $Smarty->assign($params);
        $Smarty->display($template.'.tpl');
    }
}