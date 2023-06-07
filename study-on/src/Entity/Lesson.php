<?php

namespace App\Entity;

use App\Repository\LessonRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LessonRepository::class)
 */
class Lesson
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Course::class, inversedBy="lessons")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Course;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Title;

    /**
     * @ORM\Column(type="text")
     */
    private $Content;

    /**
     * @ORM\Column(type="integer")
     */
    private $LessonNumber;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCourse(): ?Course
    {
        return $this->Course;
    }

    public function setCourse(?Course $Course): self
    {
        $this->Course = $Course;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): self
    {
        $this->Title = $Title;

        return $this;
    }

    public function getLessonContent(): ?string
    {
        return $this->Content;
    }

    public function setLessonContent(string $Content): self
    {
        $this->Content = $Content;

        return $this;
    }

    public function getLessonNumber(): ?int
    {
        return $this->LessonNumber;
    }

    public function setLessonNumber(int $LessonNumber): self
    {
        $this->LessonNumber = $LessonNumber;

        return $this;
    }
}
