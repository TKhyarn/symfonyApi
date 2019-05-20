<?php
/********************************
 * Created by ktroufleau.
 * Date: 20/05/2019
 * Time: 21:26
 ********************************/


namespace Anaxago\CoreBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CredentialsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('login');
        $builder->add('password');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Anaxago\CoreBundle\Entity\Credentials',
            'csrf_protection' => false,
        ]);
    }
}