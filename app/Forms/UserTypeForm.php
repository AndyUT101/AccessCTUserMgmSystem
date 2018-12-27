<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class UserTypeForm extends Form
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

            ->add('typelevel', 'number', [
                'label' => 'Type level',
                'rules' => 'required|max:50',
                'error_messages' => [
                    'title.required' => 'The title field is mandatory.'
                ]
            ])
            
            ->add('submit', 'submit', [
                'label' => 'Save'
            ]);
    }
}   