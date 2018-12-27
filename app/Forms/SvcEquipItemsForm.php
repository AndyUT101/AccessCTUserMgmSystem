<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

use App\SvcEquipCategory;
use App\SvcEquip;

class SvcEquipItemsForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('svc_equip_id', 'select', [
                'label' => 'Service / Equipment Type',
                'choices' => $this->get_svcequip_choices(),
                'empty_value' => '-'
            ])

            ->add('item_category_id', 'select', [
                'label' => 'Request Item Category',
                'choices' => $this->get_itemcategory_choices(),
                'empty_value' => '-'
            ])

            ->add('name', 'text', [
                'label' => 'Name',
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

            ->add('exec_command', 'textarea', [
                'label' => 'Exec command',
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


    private function get_svcequip_choices() {
        $records = SvcEquip::all();
        
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