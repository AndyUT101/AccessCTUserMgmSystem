<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use App\Zone;

class EnhancedAuthForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('fa-key', 'hidden',
            [
                'value' => $this->getdata('fa_key'),
            ])

            ->add('user-secret', 'number', [
                'label' => 'Enter the PIN from the Google Authenticator',
                'rules' => 'required',
                'error_messages' => [
                    'title.required' => 'The title field is mandatory.'
                ]
            ])

            ->add('submit', 'submit', [
                'label' => 'Apply 2FA Auth'
            ]);
    }
}   