<?php
namespace System\DesignPatterns\Behavioral\State;

class WarningState implements StudentState {
    public function canStudy(): bool {
        return true;
    }

    public function label(): string {
        return 'Bị cảnh cáo';
    }

    public function nextStates(): array {
        return ['Nghỉ học', 'Đang học'];
    }
}
