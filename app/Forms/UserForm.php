<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

use App\UserType;
use App\BranchDept;

class UserForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', [
                'label' => 'User name',
                'rules' => 'required|size:6',
                'help_block' => [
                    'text' => "Require specfic format, eg. \"D95I01\"",
                    'tag' => 'p',
                    'attr' => ['class' => 'help-block']
                ],
                'error_messages' => [
                    'title.required' => 'The title field is mandatory.'
                ]
            ])

            ->add('email', 'email', [
                'label' => 'User email',
                'rules' => 'required|email',
                'error_messages' => [
                    'title.required' => 'The title field is mandatory.'
                ]
            ])

            ->add('first_name', 'text', [
                'label' => 'First name',
                'rules' => 'required',
                'error_messages' => [
                    'title.required' => 'The title field is mandatory.'
                ]
            ])

            ->add('last_name', 'text', [
                'label' => 'Last name',
                'rules' => 'required',
                'error_messages' => [
                    'title.required' => 'The title field is mandatory.'
                ]
            ])

            ->add('usertype_id', 'select', [
                'label' => 'User type',
                'choices' => $this->get_usertype_choices(),
                'empty_value' => '-'
            ])

            ->add('branchdept_id', 'select', [
                'label' => 'Branch/Department',
                'choices' => $this->get_branchdept_choices(),
                'empty_value' => '-'
            ])

            ->add('is_disable', 'checkbox', [
                'label' => 'Account disable',
                'value' => 1,
            ])

            ->add('submit', 'submit', [
                'label' => 'Save'
            ]);
    }

    private function get_usertype_choices() {
        $records = UserType::orderby('typelevel')->orderby('name')->get();
        $typelevel = $this->getData('active_user')->load('user_type')->user_type->typelevel;

        $choices = array();
        foreach ($records as $record) {
            if ($typelevel < $record->typelevel) continue;
            $choices[$record->id] = sprintf("%s [User level: %u]", $record->name, $record->typelevel);
        }

        return $choices;
    }

    private function get_branchdept_choices() {
        $records = BranchDept::orderby('type')->get();

        $choices = array();
        foreach ($records as $record) {
            $choices[$record->id] = sprintf("[%s] %s (%02d)", strtoupper($record->type), $record->name, $record->code);
        }

        return $choices;
    }
}   