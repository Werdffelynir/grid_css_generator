<?php

class Controller{

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


        $data = $this->import('views/pages/about.php',$data);
        echo $data;
        exit;
    }



    private function calc($prefix, $width, $padding, $grid)
    {
        $cssData = array();
        $inter = $grid-1;
        $paddingOnce = $padding / $width * 100;
        $paddingSum = $padding * ($grid - 1);

        for($i=0;$i<$inter;$i++)
        {
            $numColl = $i+1;

            if ($i<$inter-1){
                $cssData[] = $prefix.$numColl.",";
            }else{
                $cssData[] = $prefix.$numColl.
                    "{display:inline; float:left; margin:0 0 0 ".$paddingOnce."%; list-style:none;}\n".
                    ".first{margin-left:0; clear:left;}\n.full{display:block; width:100%; clear:both;}\n".
                    ".clear_line{clear: both; width: 100%; height: 1px; margin-top: -1px;}\n.clear:before, .clear:after{content: \" \"; display: table;}\n.clear:after {clear: both;}\n.clear {*zoom: 1;}\n".
                    ".lite{display:block; width:100%; clear:both;}";
            }
        }

        for($i2=0;$i2<$inter;$i2++)
        {
            $numColl = $i2+1;

            if ($i2 < $inter - 1){
                $cssData[] = $prefix.$numColl.":first-child,";
            }else{
                $cssData[] = $prefix.$numColl.":first-child{margin-left:0;}";
            }
        }

        $firstCalc = function () use ($width, $grid, $padding, $paddingSum){
            $firstCalcData[0] = ($width - $paddingSum) / $grid;
            for($i=1; $i < $grid-1; $i++)
                $firstCalcData[] = $firstCalcData[0] * ($i + 1) + $padding * $i;
            return $firstCalcData;
        };

        $resultCalc = function ()
        {
            $integr = $this->defcolum - 1;  // для цикла
            for($i=0; $i < $integr; $i++)
            {
                $this->resultcalcarray[] = $this->firstcalcarray[$i] / $this->defwidth * 100;
            }
        };

        for($i3=0;$i3<$inter;$i3++)
        {
            $numColl = $i3+1;
            $cssData[] = $prefix.$numColl."{width:".$this->resultcalcarray[$i3]."%;}";
        }

        return $cssData;
    }

    public function import($filePath,$data=array())
    {
        ob_start();
        extract($data);
        include self::$path.DIRECTORY_SEPARATOR.$filePath;
        return ob_get_clean();
    }
}