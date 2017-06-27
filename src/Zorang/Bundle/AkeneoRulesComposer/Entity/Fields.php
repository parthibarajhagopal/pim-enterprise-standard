<?php

namespace Zorang\Bundle\AkeneoRulesComposer\Entity;

class Fields
{
    protected $field;

    protected $operator;

    protected $conditionvalue;

    protected $field1;

    protected $operator1;

    protected $conditionvalue1;

    /**
     * @return mixed
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param mixed $field
     */
    public function setField($field)
    {
        $this->field = $field;
    }

    /**
     * @return mixed
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * @param mixed $operator
     */
    public function setOperator($operator)
    {
        $this->operator = $operator;
    }

    /**
     * @return mixed
     */
    public function getConditionvalue()
    {
        return $this->conditionvalue;
    }

    /**
     * @param mixed $conditionvalue
     */
    public function setConditionvalue($conditionvalue)
    {
        $this->conditionvalue = $conditionvalue;
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
    public function getConditionvalue1()
    {
        return $this->conditionvalue1;
    }

    /**
     * @param mixed $conditionvalue1
     */
    public function setConditionvalue1($conditionvalue1)
    {
        $this->conditionvalue1 = $conditionvalue1;
    }




}