<?php 
namespace LanguageServer\Concerns;

use Sabre\Uri;
use Webmozart\Glob\Glob;
use Webmozart\PathUtil\Path;

/**
 * 
 */
trait ExcludeUriTrait
{
    protected $excludedPaths=[];
    public function setExcludedPaths($excludedPaths){
         
        $this->excludedPaths=$excludedPaths;
           
        $excludedJson=\json_encode($excludedPaths);
        #$this->client->window->logMessage(MessageType::INFO, "Excluded paths: $excludedJson ");

    }
    /**
     * Convert a relative Glob to an absolute Glob.
     * This is neccesary to use Glob::match
     *
     * @param string $glob to exclude the files
     * @param string $rootDir 
     * @return string Absolute Glob
     */
    public function resolveToAbsoluteGlob($glob,$rootDir){
        return Uri\parse(Path::makeAbsolute($glob, $rootDir))['path'];
    }
   /**
    * Returns true if the uri match again a glob exclusion.
    *
    * @param string $uri The path to match
    * @return boolean
    */
    public function isUriExcluded(string $uri){
#        $this->client->window->logMessage(MessageType::INFO, "isUriExcluded ");

        $countExcluedPaths=count($this->excludedPaths);
        if($countExcluedPaths>0){
            for ($i=0; $i < $countExcluedPaths; $i++) { 
                #if match at least one glob exclusion next
                $path= Uri\parse($uri)['path'];
                if(Glob::match($path,$this->excludedPaths[$i])){
                    return true;
                }                        
            }                    
        }
        return false;
    } 
}
