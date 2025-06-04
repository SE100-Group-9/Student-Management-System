<?php
namespace System\DesignPatterns\Behavioral\State;

class PendingState implements StudentState {
    public function canStudy(): bool {
        return false;
    }

    public function label(): string {
        return 'Mới tiếp nhận';
    }

    public function nextStates(): array {
        return ['Đang học'];
    }
}
