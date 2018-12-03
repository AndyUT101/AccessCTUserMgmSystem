<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class MySettingForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('2fa_token', 'text', [
                'label' => '2FA code',
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
