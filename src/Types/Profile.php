<?php

namespace Budry\OpenGraph\Types;

use Budry\OpenGraph\MetaItem;
use Budry\OpenGraph\TypeInterface;
use Budry\OpenGraph\Utils\Gender;

class Profile implements TypeInterface
{
    /** @var string|null */
    private $firstName;

    /** @var string|null */
    private $lastName;

    /** @var string|null */
    private $username;

    /** @var string|null */
    private $gender;

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string|null $firstName
     * @return $this
     */
    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     * @return $this
     */
    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string|null $username
     * @return $this
     */
    public function setUsername(?string $username): self
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getGender(): ?string
    {
        return $this->gender;
    }

    /**
     * @param string|null $gender
     * @return $this
     */
    public function setGender(?string $gender): self
    {
        if ($gender !== null && !in_array($gender, Gender::getAllowedValues())) {
            throw new \InvalidArgumentException("Allowed values are only '" . json_encode(Gender::getAllowedValues()) . "'");
        }
        $this->gender = $gender;
        return $this;
    }

    /**
     * @return string
     */
    public static function getType(): string
    {
        return "profile";
    }

    /**
     * @return array|MetaItem[]
     */
    public function getFields(): array
    {
        return [
            new MetaItem("profile:first_name", $this->getFirstName()),
            new MetaItem("profile:last_name", $this->getLastName()),
            new MetaItem("profile:username", $this->getUsername()),
            new MetaItem("profile:gender", $this->getGender())
        ];
    }
}