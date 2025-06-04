<?php
namespace System\DesignPatterns\Behavioral\State;

use Exception;

class StudentStateManager
{
    private StudentState $state;

    public function __construct(string $status)
    {
        switch (trim($status)) {
            case 'Đang học':
                $this->state = new ActiveState();
                break;
            case 'Mới tiếp nhận':
                $this->state = new PendingState();
                break;
            case 'Nghỉ học':
                $this->state = new InactiveState();
                break;
            case 'Bị cảnh cáo':
                $this->state = new WarningState();
                break;
            default:
                throw new Exception("Trạng thái học sinh không hợp lệ");
        }
    }

    public function canStudy(): bool
    {
        return $this->state->canStudy();
    }

    public function getLabel(): string
    {
        return $this->state->label();
    }

    public function getNextStates(): array
    {
        return $this->state->nextStates();
    }
}
