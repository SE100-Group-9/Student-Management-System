<?php
namespace DesignPatterns\Creational\FactoryMethod;

use App\Models\TaiKhoanModel;
use App\Models\HocSinhModel;
use App\Models\GiaoVienModel;
use App\Models\BanGiamHieuModel;
use App\Models\GiamThiModel;
use App\Models\ThuNganModel;

// ===== Interface dùng chung =====
interface UserInterface {
    public function getInfo(): string;
    public function getRole(): string;
    public function createAndSave(): bool;
}

// ===== Các lớp người dùng cụ thể =====
class Student implements UserInterface {
    protected array $info;
    protected TaiKhoanModel $taiKhoanModel;
    protected HocSinhModel $hocSinhModel;

    public function __construct(array $info) {
        $this->info = $info;
        $this->taiKhoanModel = new TaiKhoanModel();
        $this->hocSinhModel = new HocSinhModel();
    }

    public function createAndSave(): bool {
        $maTK = $this->taiKhoanModel->insert([
            'TenTK' => $this->info['account'],
            'MatKhau' => $this->info['password'],
            'HoTen' => $this->info['name'],
            'Email' => $this->info['email'],
            'SoDienThoai' => $this->info['phone'],
            'DiaChi' => $this->info['address'],
            'GioiTinh' => $this->info['gender'],
            'NgaySinh' => $this->info['birthday'],
            'MaVT' => 3,
        ]);

        if (!$maTK) return false;

        return $this->hocSinhModel->insert([
            'MaTK' => $maTK,
            'DanToc' => $this->info['nation'] ?? '',
            'NoiSinh' => $this->info['country'] ?? '',
            'TinhTrang' => $this->info['status'] ?? 'Mới tiếp nhận',
        ]) !== false;
    }

    public function getInfo(): string {
        return "Học sinh: " . $this->info['name'];
    }

    public function getRole(): string {
        return "Học sinh";
    }
}

class Teacher implements UserInterface {
    protected array $info;
    protected TaiKhoanModel $taiKhoanModel;
    protected GiaoVienModel $giaoVienModel;

    public function __construct(array $info) {
        $this->info = $info;
        $this->taiKhoanModel = new TaiKhoanModel();
        $this->giaoVienModel = new GiaoVienModel();
    }

    public function createAndSave(): bool {
        $maTK = $this->taiKhoanModel->insert([
            'TenTK' => $this->info['account'],
            'MatKhau' => $this->info['password'],
            'HoTen' => $this->info['name'],
            'Email' => $this->info['email'],
            'SoDienThoai' => $this->info['phone'],
            'DiaChi' => $this->info['address'],
            'GioiTinh' => $this->info['gender'],
            'NgaySinh' => $this->info['birthday'],
            'MaVT' => 2,
        ]);

        if (!$maTK) return false;

        return $this->giaoVienModel->insert(['MaTK' => $maTK]) !== false;
    }

    public function getInfo(): string {
        return "Giáo viên: " . $this->info['name'];
    }

    public function getRole(): string {
        return "Giáo viên";
    }
}

class Supervisor implements UserInterface {
    protected array $info;
    protected TaiKhoanModel $taiKhoanModel;
    protected GiamThiModel $giamThiModel;

    public function __construct(array $info) {
        $this->info = $info;
        $this->taiKhoanModel = new TaiKhoanModel();
        $this->giamThiModel = new GiamThiModel();
    }

    public function createAndSave(): bool {
        $maTK = $this->taiKhoanModel->insert([
            'TenTK' => $this->info['account'],
            'MatKhau' => $this->info['password'],
            'HoTen' => $this->info['name'],
            'Email' => $this->info['email'],
            'SoDienThoai' => $this->info['phone'],
            'DiaChi' => $this->info['address'],
            'GioiTinh' => $this->info['gender'],
            'NgaySinh' => $this->info['birthday'],
            'MaVT' => 5,
        ]);

        if (!$maTK) return false;

        return $this->giamThiModel->insert([
            'MaTK' => $maTK,
            'TinhTrang' => $this->info['status'] ?? 'Đang làm việc',
        ]) !== false;
    }

    public function getInfo(): string {
        return "Giám thị: " . $this->info['name'];
    }

    public function getRole(): string {
        return "Giám thị";
    }
}

class Cashier implements UserInterface {
    protected array $info;
    protected TaiKhoanModel $taiKhoanModel;
    protected ThuNganModel $thuNganModel;

    public function __construct(array $info) {
        $this->info = $info;
        $this->taiKhoanModel = new TaiKhoanModel();
        $this->thuNganModel = new ThuNganModel();
    }

    public function createAndSave(): bool {
        $maTK = $this->taiKhoanModel->insert([
            'TenTK' => $this->info['account'],
            'MatKhau' => $this->info['password'],
            'HoTen' => $this->info['name'],
            'Email' => $this->info['email'],
            'SoDienThoai' => $this->info['phone'],
            'DiaChi' => $this->info['address'],
            'GioiTinh' => $this->info['gender'],
            'NgaySinh' => $this->info['birthday'],
            'MaVT' => 4,
        ]);

        if (!$maTK) return false;

        return $this->thuNganModel->insert([
            'MaTK' => $maTK,
            'TinhTrang' => $this->info['status'] ?? 'Đang làm việc',
        ]) !== false;
    }

    public function getInfo(): string {
        return "Thủ quỹ: " . $this->info['name'];
    }

    public function getRole(): string {
        return "Thủ quỹ";
    }
}

abstract class UserFactory {
    abstract public function createUser(): UserInterface;
}

class StudentFactory extends UserFactory {
    private array $info;
    public function __construct(array $info) {
        $this->info = $info;
    }
    public function createUser(): UserInterface {
        return new Student($this->info);
    }
}

class TeacherFactory extends UserFactory {
    private array $info;
    public function __construct(array $info) {
        $this->info = $info;
    }
    public function createUser(): UserInterface {
        return new Teacher($this->info);
    }
}

class SupervisorFactory extends UserFactory {
    private array $info;
    public function __construct(array $info) {
        $this->info = $info;
    }
    public function createUser(): UserInterface {
        return new Supervisor($this->info);
    }
}

class CashierFactory extends UserFactory {
    private array $info;
    public function __construct(array $info) {
        $this->info = $info;
    }
    public function createUser(): UserInterface {
        return new Cashier($this->info);
    }
}

function getFactoryByRole(string $role, array $info): ?UserFactory
{
    $normalized = mb_strtolower(trim($role), 'UTF-8');
    
    return match ($normalized) {
        'học sinh' => new StudentFactory($info),
        'giáo viên' => new TeacherFactory($info),
        'giám thị' => new SupervisorFactory($info),
        'thu ngân' => new CashierFactory($info),
        //'ban giám hiệu' => new DirectorFactory($info),
        default => null,
    };
}


