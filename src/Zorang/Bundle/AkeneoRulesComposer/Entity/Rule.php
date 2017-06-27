<?php

namespace Zorang\Bundle\AkeneoRulesComposer\Entity;



class Rule
{
    protected $id;

    protected $code;

    protected $category;

    protected $family;

    protected $fields;

    protected $count;

    protected $countnew;

    protected $field1;

    protected $operator1;

    protected $value1;

    protected $field2;

    protected $operator2;

    protected $value2;

    protected $field3;

    protected $operator3;

    protected $value3;

    protected $field4;

    protected $operator4;

    protected $value4;

    protected $field5;

    protected $operator5;

    protected $value5;

    protected $field6;

    protected $operator6;

    protected $value6;

    protected $field7;

    protected $operator7;

    protected $value7;

    protected $field8;

    protected $operator8;

    protected $value8;

    protected $field9;

    protected $operator9;

    protected $value9;

    protected $field10;

    protected $operator10;

    protected $value10;

    protected $actioncount;

    protected $actions1;

    protected $actionsfield1;

    protected $actionsvalue1;

    protected $actions2;

    protected $actionsfield2;

    protected $actionsvalue2;

    protected $actions3;

    protected $actionsfield3;

    protected $actionsvalue3;

    protected $actions4;

    protected $actionsfield4;

    protected $actionsvalue4;

    protected $actions5;

    protected $actionsfield5;

    protected $actionsvalue5;

    protected $actionssrc1;

    protected $actionstarget1;

    protected $actionssrc2;

    protected $actionstarget2;
    protected $actionssrc3;

    protected $actionstarget3;
    protected $actionssrc4;

    protected $actionstarget4;
    protected $actionssrc5;

    protected $actionstarget5;
    protected $actionscopy1;
    protected $actionscopy2;
    protected $actionscopy3;
    protected $actionscopy4;
    protected $actionscopy5;
    protected $priority;

    /*** Rules UI Currency Functionality variables **/
    protected $currency;
    protected $currency1;
    protected $currency2;
    protected $currency3;
    protected $currency4;
    protected $currency5;
    protected $currency6;
    protected $currency7;
    protected $currency8;
    protected $currency9;
    protected $currency10;


    // locale variale for Rule Functionality
    protected $locale;
    protected $locale1;
    protected $locale2;
    protected $locale3;
    protected $locale4;
    protected $locale5;
    protected $locale6;
    protected $locale7;
    protected $locale8;
    protected $locale9;
    protected $locale10;

    // scope variale for Rule Functionality

    protected $scope;
    protected $scope1;
    protected $scope2;
    protected $scope3;
    protected $scope4;
    protected $scope5;
    protected $scope6;
    protected $scope7;
    protected $scope8;
    protected $scope9;
    protected $scope10;


    /****
     * for Add Rule Functionality
     */
    protected $items;
    protected $items1;
    protected $items2;
    protected $items3;
    protected $items4;
    protected $items5;


    /*** Rules UI Currency Functionality variables **/
    protected $unit;
    protected $unit1;
    protected $unit2;
    protected $unit3;
    protected $unit4;
    protected $unit5;
    protected $unit6;
    protected $unit7;
    protected $unit8;
    protected $unit9;
    protected $unit10;


    //Action From local
    protected $actionsrclocale1;
    protected $actionsrclocale2;
    protected $actionsrclocale3;
    protected $actionsrclocale4;
    protected $actionsrclocale5;
    //Action To local
    protected $actiontgtlocale1;
    protected $actiontgtlocale2;
    protected $actiontgtlocale3;
    protected $actiontgtlocale4;
    protected $actiontgtlocale5;

    /**
     * @return mixed
     */
    public function getActionsrclocale1()
    {
        return $this->actionsrclocale1;
    }

    /**
     * @param mixed $actionsrclocale1
     */
    public function setActionsrclocale1($actionsrclocale1)
    {
        $this->actionsrclocale1 = $actionsrclocale1;
    }

    /**
     * @return mixed
     */
    public function getActionsrclocale2()
    {
        return $this->actionsrclocale2;
    }

    /**
     * @param mixed $actionsrclocale2
     */
    public function setActionsrclocale2($actionsrclocale2)
    {
        $this->actionsrclocale2 = $actionsrclocale2;
    }

    /**
     * @return mixed
     */
    public function getActionsrclocale3()
    {
        return $this->actionsrclocale3;
    }

    /**
     * @param mixed $actionsrclocale3
     */
    public function setActionsrclocale3($actionsrclocale3)
    {
        $this->actionsrclocale3 = $actionsrclocale3;
    }

    /**
     * @return mixed
     */
    public function getActionsrclocale4()
    {
        return $this->actionsrclocale4;
    }

    /**
     * @param mixed $actionsrclocale4
     */
    public function setActionsrclocale4($actionsrclocale4)
    {
        $this->actionsrclocale4 = $actionsrclocale4;
    }

    /**
     * @return mixed
     */
    public function getActionsrclocale5()
    {
        return $this->actionsrclocale5;
    }

    /**
     * @param mixed $actionsrclocale5
     */
    public function setActionsrclocale5($actionsrclocale5)
    {
        $this->actionsrclocale5 = $actionsrclocale5;
    }

    /**
     * @return mixed
     */
    public function getActiontgtlocale1()
    {
        return $this->actiontgtlocale1;
    }

    /**
     * @param mixed $actiontgtlocale1
     */
    public function setActiontgtlocale1($actiontgtlocale1)
    {
        $this->actiontgtlocale1 = $actiontgtlocale1;
    }

    /**
     * @return mixed
     */
    public function getActiontgtlocale2()
    {
        return $this->actiontgtlocale2;
    }

    /**
     * @param mixed $actiontgtlocale2
     */
    public function setActiontgtlocale2($actiontgtlocale2)
    {
        $this->actiontgtlocale2 = $actiontgtlocale2;
    }

    /**
     * @return mixed
     */
    public function getActiontgtlocale3()
    {
        return $this->actiontgtlocale3;
    }

    /**
     * @param mixed $actiontgtlocale3
     */
    public function setActiontgtlocale3($actiontgtlocale3)
    {
        $this->actiontgtlocale3 = $actiontgtlocale3;
    }

    /**
     * @return mixed
     */
    public function getActiontgtlocale4()
    {
        return $this->actiontgtlocale4;
    }

    /**
     * @param mixed $actiontgtlocale4
     */
    public function setActiontgtlocale4($actiontgtlocale4)
    {
        $this->actiontgtlocale4 = $actiontgtlocale4;
    }

    /**
     * @return mixed
     */
    public function getActiontgtlocale5()
    {
        return $this->actiontgtlocale5;
    }

    /**
     * @param mixed $actiontgtlocale5
     */
    public function setActiontgtlocale5($actiontgtlocale5)
    {
        $this->actiontgtlocale5 = $actiontgtlocale5;
    }

    /**
     * @return mixed
     */
    public function getActionsrcscope1()
    {
        return $this->actionsrcscope1;
    }

    /**
     * @param mixed $actionsrcscope1
     */
    public function setActionsrcscope1($actionsrcscope1)
    {
        $this->actionsrcscope1 = $actionsrcscope1;
    }

    /**
     * @return mixed
     */
    public function getActionsrcscope2()
    {
        return $this->actionsrcscope2;
    }

    /**
     * @param mixed $actionsrcscope2
     */
    public function setActionsrcscope2($actionsrcscope2)
    {
        $this->actionsrcscope2 = $actionsrcscope2;
    }

    /**
     * @return mixed
     */
    public function getActionsrcscope3()
    {
        return $this->actionsrcscope3;
    }

    /**
     * @param mixed $actionsrcscope3
     */
    public function setActionsrcscope3($actionsrcscope3)
    {
        $this->actionsrcscope3 = $actionsrcscope3;
    }

    /**
     * @return mixed
     */
    public function getActionsrcscope4()
    {
        return $this->actionsrcscope4;
    }

    /**
     * @param mixed $actionsrcscope4
     */
    public function setActionsrcscope4($actionsrcscope4)
    {
        $this->actionsrcscope4 = $actionsrcscope4;
    }

    /**
     * @return mixed
     */
    public function getActionsrcscope5()
    {
        return $this->actionsrcscope5;
    }

    /**
     * @param mixed $actionsrcscope5
     */
    public function setActionsrcscope5($actionsrcscope5)
    {
        $this->actionsrcscope5 = $actionsrcscope5;
    }

    /**
     * @return mixed
     */
    public function getActiontgtscope1()
    {
        return $this->actiontgtscope1;
    }

    /**
     * @param mixed $actiontgtscope1
     */
    public function setActiontgtscope1($actiontgtscope1)
    {
        $this->actiontgtscope1 = $actiontgtscope1;
    }

    /**
     * @return mixed
     */
    public function getActiontgtscope2()
    {
        return $this->actiontgtscope2;
    }

    /**
     * @param mixed $actiontgtscope2
     */
    public function setActiontgtscope2($actiontgtscope2)
    {
        $this->actiontgtscope2 = $actiontgtscope2;
    }

    /**
     * @return mixed
     */
    public function getActiontgtscope3()
    {
        return $this->actiontgtscope3;
    }

    /**
     * @param mixed $actiontgtscope3
     */
    public function setActiontgtscope3($actiontgtscope3)
    {
        $this->actiontgtscope3 = $actiontgtscope3;
    }

    /**
     * @return mixed
     */
    public function getActiontgtscope4()
    {
        return $this->actiontgtscope4;
    }

    /**
     * @param mixed $actiontgtscope4
     */
    public function setActiontgtscope4($actiontgtscope4)
    {
        $this->actiontgtscope4 = $actiontgtscope4;
    }

    /**
     * @return mixed
     */
    public function getActiontgtscope5()
    {
        return $this->actiontgtscope5;
    }

    /**
     * @param mixed $actiontgtscope5
     */
    public function setActiontgtscope5($actiontgtscope5)
    {
        $this->actiontgtscope5 = $actiontgtscope5;
    }


    //Action From scope
    protected $actionsrcscope1;
    protected $actionsrcscope2;
    protected $actionsrcscope3;
    protected $actionsrcscope4;
    protected $actionsrcscope5;
    //Action To scope
    protected $actiontgtscope1;
    protected $actiontgtscope2;
    protected $actiontgtscope3;
    protected $actiontgtscope4;
    protected $actiontgtscope5;

    /**
     * @return mixed
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * @param mixed $unit
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;
    }

    /**
     * @return mixed
     */
    public function getUnit1()
    {
        return $this->unit1;
    }

    /**
     * @param mixed $unit1
     */
    public function setUnit1($unit1)
    {
        $this->unit1 = $unit1;
    }

    /**
     * @return mixed
     */
    public function getUnit2()
    {
        return $this->unit2;
    }

    /**
     * @param mixed $unit2
     */
    public function setUnit2($unit2)
    {
        $this->unit2 = $unit2;
    }

    /**
     * @return mixed
     */
    public function getUnit3()
    {
        return $this->unit3;
    }

    /**
     * @param mixed $unit3
     */
    public function setUnit3($unit3)
    {
        $this->unit3 = $unit3;
    }

    /**
     * @return mixed
     */
    public function getUnit4()
    {
        return $this->unit4;
    }

    /**
     * @param mixed $unit4
     */
    public function setUnit4($unit4)
    {
        $this->unit4 = $unit4;
    }

    /**
     * @return mixed
     */
    public function getUnit5()
    {
        return $this->unit5;
    }

    /**
     * @param mixed $unit5
     */
    public function setUnit5($unit5)
    {
        $this->unit5 = $unit5;
    }

    /**
     * @return mixed
     */
    public function getUnit6()
    {
        return $this->unit6;
    }

    /**
     * @param mixed $unit6
     */
    public function setUnit6($unit6)
    {
        $this->unit6 = $unit6;
    }

    /**
     * @return mixed
     */
    public function getUnit7()
    {
        return $this->unit7;
    }

    /**
     * @param mixed $unit7
     */
    public function setUnit7($unit7)
    {
        $this->unit7 = $unit7;
    }

    /**
     * @return mixed
     */
    public function getUnit8()
    {
        return $this->unit8;
    }

    /**
     * @param mixed $unit8
     */
    public function setUnit8($unit8)
    {
        $this->unit8 = $unit8;
    }

    /**
     * @return mixed
     */
    public function getUnit9()
    {
        return $this->unit9;
    }

    /**
     * @param mixed $unit9
     */
    public function setUnit9($unit9)
    {
        $this->unit9 = $unit9;
    }

    /**
     * @return mixed
     */
    public function getUnit10()
    {
        return $this->unit10;
    }

    /**
     * @param mixed $unit10
     */
    public function setUnit10($unit10)
    {
        $this->unit10 = $unit10;
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param mixed $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }

    /**
     * @return mixed
     */
    public function getItems1()
    {
        return $this->items1;
    }

    /**
     * @param mixed $items1
     */
    public function setItems1($items1)
    {
        $this->items1 = $items1;
    }

    /**
     * @return mixed
     */
    public function getItems2()
    {
        return $this->items2;
    }

    /**
     * @param mixed $items2
     */
    public function setItems2($items2)
    {
        $this->items2 = $items2;
    }

    /**
     * @return mixed
     */
    public function getItems3()
    {
        return $this->items3;
    }

    /**
     * @param mixed $items3
     */
    public function setItems3($items3)
    {
        $this->items3 = $items3;
    }

    /**
     * @return mixed
     */
    public function getItems4()
    {
        return $this->items4;
    }

    /**
     * @param mixed $items4
     */
    public function setItems4($items4)
    {
        $this->items4 = $items4;
    }

    /**
     * @return mixed
     */
    public function getItems5()
    {
        return $this->items5;
    }

    /**
     * @param mixed $items5
     */
    public function setItems5($items5)
    {
        $this->items5 = $items5;
    }
    /**
     * @return mixed
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param mixed $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return mixed
     */
    public function getLocale1()
    {
        return $this->locale1;
    }

    /**
     * @param mixed $locale1
     */
    public function setLocale1($locale1)
    {
        $this->locale1 = $locale1;
    }

    /**
     * @return mixed
     */
    public function getLocale2()
    {
        return $this->locale2;
    }

    /**
     * @param mixed $locale2
     */
    public function setLocale2($locale2)
    {
        $this->locale2 = $locale2;
    }

    /**
     * @return mixed
     */
    public function getLocale3()
    {
        return $this->locale3;
    }

    /**
     * @param mixed $locale3
     */
    public function setLocale3($locale3)
    {
        $this->locale3 = $locale3;
    }

    /**
     * @return mixed
     */
    public function getLocale4()
    {
        return $this->locale4;
    }

    /**
     * @param mixed $locale4
     */
    public function setLocale4($locale4)
    {
        $this->locale4 = $locale4;
    }

    /**
     * @return mixed
     */
    public function getLocale5()
    {
        return $this->locale5;
    }

    /**
     * @param mixed $locale5
     */
    public function setLocale5($locale5)
    {
        $this->locale5 = $locale5;
    }

    /**
     * @return mixed
     */
    public function getLocale6()
    {
        return $this->locale6;
    }

    /**
     * @param mixed $locale6
     */
    public function setLocale6($locale6)
    {
        $this->locale6 = $locale6;
    }

    /**
     * @return mixed
     */
    public function getLocale7()
    {
        return $this->locale7;
    }

    /**
     * @param mixed $locale7
     */
    public function setLocale7($locale7)
    {
        $this->locale7 = $locale7;
    }

    /**
     * @return mixed
     */
    public function getLocale8()
    {
        return $this->locale8;
    }

    /**
     * @param mixed $locale8
     */
    public function setLocale8($locale8)
    {
        $this->locale8 = $locale8;
    }

    /**
     * @return mixed
     */
    public function getLocale9()
    {
        return $this->locale9;
    }

    /**
     * @param mixed $locale9
     */
    public function setLocale9($locale9)
    {
        $this->locale9 = $locale9;
    }

    /**
     * @return mixed
     */
    public function getLocale10()
    {
        return $this->locale10;
    }

    /**
     * @param mixed $locale10
     */
    public function setLocale10($locale10)
    {
        $this->locale10 = $locale10;
    }

    /**
     * @return mixed
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * @param mixed $scope
     */
    public function setScope($scope)
    {
        $this->scope = $scope;
    }

    /**
     * @return mixed
     */
    public function getScope1()
    {
        return $this->scope1;
    }

    /**
     * @param mixed $scope1
     */
    public function setScope1($scope1)
    {
        $this->scope1 = $scope1;
    }

    /**
     * @return mixed
     */
    public function getScope2()
    {
        return $this->scope2;
    }

    /**
     * @param mixed $scope2
     */
    public function setScope2($scope2)
    {
        $this->scope2 = $scope2;
    }

    /**
     * @return mixed
     */
    public function getScope3()
    {
        return $this->scope3;
    }

    /**
     * @param mixed $scope3
     */
    public function setScope3($scope3)
    {
        $this->scope3 = $scope3;
    }

    /**
     * @return mixed
     */
    public function getScope4()
    {
        return $this->scope4;
    }

    /**
     * @param mixed $scope4
     */
    public function setScope4($scope4)
    {
        $this->scope4 = $scope4;
    }

    /**
     * @return mixed
     */
    public function getScope5()
    {
        return $this->scope5;
    }

    /**
     * @param mixed $scope5
     */
    public function setScope5($scope5)
    {
        $this->scope5 = $scope5;
    }

    /**
     * @return mixed
     */
    public function getScope6()
    {
        return $this->scope6;
    }

    /**
     * @param mixed $scope6
     */
    public function setScope6($scope6)
    {
        $this->scope6 = $scope6;
    }

    /**
     * @return mixed
     */
    public function getScope7()
    {
        return $this->scope7;
    }

    /**
     * @param mixed $scope7
     */
    public function setScope7($scope7)
    {
        $this->scope7 = $scope7;
    }

    /**
     * @return mixed
     */
    public function getScope8()
    {
        return $this->scope8;
    }

    /**
     * @param mixed $scope8
     */
    public function setScope8($scope8)
    {
        $this->scope8 = $scope8;
    }

    /**
     * @return mixed
     */
    public function getScope9()
    {
        return $this->scope9;
    }

    /**
     * @param mixed $scope9
     */
    public function setScope9($scope9)
    {
        $this->scope9 = $scope9;
    }

    /**
     * @return mixed
     */
    public function getScope10()
    {
        return $this->scope10;
    }

    /**
     * @param mixed $scope10
     */
    public function setScope10($scope10)
    {
        $this->scope10 = $scope10;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param mixed $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return mixed
     */
    public function getCurrency1()
    {
        return $this->currency1;
    }

    /**
     * @param mixed $currency1
     */
    public function setCurrency1($currency1)
    {
        $this->currency1 = $currency1;
    }

    /**
     * @return mixed
     */
    public function getCurrency2()
    {
        return $this->currency2;
    }

    /**
     * @param mixed $currency2
     */
    public function setCurrency2($currency2)
    {
        $this->currency2 = $currency2;
    }

    /**
     * @return mixed
     */
    public function getCurrency3()
    {
        return $this->currency3;
    }

    /**
     * @param mixed $currency3
     */
    public function setCurrency3($currency3)
    {
        $this->currency3 = $currency3;
    }

    /**
     * @return mixed
     */
    public function getCurrency4()
    {
        return $this->currency4;
    }

    /**
     * @param mixed $currency4
     */
    public function setCurrency4($currency4)
    {
        $this->currency4 = $currency4;
    }

    /**
     * @return mixed
     */
    public function getCurrency5()
    {
        return $this->currency5;
    }

    /**
     * @param mixed $currency5
     */
    public function setCurrency5($currency5)
    {
        $this->currency5 = $currency5;
    }

    /**
     * @return mixed
     */
    public function getCurrency6()
    {
        return $this->currency6;
    }

    /**
     * @param mixed $currency6
     */
    public function setCurrency6($currency6)
    {
        $this->currency6 = $currency6;
    }

    /**
     * @return mixed
     */
    public function getCurrency7()
    {
        return $this->currency7;
    }

    /**
     * @param mixed $currency7
     */
    public function setCurrency7($currency7)
    {
        $this->currency7 = $currency7;
    }

    /**
     * @return mixed
     */
    public function getCurrency8()
    {
        return $this->currency8;
    }

    /**
     * @param mixed $currency8
     */
    public function setCurrency8($currency8)
    {
        $this->currency8 = $currency8;
    }

    /**
     * @return mixed
     */
    public function getCurrency9()
    {
        return $this->currency9;
    }

    /**
     * @param mixed $currency9
     */
    public function setCurrency9($currency9)
    {
        $this->currency9 = $currency9;
    }

    /**
     * @return mixed
     */
    public function getCurrency10()
    {
        return $this->currency10;
    }

    /**
     * @param mixed $currency10
     */
    public function setCurrency10($currency10)
    {
        $this->currency10 = $currency10;
    }

    /**
     * @return mixed
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param mixed $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }



    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getFamily()
    {
        return $this->family;
    }

    /**
     * @param mixed $family
     */
    public function setFamily($family)
    {
        $this->family = $family;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param $fields
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
    }

    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param mixed $count
     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * @return mixed
     */
    public function getCountnew()
    {
        return $this->countnew;
    }

    /**
     * @param mixed $countnew
     */
    public function setCountnew($countnew)
    {
        $this->countnew = $countnew;
    }

    /**
     * @return mixed
     */
    public function getField1()
    {
        return $this->field1;
    }

    /**
     * @param mixed $field1
     */
    public function setField1($field1)
    {
        $this->field1 = $field1;
    }

    /**
     * @return mixed
     */
    public function getOperator1()
    {
        return $this->operator1;
    }

    /**
     * @param mixed $operator1
     */
    public function setOperator1($operator1)
    {
        $this->operator1 = $operator1;
    }

    /**
     * @return mixed
     */
    public function getValue1()
    {
        return $this->value1;
    }

    /**
     * @param mixed $value1
     */
    public function setValue1($value1)
    {
        $this->value1 = $value1;
    }

    /**
     * @return mixed
     */
    public function getField2()
    {
        return $this->field2;
    }

    /**
     * @param mixed $field2
     */
    public function setField2($field2)
    {
        $this->field2 = $field2;
    }

    /**
     * @return mixed
     */
    public function getOperator2()
    {
        return $this->operator2;
    }

    /**
     * @param mixed $operator2
     */
    public function setOperator2($operator2)
    {
        $this->operator2 = $operator2;
    }

    /**
     * @return mixed
     */
    public function getValue2()
    {
        return $this->value2;
    }

    /**
     * @param mixed $value2
     */
    public function setValue2($value2)
    {
        $this->value2 = $value2;
    }

    /**
     * @return mixed
     */
    public function getField3()
    {
        return $this->field3;
    }

    /**
     * @param mixed $field3
     */
    public function setField3($field3)
    {
        $this->field3 = $field3;
    }

    /**
     * @return mixed
     */
    public function getOperator3()
    {
        return $this->operator3;
    }

    /**
     * @param mixed $operator3
     */
    public function setOperator3($operator3)
    {
        $this->operator3 = $operator3;
    }

    /**
     * @return mixed
     */
    public function getValue3()
    {
        return $this->value3;
    }

    /**
     * @param mixed $value3
     */
    public function setValue3($value3)
    {
        $this->value3 = $value3;
    }

    /**
     * @return mixed
     */
    public function getField4()
    {
        return $this->field4;
    }

    /**
     * @param mixed $field4
     */
    public function setField4($field4)
    {
        $this->field4 = $field4;
    }

    /**
     * @return mixed
     */
    public function getOperator4()
    {
        return $this->operator4;
    }

    /**
     * @param mixed $operator4
     */
    public function setOperator4($operator4)
    {
        $this->operator4 = $operator4;
    }

    /**
     * @return mixed
     */
    public function getValue4()
    {
        return $this->value4;
    }

    /**
     * @param mixed $value4
     */
    public function setValue4($value4)
    {
        $this->value4 = $value4;
    }

    /**
     * @return mixed
     */
    public function getField5()
    {
        return $this->field5;
    }

    /**
     * @param mixed $field5
     */
    public function setField5($field5)
    {
        $this->field5 = $field5;
    }

    /**
     * @return mixed
     */
    public function getOperator5()
    {
        return $this->operator5;
    }

    /**
     * @param mixed $operator5
     */
    public function setOperator5($operator5)
    {
        $this->operator5 = $operator5;
    }

    /**
     * @return mixed
     */
    public function getValue5()
    {
        return $this->value5;
    }

    /**
     * @param mixed $value5
     */
    public function setValue5($value5)
    {
        $this->value5 = $value5;
    }

    /**
     * @return mixed
     */
    public function getField6()
    {
        return $this->field6;
    }

    /**
     * @param mixed $field6
     */
    public function setField6($field6)
    {
        $this->field6 = $field6;
    }

    /**
     * @return mixed
     */
    public function getOperator6()
    {
        return $this->operator6;
    }

    /**
     * @param mixed $operator6
     */
    public function setOperator6($operator6)
    {
        $this->operator6 = $operator6;
    }

    /**
     * @return mixed
     */
    public function getValue6()
    {
        return $this->value6;
    }

    /**
     * @param mixed $value6
     */
    public function setValue6($value6)
    {
        $this->value6 = $value6;
    }

    /**
     * @return mixed
     */
    public function getField7()
    {
        return $this->field7;
    }

    /**
     * @param mixed $field7
     */
    public function setField7($field7)
    {
        $this->field7 = $field7;
    }

    /**
     * @return mixed
     */
    public function getOperator7()
    {
        return $this->operator7;
    }

    /**
     * @param mixed $operator7
     */
    public function setOperator7($operator7)
    {
        $this->operator7 = $operator7;
    }

    /**
     * @return mixed
     */
    public function getValue7()
    {
        return $this->value7;
    }

    /**
     * @param mixed $value7
     */
    public function setValue7($value7)
    {
        $this->value7 = $value7;
    }

    /**
     * @return mixed
     */
    public function getField8()
    {
        return $this->field8;
    }

    /**
     * @param mixed $field8
     */
    public function setField8($field8)
    {
        $this->field8 = $field8;
    }

    /**
     * @return mixed
     */
    public function getOperator8()
    {
        return $this->operator8;
    }

    /**
     * @param mixed $operator8
     */
    public function setOperator8($operator8)
    {
        $this->operator8 = $operator8;
    }

    /**
     * @return mixed
     */
    public function getValue8()
    {
        return $this->value8;
    }

    /**
     * @param mixed $value8
     */
    public function setValue8($value8)
    {
        $this->value8 = $value8;
    }

    /**
     * @return mixed
     */
    public function getField9()
    {
        return $this->field9;
    }

    /**
     * @param mixed $field9
     */
    public function setField9($field9)
    {
        $this->field9 = $field9;
    }

    /**
     * @return mixed
     */
    public function getOperator9()
    {
        return $this->operator9;
    }

    /**
     * @param mixed $operator9
     */
    public function setOperator9($operator9)
    {
        $this->operator9 = $operator9;
    }

    /**
     * @return mixed
     */
    public function getValue9()
    {
        return $this->value9;
    }

    /**
     * @param mixed $value9
     */
    public function setValue9($value9)
    {
        $this->value9 = $value9;
    }

    /**
     * @return mixed
     */
    public function getField10()
    {
        return $this->field10;
    }

    /**
     * @param mixed $field10
     */
    public function setField10($field10)
    {
        $this->field10 = $field10;
    }

    /**
     * @return mixed
     */
    public function getOperator10()
    {
        return $this->operator10;
    }

    /**
     * @param mixed $operator10
     */
    public function setOperator10($operator10)
    {
        $this->operator10 = $operator10;
    }

    /**
     * @return mixed
     */
    public function getValue10()
    {
        return $this->value10;
    }

    /**
     * @param mixed $value10
     */
    public function setValue10($value10)
    {
        $this->value10 = $value10;
    }

    /**
     * @return mixed
     */
    public function getActioncount()
    {
        return $this->actioncount;
    }

    /**
     * @param mixed $actioncount
     */
    public function setActioncount($actioncount)
    {
        $this->actioncount = $actioncount;
    }

    /**
     * @return mixed
     */
    public function getActions1()
    {
        return $this->actions1;
    }

    /**
     * @param mixed $actions1
     */
    public function setActions1($actions1)
    {
        $this->actions1 = $actions1;
    }

    /**
     * @return mixed
     */
    public function getActionsfield1()
    {
        return $this->actionsfield1;
    }

    /**
     * @param mixed $actionsfield1
     */
    public function setActionsfield1($actionsfield1)
    {
        $this->actionsfield1 = $actionsfield1;
    }

    /**
     * @return mixed
     */
    public function getActionsvalue1()
    {
        return $this->actionsvalue1;
    }

    /**
     * @param mixed $actionsvalue1
     */
    public function setActionsvalue1($actionsvalue1)
    {
        $this->actionsvalue1 = $actionsvalue1;
    }

    /**
     * @return mixed
     */
    public function getActions2()
    {
        return $this->actions2;
    }

    /**
     * @param mixed $actions2
     */
    public function setActions2($actions2)
    {
        $this->actions2 = $actions2;
    }

    /**
     * @return mixed
     */
    public function getActionsfield2()
    {
        return $this->actionsfield2;
    }

    /**
     * @param mixed $actionsfield2
     */
    public function setActionsfield2($actionsfield2)
    {
        $this->actionsfield2 = $actionsfield2;
    }

    /**
     * @return mixed
     */
    public function getActionsvalue2()
    {
        return $this->actionsvalue2;
    }

    /**
     * @param mixed $actionsvalue2
     */
    public function setActionsvalue2($actionsvalue2)
    {
        $this->actionsvalue2 = $actionsvalue2;
    }

    /**
     * @return mixed
     */
    public function getActions3()
    {
        return $this->actions3;
    }

    /**
     * @param mixed $actions3
     */
    public function setActions3($actions3)
    {
        $this->actions3 = $actions3;
    }

    /**
     * @return mixed
     */
    public function getActionsfield3()
    {
        return $this->actionsfield3;
    }

    /**
     * @param mixed $actionsfield3
     */
    public function setActionsfield3($actionsfield3)
    {
        $this->actionsfield3 = $actionsfield3;
    }

    /**
     * @return mixed
     */
    public function getActionsvalue3()
    {
        return $this->actionsvalue3;
    }

    /**
     * @param mixed $actionsvalue3
     */
    public function setActionsvalue3($actionsvalue3)
    {
        $this->actionsvalue3 = $actionsvalue3;
    }

    /**
     * @return mixed
     */
    public function getActions4()
    {
        return $this->actions4;
    }

    /**
     * @param mixed $actions4
     */
    public function setActions4($actions4)
    {
        $this->actions4 = $actions4;
    }

    /**
     * @return mixed
     */
    public function getActionsfield4()
    {
        return $this->actionsfield4;
    }

    /**
     * @param mixed $actionsfield4
     */
    public function setActionsfield4($actionsfield4)
    {
        $this->actionsfield4 = $actionsfield4;
    }

    /**
     * @return mixed
     */
    public function getActionsvalue4()
    {
        return $this->actionsvalue4;
    }

    /**
     * @param mixed $actionsvalue4
     */
    public function setActionsvalue4($actionsvalue4)
    {
        $this->actionsvalue4 = $actionsvalue4;
    }

    /**
     * @return mixed
     */
    public function getActions5()
    {
        return $this->actions5;
    }

    /**
     * @param mixed $actions5
     */
    public function setActions5($actions5)
    {
        $this->actions5 = $actions5;
    }

    /**
     * @return mixed
     */
    public function getActionsfield5()
    {
        return $this->actionsfield5;
    }

    /**
     * @param mixed $actionsfield5
     */
    public function setActionsfield5($actionsfield5)
    {
        $this->actionsfield5 = $actionsfield5;
    }

    /**
     * @return mixed
     */
    public function getActionsvalue5()
    {
        return $this->actionsvalue5;
    }

    /**
     * @param mixed $actionsvalue5
     */
    public function setActionsvalue5($actionsvalue5)
    {
        $this->actionsvalue5 = $actionsvalue5;
    }
    /**
     * @return mixed
     */
    public function getActionssrc1()
    {
        return $this->actionssrc1;
    }

    /**
     * @param mixed $actionssrc1

     */
    public function setActionssrc1($actionssrc1)
    {
        $this->actionssrc1 = $actionssrc1;

    }

    /**
     * @return mixed
     */
    public function getActionstarget1()
    {
        return $this->actionstarget1;
    }

    /**
     * @param mixed $actionstarget1

     */
    public function setActionstarget1($actionstarget1)
    {
        $this->actionstarget1 = $actionstarget1;
       // return $this;
    }

    /**
     * @return mixed
     */
    public function getActionssrc2()
    {
        return $this->actionssrc2;
    }

    /**
     * @param mixed $actionssrc2
     * @return Rule
     */
    public function setActionssrc2($actionssrc2)
    {
        $this->actionssrc2 = $actionssrc2;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getActionstarget2()
    {
        return $this->actionstarget2;
    }

    /**
     * @param mixed $actionstarget2
     * @return Rule
     */
    public function setActionstarget2($actionstarget2)
    {
        $this->actionstarget2 = $actionstarget2;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getActionssrc3()
    {
        return $this->actionssrc3;
    }

    /**
     * @param mixed $actionssrc3
     * @return Rule
     */
    public function setActionssrc3($actionssrc3)
    {
        $this->actionssrc3 = $actionssrc3;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getActionstarget3()
    {
        return $this->actionstarget3;
    }

    /**
     * @param mixed $actionstarget3
     * @return Rule
     */
    public function setActionstarget3($actionstarget3)
    {
        $this->actionstarget3 = $actionstarget3;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getActionssrc4()
    {
        return $this->actionssrc4;
    }

    /**
     * @param mixed $actionssrc4
     * @return Rule
     */
    public function setActionssrc4($actionssrc4)
    {
        $this->actionssrc4 = $actionssrc4;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getActionstarget4()
    {
        return $this->actionstarget4;
    }

    /**
     * @param mixed $actionstarget4
     * @return Rule
     */
    public function setActionstarget4($actionstarget4)
    {
        $this->actionstarget4 = $actionstarget4;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getActionssrc5()
    {
        return $this->actionssrc5;
    }

    /**
     * @param mixed $actionssrc5
     * @return Rule
     */
    public function setActionssrc5($actionssrc5)
    {
        $this->actionssrc5 = $actionssrc5;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getActionstarget5()
    {
        return $this->actionstarget5;
    }

    /**
     * @param mixed $actionstarget5
     * @return Rule
     */
    public function setActionstarget5($actionstarget5)
    {
        $this->actionstarget5 = $actionstarget5;
        return $this;
    }

    public static function getLabelProperty()
    {
        return 'name';
    }

    /**
     * @return mixed
     */
    public function getActionscopy1()
    {
        return $this->actionscopy1;
    }

    /**
     * @param mixed $actionscopy1
     */
    public function setActionscopy1($actionscopy1)
    {
        $this->actionscopy1 = $actionscopy1;
    }

    /**
     * @return mixed
     */
    public function getActionscopy2()
    {
        return $this->actionscopy2;
    }

    /**
     * @param mixed $actionscopy2

     */
    public function setActionscopy2($actionscopy2)
    {
        $this->actionscopy2 = $actionscopy2;

    }

    /**
     * @return mixed
     */
    public function getActionscopy3()
    {
        return $this->actionscopy3;
    }

    /**
     * @param mixed $actionscopy3

     */
    public function setActionscopy3($actionscopy3)
    {
        $this->actionscopy3 = $actionscopy3;

    }

    /**
     * @return mixed
     */
    public function getActionscopy4()
    {
        return $this->actionscopy4;
    }

    /**
     * @param mixed $actionscopy4

     */
    public function setActionscopy4($actionscopy4)
    {
        $this->actionscopy4 = $actionscopy4;

    }

    /**
     * @return mixed
     */
    public function getActionscopy5()
    {
        return $this->actionscopy5;
    }

    /**
     * @param mixed $actionscopy5

     */
    public function setActionscopy5($actionscopy5)
    {
        $this->actionscopy5 = $actionscopy5;

    }

    
}