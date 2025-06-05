<?php

namespace System\DesignPatterns\Behavioral\Observer;

interface Observer
{
    public function update(array $grade): void;
}
