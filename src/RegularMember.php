<?php

declare(strict_types=1);

class RegularMember extends Member
{
    public function canBorrow(): bool
    {
        return $this->getLoanCount() < 2;
    }
}
