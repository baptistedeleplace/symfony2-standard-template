<?php

namespace Nsm\Bundle\AppBundle\Form\Type;

use Nsm\Bundle\AppBundle\Entity\SubTask;
use Nsm\Bundle\AppBundle\Entity\Task;
use Nsm\Bundle\AppBundle\Entity\FeatureRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Util\FormUtil;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TaskType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (true === $options['display_project']) {

            $builder->add(
                'project',
                'entity',
                array(
                    'class' => 'NsmAppBundle:Project',
                    'empty_value' => '',
                    'control_attr' => array(
                        'onchange' => 'document.getElementById(\'task_Refresh\').click();'
                    )
                )
            );
        }

        $builder->add(
            'title',
            'text'
        );

        $builder->add(
            'tags',
            'text'
        );

        $builder->add(
            'description',
            'textarea',
            array(
                'required' => false
            )
        );

        $task = $builder->getData();

        $subTask = new SubTask();
        $subTask->setTask($task);

        $builder->add(
            'subTasks',
            'nsm_collection',
            array(
                'required' => false,
                'allow_add' => true,
                'prototype_data' => $subTask,
                'prototype_name' => 'sub_tasks',
                'type' => new SubTaskType(),
                'options' => array(
                    'display_task' => false,
                )
            )
        );

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Nsm\Bundle\AppBundle\Entity\Task',
                'display_project' => true
            )
        );
    }

    public function getName()
    {
        return 'task';
    }
}
