<?php
/**
 * Created by PhpStorm.
 * User: vagrant
 * Date: 6/19/17
 * Time: 11:20 AM
 */

namespace Zorang\Bundle\AkeneoRulesComposer\Utility;


class CreateRuleValidate
{
    public function validate($arraydata)
    {
        $error="";
        $dataarray = explode("&", $arraydata);
        $code=$dataarray[0];
print_r($code);// echo$h;
        if(stripos($code,"=code")!==false
           // ||stripos($code,"code")!==false
            ||stripos($code,"priority")!==false
            ||stripos($code,"category")!==false
            ||stripos($code,"family")!==false
            || stripos($code,"field")!==false
            ||stripos($code,"fields")!==false
            ||stripos($code,"operator")!==false
            ||stripos($code,"value")!==false
            ||stripos($code,"actionsfield")!==false
            || stripos($code,"actionsvalue")!==false
            ||stripos($code,"actions")!==false
            ||stripos($code,"actionssrc")!==false
            ||stripos($code,"actionstarget")!==false


        ){
            $error=$error."Rule code doesnot accept any of the field names code,category,family,field,operator,value,actions...etc\n";
            $error=$error."Please give a valid rule code \n";
            return $error;
        }
        if(stripos($arraydata,"zorang_rule[actions")===false){
            $error="Please add a valid actions to create rule \n";
            return $error;
        }

        return $error;

    }
}