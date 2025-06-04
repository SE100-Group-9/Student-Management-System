<?php
namespace System\DesignPatterns\Behavioral\State;

interface StudentState {
    public function canStudy(): bool;
    public function label(): string;
    public function nextStates(): array;
}
