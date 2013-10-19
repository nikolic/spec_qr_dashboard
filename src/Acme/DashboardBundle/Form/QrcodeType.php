<?php

namespace Acme\DashboardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QrcodeType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('secret')
            ->add('filename')
            ->add('used')
            ->add('weight')
            ->add('user')
            ->add('created')
            ->add('updated')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\DashboardBundle\Entity\Qrcode'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'acme_dashboardbundle_qrcode';
    }
}
