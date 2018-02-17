<?php

namespace CommonCrawler\Form;


use Zend\Form\Form;

class IndexForm extends Form
{
    public function __construct($name = null, array $options = [])
    {
        parent::__construct('IndexForm', $options);

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'name',
            'type' => 'Text',
            'options' => array(
                'label' => 'Index Name',
            ),
        ));
        $this->add(array(
            'name' => 'status',
            'type' => 'Select',
            'options' => array(
                'label' => 'Status',
                'value_options' => array(
                    0 => 'Inactive',
                    1 => 'Active',
                ),
            ),
        ));
        $this->add(array(
            'name' => 'reset',
            'type' => 'Reset',
            'attributes' => array(
                'value' => 'Reset',
                'id' => 'resetbutton',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Submit',
                'id' => 'submitbutton',
            ),
        ));
    }


}