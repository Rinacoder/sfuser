<?php

namespace App\DataFixtures;

use App\Entity\Course;
use App\Entity\Lesson;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\Collections\ArrayCollection;



class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $course = new Course();
        $course->setCharacterCode('The_life_of_a_programmer');
        $course->setName('Жизнь программиста');
        $course->setDescription('На этом курсе вы познакомитесь с жизнью программиста.
Вы узнаете, что значит быть программистом и как им стать.
В итоге вы научитесь правильно настраиваться на достижение своих целей.
Курс пригодится, если вы решите стать программистом и хотите узнать о навыках,
которые нужны для этого. Знания из этого курса помогут узнать о нюансах профессии,
о видах компаний и разработки. Этот курс подойдет новичкам, которые хотят познакомиться
с профессией.');


        $lesson = new Lesson();
        $lesson->setTitle('Введение');
        $lesson->setLessonContent('Этот курс рассчитан на всех, кто хочет стать программистом.
Студенты технической специальности почерпнут для себя что-то новое,
поскольку далеко не всё, что преподается в институте, имеет отношение к промышленному
программированию. Те же, кто не имеет к нему отношения, но хотят им заниматься,
получат максимально подробный обзор этой профессии. Программирование открыто для всех,
поэтому всё больше и больше людей становятся программистами.');
        $lesson->setLessonNumber('1');
        $manager->persist($lesson);
        $course->addLesson($lesson);

        $lesson = new Lesson();
        $lesson->setTitle('Программирование как профессия');
        $lesson->setLessonContent('Специально для этого урока мы провели опрос среди самых активных пользователей Хекслета и узнали, что для них значит быть программистом. Для большинства опрошенных быть программистом — значит:
• Создавать что-то новое
• Изменять жизнь людей по всему миру
• Заниматься любимым делом, за которое еще и платят');
        $lesson->setLessonNumber('2');
        $manager->persist($lesson);
        $course->addLesson($lesson);

        $lesson = new Lesson();
        $lesson->setTitle('Виды компаний и разработки');
        $lesson->setLessonContent('Компании делятся на две больших категории,
исходя из ролей, которые в них играют программисты и разработка
программного обеспечения. Первая группа — это те компании, в
которых IT — это просто отдел, который не является основным бизнесом, а вторые — те,
в которых бизнес построен вокруг IT.

С теми компаниями, в которых IT представлен в качестве отдела, всё достаточно просто.
Это могут быть фабричные производства, банки, крупные строительные и любые другие
компании, в которых нужна автоматизация. Чаще всего эти IT-отделы нужны именно для
автоматизации документооборота или улучшения каких-то бизнес-процессов внутри компании,
и от IT-отдела не требуется ничего сверхъестественного, кроме решения конкретных
потребностей этого бизнеса.');
        $lesson->setLessonNumber('3');
        $manager->persist($lesson);
        $course->addLesson($lesson);

        $lesson = new Lesson();
        $lesson->setTitle('Написание кода');
        $lesson->setLessonContent('Процесс кодинга — это непосредственная работа с языком.
Пришло время разобраться, что из себя представляет язык.
Любой язык программирования, равно как и язык естественный,
состоит из 3 элементов.');
        $lesson->setLessonNumber('4');
        $manager->persist($lesson);
        $course->addLesson($lesson);

        $lesson = new Lesson();
        $lesson->setTitle('Неустаревающие знания');
        $lesson->setLessonContent('Мир вокруг нас непрерывно меняется, и точно так же
каждый день меняются технологии, причем иногда настолько сильно, что освоенное
сегодня через год уже может быть не нужно. Но если посмотреть глубже, то можно
увидеть, что базовые, фундаментальные знания, которые используются в большинстве
современных технологий, появились очень давно и практически не изменились.
В этом уроке мы поговорим о том, какие области фундаментальных знаний нужно
прокачивать, чтобы стать хорошим программистом, а в конце перечислим и некоторые
инструменты, знание которых необходимо каждому профессиональному разработчику.');
        $lesson->setLessonNumber('5');
        $manager->persist($lesson);
        $course->addLesson($lesson);

        $manager->persist($course);

        $course = new Course();
        $course->setCharacterCode('Basics_of_modern_layout');
        $course->setName('Основы современной верстки');
        $course->setDescription('На этом курсе вы изучите основы верстки сайтов HTML.
Знание этого языка пригодится, когда вы начнете работать над версткой своих
первых веб-страниц. Вы узнаете больше об HTML-разметке и возможностях современного
стандарта HTML5. Также вы получите базовые знания по стилизации с помощью CSS:
научитесь подключать стили, использовать селекторы, работать с каскадностью.
В дополнение к HTML и CSS, вы научитесь работать со встроенными в браузер
средствами отладки верстки, в частности с Google Chrome DevTools. В итоге
вы научитесь использовать язык разметки HTML для верстки текста на сайте,
а также познакомитесь с базовыми правилами использования CSS и стилизации текста.');


        $lesson = new Lesson();
        $lesson->setTitle('Введение');
        $lesson->setLessonContent('Курс Основы современной верстки является базой для
изучения основ HTML и CSS. На протяжении десятка уроков вы познакомитесь с
основами верстки. Разберетесь, как и в чем писать верстку. Научитесь базовым
основам стилизации HTML элементов с помощью CSS.');
        $lesson->setLessonNumber('1');
        $manager->persist($lesson);
        $course->addLesson($lesson);


        $lesson = new Lesson();
        $lesson->setTitle('Введение в HTML');
        $lesson->setLessonContent('HTML (HyperText Markup Language) — язык для разметки
гипертекста, он является набором правил, по которым браузер отличает заголовки
от списков, таблицы от картинок и так далее. HTML появился в 1993 году и был
призван стандартизировать правила для вывода текста внутри веб-страниц.');
        $lesson->setLessonNumber('2');
        $manager->persist($lesson);
        $course->addLesson($lesson);

        $lesson = new Lesson();
        $lesson->setTitle('Блочная модель');
        $lesson->setLessonContent('Представьте себе процесс строительства дома.
Условно его можно разделить на несколько этапов: возведение структуры
дома и его отделка. При возведении дома мы заливаем фундамент,
возводим стены, устанавливаем крышу. После этого уже переходим к
покраске дома, устанавливаем окна и занимаемся декорированием.');
        $lesson->setLessonNumber('3');
        $manager->persist($lesson);
        $course->addLesson($lesson);

        $manager->persist($course);

        $course = new Course();
        $course->setCharacterCode('Basics_Go');
        $course->setName('Основы Go');
        $course->setDescription('На этом курсе вы изучите основы языка Go.
Вы познакомитесь с простыми типами данных, условиями и циклами в Go
и узнаете, как объявлять собственные функции и использовать встроенные.
Во время обучения вы попрактикуетесь в использовании структур и представлении
ООП в Go. Также узнаете о сильной стороне программирования на Go — легковесных
потоках и Go-рутинах. Освоить язык Go с нуля непросто, поэтому с первых уроков
вы начнете выполнять упражнения. Такое сочетание теории и практики в обучении
помогут быстрее привыкнуть к основам программирования на Go. Знания из этого
курса помогут получить основное представление о Go, его принципах и особенностях.
Этот курс подойдет тем, кто уже знаком с концепциями программирования и осваивает
новый язык.');


        $lesson = new Lesson();
        $lesson->setTitle('Введение');
        $lesson->setLessonContent('Go (также часто его называют Golang) — это современный язык
программирования общего назначения с открытым исходным кодом. Он был задуман в первую
очередь для того, чтобы легко писать простые и надежные программы, которые эффективно
утилизируют многопроцессорные системы с несколькими ядрами.

В Go очень простой синтаксис, мало синтаксического сахара, строгие правила
форматирования, что позволяет на нем писать код, который легко читать и понимать.
За счет этого Go имеет достаточно низкий порог входа для новых программистов.');
        $lesson->setLessonNumber('1');
        $manager->persist($lesson);
        $course->addLesson($lesson);

        $lesson = new Lesson();
        $lesson->setTitle('Привет, мир!');
        $lesson->setLessonContent('По традиции начнем с программы Hello World:');
        $lesson->setLessonNumber('2');
        $manager->persist($lesson);
        $course->addLesson($lesson);

        $lesson = new Lesson();
        $lesson->setTitle('Go, Go, Go');
        $lesson->setLessonContent('Go — это компилируемый строго типизированный язык
программирования, разработанный в Google. Язык спроектирован для быстрой разработки
высоконагруженных бэкендов. Если вы знакомы с императивными языками (например, C++,
PHP, Java), то синтаксис Go будет понятен практически сразу');
        $lesson->setLessonNumber('3');
        $manager->persist($lesson);
        $course->addLesson($lesson);

        $manager->persist($course);


        $manager->flush();
    }
}
