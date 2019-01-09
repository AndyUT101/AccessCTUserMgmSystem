<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class MsgTemplate extends Form
{
    public function buildForm()
    {
        $this
            ->add('msgkey', 'text', [
                'label' => 'Name',
                'rules' => 'required|min:5',
                'error_messages' => [
                    'title.required' => 'The title field is mandatory.'
                ]
            ])

            ->add('desc', 'content', [
                'label' => 'Message description',
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