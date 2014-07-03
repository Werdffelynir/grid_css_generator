<?php
/**
 * Created by Oleg Werdffelynir.
 * Date: 03.07.14
 * Time: 22:40
 */

class Generator
{

    /** @var number $width
     * символическая ширина всей сетки/страницы */
    private $width;
    /** @var number $padding
     * символическая ширина отступов */
    private $padding;
    /** @var number $grid
     * количество блоков/колонок */
    private $grid;
    /** @var string $prefix
     * префикс  */
    private $prefix;
    /** @var string $resetCode
     * дополнительный код сброса стилей */
    public $resetCode;
    /** @var string $addCode
     * дополнительный код */
    public $addCode;

    /** @var number $_percentPadding
     * Процентное соотнощение отступа к ширине */
    private $percentPadding;
    /** @var number $sumPadding
     * Сума всех отступов */
    private $sumPadding;

    private $math = array();

    private $cssData = array();

    public $min=true;

    public $pathToSave;

    public function __construct($width,$padding,$grid,$prefix='.g')
    {
        $this->width = $width;
        $this->padding = $padding;
        $this->grid = $grid;
        $this->prefix = $prefix;
    }

    private function math()
    {
        $this->percentPadding = $this->padding/$this->width*100;
        $this->sumPadding = $this->padding*($this->grid-1);

        $mathData[0] = ($this->width - $this->sumPadding) / $this->grid;

        $iterator = $this->grid-1;

        for($i=1; $i<$iterator; $i++)
            $mathData[] = $mathData[0] * ($i+1) + $this->padding * $i;

        for($j=0; $j<$iterator; $j++)
            $this->math[] = $mathData[$j] / $this->width * 100;
    }

    public function compile()
    {
        $this->math();

        $cssData = array();
        $iterator = $this->grid-1;

        for($i=0; $i<$iterator; $i++) {
            $numColumn = $i + 1;

            if ($i < $iterator-1){
                $cssData[] = $this->prefix.$numColumn.",";
            }else{
                $cssData[] = $this->prefix.$numColumn.
                    "{display:inline; float:left; margin:0 0 0 ".$this->percentPadding."%; list-style:none;}\n".
                    ".first{margin-left:0; clear:left;}\n.full,".$this->prefix.",".$this->prefix.$this->grid."{display:block; width:100%; clear:both;}\n".
                    ".clear_line{clear: both; width: 100%; height: 1px; margin-top: -1px;}\n.clear:before, .clear:after{content: \" \"; display: table;}\n.clear:after {clear: both;}\n.clear {*zoom: 1;}";
            }
        }

        for($j=0; $j < $iterator; $j++){
            $numColumn = $j + 1;
            if ($j < $iterator-1){
                $cssData[] = $this->prefix.$numColumn.":first-child,";
            }else{
                $cssData[] = $this->prefix.$numColumn.":first-child{margin-left:0;}";
            }
        }

        for($r = 0; $r < $iterator; $r ++) {
            $numColumn = $r + 1;
            $cssData[] = $this->prefix.$numColumn."{width:".$this->math[$r]."%;}";
        }

        $this->cssData = $cssData;
        return $this;
    }

    public function saveCss($path='../result/grid.css')
    {
        $this->pathToSave = $path;
        $this->compile();

        $cssString = "*{margin: 0; padding: 0; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box;}\n";

        foreach($this->cssData as $item)
            $cssString .= $item."\n";

        $resultCss = $cssString.$this->addCode.".hidden{visibility: hidden;}\n.txt_l{text-align: left;}\n.txt_r{text-align: right;}\n.txt_c{text-align: center;}\n.mg_t{margin-top: 0;}\n.mg_b{margin-bottom: 0;}\n.mg_l{margin-left: 0;}\n.mg_r{margin-right: 0;}";

        if($this->min)
            $resultCss = str_replace("\n","",$resultCss);

        file_put_contents($this->pathToSave, $resultCss);

        return $resultCss;
    }


    public function set($property,$value)
    {
        if(isset($this->$property))
            $this->$property = $value;
        else
            throw new Exception('Property <b>'.$property.'</b> is not exists!');
    }

    public function get($property)
    {
        if(isset($this->$property))
            return $this->$property;
        else
            throw new Exception('Property "'.$property.'" is not exists!');
    }

}