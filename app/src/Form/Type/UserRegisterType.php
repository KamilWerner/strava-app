<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserRegisterType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('name', TextType::class)
			->add('surname', TextType::class)
			->add('email', RepeatedType::class, [
				'type' => EmailType::class,
				'first_options' => [
					'label' => 'Email address',
				],
				'second_options' => [
					'label' => 'Repeat email address',
				],
			])
			->add('password', RepeatedType::class, [
				'type' => PasswordType::class,
				'first_options' => [
					'label' => 'Password',
					'attr' => [
						'autocomplete' => 'new-password',
					],
				],
				'second_options' => [
					'label' => 'Repeat password',
				],
			])
			->add('save', SubmitType::class, [
				'label' => 'Register',
			]);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => User::class,
		]);
	}
}
