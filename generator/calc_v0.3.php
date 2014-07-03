<?php

class Calcgrid{
    public $pistavka = ".lite_";
    public $defwidth;   // символическая ширина всей сетки/страницы
    public $defmargin;  // символическая ширина отступов
    public $defcolum;   // количество блоков/колонок
    //public $hormargin = "10";
    
    public $onemargin;                  // в % один отступ (нужен в формировании CSS)
    public $sumallmargin;               // сума всх отступов
    public $firstcalcarray = array();   // первичный расщет в px
    public $resultcalcarray = array();  // результат в %
    public $my_code;
    
    // Конструктор принимает $w - ширину всей сетки, $m - ширина отсупа между блоками, $c - количество блоков
    function __construct($w, $m, $c, $my_code = '')
    {
        $this->defwidth  = $w;
        $this->defmargin = $m;
        $this->defcolum  = $c;
        $this->my_code   = $my_code;
        
        $this->onemargin = $m / $w * 100;   // ширина одного отступа (нужен в формировании CSS)
        $this->sumallmargin = $m * ($c - 1);// сума всех отступов
        
        $this->firstcalc();     // сразу вызов метода первичного прощета
        $this->resultcalc();    // и результатирущего, результат в % помещен в свойство массив $resultcalcarray
    }
    
    // Первичный расчет значений
    function firstcalc()
    {
        // defual_margin / defual_width * 100 = one_margin_in_%
        $this->firstcalcarray[0] = ($this->defwidth - $this->sumallmargin) / $this->defcolum;
        
        $integr = $this->defcolum - 1;  // для цикла
        for($i=1; $i < $integr; $i++)
        {
            $this->firstcalcarray[] = $this->firstcalcarray[0] * ($i + 1) + $this->defmargin * $i;
        }
        
    }
    
    // Результативный расчет в процентах
    function resultcalc()
    {
        $integr = $this->defcolum - 1;  // для цикла
        for($i=0; $i < $integr; $i++)
        {
            $this->resultcalcarray[] = $this->firstcalcarray[$i] / $this->defwidth * 100;
        }
    }
    
    
    function compl_calc()
    {
        $basecss = array();
        
        $integr = $this->defcolum - 1;  // для цикла
        for($i = 0; $i < $integr; $i ++)
        {
            $num_coll = $i + 1;
            
            if ($i < $integr - 1){
                $basecss[] = $this->pistavka.$num_coll.",";
            }else{
                $basecss[] = $this->pistavka.$num_coll.
                "{display:inline; float:left; margin:0 0 0 ".$this->onemargin."%; list-style:none;}\n".
                ".first{margin-left:0; clear:left;}\n.full{display:block; width:100%; clear:both;}\n".
                ".clear_line{clear: both; width: 100%; height: 1px; margin-top: -1px;}\n.clear:before, .clear:after{content: \" \"; display: table;}\n.clear:after {clear: both;}\n.clear {*zoom: 1;}\n".
                ".lite{display:block; width:100%; clear:both;}";
                //margin-bottom: ".$this->hormargin."px;
            }
        }
        
        for($i2 = 0; $i2 < $integr; $i2 ++)
        {
            $num_coll = $i2 + 1;
            
            if ($i2 < $integr - 1){
                $basecss[] = $this->pistavka.$num_coll.":first-child,";
            }else{
                $basecss[] = $this->pistavka.$num_coll.":first-child{margin-left:0;}";
            }
        }
        
        for($i3 = 0; $i3 < $integr; $i3 ++)
        {
            $num_coll = $i3 + 1;
            $basecss[] = $this->pistavka.$num_coll."{width:".$this->resultcalcarray[$i3]."%;}";
        }
        
        return $basecss;
    }
    
    function get_add_css()
    {
        $addcss = file_get_contents('./core/calc_add.css');
        $basecss = "";
        
        return $addcss;
    }
    
    function css()
    {
        $str = ''; // для версии php 5.4
        $arraycalcall = $this->compl_calc();
        foreach($arraycalcall as $item)
        {
            $str .= $item."\n";
        }
        
        
        $beackcss = (string) $str.
                    $this->get_add_css().
                    " ".$this->my_code;
                
        file_put_contents('./compilation/framework_lite.css', $beackcss);
        return $beackcss;
                
    }
    
}

/* --------------------  TEST  ------------------- 

    $w = 960;
    $m = 10;
    $c = 12;
    $css = "wwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwww";
    
    $test = new Calcgrid($w, $m, $c, $css);
    echo $test->css();
*/












?>