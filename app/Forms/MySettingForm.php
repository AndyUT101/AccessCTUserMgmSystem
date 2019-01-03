<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class MySettingForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('tg_usertoken', 'text', [
                'label' => 'Telegram user chat id',
                'rules' => 'required|min:5',
                'error_messages' => [
                    'title.required' => 'The title field is mandatory.'
                ]
            ])
            ->add('submit', 'submit', [
                'label' => 'Update'
            ]);
    }
}
