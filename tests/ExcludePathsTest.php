<?php

use Webmozart\PathUtil\Path;
use PHPUnit\Framework\TestCase;
use LanguageServer\Concerns\ExcludeUriTrait;
use Sabre\Uri;

class ExcludePathsTest extends TestCase{
    use ExcludeUriTrait;

    public function setup(){
        $this->options=[];
       // $this->options['exclude-paths']='**/vendor';
        //$this->options['exclude-paths']='/vendor/**.php';
        
       
    }
    
    public function testIsUriExcluded(){
        $this->options['exclude-paths']='**/vendorExample/**';

        $arrExcludedPaths=  explode(',',$this->options['exclude-paths']);
        $absolutesGlob=[];
        foreach ($arrExcludedPaths as $glob) {
            $absolutesGlob[]= $this->resolveToAbsoluteGlob($glob, __DIR__);   
           # $absolutesGlob[]=  $glob;

        }
        $this->setExcludedPaths($absolutesGlob);
        $data=[
            Path::makeAbsolute('vendorExample/fileToIgnore.php',__DIR__)=>true,           
        ];
        foreach ($data as $uri => $booleanAssert) {
            $this->assertEquals($this->isUriExcluded($uri),$booleanAssert
                 ,   "It's expected  $uri to be :".(($booleanAssert)?'true':'false')
            );
        }
        
    }
    public function testIsUriExcludedWithExtension(){
        $this->options['exclude-paths']='**/vendorExample/**.php';

        $arrExcludedPaths=  explode(',',$this->options['exclude-paths']);
        $absolutesGlob=[];
        foreach ($arrExcludedPaths as $glob) {
            $absolutesGlob[]= $this->resolveToAbsoluteGlob($glob, __DIR__);   
            

        }
        $this->setExcludedPaths($absolutesGlob);
        $data=[
            Path::makeAbsolute('vendorExample/fileToIgnore.php',__DIR__)=>true,           
        ];
        foreach ($data as $uri => $booleanAssert) {
            $this->assertEquals($this->isUriExcluded($uri),$booleanAssert
                 ,   "It's expected  $uri to be :".(($booleanAssert)?'true':'false')
            );
        }
        
    }
}