<?

// src/Form/LoyaltyPointsType.php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoyaltyPointsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('points', IntegerType::class, [
                'label' => 'Points de fidélité à ajouter',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Ajouter des points',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('users'); // Définir 'users' comme une option requise
        // Autres configurations éventuelles...
    }
}
