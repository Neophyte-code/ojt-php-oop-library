<?php

declare(strict_types=1);

class StudentMember extends Member
{
    public function canBorrow(): bool
    {
        return $this->getLoanCount() < 1;
    }
}
