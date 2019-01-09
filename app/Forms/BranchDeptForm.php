<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use App\Zone;

class BranchDeptForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', [
                'label' => 'Name',
                'rules' => 'required|min:5',
                'error_messages' => [
                    'title.required' => 'The title field is mandatory.'
                ]
            ])

            ->add('desc', 'textarea', [
                'label' => 'Branch/Dept description',
                'rules' => 'required|min:5',
                'error_messages' => [
                    'title.required' => 'The title field is mandatory.'
                ]
            ])

            ->add('type', 'select', [
                'choices' => ['branch' => 'Branch', 'dept' => 'Department'],
                'empty_value' => ''
            ])

            ->add('code', 'number', [
                'label' => 'Branch/Department Code',
                'rules' => 'required|integer|max:2',
                'error_messages' => [
                    'title.required' => 'The title field is mandatory.'
                ]
            ])

            ->add('zone', 'select', [
                'choices' => $this->get_zone_choices(),
                'empty_value' => ''
            ])

            ->add('submit', 'submit', [
                'label' => 'Save'
            ]);
    }

    private function get_zone_choices() {
        $records = Zone::all();
        
        $choices = array();
        foreach ($records as $record) {
            $choices[$record->id] = $record->name;
        }

        return $choices;
    }
}   