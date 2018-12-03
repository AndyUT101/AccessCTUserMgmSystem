<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class UserTypeSvcEquipForm extends Form
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
                'label' => 'Zone description',
                'rules' => 'required|min:5',
                'error_messages' => [
                    'title.required' => 'The title field is mandatory.'
                ]
            ])

            ->add('accept_notify', 'checkbox', [
                'value' => 1,
                'checked' => false
            ])

            ->add('approve_right', 'checkbox', [
                'value' => 1,
                'checked' => false
            ])
            
            ->add('submit', 'submit', [
                'label' => 'Save'
            ]);
    }
}   