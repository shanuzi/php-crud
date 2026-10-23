<?php
declare(strict_types=1);

namespace App\Validators;

use App\Models\Student;
use App\Repositories\StudentRepository;

final class StudentValidator
{
    public function __construct(private StudentRepository $repo) {}

    /** @return array<string,string> field => error message */
    public function validate(Student $s): array
    {
        $e = [];

        if ($s->studentNo === '' || strlen($s->studentNo) > 20) {
            $e['student_no'] = 'Student number is required (max 20 characters).';
        } elseif ($this->repo->exists('student_no', $s->studentNo, $s->id)) {
            $e['student_no'] = 'This student number is already in use.';
        }

        if ($s->firstName === '' || strlen($s->firstName) > 60) {
            $e['first_name'] = 'First name is required (max 60 characters).';
        }
        if ($s->lastName === '' || strlen($s->lastName) > 60) {
            $e['last_name'] = 'Last name is required (max 60 characters).';
        }

        if (!filter_var($s->email, FILTER_VALIDATE_EMAIL) || strlen($s->email) > 120) {
            $e['email'] = 'Enter a valid email address.';
        } elseif ($this->repo->exists('email', $s->email, $s->id)) {
            $e['email'] = 'This email is already in use.';
        }

        if ($s->course === '' || strlen($s->course) > 60) {
            $e['course'] = 'Course is required (max 60 characters).';
        }
        if ($s->yearLevel < 1 || $s->yearLevel > 6) {
            $e['year_level'] = 'Year level must be between 1 and 6.';
        }

        return $e;
    }
}
