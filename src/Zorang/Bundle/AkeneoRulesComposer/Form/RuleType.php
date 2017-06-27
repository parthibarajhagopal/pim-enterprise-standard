<?php

namespace Zorang\Bundle\AkeneoRulesComposer\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Zorang\Bundle\AkeneoRulesComposer\Entity\Repository\AttributeRepository;
use Zorang\Bundle\AkeneoRulesComposer\Entity\Repository\CategoryRepository;

use Zorang\Bundle\AkeneoRulesComposer\Entity\Repository\RuleDefinitionRepository;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class RuleType extends AbstractType
{
    /** @var string */
    protected $dataClass;

    protected $attributeRepository;

    protected $categoryRepository;

    //protected $familyRepository;

    protected $ruleDefinitionRepository;

    public function __construct(
        $dataClass,
        AttributeRepository $attributeRepository,
        CategoryRepository $categoryRepository,
        //FamilyRepository $familyRepository,
        RuleDefinitionRepository $ruleDefinitionRepository
    ) {

        $this->dataClass = $dataClass;
        $this->attributeRepository = $attributeRepository;
        $this->categoryRepository = $categoryRepository;
        //$this->familyRepository = $familyRepository;
        $this->ruleDefinitionRepository = $ruleDefinitionRepository;

    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        //locale & scope
        $pimLocalCode = $this->ruleDefinitionRepository->findActivatedPimLocaleCode();//$this->ruleDefinitionRepository->findActivatedPimLocaleCode();
        $pimLocalCode = array_combine($pimLocalCode, $pimLocalCode);
        $pimScopeCode = $this->ruleDefinitionRepository->findActivatedPimScopeCode();
        $pimScopeCode = array_combine($pimScopeCode, $pimScopeCode);
        $ruleId = (int)$options['data']->getId();

        $rule = $this->ruleDefinitionRepository->findByIdNew($ruleId);

        $code = "";$priority="";
        if (count($rule) > 0) {
            $code = $rule[0];

        }
        $priorityFetch =$this->ruleDefinitionRepository->findPriority($ruleId);
        if (count($priorityFetch) > 0) {
            $priority = $priorityFetch[0];

        }
        $conditions = $this->ruleDefinitionRepository->getConditionsById($ruleId);
        $selectedCategories = array();
        foreach ($conditions as $fields) {
            foreach ($fields as $field) {
                $fieldVal = $field['field'];
                if ($fieldVal == 'categories.code') {
                    $selectedCategories = $field['value'];
                    $selectedCategories = array_combine($selectedCategories, $selectedCategories);
                } else if ($fieldVal == 'clas_gl.code') {
                    $selectedCategories = $field['value'];
                    $selectedCategories = array_combine($selectedCategories, $selectedCategories);
                }
            }
        }



//selcted family
        $family = array(); $selectedFamily = array();
        foreach ($conditions as $fields) {
            foreach ($fields as $field) {
                $fieldVal = $field['field'];
                if (!empty($fieldVal)&& $fieldVal == 'family.code') {
                    $selectedFamily = $field['value'];
                    $selectedFamily=array_combine($selectedFamily, $selectedFamily);

                }
            }
        }


        $categoryTree = [];
        $categoryRoot = $this->categoryRepository->findTranslatedLabels();
        forEach($categoryRoot as $key => $value) {
            $parentId = $this->categoryRepository->findCategoryId($key);
            $categoryChildLab = $this->categoryRepository->findTranslatedLabelsChildren($parentId);
            $categoryTree[$key] = $value;
            forEach($categoryChildLab as $key1 => $value1) {
                $parentId1 = $this->categoryRepository->findCategoryId($key1);
                $categoryChildLab1 = $this->categoryRepository->findTranslatedLabelsChildren($parentId1);
                $categoryTree[$key1] = $value . " / " . $value1;

                if (count($categoryChildLab1) > 0) {
                    forEach ($categoryChildLab1 as $key2 => $value2) {
                        $categoryTree[$key2] = $value . " / " . $value1 . " / " . $value2;
                        $parentId2 = $this->categoryRepository->findCategoryId($key2);
                        $categoryChildLab2 = $this->categoryRepository->findTranslatedLabelsChildren($parentId2);
                        if (count($categoryChildLab2) > 0) {
                            forEach ($categoryChildLab2 as $key3 => $value3) {
                                $categoryTree[$key3] = $value . " / " . $value1 . " / " . $value2 . " / " . $value3;
                            }
                        }
                    }
                }
            }
        }


        $family = $this->ruleDefinitionRepository->findRuleFamilyCodes();
        $family = array_combine($family, $family);

        $actions = $this->ruleDefinitionRepository->getActionsById($ruleId);
        $fieldCodesArr = $this->attributeRepository->findAttributeCodes();
        $fieldCodeValue = $this->attributeRepository->findScopeLocalActionAttributeCodes();
        $fieldCodes = array_combine($fieldCodeValue, $fieldCodesArr);
        $fieldSrcValue = $this->attributeRepository->findAttributeCodesTypes();
        $fieldSrcLabel= $this->attributeRepository->findAttributeLocalScope();
        $fieldSrc = array_combine($fieldSrcLabel, $fieldSrcValue);
        $fieldTarget=array_combine($fieldSrcLabel, $fieldSrcValue);
        //copy from -to locale
        $pimLocalCode = $this->ruleDefinitionRepository->findActivatedPimLocaleCode();
        $pimLocalCode = array_combine($pimLocalCode, $pimLocalCode);
        //copy from -to scope
        $pimScopeCode = $this->ruleDefinitionRepository->findActivatedPimScopeCode();
        $pimScopeCode = array_combine($pimScopeCode, $pimScopeCode);


        $builder
            ->add('id', 'hidden')
            ->add('code', 'text', array(
                'label' => 'Create a rule code:',
                'data' => $code,
                // 'disabled' => ($code != "") ? true : false
            ))
            ->add('priority', 'text', array(
                'label' => 'Priority:',
                'data' => $priority,
                'required'=>false
                // 'disabled' => ($code != "") ? true : false
            ))
            ->add('category',
                'choice', array('required'=>false,
                    'choices' => $categoryTree,
                    'data' => $selectedCategories,
                    'select2'   => true,
                    'disabled'  => false,
                    'read_only' => true,
                    'multiple' => true
                ))
            ->add('family',
                'choice',array(
                    'required'=>false,    'choices' =>$family ,
                    'data' => $selectedFamily,
                    'select2'   => true,
                    'disabled'  => false,
                    'read_only' => true,
                    'multiple' => true
                ))
            ->add('fields', 'zorang_fields', $options);


        if ($ruleId > 0) {

            foreach ($actions as $action) {

                $actioncount = count($action);

                $builder->add('actioncount', 'text', array(
                    'data' => $actioncount,
                    'required' => false
                ));
                foreach ($action as $key => $values1) {
                    $actionTypeRaw = "";
                    $actionType = "";
                    $actionField ="";
                    $actionValue ="";
                    $actionfrom="";
                    $actionto="";
                    //  var_dump($values1);
                    if(!empty($values1['type'])) {
                        $actionTypeRaw = $values1['type'];
                        $actionType = (string)$actionTypeRaw;
                    }
                    if(strcasecmp($actionType,"copy")){
                        if(!empty($values1['field'])) {
                            $actionField = $values1['field'];
                            $attrType = $this->attributeRepository->findAttributeTypeByCode($actionField);
                            if(isset($attrType[0]['attributeType']) && isset($attrType[0]['status'])){
                                $scopableLocalizable = $attrType[0]['status'];
                                $tmpAttType = substr($attrType[0]['attributeType'],12);
                                //$attrType = explode("pim_catalog_",$attrType[0]['attributeType']);
                                $actionField = $actionField . "/" .$tmpAttType .'/'.$scopableLocalizable;
                            }
                            else{
                                $actionField = 'null';
                            }


                        }
                        if(isset($values1['value']))
                        {
                            $actionValue = $values1['value'];
                        }
                        else{
                            $actionValue = "null";
                        }


                    }
                    else{
                        // = $values1['from_field'];
                        $actionfrom = FieldsType::getFieldVal($fieldSrc, $values1['from_field']);
                        // $actionto = $values1['to_field'];
                        $actionto = FieldsType::getFieldVal($fieldSrc, $values1['to_field']);
                    }
                    $actionValueStr="";
                    //added for group pricing
                    if(strcmp($values1['type'],"add_pricing")==false && strcmp($values1['field'],"group_pricing")==false){
                        $actionValue="PRICE-CODE:".$values1['value'].","."PRICE-GROUP-NAME:".$values1['pricing_group_name'];
                    }
                    $actionCurrencyValueStr = 'null';
                    $actionUnitValue = "";
                    //group pricing end
                    if(is_array($actionValue)) {

                        foreach ($actionValue as $valuesArray) {
                            if(is_array($valuesArray)) {
                                foreach ($valuesArray as $actionkey => $actionval) {
                                    //added for price
                                    if (!empty($actionval) && !strcmp($actionkey, 'data')) {
                                        $price = 'Price';
                                        $actionValueStr = $actionval;
                                    }
                                    if (!empty($actionval) && !strcmp($actionkey, 'currency')) {
                                        $actionCurrencyValueStr =  $actionval;
                                    }
                                    else{
                                        $actionCurrencyValueStr = 'null';
                                    }
                                    if(!empty($actionval) && !strcmp($actionkey, 'unit'))
                                    {
                                        $actionUnitValue = $actionval;
                                    }
                                    else{
                                        $actionUnitValue = "";
                                    }

                                }
                            }else{
                                if(isset($actionValue['data']) && isset($actionValue['unit']))
                                {
                                    $actionValueStr = $actionValue['data'];
                                    $actionUnitValue = $actionValue['unit'];
                                }
                                else{
                                    $actionValueStr=$actionValueStr.",".$valuesArray;

                                }
                            }
                        }
                        $actionValueStr = ltrim($actionValueStr, ",");
                    }else{
                        $actionValueStr=$actionValue;
                    }
                    if(is_bool($actionValueStr)) {
                        $actionValueStr = $this->boolConvert($actionValueStr);
                    }
                    $actionValueStr = ltrim($actionValueStr, ",");

                    //for add or remove Action
                    if(isset($values1['field']) && isset($values1['items']))
                    {
                        $addRemoveFieldValue = $values1['field'];
                        $addRemoveItemValue = $values1['items'];

                    }else{
                        $addRemoveFieldValue = 'null';
                        $addRemoveItemValue = Array ();
                    }
                    $keyStr = (string)($key + 1);
                    $actionsStr = 'actions' . $keyStr;
                    $actionsfieldStr = 'actionsfield' . $keyStr;
                    $actionsvalueStr = 'actionsvalue' . $keyStr;
                    //$actionsSrc='actionsvalue' . $keyStr;
                    //currency field
                    $currency_label = 'currency' . $keyStr;
                    $currencyFieldClass = 'actionCurrencyClass' . $keyStr;
                    $currencyCode = $this->ruleDefinitionRepository->findActivatedCurrencyCode();
                    $currencyCode = array_combine($currencyCode, $currencyCode);
                    //unit Field
                    $unit_label = 'unit' . $keyStr;
                    $unitFieldClass = 'actionUnitClass' . $keyStr;
                    //local & scope field
                    $locale_label = 'locale'.$keyStr;
                    $scope_label = 'scope'.$keyStr;
                    //Locale & Scope selected value
                    $locale = '';
                    $scope = '';
                    if(isset($values1['locale']))
                    {
                        $locale = $values1['locale'];
                    }
                    if(isset($values1['scope']))
                    {
                        $scope = $values1['scope'];
                    }
                    $builder->add($actionsStr,
                        'choice', array(
                            'choices' => array(

                                'set' => 'set',
                                'add' => 'add',
                                'remove' => 'remove',
                                //'add_pricing' => 'add_pricing',
                                'copy' => 'copy'
                            ),
                            'label'=>"Type",
                            'data' => $actionType,
                            'select2' => true,
                            'disabled' => false,
                            'read_only' => true,
                            'attr' => ['onChange' => 'changeAction(' . $keyStr . ')']
                        ));


                    $builder ->
                    add($actionsfieldStr,
                        'choice', array(
                            'choices' => $fieldCodes,
                            'data' => $actionField,
                            'select2' => true,
                            'disabled' => false,
                            'read_only' => true,
                            'label'=>"Field",
                            'attr' => ['onChange' => 'changeFields(' . $keyStr . ')']
                        ))
                        ->add($locale_label,  // Rule UI scope Field
                            'choice',
                            ['choices' => $pimLocalCode,
                                'data' => $locale,
                                'select2' => true,
                                'disabled' => false,
                                'read_only' => true
                            ])
                        ->add($scope_label,  // Rule UI locale Field
                            'choice',
                            ['choices' => $pimScopeCode,
                                'data' => $scope,
                                'select2' => true,
                                'disabled' => false,
                                'read_only' => true
                            ])
                        ->add($actionsvalueStr,
                            'text',
                            [
                                'label' => "Value",
                                'data' => $actionValueStr,
                                'help' => 'For Boolean use True or False'
                            ]
                        )
                        ->add($currency_label,  // Currency Field
                            'choice',
                            ['choices' => $currencyCode,
                                'data' => $actionCurrencyValueStr,
                                'select2' => true,
                                'disabled' => false,
                                'read_only' => true,
                                'attr'=> ['class'=> $currencyFieldClass]
                            ])
                            ->add($unit_label,
                                'text',
                                [
                                    'label' => "unit",
                                    'data' => $actionUnitValue,
                                    //'help' => 'For Boolean use True or False'
                                    'attr'=> ['class'=> $unitFieldClass]
                                ]
                            )
                    ;

                    $actionssrc="actionssrc".$keyStr;
                    $actionstarget="actionstarget". $keyStr;

                    $builder ->add($actionssrc,
                        'choice', array(
                            'choices' => $fieldSrc,
                            'data' => $actionfrom,
                            'select2' => true,
                            'disabled' => false,
                            'read_only' => true,
                            'label'=>"Form Field",
                            'attr' => ['onChange' => 'copyValidation(' . $keyStr . ')']

                        ))
                        ->add($actionstarget,
                            'choice', array(
                                'choices' => $fieldTarget,
                                'data' => $actionto,
                                'select2' => true,
                                'disabled' => false,
                                'read_only' => true,
                                'label'=>"To Field",
                                'attr' => ['onChange' => 'copyValidation(' . $keyStr . ')']

                            ));
                    //for Add Rules
                    $fieldLabel = "field" . $keyStr;
                    $itemsLabel = 'items' . $keyStr;
                    $builder ->add($fieldLabel,
                        'choice', array(
                            'choices' => array(
                                'categories' => 'categories'
                            ),
                            'data' => $addRemoveFieldValue,
                            'select2' => true,
                            'disabled' => false,
                            'read_only' => true,
                            'label'=>"From Field"
                        ))
                        ->add($itemsLabel,
                            'choice', array(
                                'choices' => $categoryTree,
                                'data' => $addRemoveItemValue,
                                'select2' => true,
                                'disabled' => false,
                                'read_only' => true,
                                'label'=>"To Field",
                                'multiple' => true,
                                //'attr' => ['onChange' => 'copyValidation(' . $keyStr . ')']

                            ));

                    //Action From-To locale
                    $actionssrclocale="actionsrclocale".$keyStr;
                    $actionstargetlocale="actiontgtlocale". $keyStr;

                    //Action From-To scope
                    $actionssrcscope="actionsrcscope".$keyStr;
                    $actionstargetscope="actiontgtscope". $keyStr;
                    $builder ->add($actionssrclocale,
                        'choice', array(
                            'choices' => $pimLocalCode,
                            'data' => $actionfrom,
                            'select2' => true,
                            'disabled' => false,
                            'read_only' => true,
                            'label'=>"Form Locale",
                            'attr'=> ['class'=> "added",'onChange' => 'OnChangeLocale(' . $keyStr . ')']

                        ))
                        ->add($actionstargetlocale,
                            'choice', array(
                                'choices' => $pimLocalCode,
                                'data' => $actionto,
                                'select2' => true,
                                'disabled' => false,
                                'read_only' => true,
                                'label'=>"To Locale",
                                'attr' => ['onChange' => 'OnChangeLocale(' . $keyStr . ')']

                            ));
                    $builder ->add($actionssrcscope,
                        'choice', array(
                            'choices' => $pimScopeCode,
                            'data' => $actionfrom,
                            'select2' => true,
                            'disabled' => false,
                            'read_only' => true,
                            'label'=>"Form Scope",
                            'attr'=> ['class'=> "added",'onChange' => 'OnChangeLocale(' . $keyStr . ')']

                        ))
                        ->add($actionstargetscope,
                            'choice', array(
                                'choices' => $pimScopeCode,
                                'data' => $actionto,
                                'select2' => true,
                                'disabled' => false,
                                'read_only' => true,
                                'label'=>"To Scope",
                                'attr' => ['onChange' => 'OnChangeLocale(' . $keyStr . ')']

                            ));

                }

                $allowedNewActions = 5 - $actioncount;

                for ($i = 0; $i < $allowedNewActions; $i++) {

                    $keyStr = (string)($actioncount + $i + 1);
                    $actionsStr = 'actions' . $keyStr;
                    $actionsfieldStr = 'actionsfield' . $keyStr;
                    $actionsvalueStr = 'actionsvalue' . $keyStr;
                    $actionType = "";
                    $actionField ="";
                    $actionValue ="";
                    $actionfrom="";
                    $actionto="";
                    //currency field
                    $currency_label = 'currency' . $keyStr;
                    $currencyFieldClass = 'actionCurrencyClass' . $keyStr;
                    $currencyCode = $this->ruleDefinitionRepository->findActivatedCurrencyCode();
                    $currencyCode = array_combine($currencyCode, $currencyCode);
                    //unit Field
                    $unit_label = 'unit' . $keyStr;
                    $unitFieldClass = 'actionUnitClass' . $keyStr;
                    //local & scope field
                    $locale_label = 'locale'.$keyStr;
                    $scope_label = 'scope'.$keyStr;

                    $builder->add($actionsStr,
                        'choice', array(
                            'choices' => array(
                                // ''=>'',
                                'set' => 'set',
                                'add' => 'add',
                                'remove' => 'remove',
                                //'add_pricing' => 'add_pricing',
                                'copy' => 'copy'
                            ),
                            'label'=>"Type",
                            'data' => $actionType,
                            'select2' => true,
                            'disabled' => false,
                            'read_only' => true,
                            'attr' => ['onChange' => 'changeAction(' . $keyStr . ')']
                        ));

                    $builder ->
                    add($actionsfieldStr,
                        'choice', array(
                            'label'=>"Field",
                            'choices' => $fieldCodes,
                            'data' => $actionField,
                            'select2' => true,
                            'disabled' => false,
                            'read_only' => true,
                            'attr' => ['onChange' => 'changeFields(' . $keyStr . ')']
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
                        ->add($actionsvalueStr,
                            'text',
                            [
                                'label' => "Value",
                                'data' => $actionValue,
                                'help' => 'For Boolean use True or False'
                            ]
                        )
                        ->add($currency_label,  // Currency Field
                            'choice',
                                ['choices' => $currencyCode,
                                //'data' => $selectedCurrency,
                                'select2' => true,
                                'disabled' => false,
                                'read_only' => true,
                                'attr'=> ['class'=> $currencyFieldClass]
                            ])
                            ->add($unit_label,
                                'text',
                                [
                                    'label' => "unit",
                                    //'data' => "null",
                                    //'help' => 'For Boolean use True or False'
                                    'attr'=> ['class'=> $unitFieldClass]
                                ]
                            )
                    ;


                    $actionssrc="actionssrc".$keyStr;
                    $actionstarget="actionstarget". $keyStr;

                    $builder ->add($actionssrc,
                        'choice', array(
                            'choices' => $fieldSrc,
                            'data' => $actionfrom,
                            'select2' => true,
                            'disabled' => false,
                            'read_only' => true,
                            'label'=>"From Field",
                            'attr' => ['onChange' => 'copyValidation(' . $keyStr . ')']
                        ))
                        ->add($actionstarget,
                            'choice', array(
                                'choices' => $fieldTarget,
                                'data' => $actionto,
                                'select2' => true,
                                'disabled' => false,
                                'read_only' => true,
                                'label'=>"To Field",
                                'attr' => ['onChange' => 'copyValidation(' . $keyStr . ')']

                            ));

                    //for Add Rules
                    $fieldLabel = "field" . $keyStr;
                    $itemsLabel = 'items' . $keyStr;
                    $builder ->add($fieldLabel,
                        'choice', array(
                            'choices' => array(
                                'categories' => 'categories'
                            ),
                            //'data' => $actionfrom,
                            'select2' => true,
                            'disabled' => false,
                            'read_only' => true,
                            'label'=>"From Field"
                        ))
                        ->add($itemsLabel,
                            'choice', array(
                                'choices' => $categoryTree,
                                //'data' => $actionto,
                                'select2' => true,
                                'disabled' => false,
                                'read_only' => true,
                                'label'=>"To Field",
                                'multiple' => true,
                                //'attr' => ['onChange' => 'copyValidation(' . $keyStr . ')']

                            ));
                    //Action From-To locale
                    $actionssrclocale="actionsrclocale".$keyStr;
                    $actionstargetlocale="actiontgtlocale". $keyStr;

                    //Action From-To scope
                    $actionssrcscope="actionsrcscope".$keyStr;
                    $actionstargetscope="actiontgtscope". $keyStr;
                    $builder ->add($actionssrclocale,
                        'choice', array(
                            'choices' => $pimLocalCode,
                            'data' => $actionfrom,
                            'select2' => true,
                            'disabled' => false,
                            'read_only' => true,
                            'label'=>"Form Locale",
                            'attr'=> ['class'=> "added",'onChange' => 'OnChangeLocale(' . $keyStr . ')']

                        ))
                        ->add($actionstargetlocale,
                            'choice', array(
                                'choices' => $pimLocalCode,
                                'data' => $actionto,
                                'select2' => true,
                                'disabled' => false,
                                'read_only' => true,
                                'label'=>"To Locale",
                                'attr' => ['onChange' => 'copyValidation(' . $keyStr . ')']

                            ));
                    $builder ->add($actionssrcscope,
                        'choice', array(
                            'choices' => $pimScopeCode,
                            'data' => $actionfrom,
                            'select2' => true,
                            'disabled' => false,
                            'read_only' => true,
                            'label'=>"Form Scope",
                            'attr'=> ['class'=> "added",'onChange' => 'OnChangeLocale(' . $keyStr . ')']

                        ))
                        ->add($actionstargetscope,
                            'choice', array(
                                'choices' => $pimScopeCode,
                                'data' => $actionto,
                                'select2' => true,
                                'disabled' => false,
                                'read_only' => true,
                                'label'=>"To Scope",
                                'attr' => ['onChange' => 'OnChangeLocale(' . $keyStr . ')']

                            ));

                }
//Remove action change
                $builder->add('addaction', 'button', array(
                    'label' => 'Add Action',
                    'attr' => ['style' => 'float: left','onClick' => 'AddActionCreate()']
                ));
                $builder->add('removeaction', 'button', array(
                    'label' => 'Remove Action',
                    'attr' => ['onClick' => 'RemoveAction()']
                ));
//Remove action change

            }
        } else {
            $actioncount = 0;

            $allowedNewActions = 5 - $actioncount;

            $builder->add('actioncount', 'text', array(
                'data' => $actioncount,
                'required' => false
            ));
            for ($i = 0; $i < $allowedNewActions; $i++) {

                $keyStr = (string)($actioncount + $i + 1);
                $actionsStr = 'actions' . $keyStr;
                $actionsfieldStr = 'actionsfield' . $keyStr;
                $actionsvalueStr = 'actionsvalue' . $keyStr;
                $actionType = "";
                $actionField ="";
                $actionValue ="";
                $actionfrom="";
                $actionto="";

                //currency field
                $currency_label = 'currency' . $keyStr;
                $currencyFieldClass = 'actionCurrencyClass' . $keyStr;
                $currencyCode = $this->ruleDefinitionRepository->findActivatedCurrencyCode();
                $currencyCode = array_combine($currencyCode, $currencyCode);

                //Unit Field
                $unit_label = 'unit' . $keyStr;
                $unitFieldClass = 'actionUnitClass' . $keyStr;
                //local & scope field
                $locale_label = 'locale'.$keyStr;
                $scope_label = 'scope'.$keyStr;

                $builder->add($actionsStr,
                    'choice', array(
                        'choices' => array(
                            // ''=>'',
                            'set' => 'set',
                            'add' => 'add',
                            'remove' => 'remove',
                            //'add_pricing' => 'add_pricing',
                            'copy' => 'copy'
                        ),
                        'label'=>"Type",
                        'data' => $actionType,
                        'select2' => true,
                        'disabled' => false,
                        'read_only' => true,
                        'attr' => ['onChange' => 'changeAction(' . $keyStr . ')']
                    ));



                $builder ->
                add($actionsfieldStr,
                    'choice', array(
                        'choices' => $fieldCodes,
                        'data'=>$actionField,
                        'select2' => true,
                        'disabled' => false,
                        'read_only' => true,
                        'label'=>"Field",
                        'attr' => ['onChange' => 'changeFields(' . $keyStr . ')']
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
                    ->add($actionsvalueStr,
                        'text',
                        [
                            'label' => "Value",
                            'data'=>$actionValue,
                            'help' => 'For Boolean use True or False'
                        ]
                    )
                    ->add($currency_label,  // Currency Field
                        'choice',
                        ['choices' => $currencyCode,
                            //'data' => $selectedCurrency,
                            'select2' => true,
                            'disabled' => false,
                            'read_only' => true,
                            'attr'=> ['class'=> $currencyFieldClass]
                        ])
                        ->add($unit_label,
                            'text',
                            [
                                'label' => "unit",
                                //'data' => "null",
                                //'help' => 'For Boolean use True or False'
                                'attr'=> ['class'=> $unitFieldClass]
                            ]
                        )
                ;

                //$actionsCopy = 'actionscopy' . $keyStr;
                $actionssrc="actionssrc".$keyStr;
                $actionstarget="actionstarget". $keyStr;

                $builder ->add($actionssrc,
                    'choice', array(
                        'choices' => $fieldSrc,
                        'data' => $actionfrom,
                        'select2' => true,
                        'disabled' => false,
                        'read_only' => true,
                        'label'=>"From Field",
                        'attr' => ['onChange' => 'copyValidation(' . $keyStr . ')']
                    ))
                    ->add($actionstarget,
                        'choice', array(
                            'choices' => $fieldTarget,
                            'data' => $actionto,
                            'select2' => true,
                            'disabled' => false,
                            'read_only' => true,
                            'label'=>"To Field",
                            'attr' => ['onChange' => 'copyValidation(' . $keyStr . ')']

                        ));

                //for Add Rules
                $fieldLabel = "field" . $keyStr;
                $itemsLabel = 'items' . $keyStr;
                $builder ->add($fieldLabel,
                    'choice', array(
                        'choices' => array(
                            'categories' => 'categories'
                        ),
                        //'data' => $actionfrom,
                        'select2' => true,
                        'disabled' => false,
                        'read_only' => true,
                        //'label'=>"Field"
                    ))
                    ->add($itemsLabel,
                        'choice', array(
                            'choices' => $categoryTree,
                            //'data' => $actionto,
                            'select2' => true,
                            'disabled' => false,
                            'read_only' => true,
                            'label'=>"Items",
                            'multiple' => true,
                            //'attr' => ['onChange' => 'copyValidation(' . $keyStr . ')']

                        ));
                //Action From-To locale
                $actionssrclocale="actionsrclocale".$keyStr;
                $actionstargetlocale="actiontgtlocale". $keyStr;

                //Action From-To scope
                $actionssrcscope="actionsrcscope".$keyStr;
                $actionstargetscope="actiontgtscope". $keyStr;
                $builder ->add($actionssrclocale,
                    'choice', array(
                        'choices' => $pimLocalCode,
                        'data' => $actionfrom,
                        'select2' => true,
                        'disabled' => false,
                        'read_only' => true,
                        'label'=>"Form Locale",
                        'attr'=> ['onChange' => 'OnChangeLocale(' . $keyStr . ')']

                    ))
                    ->add($actionstargetlocale,
                        'choice', array(
                            'choices' => $pimLocalCode,
                            'data' => $actionto,
                            'select2' => true,
                            'disabled' => false,
                            'read_only' => true,
                            'label'=>"To Locale",
                            'attr' => ['onChange' => 'OnChangeLocale(' . $keyStr . ')']

                        ));
                $builder ->add($actionssrcscope,
                    'choice', array(
                        'choices' => $pimScopeCode,
                        'data' => $actionfrom,
                        'select2' => true,
                        'disabled' => false,
                        'read_only' => true,
                        'label'=>"Form Scope",
                        'attr'=> ['onChange' => 'OnChangeLocale(' . $keyStr . ')']

                    ))
                    ->add($actionstargetscope,
                        'choice', array(
                            'choices' => $pimScopeCode,
                            'data' => $actionto,
                            'select2' => true,
                            'disabled' => false,
                            'read_only' => true,
                            'label'=>"To Scope",
                            'attr' => ['onChange' => 'OnChangeLocale(' . $keyStr . ')']

                        ));
                //   }
                // ->add($actionstofield, 'text', ['label' => 'ToField', 'data' => "actionTofield",'help'=>'Specify the field name to copy']);
            }
//Remove action change
            $builder->add('addaction', 'button', array(
                'label' => 'Add Action',
                'attr' => ['style' => 'float: left','onClick' => 'AddActionCreate()']
            ));
            $builder->add('removeaction', 'button', array(
                'label' => 'Remove Action',
                'attr' => ['onClick' => 'RemoveAction()']
            ));
//Remove action change
        }
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
//    public function setDefaultOptions(OptionsResolverInterface $resolver)
//    {
//        $resolver->setDefaults(array(
//            'data_class' => 'Zorang\Bundle\AkeneoRulesComposer\Entity\Rule',
//        ));
//    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => $this->dataClass,
            ]
        );
    }



    public function boolConvert($actionValue){
        if (is_bool($actionValue)) {

            if ($actionValue === 1) {
                return  $actionValue ="true";
            } else  {
                return  $actionValue ="false";
            }
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'zorang_rule';
    }


}