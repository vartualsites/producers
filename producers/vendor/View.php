<?php

namespace Isystems\Vendor;

class View {

    /**
     * Adding content view if exists and extract its own params
     *
     * @param string $path
     * @param array $params
     */
    public function renderTemplate($path = '', $params = array()) {
        if(!$path)
            $this->showTemplate();

        if(!empty($params))
            extract($params);

        $explodePath = explode('.', $path);
        if(count($explodePath) == 1)
            $path = $path.'.php';

        $content = '';
        if(file_exists('view/'.$path)) {
            ob_start();
            require_once 'view/'.$path;
            $content = ob_get_clean();
        }

        $this->showTemplate($content);
    }

    /**
     * Show finished application view
     *
     * @param null $content
     * @return HTML
     */
    private function showTemplate($content = null) {
        require_once 'view/index.php';
    }
}