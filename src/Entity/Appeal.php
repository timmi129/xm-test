<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AppealRepository;
use App\VO\Email;
use App\VO\PhoneNumber;
use App\VO\Text;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity(repositoryClass: AppealRepository::class)]
#[ORM\Table(name: 'appeals')]
class Appeal
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private UuidInterface $id;

    #[ORM\Column(type: 'string')]
    private string $text;

    #[ORM\Column(type: 'string')]
    private string $email;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $phone;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private User $user;

    #[ORM\ManyToOne(targetEntity: Organization::class)]
    #[ORM\JoinColumn(name: 'organization_id', referencedColumnName: 'id')]
    private Organization $organization;

    public function __construct(
        Text $text,
        Email $email,
        User $user,
        ?PhoneNumber $phone
    ) {
        $this->id = Uuid::uuid4();
        $this->text = $text->getValue();
        $this->email = $email->getValue();
        $this->phone = $phone?->getValue();
        $this->user = $user;
        $this->organization = $user->getCurrentOrganization();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getText(): Text
    {
        return Text::create($this->text);
    }

    public function getEmail(): Email
    {
        return Email::create($this->email);
    }

    public function getPhone(): ?PhoneNumber
    {
        return null !== $this->phone ? PhoneNumber::create($this->phone) : null;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getOrganization(): Organization
    {
        return $this->organization;
    }
}
