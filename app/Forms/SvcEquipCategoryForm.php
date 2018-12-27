<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class SvcEquipCategoryForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('keyname', 'text', [
                'label' => 'Key name',
                'rules' => 'required|min:5',
                'error_messages' => [
                    'title.required' => 'The title field is mandatory.'
                ]
            ])

            ->add('name', 'text', [
                'label' => 'Name',
                'rules' => 'required|min:5',
                'error_messages' => [
                    'title.required' => 'The title field is mandatory.'
                ]
            ])

            ->add('desc', 'textarea', [
                'label' => 'Zone description',
                'rules' => 'required|min:5',
                'error_messages' => [
                    'title.required' => 'The title field is mandatory.'
                ]
            ])
            
            ->add('submit', 'submit', [
                'label' => 'Save'
            ]);
    }
}   