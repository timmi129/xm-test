<?php

declare(strict_types=1);

namespace App\Request\Appeal;

use App\Request\RequestInterface;
use App\Validator\Constraints\VO\StringVO;
use App\VO\Email;
use App\VO\PhoneNumber;
use App\VO\Text;
use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;

class CreateAppealRequest implements RequestInterface
{
    #[Assert\NotBlank()]
    #[StringVO(
        [
            new Assert\NotBlank(),
        ]
    )]
    #[OA\Property(type: 'string')]
    private Text $text;

    #[Assert\NotBlank()]
    #[StringVO(
        [
            new Assert\NotBlank(),
            new Assert\Email(),
        ]
    )]
    #[OA\Property(type: 'string')]
    private Email $email;

    #[Assert\NotBlank(allowNull: true)]
    #[StringVO(
        [
            new Assert\NotBlank(),
            //            new Assert\Url()
        ]
    )]
    #[OA\Property(type: 'string', nullable: true)]
    private ?PhoneNumber $phone = null;

    public function getText(): Text
    {
        return $this->text;
    }

    public function setText(Text $text): void
    {
        $this->text = $text;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function setEmail(Email $email): void
    {
        $this->email = $email;
    }

    public function getPhone(): ?PhoneNumber
    {
        return $this->phone;
    }

    public function setPhone(?PhoneNumber $phone): void
    {
        $this->phone = $phone;
    }
}
