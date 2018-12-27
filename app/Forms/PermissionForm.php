<?php

namespace App\Forms;

use App\UserType;

use Kris\LaravelFormBuilder\Form;

class PermissionForm extends Form
{
    public function buildForm()
    {
        $dataset = UserType::orderby('typelevel', 'asc')->orderby('name', 'asc')->get();
        $exist_records = $this->getdata('exist_records');
        foreach ($dataset as $data)
        {
            $selected = array();
            if (array_key_exists($data->id, $exist_records))
            {
                if ($exist_records[$data->id]['allow-show'])
                {
                    $selected[count($selected)] = 'allow-show';
                }
                if ($exist_records[$data->id]['allow-notify'])
                {
                    $selected[count($selected)] = 'allow-notify';
                }
                if ($exist_records[$data->id]['allow-approve'])
                {
                    $selected[count($selected)] = 'allow-approve';
                }
            }

            $this
                ->add($data->id, 'choice', [
                    'label' => 'Permission of user type - ' . $data->name,
                    'choices' => ['allow-show' => 'Display and allow apply', 'allow-notify' => 'Allow notify', 'allow-approve' => 'Allow approve right'],
                    'choice_options' => [
                        'wrapper' => ['class' => 'choice-wrapper'],
                        'label_attr' => ['class' => 'label-class'],
                    ],
                    'selected' => $selected,
                    'expanded' => true,
                    'multiple' => true
                ]);
        }

        $this
            ->add('submit', 'submit', [
                'label' => 'Update changes',
            ]);
    }
}   