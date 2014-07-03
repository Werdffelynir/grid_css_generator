<?php

class Controller
{
    private $get=null;
    public $getDataContent=null;
    public static $path;

    public function __construct($get=null)
    {
        self::$path = dirname(__DIR__);
        $this->get = (!empty($get['p']))?$get['p']:'generator';

        if($this->get == 'generator')
            $this->getDataContent = $this->getPageGenerator();
        else if($this->get == 'examples')
            $this->getDataContent = $this->getPageExamples();
        else if($this->get == 'about')
            $this->getDataContent = $this->getPageAbout();
        else if($this->get == 'form')
            $this->generation($get);
    }

    private function getPageGenerator()
    {
        $data = $this->import('views/pages/generator.php',array(
            'form' => $this->import('views/parts/form.php')
        ));
        return $data;
    }

    private function getPageExamples()
    {
        $data = $this->import('views/pages/examples.php');
        return $data;
    }

    private function getPageAbout()
    {
        $data = $this->import('views/pages/about.php');
        return $data;
    }

    private function generation($data)
    {
        include 'Generator.php';
        $generator = new Generator($data['width'],$data['padding'],$data['grid'],$data['prefix']);
        $file = self::$path.'/result/grid.css';
        $css = $generator->saveCss($file);

        $data = "
            <div class='full clear gen'>
                <div class='first G3'>
                    <a href='result/grid.css' download ><img src='./resources/images/css-file.png' width='210' /></a>
                </div>
                <div class='G9 gen-code'>
                    <p><a href='result/grid.css' download >download file grid.css</a></p>
                    <div><code>$css</code></div>
                </div>
            </div>";
        echo $data;
        exit;
    }

    public function import($filePath,$data=array())
    {
        ob_start();
        extract($data);
        include self::$path.DIRECTORY_SEPARATOR.$filePath;
        return ob_get_clean();
    }
}