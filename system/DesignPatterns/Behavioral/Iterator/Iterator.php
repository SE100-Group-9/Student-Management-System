<?php

namespace DesignPatterns\Behavioral\Iterator;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Student: Đại diện cho đối tượng học sinh
class Student
{
    public function __construct(
        public $maHS,
        public $hoTen,
        public $tenLop,
        public $tenMH,
        public $diem15p1,
        public $diem15p2,
        public $diem1tiet1,
        public $diem1tiet2,
        public $diemCK,
        public $diemHK
    ) {}

    public function toArray(): array
    {
        return [
            $this->maHS,
            $this->hoTen,
            $this->tenLop,
            $this->tenMH,
            $this->diem15p1,
            $this->diem15p2,
            $this->diem1tiet1,
            $this->diem1tiet2,
            $this->diemCK,
            $this->diemHK,
        ];
    }
}

// IStudentIterator: Giao diện iterator
interface IStudentIterator
{
    public function hasMore(): bool;
    public function getNext(): ?Student;
}

// IStudentCollection: Giao diện tập hợp
interface IStudentCollection
{
    public function createIterator(): IStudentIterator;
}

// StudentCollection: Tập hợp quản lý danh sách học sinh
class StudentCollection implements IStudentCollection
{
    private array $students = [];

    public function addStudent(Student $student): void
    {
        $this->students[] = $student;
    }

    public function getStudents(): array
    {
        return $this->students;
    }

    public function createIterator(): IStudentIterator
    {
        return new StudentIterator($this);
    }
}

// StudentIterator: Duyệt qua danh sách học sinh
class StudentIterator implements IStudentIterator
{
    private StudentCollection $collection;
    private int $currentIndex = 0;

    public function __construct(StudentCollection $collection)
    {
        $this->collection = $collection;
    }

    public function hasMore(): bool
    {
        return $this->currentIndex < count($this->collection->getStudents());
    }

    public function getNext(): ?Student
    {
        if (!$this->hasMore()) {
            return null;
        }
        return $this->collection->getStudents()[$this->currentIndex++];
    }
}

// Client sử dụng: StudentManager (nếu muốn)
// class StudentManager
// {
//     private StudentCollection $students;

//     public function __construct(StudentCollection $collection)
//     {
//         $this->students = $collection;
//     }

//     public function exportStudentList(string $filename = "student_scores.xlsx"): void
//     {
//         //$spreadsheet = new Spreadsheet();
//         //$sheet = $spreadsheet->getActiveSheet();

//         // Tiêu đề cột
//         $sheet->fromArray([
//             'Mã HS', 'Họ tên', 'Lớp', 'Môn học',
//             '15p lần 1', '15p lần 2',
//             '1 tiết lần 1', '1 tiết lần 2',
//             'Cuối kỳ', 'HK'
//         ], null, 'A1');

//         $iterator = $this->students->createIterator();
//         $row = 2;

//         while ($iterator->hasMore()) {
//             $student = $iterator->getNext();
//             $sheet->fromArray($student->toArray(), null, "A$row");
//             $row++;
//         }

//         //$writer = new Xlsx($spreadsheet);
//         //$writer->save($filename);

//         echo "✅ Đã xuất danh sách điểm ra file: $filename\n";
//     }
// }
