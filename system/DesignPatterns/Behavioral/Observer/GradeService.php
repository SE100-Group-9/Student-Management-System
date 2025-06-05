<?php
namespace System\DesignPatterns\Behavioral\Observer;

use App\Models\DiemModel;

class GradeService
{
    private array $observers = [];

    public function addObserver(Observer $observer): void
    {
        $this->observers[] = $observer;
    }

    public function removeObserver(Observer $observer): void
    {
        $this->observers = array_filter($this->observers, fn ($obs) => $obs !== $observer);
    }

    public function updateGrade(array $gradeData): void
    {
        $diemModel = new DiemModel();

        $existing = $diemModel->where([
            'MaHS'   => $gradeData['MaHS'],
            'MaMH'   => $gradeData['MaMH'],
            'MaGV'   => $gradeData['MaGV'],
            'HocKy'  => $gradeData['HocKy'],
            'NamHoc' => $gradeData['NamHoc'],
        ])->first();

        if ($existing) {
            $diemId = $existing['MaDiem'];
            $diemModel->update($diemId, $gradeData);
            $updated = $diemModel->find($diemId);

            // Gọi Observer
            $this->notifyObservers($updated);
        }
    }

    private function notifyObservers(array $diem): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($diem);
        }
    }
}
