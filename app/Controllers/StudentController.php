<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Session;
use App\Core\View;
use App\Models\Student;
use App\Repositories\StudentRepository;
use App\Validators\StudentValidator;

final class StudentController
{
    private StudentRepository $repo;
    private StudentValidator $validator;

    public function __construct()
    {
        $this->repo      = new StudentRepository();
        $this->validator = new StudentValidator($this->repo);
    }

    /** READ (list + search) */
    public function index(): void
    {
        $search = trim($_GET['q'] ?? '');
        View::render('students/index', [
            'students' => $this->repo->all($search),
            'search'   => $search,
        ]);
    }

    /** CREATE form */
    public function create(): void
    {
        $this->renderForm(new Student(), [], 'store', 'Add Student');
    }

    /** CREATE action */
    public function store(): void
    {
        $this->guardPost();
        $student = Student::fromInput($_POST);
        $errors  = $this->validator->validate($student);

        if ($errors) {
            $this->renderForm($student, $errors, 'store', 'Add Student');
            return;
        }

        $this->repo->create($student);
        $this->redirectWith('Student added successfully.');
    }

    /** UPDATE form */
    public function edit(): void
    {
        $student = $this->findOrFail((int) ($_GET['id'] ?? 0));
        $this->renderForm($student, [], 'update', 'Edit Student');
    }

    /** UPDATE action */
    public function update(): void
    {
        $this->guardPost();
        $existing = $this->findOrFail((int) ($_POST['id'] ?? 0));
        $student  = Student::fromInput($_POST, $existing->id);
        $errors   = $this->validator->validate($student);

        if ($errors) {
            $this->renderForm($student, $errors, 'update', 'Edit Student');
            return;
        }

        $this->repo->update($student);
        $this->redirectWith('Student updated successfully.');
    }

    /** DELETE action */
    public function destroy(): void
    {
        $this->guardPost();
        $student = $this->findOrFail((int) ($_POST['id'] ?? 0));
        $this->repo->delete($student->id);
        $this->redirectWith('Student deleted.');
    }

    // ---------- helpers ----------

    private function renderForm(Student $student, array $errors, string $action, string $title): void
    {
        View::render('students/form', compact('student', 'errors', 'action', 'title'));
    }

    private function findOrFail(int $id): Student
    {
        $student = $id > 0 ? $this->repo->find($id) : null;
        if (!$student) {
            http_response_code(404);
            View::render('404');
            exit;
        }
        return $student;
    }

    private function guardPost(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !Session::verifyCsrf($_POST['_token'] ?? null)) {
            http_response_code(419);
            exit('Invalid or expired request. Go back and try again.');
        }
    }

    private function redirectWith(string $message): void
    {
        Session::flash('success', $message);
        header('Location: index.php');
        exit;
    }
}
