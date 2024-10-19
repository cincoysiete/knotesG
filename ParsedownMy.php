<?php

require_once 'Parsedown.php'; 

class MyParsedown extends Parsedown
{
    // Habilita los saltos de línea automáticos
    protected $breaksEnabled = true; 

    public function __construct()
    {
        // Activamos la opción de saltos de línea sin dos espacios
        $this->setBreaksEnabled(true);
    }

    public function text($text)
    {
        // Procesa el texto Markdown y aplica la configuración para saltos de línea automáticos
        return parent::text($text);
    }
}


