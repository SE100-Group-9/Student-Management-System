<?php
namespace System\DesignPatterns\Behavioral\State;

class InactiveState implements StudentState {
    public function canStudy(): bool {
        return false;
    }

    public function label(): string {
        return 'Nghỉ học';
    }

    public function nextStates(): array {
        return ['Đang học'];
    }
}
