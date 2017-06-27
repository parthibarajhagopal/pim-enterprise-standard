<?php
/**
 * Created by PhpStorm.
 * User: parthi
 * Date: 4/13/2017
 * Time: 8:20 AM
 */


namespace Zorang\Bundle\AkeneoRulesComposer\Utility;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Symfony\Component\HttpFoundation\Request;
use Zorang\Bundle\AkeneoRulesComposer\Utility\YmlHelper;
use Zorang\Bundle\AkeneoRulesComposer\Utility\YmlWriter;
use Symfony\Component\Yaml\Yaml;
class CreateYmlFile
{
    /**
     * @Route("/", name="homepage")
     */

    //added for log
    public $logger;

    public function createYml($arraydata,$dir)
    {
        try {

            $this->logger = new Logger('rulesengine');
            $rootDir=$this->get('kernel')->getRootDir();
            $this->logger->pushHandler(new StreamHandler($rootDir.'/logs/rulesengine.log', Logger::DEBUG));

            $this->logger->addInfo('Yml file creation starts...');
            $arraydata = str_ireplace("zorang_rule", "", $arraydata);
            $tstamp = time();
            $filename = $dir."/addrule_". $tstamp.".yml";
            //$filename = "/tmp/rulesfiles/addrule_" . $tstamp . ".yml";
            $this->logger->addInfo('Yml file creation : file name' . $filename);
    //added for log

            $arryidx = 0;$condn="empty";
        if ((!empty($arraydata) && stristr ($arraydata, 'code') !== false) && stristr ($arraydata, 'priority') !== false){
            $start=stripos ($arraydata,"code",1);
            $end=$start;
            if($start===$end && stristr ($arraydata, 'category') !== false){
                $end=stripos($arraydata,'category',1);
                $condn="not-empty";
            }
            if($start===$end && stristr ($arraydata, 'family') !== false){
                $end=stripos ($arraydata,"family",1);
                $condn="not-empty";
            }//changed for rule without condn
            if ($start === $end && stristr($arraydata, 'fields') !== false) {
                $end = stripos($arraydata, "fields", 1);
                $condn="not-empty";
            }if ($start === $end) {
                $end = stripos($arraydata, "actions", 1);
                $condn="empty";

            }
            $end=CreateYmlFile::findLength($start,$end);
            $fieldData=substr($arraydata,$start,$end);

                $arryidx = CreateYmlFile::ymlFieldConstruction($fieldData, "priority/".$condn, $arryidx, $filename);
                $arraydata=substr($arraydata, $end,strlen($arraydata) );
        } else{
                $end = stristr($arraydata, '&', 1);// echo"end --- ".$end;
                $arryidx = CreateYmlFile::ymlFieldConstruction($end, "code", $arryidx, $filename);
                $arraydata=substr($arraydata, $end,strlen($arraydata) );

        }
        if ((!empty($arraydata) && stristr ($arraydata, "category") !== false)){

            $start=stripos ($arraydata,"category",1);
                $end = $start;
            if(stristr ($arraydata, 'family') !== false){
                $end=stripos ($arraydata,"family",1);
                } else if ($start === $end && stristr($arraydata, 'fields') !== false) {
                $end=stripos ($arraydata,"fields",1);
            }
                else {
                    $end = stripos($arraydata, "actions", 1);
                }
            $end=CreateYmlFile::findLength($start,$end);
            $fieldData=substr($arraydata,$start,$end);
                $arryidx = CreateYmlFile::ymlFieldConstruction($fieldData, "categories", $arryidx, $filename);
                $arraydata=substr($arraydata, $end,strlen($arraydata) );
            }
            if ((!empty($arraydata) && stristr($arraydata, "family") !== false)) {


        $start=stripos ($arraydata,"family",1);
                //$end=$start;
        if(stristr ($arraydata, 'fields') !== false){
            $end=stripos ($arraydata,"fields",1);
        }else{
            $end=stripos ($arraydata,"actions",1);
        }
        $end=CreateYmlFile::findLength($start,$end);
        $fieldData=substr($arraydata,$start,$end);
                $arryidx = CreateYmlFile::ymlFieldConstruction($fieldData, "family", $arryidx, $filename);
                $arraydata=substr($arraydata, $end,strlen($arraydata) );

            }
            if ((!empty($arraydata) && stristr($arraydata, "fields") !== false)) {

        $start=stripos ($arraydata,"fields",1);

        if(stristr ($arraydata, 'actions') !== false){
            $end=stripos ($arraydata,"actions",1);
        }else{
            $end=strlen($arraydata);
        }


        $end=CreateYmlFile::findLength($start,$end);
        $fieldData=substr($arraydata,$start,$end);
        $fieldData=CreateYmlFile::ymlFormation($fieldData,"fields");
                $arryidx = CreateYmlFile::ymlFieldConstruction($fieldData, "fields", $arryidx, $filename);
                $arraydata=substr($arraydata, $end,strlen($arraydata) );
            }
            if ((!empty($arraydata) && stristr($arraydata, "actions") !== false)) {

        if(stristr ($arraydata, 'actions') !== false) {
            $start = stripos($arraydata, "actions", 1);
            $end = strlen($arraydata);
            $end=CreateYmlFile::findLength($start,$end);

            if ($start != $end) {
                $fieldData = substr($arraydata, $start, $end);
            }
            $fieldData=CreateYmlFile::ymlActionFormation($fieldData,"actions");
                    $arryidx = CreateYmlFile::ymlFieldConstruction($fieldData, "actions", $arryidx, $filename);

        }

        return $filename;

    }//added for log
        }catch(Exception $e){
            $this->logger->addError('Yml file creation : ' . $e->getMessage());
        }
        //added for log

    }

    public function ymlFieldConstruction($fieldData,$fieldName,$arryidx,$filename,$arraydata)
    {

        //added for log
        try {
        $ymlField=array();

        if (!strcasecmp($fieldName, "code")) {


            $root=explode("=", $fieldData);
            $fieldData=$root[1];
            $ymlField["rules"][$fieldData]["conditions"]=array();

            file_put_contents($filename, YmlWriter::dumpData($ymlField, 2, 2), FILE_APPEND | LOCK_EX);
        }
        //changed for rule without condn
            if (stripos($fieldName, "priority")!==false) {
                if (strpos($fieldName, '/') !== false) {
                    $pos = stripos($fieldName, "/", 1);
                    $field = substr($fieldName, 0, $pos);
                }
                $fieldData = CreateYmlFile::replace($fieldData, $fieldName);
                $root=explode(",", $fieldData);

        foreach($root as $rootVal){
            if(stristr($rootVal,"code")!==false){
                $rule=str_ireplace("code","",$rootVal);
            }else{
                $priority=trim($rootVal," ");
            }
        }

        $ymlField["rules"][$rule]=array();

        file_put_contents($filename, YmlWriter::dumpData($ymlField, 2, 2), FILE_APPEND | LOCK_EX);
        $priValue=trim($priority," ");
        $priValue=trim($priValue,"\'");
        $priValue=trim($priValue,"priority");
        $ymlpriority["priority"]=$priValue;
        file_put_contents($filename, YmlWriter::dumpData($ymlpriority, 2, 9), FILE_APPEND | LOCK_EX);
            //changed for rule without condn
                if (stripos($fieldName, "not-empty")!==false) {
                    $ymlcondn["conditions"] = array();
                    file_put_contents($filename, YmlWriter::dumpData($ymlcondn, 2, 9), FILE_APPEND | LOCK_EX);
                }else{
                    $ymlcondn["conditions"] = array('[]');
                    file_put_contents($filename, YmlWriter::dumpData($ymlcondn, 2, 9), FILE_APPEND | LOCK_EX);
                }
      }

        if (!strcasecmp($fieldName, "categories") || !strcasecmp($fieldName, "family")) {



            if(!strcasecmp($fieldName, "categories")) {
                $fieldData = CreateYmlFile::replace($fieldData, "category");
                $value=explode(",", $fieldData);
                $ymlField= array('field' => $fieldName . ".code", "operator" => "IN CHILDREN","value"=>$value);

            }else{

                $fieldData = CreateYmlFile::replace($fieldData, $fieldName);
                $value=explode(",", $fieldData);
                $ymlField= array('field' => trim($fieldName ," "). ".code", "operator" => "IN","value"=>$value);
            }







            file_put_contents($filename, YmlWriter::dumpData($ymlField, 4, 12), FILE_APPEND | LOCK_EX);

        }
        if (!strcasecmp($fieldName, "fields")) {

            $ymlData = explode("##", $fieldData);
            $ymlFieldTemp = array();
            foreach ($ymlData as $key => $data) {
                if (!empty($data)) {
                    $data =CreateYmlFile::replaceForFieldData($data, $fieldName);
                    $ymlDataWrite = explode(",", $data);
                    for ($j = 0; $j < count($ymlDataWrite) - 1; $j = $j + 2) {
                        $val = $ymlDataWrite[$j + 1];
                        if(!empty($ymlDataWrite[$j]) && stristr($ymlDataWrite[$j], "local") !== false)
                        {
                            $idx = "locale";
                            $ymlFieldTemp[$idx] =str_replace(";"," ",$val) ;
                        }
                        else if(!empty($ymlDataWrite[$j]) && stristr($ymlDataWrite[$j], "scope") !== false){
                            $idx = "scope";

                             $ymlFieldTemp[$idx] =str_replace(";"," ",$val) ;
                        }
                        else if(!empty($ymlDataWrite[$j]) && stristr($ymlDataWrite[$j], "currency") !== false){
                            $idx = "currency";
                            $ymlFieldTemp[$idx] =str_replace(";"," ",$val) ;
                        }
                        else if (!empty($ymlDataWrite[$j]) && stristr($ymlDataWrite[$j], "field") !== false) {
                            $idx = "field";
                            if (strpos($val, '/') !== false) {
                                $pos = stripos($val, "/", 1);
                                $val = substr($val, 0, $pos);
                                $valType = substr($ymlDataWrite[$j + 1], $pos+1, strlen($ymlDataWrite[$j + 1]));
                                // if(!empty($valType) && !stripos($valType,"simpleselect")||!strcasecmp($valType,"multiselect")){

                                if(!empty($valType) && (stripos($valType,"simpleselect")!==false)||(stripos($valType,"multiselect")!==false)){
                                    $val=$val.".code";
                                }
                            }
                            $ymlFieldTemp[$idx] = $val;

                        } else if (!empty($ymlDataWrite[$j]) && stristr($ymlDataWrite[$j], "operator") !== false) {
                            $idx = "operator";
                            if(!strcasecmp("not_eq", $val)){
                                $val="!=";
                            }if(!strcasecmp("eq_sign", $val)){
                                $val="=";
                            } if(!strcasecmp("less_eq", $val)){
                                $val="<=";
                            }if(!strcasecmp("grt_eq", $val)){
                                $val=">=";
                            }
                            $ymlFieldTemp[$idx] =str_replace(";"," ",$val) ;
                        }
                        else if( (!empty($ymlDataWrite[$j]) && stristr($ymlDataWrite[$j], "value") !==false)
                            ||( stristr($ymlDataWrite[$j-1], "operator") !== false && stristr($ymlDataWrite[$j-1], "EMPTY") !== false)){
                            $idx = "value";
                            //if(stripos($val,"price")!==false &&stripos($val,"currency")!==false){
                            $priceFieldValue = explode(",",$data);
                            $priceFieldValue = $priceFieldValue[1];
                            $priceFieldValue = explode("/",$priceFieldValue);
                            $priceFieldValue = $priceFieldValue[1];
                            if($priceFieldValue=='price'|| $priceFieldValue === 'price_collection' || $priceFieldValue === 'ricing'){

                                if(isset($ymlFieldTemp["locale"]) && isset($ymlFieldTemp["scope"]))
                                {
                                    $ymlArray = array("field" => trim($ymlFieldTemp["field"]," "), "locale" => trim($ymlFieldTemp["locale"]," "), "scope" => trim($ymlFieldTemp["scope"]," "), "operator" => trim($ymlFieldTemp["operator"]," "));
                                }
                                else if(isset($ymlFieldTemp["locale"]) && !isset($ymlFieldTemp["scope"]))
                                {
                                    $ymlArray = array("field" => trim($ymlFieldTemp["field"]," "), "locale" => trim($ymlFieldTemp["locale"]," "), "operator" => trim($ymlFieldTemp["operator"]," "));
                                }
                                else if(!isset($ymlFieldTemp["locale"]) && isset($ymlFieldTemp["scope"]))
                                {
                                    $ymlArray = array("field" => trim($ymlFieldTemp["field"]," "), "scope" => trim($ymlFieldTemp["scope"]," "), "operator" => trim($ymlFieldTemp["operator"]," "));
                                }
                                else
                                {
                                    $ymlArray = array("field" => trim($ymlFieldTemp["field"]," "), "operator" => trim($ymlFieldTemp["operator"]," "));
                                }
                                //$ymlArray = array("field" => trim($ymlFieldTemp["field"]," "), "locale" => trim($ymlFieldTemp["locale"]," "), "scope" => trim($ymlFieldTemp["scope"]," "), "operator" => trim($ymlFieldTemp["operator"]," "));
                                file_put_contents($filename,YmlWriter::dumpData($ymlArray, 4, 12), FILE_APPEND | LOCK_EX);
                                if(!empty($ymlDataWrite[$j+2]) && stristr($ymlDataWrite[$j+2], "currency") !==false)
                                {
                                    $currencyValue = $ymlDataWrite[$j+3];
                                }
                                else{
                                    $currencyValue = "null";
                                }
                                $val=ltrim($val,";");
                                $pricedata = "data";
                                $priceValue = str_replace("'", "", $val);
                                $currencydata = "currency";
                                //$currencyValue = trim($ymlFieldTemp["currency"]," ");
                                $ymlArray = array("value"=>array($pricedata=>$priceValue,$currencydata=>$currencyValue));
                                file_put_contents($filename,YmlWriter::dumpData($ymlArray, 4, 12), FILE_APPEND | LOCK_EX);
                            }
                            else if($priceFieldValue=='metric')
                            {
                                if(isset($ymlFieldTemp["locale"]) && isset($ymlFieldTemp["scope"]))
                                {
                                    $ymlArray = array("field" => trim($ymlFieldTemp["field"]," "), "locale" => trim($ymlFieldTemp["locale"]," "), "scope" => trim($ymlFieldTemp["scope"]," "), "operator" => trim($ymlFieldTemp["operator"]," "));
                                }
                                else if(isset($ymlFieldTemp["locale"]) && !isset($ymlFieldTemp["scope"]))
                                {
                                    $ymlArray = array("field" => trim($ymlFieldTemp["field"]," "), "locale" => trim($ymlFieldTemp["locale"]," "), "operator" => trim($ymlFieldTemp["operator"]," "));
                                }
                                else if(!isset($ymlFieldTemp["locale"]) && isset($ymlFieldTemp["scope"]))
                                {
                                    $ymlArray = array("field" => trim($ymlFieldTemp["field"]," "), "scope" => trim($ymlFieldTemp["scope"]," "), "operator" => trim($ymlFieldTemp["operator"]," "));
                                }
                                else
                                {
                                    $ymlArray = array("field" => trim($ymlFieldTemp["field"]," "), "operator" => trim($ymlFieldTemp["operator"]," "));
                                }
                                file_put_contents($filename,YmlWriter::dumpData($ymlArray, 4, 12), FILE_APPEND | LOCK_EX);
                                if(!empty($ymlDataWrite[$j+4]) && stristr($ymlDataWrite[$j+4], "unit") !==false)
                                {
                                    $unitValue = $ymlDataWrite[$j+5];
                                }
                                else{
                                    $unitValue = "null";
                                }
                                $val=ltrim($val,";");
                                $pricedata = "data";
                                $priceValue = str_replace("'", "", $val);
                                $unitData = "unit";
                                $ymlArray = array("value"=>array($pricedata=>$priceValue,$unitData=>$unitValue));
                                file_put_contents($filename,YmlWriter::dumpData($ymlArray, 4, 12), FILE_APPEND | LOCK_EX);
                            }
                            else if(stripos($ymlFieldTemp["field"],".code")!==false) {
                                if (stripos($ymlFieldTemp["operator"], "EMPTY") !== false) {
                                    if(isset($ymlFieldTemp["locale"]) && isset($ymlFieldTemp["scope"]))
                                    {
                                        $ymlArray = array("field" => trim($ymlFieldTemp["field"]," "), "locale" => trim($ymlFieldTemp["locale"]," "), "scope" => trim($ymlFieldTemp["scope"]," "), "operator" => trim($ymlFieldTemp["operator"]," "), "value" => $val);
                                    }
                                    else if(isset($ymlFieldTemp["locale"]) && !isset($ymlFieldTemp["scope"]))
                                    {
                                        $ymlArray = array("field" => trim($ymlFieldTemp["field"]," "), "locale" => trim($ymlFieldTemp["locale"]," "), "operator" => trim($ymlFieldTemp["operator"]," "), "value" => $val);
                                    }
                                    else if(!isset($ymlFieldTemp["locale"]) && isset($ymlFieldTemp["scope"]))
                                    {
                                        $ymlArray = array("field" => trim($ymlFieldTemp["field"]," "), "scope" => trim($ymlFieldTemp["scope"]," "), "operator" => trim($ymlFieldTemp["operator"]," "), "value" => $val);
                                    }
                                    else
                                    {
                                        $ymlArray = array("field" => trim($ymlFieldTemp["field"]," "), "operator" => trim($ymlFieldTemp["operator"]," "), "value" => $val);
                                    }
                                    //$ymlArray = array("field" => trim($ymlFieldTemp["field"], " "),"locale" => trim($ymlFieldTemp["locale"]," "), "scope" => trim($ymlFieldTemp["scope"]," "), "operator" => trim($ymlFieldTemp["operator"], " "), "value" => $val);
                                    file_put_contents($filename, YmlWriter::dumpData($ymlArray, 4, 12), FILE_APPEND | LOCK_EX);
                                } else {
                                    $valArray = explode(";", $val);
                                    if(isset($ymlFieldTemp["locale"]) && isset($ymlFieldTemp["scope"]))
                                    {
                                        $ymlArray = array("field" => trim($ymlFieldTemp["field"]," "), "locale" => trim($ymlFieldTemp["locale"]," "), "scope" => trim($ymlFieldTemp["scope"]," "), "operator" => trim($ymlFieldTemp["operator"]," "), "value" => $valArray);
                                    }
                                    else if(isset($ymlFieldTemp["locale"]) && !isset($ymlFieldTemp["scope"]))
                                    {
                                        $ymlArray = array("field" => trim($ymlFieldTemp["field"]," "), "locale" => trim($ymlFieldTemp["locale"]," "), "operator" => trim($ymlFieldTemp["operator"]," "), "value" => $valArray);
                                    }
                                    else if(!isset($ymlFieldTemp["locale"]) && isset($ymlFieldTemp["scope"]))
                                    {
                                        $ymlArray = array("field" => trim($ymlFieldTemp["field"]," "), "scope" => trim($ymlFieldTemp["scope"]," "), "operator" => trim($ymlFieldTemp["operator"]," "), "value" => $valArray);
                                    }
                                    else
                                    {
                                        $ymlArray = array("field" => trim($ymlFieldTemp["field"]," "), "operator" => trim($ymlFieldTemp["operator"]," "), "value" => $valArray);
                                    }
                                    //$ymlArray = array("field" => trim($ymlFieldTemp["field"], " "),"locale" => trim($ymlFieldTemp["locale"]," "), "scope" => trim($ymlFieldTemp["scope"]," "), "operator" => trim($ymlFieldTemp["operator"], " "), "value" => $valArray);
                                    file_put_contents($filename, YmlWriter::dumpData($ymlArray, 4, 12), FILE_APPEND | LOCK_EX);
                                }
                            }
                            else if(stripos($val,"price-code")!==false &&stripos($val,"price-group-name")!==false) {
                                if(isset($ymlFieldTemp["locale"]) && isset($ymlFieldTemp["scope"]))
                                {
                                    $ymlArray = array("field" => trim($ymlFieldTemp["field"]," "), "locale" => trim($ymlFieldTemp["locale"]," "), "scope" => trim($ymlFieldTemp["scope"]," "), "operator" => trim($ymlFieldTemp["operator"]," "));
                                }
                                else if(isset($ymlFieldTemp["locale"]) && !isset($ymlFieldTemp["scope"]))
                                {
                                    $ymlArray = array("field" => trim($ymlFieldTemp["field"]," "), "locale" => trim($ymlFieldTemp["locale"]," "), "operator" => trim($ymlFieldTemp["operator"]," "));
                                }
                                else if(!isset($ymlFieldTemp["locale"]) && isset($ymlFieldTemp["scope"]))
                                {
                                    $ymlArray = array("field" => trim($ymlFieldTemp["field"]," "), "scope" => trim($ymlFieldTemp["scope"]," "), "operator" => trim($ymlFieldTemp["operator"]," "));
                                }
                                else
                                {
                                    $ymlArray = array("field" => trim($ymlFieldTemp["field"]," "), "operator" => trim($ymlFieldTemp["operator"]," "));
                                }
                                //$ymlArray = array("field" => trim($ymlFieldTemp["field"]," "),"locale" => trim($ymlFieldTemp["locale"]," "), "scope" => trim($ymlFieldTemp["scope"]," "), "operator" => trim($ymlFieldTemp["operator"]," "));

                                $val=ltrim($val,";");$val=str_replace(";;","#",$val);
                                $val=str_replace(";"," ",$val);

                                if(stripos($val,"#")!==false){
                                    $priceGrp=explode("#", $val);
                                    foreach($priceGrp as $grpKey => $grpVal){
                                        if(stripos($grpVal,"price-code")!==false) {
                                            $grpCode=str_ireplace("price-code:","",$grpVal);
                                            $ymlFieldTemp["value"] = trim($grpCode," ");
                                        }if(stripos($grpVal,"price-group-name")!==false) {
                                            $grpName=str_ireplace("price_group_name:","",$grpVal);
                                            $grpName=trim($grpName," ");
                                            $ymlFieldTemp["pricing_group_name"] =$grpName ;
                                        }
                                    }

                                }
                                file_put_contents($filename, YmlWriter::dumpData($ymlFieldTemp, 2, 12), FILE_APPEND | LOCK_EX);
                            }else{
                                $val= str_replace(";",",", $val);
                                $val= trim($val," ");
                                if(!empty($valType) && !strcasecmp($valType,"text")||!strcasecmp($valType,"textarea")){
                                    $val="\"".$val."\"";
                                    $val=str_replace("\"\"","",$val);

                                }
                                if(isset($ymlFieldTemp["locale"]) && isset($ymlFieldTemp["scope"]))
                                {
                                    $ymlArray = array("field" => trim($ymlFieldTemp["field"]," "), "locale" => trim($ymlFieldTemp["locale"]," "), "scope" => trim($ymlFieldTemp["scope"]," "), "operator" => trim($ymlFieldTemp["operator"]," "), "value" => $val);
                                }
                                else if(isset($ymlFieldTemp["locale"]) && !isset($ymlFieldTemp["scope"]))
                                {
                                    $ymlArray = array("field" => trim($ymlFieldTemp["field"]," "), "locale" => trim($ymlFieldTemp["locale"]," "), "operator" => trim($ymlFieldTemp["operator"]," "), "value" => $val);
                                }
                                else if(!isset($ymlFieldTemp["locale"]) && isset($ymlFieldTemp["scope"]))
                                {
                                    $ymlArray = array("field" => trim($ymlFieldTemp["field"]," "), "scope" => trim($ymlFieldTemp["scope"]," "), "operator" => trim($ymlFieldTemp["operator"]," "), "value" => $val);
                                }
                                else
                                {
                                    $ymlArray = array("field" => trim($ymlFieldTemp["field"]," "), "operator" => trim($ymlFieldTemp["operator"]," "), "value" => $val);
                                }
                                //$ymlArray = array("field" => trim($ymlFieldTemp["field"]," "),"locale" => trim($ymlFieldTemp["locale"]," "), "scope" => trim($ymlFieldTemp["scope"]," "), "operator" => trim($ymlFieldTemp["operator"]," "), "value" => $val);
                                file_put_contents($filename,YmlWriter::dumpData($ymlArray, 4, 12), FILE_APPEND | LOCK_EX);
                            }


                        }

                    }


                }
            }

        }

        if (!strcasecmp($fieldName, "actions")) {
            $ymlField["actions"] = array();
            file_put_contents($filename, YmlWriter::dumpData($ymlField, 4, 9), FILE_APPEND | LOCK_EX);
            $ymlData = explode("##", $fieldData);
            $ymlFieldTemp=array();
            foreach ($ymlData as $key => $data) {
                  $ymlFieldTemp=array();
                $ymlItemsTemp=array();
                $copy="";
                if(!empty($data)){
                    $data = CreateYmlFile::replaceForActionData($data, $fieldName);
                    $ymlFieldData = explode(",", $data);
                    for ($j = 0; $j < count($ymlFieldData) - 1; $j = $j + 1) {
                        if(strcasecmp($copy,"copy")) {
                            $val = $ymlFieldData[$j + 1];
                            if (!empty($ymlFieldData[$j]) && stristr($ymlFieldData[$j], "field") !== false) {
                                $fieldValType = explode("/", $val);
                                $idx = "field";
                                $ymlFieldTemp[$idx] = $fieldValType[0];
                                if(isset($fieldValType[1]))
                                {
                                    $idx = "ftype";
                                    $ymlFieldTemp[$idx] = $fieldValType[1];
                                }
                            }
                            else if (!empty($ymlFieldData[$j]) && stristr($ymlFieldData[$j], "currency") !== false) {
                                $idx = "currency";
                                $ymlFieldTemp[$idx] = $val;
                            }
                            else if (!empty($ymlFieldData[$j]) && (stristr($ymlFieldData[$j], "locale") !== false)) {
                                $idx = "locale";
                                $ymlFieldTemp[$idx] = $val;
                            }
                            else if (!empty($ymlFieldData[$j]) && (stristr($ymlFieldData[$j], "scope") !== false)) {
                                $idx = "scope";
                                $ymlFieldTemp[$idx] = $val;
                            }
                            else if (!empty($ymlFieldData[$j]) && stristr($ymlFieldData[$j], "items") !== false
                                         && (stristr($data, "add") !== false || stristr($data, "remove") !== false)) {
                                $val = rtrim($val, ";");
                                $val = ltrim($val, ";");
                                $ymlItemsTemp[]=$val;
                                if(empty($ymlFieldData[$j+2]) || !stristr($ymlFieldData[$j+2], "items") !== false)
                                {
                                    $idx = "items";
                                    $ymlFieldTemp[$idx] = [];
                                    $YMLData = Array ( "type" => $ymlFieldTemp["type"], "field" => $ymlFieldTemp["field"] );
                                    file_put_contents($filename, YmlWriter::dumpData($ymlFieldTemp, 4, 12), FILE_APPEND | LOCK_EX);
                                    file_put_contents($filename, YmlWriter::dumpData($ymlItemsTemp, 4, 15), FILE_APPEND | LOCK_EX);
                                }

                            }
                            else if (!empty($ymlFieldData[$j]) && stristr($ymlFieldData[$j], "value") !== false) {
                                $idx = "value";
                                $ymlFieldTemp[$idx] = $val;
                                $fieldType =  $ymlFieldTemp['ftype'];
                                $fieldValue = $ymlFieldTemp['field'];
                                if($fieldType === 'price'|| $fieldType === 'price_collection' || $fieldType === 'ricing') {
                                    $ymlArray = array("type" => $ymlFieldTemp["type"], "field" => $fieldValue);
                                    file_put_contents($filename, YmlWriter::dumpData($ymlArray, 4, 12), FILE_APPEND | LOCK_EX);
                                    //scope & Local fields
                                    if(isset($ymlFieldTemp['scope']))
                                    {
                                        $ymlArray = array("scope" => $ymlFieldTemp['scope']);
                                        file_put_contents($filename, YmlWriter::dumpData($ymlArray, 4, 12), FILE_APPEND | LOCK_EX);
                                        unset($ymlFieldTemp['scope']);
                                    }
                                    if(isset($ymlFieldTemp['locale']))
                                    {
                                        $ymlArray = array("locale" => $ymlFieldTemp['locale']);
                                        file_put_contents($filename, YmlWriter::dumpData($ymlArray, 4, 12), FILE_APPEND | LOCK_EX);
                                        unset($ymlFieldTemp['locale']);
                                    }

                                    $val = ltrim($val, ";");
                                    $pricedata = "actiondata";
                                    $priceValue = $val;
                                    $currencydata = "actioncurrency";
                                    $currencyValue = 'null';
                                    for($YDIndex = 0; $YDIndex < count($ymlFieldData); $YDIndex++){
                                        if(!empty($ymlFieldData[$YDIndex]) && stristr($ymlFieldData[$YDIndex], "currency") !== false){
                                            $currencyValue = $ymlFieldData[$YDIndex+1];
                                        }
                                    }
                                    $ymlArray = array("value" => array("actiondata" => $priceValue, "actioncurrency" => $currencyValue));
                                    file_put_contents($filename, YmlWriter::dumpData($ymlArray, 4, 12), FILE_APPEND | LOCK_EX);

                                }
                                else if($fieldType === 'metric')
                                {
                                    $ymlArray = array("type" => $ymlFieldTemp["type"], "field" => $fieldValue);
                                    file_put_contents($filename, YmlWriter::dumpData($ymlArray, 4, 12), FILE_APPEND | LOCK_EX);
                                    //scope & Local fields
                                    if(isset($ymlFieldTemp['scope']))
                                    {
                                        $ymlArray = array("scope" => $ymlFieldTemp['scope']);
                                        file_put_contents($filename, YmlWriter::dumpData($ymlArray, 4, 12), FILE_APPEND | LOCK_EX);
                                        unset($ymlFieldTemp['scope']);
                                    }
                                    if(isset($ymlFieldTemp['locale']))
                                    {
                                        $ymlArray = array("locale" => $ymlFieldTemp['locale']);
                                        file_put_contents($filename, YmlWriter::dumpData($ymlArray, 4, 12), FILE_APPEND | LOCK_EX);
                                        unset($ymlFieldTemp['locale']);
                                    }

                                    $val = ltrim($val, ";");
                                    $pricedata = "data";
                                    $priceValue = $val;
                                    $currencydata = "unit";
                                    $unitValue = 'null';
                                    for($YDIndex = 0; $YDIndex < count($ymlFieldData); $YDIndex++){
                                        if(!empty($ymlFieldData[$YDIndex]) && stristr($ymlFieldData[$YDIndex], "unit") !== false){
                                            $unitValue = $ymlFieldData[$YDIndex+1];
                                        }
                                    }
                                    $ymlArray = array("value" => array("data" => $priceValue, "unit" => $unitValue));
                                    file_put_contents($filename, YmlWriter::dumpData($ymlArray, 4, 12), FILE_APPEND | LOCK_EX);
                                }

                                else if (stripos($val, "price-code") !== false && stripos($val, "price-group-name") !== false) {
                                    if (stripos($val, ";") !== false) {
                                        $priceGrp = explode(";", $val);
                                        foreach ($priceGrp as $grpKey => $grpVal) {
                                            if (stripos($grpVal, "price-code") !== false) {
                                                $priceCode = str_ireplace("price-code:", "", $grpVal);
                                                $ymlFieldTemp["value"] = trim($priceCode, " ");
                                            }
                                            if (stripos($grpVal, "price-group-name") !== false) {
                                                $groupName = str_ireplace("price-group-name:", "", $grpVal);
                                                $ymlFieldTemp["pricing_group_name"] = trim($groupName, " ");
                                            }
                                        }

                                    }
                                    if(isset($ymlFieldTemp['ftype']))
                                    {
                                        unset($ymlFieldTemp['ftype']);
                                    }
                                    file_put_contents($filename, YmlWriter::dumpData($ymlFieldTemp, 2, 12), FILE_APPEND | LOCK_EX);
                                } else {
                                    if(isset($ymlFieldTemp['ftype']))
                                    {
                                        unset($ymlFieldTemp['ftype']);
                                    }
                                    file_put_contents($filename, YmlWriter::dumpData($ymlFieldTemp, 2, 12), FILE_APPEND | LOCK_EX);
                                }

                            } else if (!empty($ymlFieldData[$j]) && stristr($ymlFieldData[$j], "actions") !== false) {
                                $idx = "type";
                                $ymlFieldTemp[$idx] = $val;
                                $copy=$val;
                            }

                        }else {
                            //"--------------------copy action -----------------------";

                            $val = $ymlFieldData[$j + 1];

                            if (!empty($ymlFieldData[$j]) && stristr($ymlFieldData[$j], "actionssrc") !== false) {
                                $idx = "from_field";
                                $pos = strpos($val, "/");
                                $val = substr($val, 0, $pos);
                                $ymlFieldTemp[$idx] = trim($val,";");

                            } else if (!empty($ymlFieldData[$j]) && stristr($ymlFieldData[$j], "actionsrcscope") !== false) {
                                $idx = "from_scope";
                                $ymlFieldTemp[$idx] =  trim($val,";");
                                //   file_put_contents($filename, YmlWriter::dumpData($ymlFieldTemp, 2, 12), FILE_APPEND | LOCK_EX);
                            }else if (!empty($ymlFieldData[$j]) && stristr($ymlFieldData[$j], "actionsrclocale") !== false) {
                                $idx = "from_locale";
                                $ymlFieldTemp[$idx] =  trim($val,";");
                                //file_put_contents($filename, YmlWriter::dumpData($ymlFieldTemp, 2, 12), FILE_APPEND | LOCK_EX);
                            }else if (!empty($ymlFieldData[$j]) && stristr($ymlFieldData[$j], "actionstarget") !== false) {
                                $idx = "to_field";
                                $pos = strpos($val, "/");
                                $val = substr($val, 0, $pos);
                                $ymlFieldTemp[$idx] =  trim($val,";");
                                file_put_contents($filename, YmlWriter::dumpData($ymlFieldTemp, 2, 12), FILE_APPEND | LOCK_EX);
                                $ymlFieldTemp=array();
                            }else if (!empty($ymlFieldData[$j]) && stristr($ymlFieldData[$j], "actiontgtscope") !== false) {
                                $idx = "to_scope";
                                $ymlFieldTemp[$idx] =  trim($val,";");
                                file_put_contents($filename, YmlWriter::dumpData($ymlFieldTemp, 2, 12), FILE_APPEND | LOCK_EX);
                                $ymlFieldTemp=array();
                            }else if (!empty($ymlFieldData[$j]) && stristr($ymlFieldData[$j], "actiontgtlocale") !== false) {
                                $idx = "to_locale";
                                $val = trim($val, ";");
                                $ymlFieldTemp[$idx] = trim($val,";");
                                file_put_contents($filename, YmlWriter::dumpData($ymlFieldTemp, 2, 12), FILE_APPEND | LOCK_EX);
                                $ymlFieldTemp=array();
                            }

                        }
                    }


                }
            }
        }//added for log
        }catch(Exception $e){
            $this->logger->addError('Yml file creation :@ymlFieldConstruction: ' . $e->getMessage());
        }
    }
    public function replace($fieldData,$fieldName)
    {

        //category][]=//brand_3_sticks&[category][]=brand_art//&[
        $fieldData = str_replace("]", "", $fieldData);
        $fieldData = str_replace("[", "", $fieldData);
        $fieldData = str_replace($fieldName, "", $fieldData);
        $fieldData = str_replace(",", "','", $fieldData);

        $fieldData = str_replace("=", "", $fieldData);
        // $fieldData=str_replace("\'","",$fieldData);
        $fieldData=trim($fieldData,",'");
        $fieldData=str_replace(",'","",$fieldData);
        $fieldData=trim($fieldData,",");
        $fieldData = str_replace("&", ",", $fieldData);
        if (strrpos($fieldData, ',') !== false) {
            $pos = strrpos($fieldData, ",", 1);
            $fieldData = substr($fieldData, 0, $pos);
        }

        return $fieldData;
    }
    public function replaceForFieldData($fieldData,$fieldName)
    {


        // Data: value1=123&,operator1==&,field1=serial/text&
        $fieldData = str_replace("]", "", $fieldData);
        $fieldData = str_replace("[", "", $fieldData);

        if(!strcasecmp($fieldName,"fields")) {
            $fieldData = str_replace(",", ";", $fieldData);
        }
        $fieldData = str_replace("&", ",", $fieldData);
        $fieldData = str_replace("==", "=eq_sign", $fieldData);
        $fieldData = str_replace("!=", "=not_eq", $fieldData);
        $fieldData = str_replace("<=", "less_eq=", $fieldData);
        $fieldData = str_replace(">=", "grt_eq=", $fieldData);
        $fieldData = str_replace("=", ",", $fieldData);
        $fieldData = str_replace(",,", ",", $fieldData);
        $fieldData = str_replace(" ", ";", $fieldData);
        $fieldData = str_replace(":;", ":", $fieldData);
        $fieldData = str_replace(",;", ",", $fieldData);


        return $fieldData;
    }
    public function replaceForActionData($fieldData,$fieldName)
    {


        // Data: actions1]=set,[actionsfield1]=price,[actionsvalue1]=Price: 12,currency: EUR
        $fieldData = str_replace("]", "", $fieldData);
        $fieldData = str_replace(",[", "&", $fieldData);

        $fieldData = str_replace(",", ";", $fieldData);

        $fieldData = str_replace("&", ",", $fieldData);

        $fieldData = str_replace("=", ",", $fieldData);


        return $fieldData;
    }

    public function ymlFormation($fieldData,$fieldName)
    {
        //added for log

        try {
        //$fieldData = str_replace($fieldName, "", $fieldData);

        $fieldData = str_replace("]", "", $fieldData);
        $fieldData = str_replace("[", "", $fieldData);
        $arrayFields =  explode($fieldName, $fieldData);
        $fieldData="";
        for($i=0;$i<count($arrayFields);$i++)  {
            if(stristr ($arrayFields[$i], "unit")!==false) {
                if ((!empty($arrayFields[$i-6]) && stristr($arrayFields[$i-1], '=&') == false)
                    && (stristr($arrayFields[$i - 6], 'field') !== false)) {
                        $fieldData =$fieldData.$arrayFields[$i - 6] . "," .$arrayFields[$i - 5] . "," .$arrayFields[$i - 4] . "," .$arrayFields[$i - 3] . "," .$arrayFields[$i - 2] . "," . $arrayFields[$i - 1] . "," .$arrayFields[$i] ;

                    $fieldData = $fieldData."##";
                }
                else if ((!empty($arrayFields[$i-5]) && stristr($arrayFields[$i-1], '=&') == false)
                    && (stristr($arrayFields[$i - 5], 'field') !== false)) {
                    $fieldData =$fieldData.$arrayFields[$i - 5] . "," .$arrayFields[$i - 4] . "," .$arrayFields[$i - 3] . "," .$arrayFields[$i - 2] . "," . $arrayFields[$i - 1] . "," .$arrayFields[$i] ;

                    $fieldData = $fieldData."##";
                }
                else if ((!empty($arrayFields[$i-4]) && stristr($arrayFields[$i-1], '=&') == false)
                    && (stristr($arrayFields[$i - 4], 'field') !== false)) {
                    $fieldData =$fieldData.$arrayFields[$i - 4] . "," .$arrayFields[$i - 3] . "," .$arrayFields[$i - 2] . "," . $arrayFields[$i - 1] . "," .$arrayFields[$i] ;

                    $fieldData = $fieldData."##";
                }
            }
            // $i++;

        }
        return $fieldData;

//added for log
        }catch(Exception $e){
            $this->logger->addError('Yml file creation :@ymlFormation: ' . $e->getMessage());
        }
    }

    public function ymlActionFormation($fieldData,$fieldName)
    {
    //added for log
        try {
        $arrayFields =  explode("&", $fieldData);
        $fieldData="";
        for($i=0;$i<count($arrayFields);$i++) {

            if (stristr($arrayFields[$i], "value") !== false) {
                if (!empty($arrayFields[$i]) && stristr($arrayFields[$i]."&", '=&') == false) {
                    if (stristr($arrayFields[$i - 1], "actionsfield") !== false ) {
                        //$fieldData = $fieldData . "," . $arrayFields[$i - 1] . "," . $arrayFields[$i - 2];
                        $fieldData =$fieldData .$arrayFields[$i - 2] . "," . $arrayFields[$i - 1] . "," .$arrayFields[$i] .",". $arrayFields[$i+1] ;
                    }else if (stristr($arrayFields[$i - 1], "actions") !== false ) {
                        $fieldData = $fieldData .$arrayFields[$i - 1].",".$arrayFields[$i] .",". $arrayFields[$i+1];
                    }
                    else if(stristr($arrayFields[$i - 1], "scope") !== false && stristr($arrayFields[$i-2], "locale") !== false)
                    {
                        $fieldData =$fieldData .$arrayFields[$i - 4] . "," . $arrayFields[$i - 3] .','.$arrayFields[$i - 2] . "," . $arrayFields[$i - 1] . "," .$arrayFields[$i] .",". $arrayFields[$i+1] ;
                    }
                    else if(stristr($arrayFields[$i - 1], "scope") !== false && stristr($arrayFields[$i-2], "actionsfield") !== false)
                    {
                        $fieldData =$fieldData . $arrayFields[$i - 3] .','.$arrayFields[$i - 2] . "," . $arrayFields[$i - 1] . "," .$arrayFields[$i] .",". $arrayFields[$i+1] ;
                    }
                    else if(stristr($arrayFields[$i - 1], "locale") !== false && stristr($arrayFields[$i-2], "actionsfield") !== false)
                    {
                        $fieldData =$fieldData . $arrayFields[$i - 3].',' .$arrayFields[$i - 2] . "," . $arrayFields[$i - 1] . "," .$arrayFields[$i] .",". $arrayFields[$i+1] ;
                    }

                    $fieldData = $fieldData."##";
                }
            }
            //added for copy fun
            if(stristr($arrayFields[$i], 'actionstarget') !== false){

                if ( stristr($arrayFields[$i], 'locale:1/scope:1') !== false ) {

                    $i=$i+4;
                    for($j=$i-6;$j<=$i;$j++){
                        $fieldData = $fieldData . $arrayFields[$j] . "," ;
                    }

                }else if(stristr($arrayFields[$i], 'locale:0/scope:1') !== false || stristr($arrayFields[$i], 'locale:1/scope:0') !== false) {
                    $i=$i+2;
                    for($j=$i-4;$j<=$i;$j++){
                        $fieldData = $fieldData . $arrayFields[$j] . "," ;
                    }

                }else{
                    for($j=$i-2;$j<=$i;$j++){
                        $fieldData = $fieldData . $arrayFields[$j] . "," ;
                    }
                }
                $fieldData = $fieldData . "##";
            }

            //for add or remove Action
            if (stristr($arrayFields[$i], "field") !== false && stristr($arrayFields[$i + 1], 'items') !== false) {
                if ((!empty($arrayFields[$i]) && stristr($arrayFields[$i]. "&", '=&') == false)
                    && !empty($arrayFields[$i - 1]) && stristr($arrayFields[$i - 1]. "&", '=&') == false
                ) {
                    $tempVal = explode("=", $arrayFields[$i]);
                    $tempVal = str_replace("]", "", $tempVal[0]);
                    $tempVal = str_replace("[", "", $tempVal);
                    $tempVal = explode("field", $tempVal);
                    for($k=$i;$k>=0;$k--)
                    {
                        if(stristr($arrayFields[$k], "actions") !== false)
                        {
                            $fieldData = $fieldData .$arrayFields[$k];
                            break;
                        }
                    }
                    $fieldData = $fieldData .','. $arrayFields[$i] . "," . $arrayFields[$i+1];
                    $ItemLists = CreateYmlFile::getAllItems($arrayFields,$i+2);
                    $fieldData = $fieldData. ',' .$ItemLists;
                    $fieldData = $fieldData . "##";
                }
            }
        }
        return $fieldData;
        }catch(Exception $e){
            $this->logger->addError('Yml file creation :@ymlActionFormation: ' . $e->getMessage());
        }
    }
    public function findLength($start,$end)
    {

        return $end-$start;

    }

    public function getAllItems($arrayFields,$index)
    {
        $fieldDataTmp ='';
        while(stristr($arrayFields[$index], 'items') !== false)
        {
            if($fieldDataTmp === '')
            {
                $fieldDataTmp =  $arrayFields[$index];
            }
            else{
                $fieldDataTmp = $fieldDataTmp . "," . $arrayFields[$index];
            }
            $index = $index+1;
        }
            return $fieldDataTmp;
    }






}