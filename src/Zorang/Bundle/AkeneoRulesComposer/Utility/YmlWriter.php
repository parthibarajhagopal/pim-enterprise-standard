<?php
/**
 * Created by PhpStorm.
 * User: parthi
 * Date: 4/13/2017
 * Time: 8:20 AM
 */

namespace Zorang\Bundle\AkeneoRulesComposer\Utility;

use Zorang\Bundle\AkeneoRulesComposer\Utility\YmlHelper;

/**
 * Dumper dumps PHP variables to YAML strings.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class YmlWriter
{
    /**
     * The amount of spaces to use for indentation of nested nodes.
     *
     * @var int
     */
    public $indentation = 4;

    /**
     * Sets the indentation.
     *
     * @param int $num The amount of spaces to use for indentation of nested nodes
     */
    public function setIndentation($num)
    {
        if ($num < 1) {
            throw new \InvalidArgumentException('The indentation must be greater than zero.');
        }

        $this->indentation = (int) $num;
    }

    /**
     * Dumps a PHP value to YAML.
     *
     * @param mixed $input                  The PHP value
     * @param int   $inline                 The level where you switch to inline YAML
     * @param int   $indent                 The level of indentation (used internally)
     * @param bool  $exceptionOnInvalidType true if an exception must be thrown on invalid types (a PHP resource or object), false otherwise
     * @param bool  $objectSupport          true if object support is enabled, false otherwise
     *
     * @return string The YAML representation of the PHP value
     */
    public function dumpData($input, $inline = 0, $indent = 0, $exceptionOnInvalidType = false, $objectSupport = false)
    {

        $output = '';
        $prefix = $indent ? str_repeat(' ', $indent) : '';

        if ($inline <= 0 || !is_array($input) || empty($input)) {
            $output .= $prefix.YmlHelper::dump($input, $exceptionOnInvalidType, $objectSupport);
           // echo "<br/>----o/p-inline----".$output."---out-inlline-- <br/>";
        } else {
            $isAHash = YmlHelper::isHash($input);

            foreach ($input as $key => $value) {
                $willBeInlined = $inline - 1 <= 0 || !is_array($value) || empty($value);

                $output .= sprintf('%s%s%s%s',
                        $prefix,
                        $isAHash ? YmlHelper::dump($key, $exceptionOnInvalidType, $objectSupport).':' : '-',
                        $willBeInlined ? ' ' : "\n",
                        YmlWriter::dumpData($value, $inline - 1, $willBeInlined ? 0 : $indent + 4, $exceptionOnInvalidType, $objectSupport)
                    ).($willBeInlined ? "\n" : '');
            }
        }

        //added for cosmomusic
        if(stripos($output,"conditions")!==false && stripos($output,"[]")!==false){

            $output=str_replace("conditions","conditions:",$output);
            $output=str_replace("-","",$output);
            $output=str_replace("    []","[]",$output);
            // $countpfx=
        }
        if(stripos($output,"conditions:")!==false && stripos($output,"rules:")!==false){
            $output=str_replace(str_repeat(' ', 2) ."rules:","rules:".$prefix,$output);
            $output=str_replace("conditions:","\n".$prefix.$prefix.str_repeat(' ', 5) ."conditions:",$output);
            // $countpfx=
        }if(stripos($output,"conditions:")==false && stripos($output,"rules:")!==false){
        $output=str_replace(str_repeat(' ', 2) ."rules:","rules:".$prefix,$output);
    }
        if( stripos($output,"type:")!==false){
            $output=str_replace(str_repeat(' ', 2) ."type:","- type:",$output);
          //  $output=str_replace("actions:",str_repeat(' ', 1)."actions:",$output);
        }if( stripos($output,"actiondata:")!==false){
        $output=str_replace("actiondata:","- data:",$output);

    }if( stripos($output,"actioncurrency:")!==false){
        $output=str_replace("actioncurrency:",str_repeat(' ', 2)."currency:",$output);
    }
        if(stripos($output,"field:")!==false && stripos($output,"category:")!==false || stripos($output,"field:")!==false && stripos($output,"operator:")!==false){
            $output=str_replace(str_repeat(' ', 2) ."field:","- field:",$output);
            //  $output=str_replace(":\n","",$output);
        }
        if(stripos($output,"--")!==false){
            $output=str_replace("--","-",$output);
        } if(stripos($output,"-:\n")!==false){
        $output=str_replace("-:\n".$prefix,"",$output);
    } if(stripos($output,":\n")!==false && stripos($output,"rules:")==false ) {
        $output = str_replace("value:\n", "value:newline", $output);
        $output = str_replace(":\n" . $prefix, "", $output);
        $output = str_replace("value:newline", "value:\n", $output);

    }
    if(!strcmp($output,str_repeat(' ',8))){
        $output=str_replace(str_repeat(' ',8),"",$output);
    }if(stripos($output,"priority:")!==false){
        $output=str_replace("'","",$output);
    }

        //  cosmomusic changes end
       // echo "<br/>----o/p--".$output."---out--- <br/>";
        return $output;
    }


}
