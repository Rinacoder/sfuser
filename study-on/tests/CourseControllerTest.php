<?php

namespace App\Tests;

use App\DataFixtures\AppFixtures;
use App\Entity\Course;

class CourseControllerTest extends AbstractTest
{
    protected function getFixtures(): array
    {
        return [AppFixtures::class];
    }

    public function urlProviderSuccessful(): \Generator
    {
        yield ['/'];
        yield ['/courses/'];
        yield ['/courses/new'];
    }

    /**
     * @dataProvider urlProviderSuccessful
     */
    public function testPageSuccessful($url): void
    {
        $client = static::getClient();
        $client->request('GET', $url);
        $this->assertResponseOk();
    }

    public function urlProviderNotFound(): \Generator
    {
        yield ['/abcdefg/'];
    }

    /**
     * @dataProvider urlProviderNotFound
     */
    public function testPageNotFound($url): void
    {
        $client = self::getClient();
        $client->request('GET', $url);
        $this->assertResponseNotFound();
    }

    public function testGetActionsResponseOk(): void
    {
        //проверка страниц всех курсов
        $client = $this->getClient();
        $courses = $this->getEntityManager()->getRepository(Course::class)->findAll();
        foreach ($courses as $course) {
            // страница курса
            $client->request('GET', '/courses/' . $course->getId());
            $this->assertResponseOk();

            // редактирование курса
            $client->request('GET', '/courses/' . $course->getId() . '/edit');
            $this->assertResponseOk();

            // добавление урока
            $client->request('POST', '/courses/' . $course->getId() . '/new_lesson');
            $this->assertResponseOk();
        }
    }

    public function testSuccessfulCourseCreating(): void
    {
        // список курсов
        $client = $this->getClient();
        $crawler = $client->request('GET', '/courses/');
        $this->assertResponseOk();

        // переход на окно добавления курса
        $link = $crawler->selectLink('Добавить курс')->link();
        $crawler = $client->click($link);
        $this->assertResponseOk();

        // заполнение формы корректными значениями
        $courseCreatingForm = $crawler->selectButton('Сохранить')->form([
            'course[CharacterCode]' => 'код-тест-1',
            'course[Name]' => 'Тест-имя',
            'course[Description]' => 'Тест-описание',
        ]);
        $client->submit($courseCreatingForm);

        // редирект
        $this->assertSame($client->getResponse()->headers->get('location'), '/courses/');
        $client->followRedirect();
        $this->assertResponseOk();

        // поиск новго курса
        $course = $this->getEntityManager()->getRepository(Course::class)->findOneBy([
            'code' => 'код-тест-1',
        ]);
        $crawler = $client->request('GET', '/courses/' . $course->getId());
        $this->assertResponseOk();

        // сравнение данных
        $this->assertSame($crawler->filter('.course-name')->text(), ('Курс: ' . 'Тест-имя'));
        $this->assertSame($crawler->filter('.course-description')->text(), 'Тест-описание');
    }

    public function testCourseFailCreating(): void
    {
        // список курсов
        $client = $this->getClient();
        $crawler = $client->request('GET', '/courses/');
        $this->assertResponseOk();

        // переход на окно добавления курса
        $link = $crawler->selectLink('Добавить курс')->link();
        $crawler = $client->click($link);
        $this->assertResponseOk();

        // заполнение формы корректными значениями(кроме кода)
        $courseCreatingForm = $crawler->selectButton('Сохранить')->form([
            'course[CharacterCode]' => '',
            'course[Name]' => 'Тест-имя',
            'course[Description]' => 'Тест-описание',
        ]);
        $client->submit($courseCreatingForm);
        $this->assertResponseCode(422);

        // сравнение текста ошибки
        $this->assertSelectorTextContains(
            'li',
            'Код курса не должен быть пустым'
        );

        // заполнение формы корректными значениями(кроме названия)
        $courseCreatingForm = $crawler->selectButton('Сохранить')->form([
            'course[code]' => 'код-тест-1',
            'course[name]' => '',
            'course[description]' => 'Тест-описание',
        ]);
        $client->submit($courseCreatingForm);
        $this->assertResponseCode(422);

        // сравнение текста ошибки
        $this->assertSelectorTextContains(
            'li',
            'Название курса не должно быть пустым'
        );

        // получение кода последнего курса
        $courses = $this->getEntityManager()->getRepository(Course::class)->findAll();
        $last_course = $courses[count($courses) - 1];

        // заполнение формы корректными значениями(с тем же кодом)
        $courseCreatingForm = $crawler->selectButton('Сохранить')->form([
            'course[CharacterCode]' => $last_course->getCode(),
            'course[Name]' => 'Тест-имя',
            'course[Description]' => 'Тест-описание',
        ]);
        $client->submit($courseCreatingForm);
        $this->assertResponseCode(422);

        // сравнение текста ошибки
        $this->assertSelectorTextContains(
            'li',
            'Курс с таким символьным кодом уже существует.'
        );

        // заполнение формы корректными значениями(кроме кода)
        $courseCreatingForm = $crawler->selectButton('Сохранить')->form([
            'course[CharacterCode]' => str_repeat("test", 64),
            'course[Name]' => 'Тест-имя',
            'course[Description]' => 'Тест-описание',
        ]);
        $client->submit($courseCreatingForm);
        $this->assertResponseCode(422);

        // сравнение текста ошибки
        $this->assertSelectorTextContains(
            'li',
            'Код курса не может содержать более 255 символов'
        );

        // заполнение формы корректными значениями(кроме названия)
        $courseCreatingForm = $crawler->selectButton('Сохранить')->form([
            'course[CharacterCode]' => 'код-тест-1',
            'course[Name]' => str_repeat("test", 64),
            'course[Description]' => 'Тест-описание',
        ]);
        $client->submit($courseCreatingForm);
        $this->assertResponseCode(422);

        // сравнение текста ошибки
        $this->assertSelectorTextContains(
            'li',
            'Название курса не может содержать более 255 символов'
        );

        // заполнение формы корректными значениями(кроме описания)
        $courseCreatingForm = $crawler->selectButton('Сохранить')->form([
            'course[CharacterCode]' => 'код-тест-1',
            'course[Name]' => 'Тест-имя',
            'course[Description]' => str_repeat("test", 251),
        ]);
        $client->submit($courseCreatingForm);
        $this->assertResponseCode(422);

        // сравнение текста ошибки
        $this->assertSelectorTextContains(
            'li',
            'Описание курса не может содержать более 1000 символов'
        );
    }

    public function testCourseSuccessfulEditing(): void
    {
        // список курсов
        $client = $this->getClient();
        $crawler = $client->request('GET', '/courses/');
        $this->assertResponseOk();

        // переход на первый курс
        $link = $crawler->filter('.course-show')->first()->link();
        $crawler = $client->click($link);
        $this->assertResponseOk();

        // переход на окно редактирования
        $link = $crawler->selectLink('Редактировать')->link();
        $crawler = $client->click($link);
        $this->assertResponseOk();
        $form = $crawler->selectButton('Сохранить')->form();

        // сохранение id редактируемого курса
        $courseId = $this->getEntityManager()
            ->getRepository(Course::class)
            ->findOneBy(['code' => $form['course[code]']->getValue()])->getId();

        // заполнение формы корректными значениями
        $form['course[CharacterCode]'] = 'код-тест-1';
        $form['course[Name]'] = 'Тест-имя';
        $form['course[Description]'] = 'Тест-описание';
        $client->submit($form);

        // редирект
        $crawler = $client->followRedirect();
        $this->assertRouteSame('app_course_show', ['id' => $courseId]);
        $this->assertResponseOk();

        // сравнение данных
        $this->assertSame($crawler->filter('.course-name')->text(), 'Курс: Тест-имя');
        $this->assertSame($crawler->filter('.course-description')->text(), 'Тест-описание');
    }

    public function testCourseFailedEditing(): void
    {
        // список курсов
        $client = $this->getClient();
        $crawler = $client->request('GET', '/courses/');
        $this->assertResponseOk();

        // переход на первый курс
        $link = $crawler->filter('.course-show')->first()->link();
        $crawler = $client->click($link);
        $this->assertResponseOk();

        // переход на окно редактирования
        $link = $crawler->selectLink('Редактировать')->link();
        $crawler = $client->click($link);
        $this->assertResponseOk();
        $submitButton = $crawler->selectButton('Сохранить');
        $form = $submitButton->form();

        // заполнение формы корректными значениями(кроме кода)
        $form['course[CharacterCode]'] = '';
        $form['course[Name]'] = 'Тест-имя';
        $form['course[Description]'] = 'Тест-описание';
        $client->submit($form);
        $this->assertResponseCode(422);

        // сравнение текста ошибки
        $this->assertSelectorTextContains(
            'li',
            'Код курса не должен быть пустым'
        );

        // получение кода последнего курса
        $courses = $this->getEntityManager()->getRepository(Course::class)->findAll();
        $last_course = $courses[count($courses) - 1];

        // заполнение формы корректными значениями(с тем же кодом)
        $form['course[CharacterCode]'] = $last_course->getCode();
        $form['course[Name]'] = 'Тест-имя';
        $form['course[Description]'] = 'Тест-описание';
        $client->submit($form);
        $this->assertResponseCode(422);

        // сравнение текста ошибки
        $this->assertSelectorTextContains(
            'li',
            'Курс с таким символьным кодом уже существует.'
        );

        // заполнение формы корректными значениями(кроме названия)
        $form['course[CharacterCode]'] = 'код-тест-1';
        $form['course[Name]'] = '';
        $form['course[Description]'] = 'Тест-описание';
        $client->submit($form);
        $this->assertResponseCode(422);

        // сравнение текста ошибки
        $this->assertSelectorTextContains(
            'li',
            'Название курса не должно быть пустым'
        );

        // заполнение формы корректными значениями(кроме кода)
        $form['course[CharacterCode]'] = str_repeat("test", 64);
        $form['course[Name]'] = 'Тест-имя';
        $form['course[Description]'] = 'Тест-описание';
        $client->submit($form);
        $this->assertResponseCode(422);

        // сравнение текста ошибки
        $this->assertSelectorTextContains(
            'li',
            'Код курса не может содержать более 255 символов'
        );

        // заполнение формы корректными значениями(кроме названия)
        $form['course[CharacterCode]'] = 'код-тест-1';
        $form['course[Name]'] = str_repeat("test", 64);
        $form['course[Description]'] = 'Тест-описание';
        $client->submit($form);
        $this->assertResponseCode(422);

        // сравнение текста ошибки
        $this->assertSelectorTextContains(
            'li',
            'Название курса не может содержать более 255 символов'
        );

        // заполнение формы корректными значениями(кроме описания)
        $form['course[Name]'] = 'Course name for test';
        $form['course[Description]'] = str_repeat("test", 251);
        $client->submit($form);
        $this->assertResponseCode(422);

        // сравнение текста ошибки
        $this->assertSelectorTextContains(
            'li',
            'Описание курса не может содержать более 1000 символов'
        );
    }

    public function testCourseDeleting(): void
    {
        // список курсов
        $client = $this->getClient();
        $crawler = $client->request('GET', '/courses/');
        $this->assertResponseOk();

        // сохранение количества крусов
        $coursesCount = count($this->getEntityManager()->getRepository(Course::class)->findAll());

        // переход на первый курс
        $link = $crawler->filter('.course-show')->first()->link();
        $client->click($link);
        $this->assertResponseOk();
        $client->submitForm('Удалить курс');
        $this->assertSame($client->getResponse()->headers->get('location'), '/courses/');

        // редирект
        $crawler = $client->followRedirect();

        // сохранение количества курсов после удаления
        $coursesCountAfterDelete = count($this->getEntityManager()->getRepository(Course::class)->findAll());

        // проверка количества курсов
        $this->assertSame($coursesCount - 1, $coursesCountAfterDelete);
        $this->assertCount($coursesCountAfterDelete, $crawler->filter('.course'));
    }
}
