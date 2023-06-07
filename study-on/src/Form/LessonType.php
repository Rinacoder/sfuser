<?php

namespace App\Form;

use App\Entity\Course;
use App\Entity\Lesson;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class LessonType extends AbstractType
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Title',TextType::class, [
                'label' => 'Название',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Название урока не должно быть пустым']),
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'Название урока не может содержать более {{ limit }} символов']),
                ],
                'attr' => [
                    'placeholder' => 'Укажите код курса',
                    'class' => 'form-control w-100 mb-2 fs-5'
                ]
            ])
            ->add('LessonContent', TextareaType::class, [
                'label' => 'Содержимое урока',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Текст вашего урока',
                    'class' => 'form-control w-100 mb-2 fs-5'
                ]
            ])
            ->add('LessonNumber', NumberType::class, [
                'label' => 'Порядковый номер',
                'required' => true,
                'constraints' => [
                    new Length([
                        'max' => 1000,
                        'maxMessage' => 'Контент не может содержать более {{ limit }} символов']),
                ],
                'attr' => [
                    'placeholder' => 'Укажите номер вашего урока',
                    'class' => 'form-control w-100 mb-2 fs-5',
                    'max' => 10000,
                    'min' => 1,
                ]
            ])
            ->add('course', HiddenType::class)
        ;
        $builder->get('course')
            ->addModelTransformer(
                new CallbackTransformer(
                    function ($courseAsObj): string {
                        return $courseAsObj->getId();
                    },
                    function ($courseId): Course {
                        return $this->entityManager
                            ->getRepository(Course::class)
                            ->find($courseId);
                    }
                )
            )
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lesson::class,
        ]);
    }
}
