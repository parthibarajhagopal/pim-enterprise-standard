<?php

namespace Zorang\Bundle\AkeneoRulesComposer\Form;

use Akeneo\Bundle\MeasureBundle\Manager\MeasureManager;
use Doctrine\ORM\EntityManager;
use Pim\Component\Catalog\AttributeTypes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Zorang\Bundle\AkeneoRulesComposer\Entity\Repository\AttributeRepository;
use Zorang\Bundle\AkeneoRulesComposer\Entity\Repository\RuleDefinitionRepository;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


/**
 * Conversion units form type
 *
 * @author    Gildas Quemener <gildas@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class FieldsType extends AbstractType
{
    protected $attributeRepository;

    protected $ruleDefinitionRepository;

    protected $fieldsClass;

    public function __construct(
        AttributeRepository $attributeRepository,
        RuleDefinitionRepository $ruleDefinitionRepository,
        $fieldsClass
    )
    {
        $this->attributeRepository = $attributeRepository;
        $this->ruleDefinitionRepository = $ruleDefinitionRepository;
        $this->fieldsClass = $fieldsClass;

    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $ruleId = (int)$options['data']->getId();

        $fieldCodesTypesArr = $this->attributeRepository->findAttributeCodesTypes();
        $fieldCodesTypesArrValue = $this->attributeRepository->findScopeLocaleAttributeCodesTypes();

        $fieldCodesTypes = array_combine($fieldCodesTypesArrValue, $fieldCodesTypesArr);
        $conditions = $this->ruleDefinitionRepository->getConditionsById($ruleId);
        // Getting Active Currency code from DB
        $currencyCode = $this->ruleDefinitionRepository->findActivatedCurrencyCode();
        $currencyCode = array_combine($currencyCode, $currencyCode);

        $pimLocalCode = $this->ruleDefinitionRepository->findActivatedPimLocaleCode();
        $pimLocalCode = array_combine($pimLocalCode, $pimLocalCode);

        $pimScopeCode = $this->ruleDefinitionRepository->findActivatedPimScopeCode();
        $pimScopeCode = array_combine($pimScopeCode, $pimScopeCode);
        $count = 0;
        if ($ruleId > 0) {
            foreach ($conditions as $fields) {
                foreach ($fields as $key => $field) {
                    if (strcasecmp($field['field'], "family.code")
                        && strcasecmp($field['field'], 'categories.code')
                    ) {

                        // Edit Field populate
                        $fieldCodeType = $this->getFieldVal($fieldCodesTypes, $field['field']);

                        // Edit operator populate
                        $tmpFieldCodeType = explode("/", $fieldCodeType);
                        $tmpFieldCodeType = $tmpFieldCodeType[0].'/'.$tmpFieldCodeType[1];
                        $type = $this->getAttributeType($tmpFieldCodeType);
                        $operatorList = $this->getOperatorsList($type);
                        $selectedOperator = $field['operator'];

                        // Edit Value populate
                        $valueStr = ltrim($this->getValues($field['value']), ',');

                        $onChangekey = (string)($count + 1);
                        $fieldLabel = $this->getLabelName($key, 'field', $count);
                        $operatorLabel = $this->getLabelName($key, 'operator', $count);
                        $valueLabel = $this->getLabelName($key, 'value', $count);

                        $currency_label = $this->getLabelName($key, 'currency', $count);
                        $unit_label = $this->getLabelName($key, 'unit', $count);
                        $currencyFieldClass = $this->getLabelName($key, 'currencyCode', $count);
                        $unitFieldClass = $this->getLabelName($key, 'unitCode', $count);

                        $locale_label = $this->getLabelName($key, 'locale', $count);
                        $scope_label = $this->getLabelName($key, 'scope', $count);

                        if(isset($field['value']['currency'])){
                            $selectedCurrency = $field['value']['currency'];

                        }else{
                            $selectedCurrency = 'null';
                        }

                        if(isset($field['locale'])){
                            $selectedLocale = $field['locale'];

                        }else{
                            $selectedLocale = 'null';
                        }
                        if(isset($field['scope'])){
                            $selectedScope = $field['scope'];

                        }else{
                            $selectedScope = 'null';
                        }
                        // for Unit Data
                        if(isset($field['value']['unit']))
                        {
                            $unitDataValue = $field['value']['unit'];
                        }
                        else{
                            $unitDataValue = "";
                        }
                        $builder
                            ->add($fieldLabel,
                                'choice',
                                [
                                    'choices' => $fieldCodesTypes,
                                    'data' => $fieldCodeType,
                                    'select2' => true,
                                    'disabled' => false,
                                    'read_only' => true,
                                    'required' => false,
                                    'label'=>'Field',
                                    'attr' => ['onChange' => 'changeOperator(' . $onChangekey . ')']
                                ])


                            ->add($locale_label,  // Rule UI scope Field
                                'choice',
                                ['choices' => $pimLocalCode,
                                    'data' => $selectedLocale,
                                    'select2' => true,
                                    'disabled' => false,
                                    'read_only' => true
                                ])
                            ->add($scope_label,  // Rule UI locale Field
                                'choice',
                                ['choices' => $pimScopeCode,
                                    'data' => $selectedScope,
                                    'select2' => true,
                                    'disabled' => false,
                                    'read_only' => true
                                ])
                            ->add($operatorLabel,
                                'choice',
                                ['choices' => $operatorList,
                                    'data' => $selectedOperator,
                                    'select2' => true,
                                    'disabled' => false,
                                    'read_only' => true,
                                    'required' => false,
                                    'label'=>'Operator',
                                    'attr' => ['onChange' => 'changeOperator(' . $onChangekey . ')']
                                ])
                            ->add($valueLabel, 'text', array(
                                'data' => $valueStr,
                                'required' => false,
                                'label'=>'Value',
                                'help' => 'For Boolean use True or False'
                            ))
                            ->add($currency_label,  // Rule UI Currency Field
                                'choice',
                                ['choices' => $currencyCode,
                                    'data' => $selectedCurrency,
                                    'select2' => true,
                                    'disabled' => false,
                                    'read_only' => true,
                                    'attr'=> ['class'=> $currencyFieldClass]
                                ])
                            ->add($unit_label,
                                'text',
                                [
                                    'label' => "Unit",
                                    'data' => $unitDataValue,
                                    'attr'=> ['class'=> $unitFieldClass]
                                ]
                            )
                        ;
                        $count++;
                    }

                }
            }
            if ($count > 0) {

                $allowedNewFields = 10 - $count;

                $builder->add('count', 'text', array(
                    'data' => $count,
                    'required' => false
                ));
                for ($i = 0; $i < $allowedNewFields; $i++) {
                    $keyStr1 = (string)($count + $i + 1);
                    $fieldNewStr = 'field' . $keyStr1;
                    $operatorNewStr = 'operator' . $keyStr1;
                    $conditionValueNewStr = 'value' . $keyStr1;
                    $currency_label = 'currency' . $keyStr1;
                    $unit_label = 'unit' . $keyStr1;

                    $currencyFieldClass = 'currencyCode'.$keyStr1;
                    $unitFieldClass = 'unitCode'.$keyStr1;
                    $locale_label = 'locale'.$keyStr1;
                    $scope_label = 'scope'.$keyStr1;
                      $builder
                        ->add($fieldNewStr,
                            'choice',
                            [   'label'=>'Field',
                                'choices' => $fieldCodesTypes,
                                'select2' => true,
                                'disabled' => false,
                                'read_only' => true,
                                'attr' => ['onChange' => 'changeOperator(' . $keyStr1 . ')']
                            ])


                        ->add($operatorNewStr,
                            'choice', array(
                                'choices' => ['=','='],
                                'select2' => true,
                                'disabled' => false,
                                'read_only' => true,
                                'label'=>'Operator'
                            ))
                          ->add($locale_label,  // Rule UI scope Field
                              'choice',
                              ['choices' => $pimLocalCode,
                                  //'data' => $selectedLocal,
                                  'select2' => true,
                                  'disabled' => false,
                                  'read_only' => true
                              ])
                          ->add($scope_label,  // Rule UI locale Field
                              'choice',
                              ['choices' => $pimScopeCode,
                                  //'data' => $selectedScope,
                                  'select2' => true,
                                  'disabled' => false,
                                  'read_only' => true
                              ])
                          ->add($conditionValueNewStr,
                              'text', array('label'=>'Value',
                                  'required' => false,
                                  'help' => 'For Boolean use True or False'
                              ))
                          ->add($currency_label,
                              'choice',
                              ['choices' => $currencyCode,
                                  'select2' => true,
                                  'disabled' => false,
                                  'read_only' => true,
                                  'attr'=> ['class'=> $currencyFieldClass]
                              ])
                          ->add($unit_label,
                              'text',
                              [
                                  'label' => "Unit",
                                  //'data' => "null",
                                  'attr'=> ['class'=> $unitFieldClass]
                              ]
                          )
                      ;
                }
//Remove field
                $builder->add('addfield', 'button', array(
                    'label' => 'Add Field',
                    'attr' => ['style' => 'float: left','onClick' => 'showFieldFormEdit(' . $count . ')']
                ));
                $builder->add('removefield', 'button', array(
                    'label' => 'Remove Field',
                    'attr' => ['float: center','onClick' => 'RemoveField()']
                ));
//Remove field
            } else {
                $this->addFields($builder, $fieldCodesTypes,$currencyCode);
            }


        } else {
            $this->addFields($builder, $fieldCodesTypes,$currencyCode);
        }
    }


    public function addFields(FormBuilderInterface $builder,$fieldCodesTypes,$currencyCode )
    {
        $pimLocalCode = $this->ruleDefinitionRepository->findActivatedPimLocaleCode();
        $pimLocalCode = array_combine($pimLocalCode, $pimLocalCode);

        $pimScopeCode = $this->ruleDefinitionRepository->findActivatedPimScopeCode();
        $pimScopeCode = array_combine($pimScopeCode, $pimScopeCode);
        $count = 0;

        $builder->add('countnew', 'text', array(
            'data' => $count,
            'required' => false
        ));

        $allowedNewFields = 10 - $count;

        for ($i = 0; $i < $allowedNewFields; $i++) {
            $keyStr1 = (string)($count + $i + 1);
            $fieldNewStr = 'field' . $keyStr1;
            $operatorNewStr = 'operator' . $keyStr1;
            $conditionValueNewStr = 'value' . $keyStr1;
            $currencyLabel = 'currency'.$keyStr1;
            $currencyFieldClass = 'currencyCode'.$keyStr1;
            $unitFieldClass = 'unitCode'.$keyStr1;
            $locale_label = 'locale'.$keyStr1;
            $scope_label = 'scope'.$keyStr1;

            $unit_label = 'unit' . $keyStr1;

            $builder
                ->add($fieldNewStr,
                    'choice',
                    [
                        'choices' => $fieldCodesTypes,
                        'select2' => true,
                        'disabled' => false,
                        'read_only' => true,
                        'label'=>'Field',
                        'attr' => ['onChange' => 'changeOperator(' . $keyStr1 . ')']
                    ])

                ->add($operatorNewStr,
                    'choice', array(
                        'choices' => ['=','='],
                        'select2' => true,
                        'disabled' => false,
                        'read_only' => true,
                        'label'=>'Operator',
                    ))

             ->add($locale_label,  // Rule UI scope Field
                 'choice',
                 ['choices' => $pimLocalCode,
                     //'data' => $selectedLocal,
                     'select2' => true,
                     'disabled' => false,
                     'read_only' => true
                 ])
             ->add($scope_label,  // Rule UI locale Field
                 'choice',
                 ['choices' => $pimScopeCode,
                     //'data' => $selectedScope,
                     'select2' => true,
                     'disabled' => false,
                     'read_only' => true
                 ])
                ->add($conditionValueNewStr,
                    'text', array(
                        'required' => false,
                        'label'=>'Value',
                        'help' => 'For Boolean use True or False'
                    ))
             ->add($currencyLabel,
                 'choice',
                 [
                     'choices' => $currencyCode,
                     'select2' => true,
                     'disabled' => false,
                     'read_only' => true,
                     'attr'=> ['class'=> $currencyFieldClass]
                 ])
             ->add($unit_label,
                 'text',
                 [
                     'label' => "Unit",
                     //'data' => "null",
                     'attr'=> ['class'=> $unitFieldClass]
                 ]
             )
         ;
        }
//Remove field
        $builder->add('addfield2', 'button', array(
            'label' => 'Add Field',
            'attr' => ['style' => 'float: left','onClick' => 'showFieldFormCreate(' . $count . ','.$this->isLocalScopeAllow().')']
        ));
        $builder->add('removefield', 'button', array(
            'label' => 'Remove Field',
            'attr' => ['float: center','onClick' => 'RemoveField()']
        ));
        //Remove field
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'zorang_fields';
    }

    /**
     * {@inheritdoc}
     */
    public function getLabelName($key, $name, $count)
    {
        $key = $name . ($count + 1);
        return $key;
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldVal($fieldCodesTypes, $field)
    {

        $field = str_replace(".code", "", $field);

        $pattern = '/^' . $field . '*/';

        $fieldCodeType = "";
        $fieldCodeTypeArr = preg_grep($pattern, array_keys($fieldCodesTypes));
        $field=$field."/";

        if (count($fieldCodeTypeArr) > 0) {
            foreach ($fieldCodeTypeArr as $val) {


                if(stristr($val,$field)!==false) {
                    $fieldCodeType = $val;

                }
            }
        }

        return $fieldCodeType;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributeType($field)
    {
        $pos=strrpos($field,"/");
        $len=strlen($field);
        if(strpos($field,"_collection")!==false){
       // $len=strpos($field,"_")-1;
            $field=str_replace("_collection","",$field);
        }
        $field=substr($field,$pos+1,$len);
        return $field;
    }

        public function getValues($field)
    {
            $values = $field;
            $value = '';
            if (gettype($values) == 'array') {
                foreach ($values as $vkey => $val) {
                    if (!strcasecmp($vkey, 'data')) {
                        $value = $val;
                    }
                }
            } else {
                $value = $values;
            }
            if (gettype($field) == 'boolean') {

                if ($field == 1) {
                    $value = "true";
                } else{
                    $value = "false";
                }
            }

            return $value;
        //}

    }

    public function addFieldsButton(FormBuilderInterface $builder,$fieldCodesList,$count)
    {
        $currencyCode = $this->ruleDefinitionRepository->findActivatedCurrencyCode();
        $currencyCode = array_combine($currencyCode, $currencyCode);
        $pimLocalCode = $this->ruleDefinitionRepository->findActivatedPimLocaleCode();
        $pimLocalCode = array_combine($pimLocalCode, $pimLocalCode);
        $pimScopeCode = $this->ruleDefinitionRepository->findActivatedPimScopeCode();
        $pimScopeCode = array_combine($pimScopeCode, $pimScopeCode);
            $allowedNewFields = 10 - $count;

            $builder->add('count', 'text', array(
                'data' => $count,
                'required' => false
            ));
            for ($i = 0; $i < $allowedNewFields; $i++) {
                $keyStr1 = (string)($count + $i + 1);
                $fieldNewStr = 'field' . $keyStr1;
                $operatorNewStr = 'operator' . $keyStr1;
                $conditionValueNewStr = 'value' . $keyStr1;
                $currency_label = 'currency' . $keyStr1;
                $unit_label = 'unit' . $keyStr1;
                $currencyFieldClass = 'currencyCode'.$keyStr1;
                $unitFieldClass = 'unitCode'.$keyStr1;
                $locale_label = 'locale'.$keyStr1;
                $scope_label = 'scope'.$keyStr1;

             $builder
                    ->add($fieldNewStr,
                        'choice',
                        [
                            'choices' => $fieldCodesList,
                            'select2' => true,
                            'disabled' => false,
                            'read_only' => true,
                            'label'=>'Field',
                            'attr' => ['onChange' => 'changeOperator(' . $keyStr1 . ')']
                        ])

                    ->add($operatorNewStr,
                        'choice', array(
                            'choices' => ['=','='],
                            'select2' => true,
                            'disabled' => false,
                            'read_only' => true,
                            'label'=>'Operator'
                        ))
                    ->add($conditionValueNewStr,
                        'text', array(
                            'required' => false,
                            'label'=>'Value',
                            'help' => 'For Boolean use True or False'
                        ))
                 ->add($locale_label,  // Rule UI scope Field
                     'choice',
                     ['choices' => $pimLocalCode,
                         //'data' => $selectedLocal,
                         'select2' => true,
                         'disabled' => false,
                         'read_only' => true
                     ])
                 ->add($scope_label,  // Rule UI locale Field
                     'choice',
                     ['choices' => $pimScopeCode,
                         //'data' => $selectedScope,
                         'select2' => true,
                         'disabled' => false,
                         'read_only' => true
                     ])

                 ->add($currency_label, // Rule UI Functionality start
                     'choice',
                     ['choices' => $currencyCode,
                         'select2' => true,
                         'disabled' => false,
                         'read_only' => true,
                         'attr'=> ['class'=> $currencyFieldClass]
                     ])
                 ->add($unit_label,
                     'text',
                     [
                         'label' => "Unit",
                         //'data' => "null",
                         'attr'=> ['class'=> $unitFieldClass]
                     ]
                 )
             ;
            }
//Remove field
        $builder->add('addfield', 'button', array(
            'label' => 'Add Field',
            'attr' => ['style' => 'float: left','onClick' => 'showFieldFormEdit(' . $count . ')']
        ));
        $builder->add('removefield', 'button', array(
            'label' => 'Remove Field',
            'attr' => ['style' => 'float: center','onClick' => 'RemoveField()']
        ));
//Remove field
    }



public function getOperatorsList($attributeType){
        $text="STARTS WITH,ENDS WITH,CONTAINS,DOES NOT CONTAINS,=,!=,EMPTY,NOT EMPTY";
        $metric="<,<=,=,!=,>,>=,EMPTY,NOT EMPTY";
        $boolean="=,!=";
        $price="<,<=,=,!=,>,>=,EMPTY,NOT EMPTY";
        $date="<,>,=,!=,BETWEEN,NOT BETWEEN,EMPTY,NOT EMPTY";
        $multiselect="IN,NOT IN,EMPTY,NOT EMPTY";
        $number="<,<=,=,!=,>,>=,EMPTY,NOT EMPTY";
        $file="STARTS WITH,ENDS WITH,CONTAINS,DOES NOT,CONTAIN,=,!=,EMPTY,NOT EMPTY";
        $sku="=";
        switch($attributeType){
           // case 'family.code':
             //   return;
            //case 'categories.code':
              ///  return;
            case 'text':
                return $this->dropdownArray($text);
            case 'image':
                return $this->dropdownArray($file);
            case (stripos($attributeType,'simpleselect')!==false):
                return $this->dropdownArray($multiselect);
            case 'textarea':
                return $this->dropdownArray($text);
            case 'metric':
                return $this->dropdownArray($metric);
            case 'boolean':
                return $this->dropdownArray($boolean);
            case 'price':
                return $this->dropdownArray($price);
            case 'date':
                return $this->dropdownArray($date);
            case 'number':
                return $this->dropdownArray($number);
            case (stripos($attributeType,'multiselect')!==false):
                return $this->dropdownArray($multiselect);
            case 'file':
                return $this->dropdownArray($file);
            case 'identifier':
                return $this->dropdownArray($sku);
            default:
                return $this->dropdownArray($sku);
        }

}

public function dropdownArray($values)
{
$valuesArray=explode(",",$values);
$opratorList=array_combine($valuesArray,$valuesArray);
return $opratorList;
}
//Check LocalScope Count
public function isLocalScopeAllow()
{
    $localScopeCount = $this->ruleDefinitionRepository->findActivatedPimLocaleScopeCount();
    $localCount = $localScopeCount[0]["channelCount"];
    $scopeCount = $localScopeCount[0]["localeCount"];
    if($localCount < 2 && $scopeCount < 2 )
    {
        return 1;
    }
    else if($localCount < 2 && $scopeCount > 2)
    {
        return 2;
    }
    else if($localCount > 2 && $scopeCount < 2)
    {
        return 3;
    }
    else
    {
        return 0;
    }
}

}
