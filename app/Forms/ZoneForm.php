<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class ZoneForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', [
                'label' => 'Zone name',
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