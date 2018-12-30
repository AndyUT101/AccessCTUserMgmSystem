<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

use App\SvcEquipType;
use App\SvcEquip;

class SvcEquipForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('svc_equiptype_id', 'select', [
                'label' => 'Service / Equipment Type',
                'choices' => $this->get_svcequiptype_choices(),
                'empty_value' => '-'
            ])

            ->add('name', 'text', [
                'label' => 'Service/equipment name',
                'rules' => 'required|min:5',
                'error_messages' => [
                    'title.required' => 'The title field is mandatory.'
                ]
            ])

            ->add('keyname', 'text', [
                'label' => 'Key name',
                'rules' => 'required|min:5',
                'error_messages' => [
                    'title.required' => 'The title field is mandatory.'
                ]
            ])

            ->add('desc', 'textarea', [
                'label' => 'Description',
                'rules' => 'required|min:5',
                'error_messages' => [
                    'title.required' => 'The title field is mandatory.'
                ]
            ])

            ->add('submit', 'submit', [
                'label' => 'Save'
            ]);

            if ($this->getData('is_admin') === true) {}
    }


    private function get_svcequiptype_choices() {
        $records = SvcEquipType::all();
        
        $choices = array();
        foreach ($records as $record) {
            $choices[$record->id] = $record->name;
        }

        return $choices;
    }

    private function get_itemcategory_choices() {
        $records = SvcEquipCategory::all();
        
        $choices = array();
        foreach ($records as $record) {
            $choices[$record->id] = $record->name;
        }

        return $choices;
    }
}   