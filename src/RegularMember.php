<?php

declare(strict_types=1);

class RegularMember extends Member
{

    //function implementation from abstract method in Member class
    public function canBorrow(): bool
    {
        return $this->getLoanCount() < 2;
    }
}
