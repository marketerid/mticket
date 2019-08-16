<?php

namespace App\CssInliner;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

class CssInliner{

    /**
     * Filename of the view to render
     * @var string
     */
    private $view;
    /**
     * Data - passed to view
     * @var array
     */
    private $css;

    /**
     * @param string $view Filename/path of view to render
     * @param array $data Data of email
     */
    public function __construct($view, $css)
    {
        // Render the email view
        $this->view = $view;
        $this->css = $css;
    }

    public function convert()
    {
        $converter  = new CssToInlineStyles();
        $content    = $converter->convert(
            $this->view,
            $this->css
        );

        return $content;
    }
}