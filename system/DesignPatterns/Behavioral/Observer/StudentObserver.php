<?php

namespace System\DesignPatterns\Behavioral\Observer;

class StudentObserver implements Observer
{
    private string $studentId;
    private string $mail;

    public function __construct(string $studentId, string $mail)
    {
        $this->studentId = $studentId;
        $this->mail = $mail;
    }

    public function update(array $grade): void
    {
        if ($grade['MaHS'] === $this->studentId) {
            $this->notifyStudent($grade);
        }
    }

    private function notifyStudent(array $grade): void
    {
        log_message('info', "📢 [STUDENT] {$this->studentId} ({$this->mail}) được thông báo điểm: " . json_encode($grade));
    }
}

