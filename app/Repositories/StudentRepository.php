<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use App\Models\Student;
use PDO;

/** All SQL for students lives here (prepared statements only). */
final class StudentRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    /** @return Student[] */
    public function all(string $search = ''): array
    {
        if ($search !== '') {
            $stmt = $this->db->prepare(
                'SELECT * FROM students
                 WHERE first_name LIKE :q1 OR last_name LIKE :q2 OR student_no LIKE :q3 OR email LIKE :q4
                 ORDER BY id DESC'
            );
            $like = "%{$search}%";
            $stmt->execute(['q1' => $like, 'q2' => $like, 'q3' => $like, 'q4' => $like]);
        } else {
            $stmt = $this->db->query('SELECT * FROM students ORDER BY id DESC');
        }
        return array_map([Student::class, 'fromRow'], $stmt->fetchAll());
    }

    public function find(int $id): ?Student
    {
        $stmt = $this->db->prepare('SELECT * FROM students WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ? Student::fromRow($row) : null;
    }

    public function create(Student $s): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO students (student_no, first_name, last_name, email, course, year_level)
             VALUES (:student_no, :first_name, :last_name, :email, :course, :year_level)'
        );
        $stmt->execute($this->params($s));
        return (int) $this->db->lastInsertId();
    }

    public function update(Student $s): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE students SET student_no = :student_no, first_name = :first_name,
                last_name = :last_name, email = :email, course = :course, year_level = :year_level
             WHERE id = :id'
        );
        return $stmt->execute($this->params($s) + ['id' => $s->id]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM students WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }

    /** True if another record already uses this column value. */
    public function exists(string $column, string $value, ?int $ignoreId = null): bool
    {
        if (!in_array($column, ['student_no', 'email'], true)) {
            throw new \InvalidArgumentException('Invalid column.');
        }
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM students WHERE {$column} = :v AND id <> :id"
        );
        $stmt->execute(['v' => $value, 'id' => $ignoreId ?? 0]);
        return (int) $stmt->fetchColumn() > 0;
    }

    private function params(Student $s): array
    {
        return [
            'student_no' => $s->studentNo,
            'first_name' => $s->firstName,
            'last_name'  => $s->lastName,
            'email'      => $s->email,
            'course'     => $s->course,
            'year_level' => $s->yearLevel,
        ];
    }
}
