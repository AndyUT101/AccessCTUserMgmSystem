<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class SvcEquipItemsForm extends Form
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

            ->add('desc', 'content', [
                'label' => 'Description',
                'rules' => 'required|min:5',
                'error_messages' => [
                    'title.required' => 'The title field is mandatory.'
                ]
            ])

            ->add('exec_command', 'content', [
                'label' => 'Exec command',
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