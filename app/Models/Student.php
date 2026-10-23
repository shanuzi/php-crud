<?php
declare(strict_types=1);

namespace App\Models;

/** Entity representing one row of the `students` table. */
final class Student
{
    public function __construct(
        public ?int $id = null,
        public string $studentNo = '',
        public string $firstName = '',
        public string $lastName = '',
        public string $email = '',
        public string $course = '',
        public int $yearLevel = 1,
    ) {}

    public static function fromRow(array $row): self
    {
        return new self(
            (int) $row['id'],
            $row['student_no'],
            $row['first_name'],
            $row['last_name'],
            $row['email'],
            $row['course'],
            (int) $row['year_level'],
        );
    }

    public static function fromInput(array $in, ?int $id = null): self
    {
        return new self(
            $id,
            trim($in['student_no'] ?? ''),
            trim($in['first_name'] ?? ''),
            trim($in['last_name'] ?? ''),
            trim($in['email'] ?? ''),
            trim($in['course'] ?? ''),
            (int) ($in['year_level'] ?? 0),
        );
    }

    public function fullName(): string
    {
        return "{$this->firstName} {$this->lastName}";
    }
}
