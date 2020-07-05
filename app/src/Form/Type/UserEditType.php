<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserEditType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('name', TextType::class)
			->add('surname', TextType::class)
			->add('password', RepeatedType::class, [
				'type' => PasswordType::class,
				'first_options' => [
					'label' => 'Password (only if you want to change)',
					'attr' => [
						'autocomplete' => 'new-password',
					],
				],
				'second_options' => [
					'label' => 'Repeat password',
				],
				'mapped' => false,
				'required' => false,
			])
			->add('save', SubmitType::class, [
				'label' => 'Save',
			]);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => User::class,
		]);
	}
}
