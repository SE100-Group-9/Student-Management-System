<?php

namespace DesignPatterns\Structural\Proxy;


interface User
{
    public function getInfo();
    public function getRole(); // "student" hoặc "teacher"
}

class Student implements User
{
    private $name;
    private $teachers; // danh sách giáo viên được phép xem điểm
    public function __construct($name, $teachers = [])
    {
        $this->name = $name;
        $this->teachers = $teachers;
    }

    public function getInfo()
    {
        return $this->name;
    }

    public function getRole()
    {
        return "student";
    }

    public function getTeachers()
    {
        return $this->teachers;
    }
}

class Teacher implements User
{
    private $name;
    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getInfo()
    {
        return $this->name;
    }

    public function getRole()
    {
        return "teacher";
    }
}

interface IGradeBook
{
    public function getGrades(User $user);
}

class GradeBook implements IGradeBook
{
    private $studentName;
    private $grades;

    public function __construct($studentName, $grades)
    {
        $this->studentName = $studentName;
        $this->grades = $grades;
    }

    public function getGrades(User $user = null)
    {
        return $this->grades;
    }

    public function getStudentName()
    {
        return $this->studentName;
    }
}

class GradeBookProxy implements IGradeBook
{
    private $gradeBook;
    private $student;

    public function __construct(GradeBook $gradeBook, Student $student)
    {
        $this->gradeBook = $gradeBook;
        $this->student = $student;
    }

    private function checkAccess(User $user)
    {
        if ($user->getRole() === 'student' && $user->getInfo() === $this->student->getInfo()) {
            return true;
        }
        if ($user->getRole() === 'teacher') {
            foreach ($this->student->getTeachers() as $teacher) {
                if ($teacher->getInfo() === $user->getInfo()) {
                    return true;
                }
            }
        }
        return false;
    }

    public function getGrades(User $user)
    {
        if ($this->checkAccess($user)) {
            return $this->gradeBook->getGrades();
        } else {
            return "Access Denied: Bạn không có quyền xem điểm học sinh này.";
        }
    }
}
