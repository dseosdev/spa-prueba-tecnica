<?php

namespace App\Entity;

use Assert\Choice;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BookingRepositoryInterface;
use App\Repository\DoctrineBookingRepository;
use PharIo\Manifest\Email;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: DoctrineBookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $customerName = null;

    #[ORM\Column(length: 255)]
    private ?string $customerEmail = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $day = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $hour = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $price = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    private ?spaService $spaService = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomerName(): ?string
    {
        return $this->customerName;
    }

    public function setCustomerName(string $customerName): self
    {
        $this->customerName = $customerName;

        return $this;
    }

    public function getCustomerEmail(): ?string
    {
        return $this->customerEmail;
    }

    public function setCustomerEmail(string $customerEmail): self
    {
        $this->customerEmail = $customerEmail;

        return $this;
    }

    public function getDay(): ?\DateTimeInterface
    {
        return $this->day;
    }

    public function setDay(\DateTimeInterface $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function getHour(): ?\DateTimeInterface
    {
        return $this->hour;
    }

    public function setHour(\DateTimeInterface $hour): self
    {
        $this->hour = $hour;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getSpaService(): ?spaService
    {
        return $this->spaService;
    }

    public function setSpaService(?spaService $spaService): self
    {
        $this->spaService = $spaService;

        return $this;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        // ...

        $metadata->addPropertyConstraint('customerName', new Assert\NotBlank());
        $metadata->addPropertyConstraint('customerName', new Assert\Length(['min'=>3, 'max'=>255]));
        $metadata->addPropertyConstraint('customerEmail', new Assert\NotBlank());
        $metadata->addPropertyConstraint('customerEmail', new Assert\Email());
        $metadata->addPropertyConstraint('day', new Assert\Type("DateTime"));
        $metadata->addPropertyConstraint('hour', new Assert\Type("DateTime"));
        $metadata->addPropertyConstraint('spaService', new Assert\Type(['type' => 'object']));
        
    }
}

