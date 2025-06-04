<?php
namespace System\DesignPatterns\Behavioral\State;

class ActiveState implements StudentState {
    public function canStudy(): bool {
        return true;
    }

    public function label(): string {
        return 'Đang học';
    }

    public function nextStates(): array {
        return ['Bị cảnh cáo', 'Nghỉ học'];
    }
}
