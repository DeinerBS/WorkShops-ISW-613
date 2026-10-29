<?php

require_once __DIR__ . '/../models/Course.php';
require_once __DIR__ . '/../models/Career.php';

class CourseController extends Controller
{
    public function __construct(PDO $conn)
    {
        parent::__construct($conn);

        requireLogin();
    }

    // Lista de cursos (GET)
    public function index()
    {
        $courseModel = new Course($this->conn);

        $this->render('courses/index', [
            'title' => 'Cursos',
            'courses' => $courseModel->all(),
        ]);
    }

    // Formulario para crear un curso
    public function create()
    {
        $careerModel = new Career($this->conn);

        $this->render('courses/form', [
            'title' => 'Crear Curso',
            'course' => null,
            'careers' => $careerModel->all(),
        ]);
    }

    // Guarda un curso nuevo (POST)
    public function store()
    {
        $result = $this->validate();

        if (isset($result['error'])) {
            redirect('courses/create', ['error' => $result['error']]);
        }

        try {
            $courseModel = new Course($this->conn);
            $courseModel->create($result['data']);
        } catch (PDOException $exception) {
            if ($exception->getCode() === '23000') {
                redirect('courses/create', ['error' => 'course_code_taken']);
            }

            error_log('Create course database error: ' . $exception->getMessage());
            redirect('courses/create', ['error' => 'server_error']);
        }

        // Curso creado
        redirect('courses', ['success' => 'course_created']);
    }

    // Formulario para editar un curso: /index.php?route=courses/edit&id=3
    public function edit()
    {
        $courseId = $_GET['id'] ?? null;

        if (!is_string($courseId) || !ctype_digit($courseId)) {
            redirect('courses', ['error' => 'invalid_course']);
        }

        $courseModel = new Course($this->conn);
        $course = $courseModel->find((int) $courseId);

        if ($course === false) {
            redirect('courses', ['error' => 'course_not_found']);
        }

        $careerModel = new Career($this->conn);

        $this->render('courses/form', [
            'title' => 'Editar Curso',
            'course' => $course,
            'careers' => $careerModel->all(),
        ]);
    }

    // Guarda los cambios de un curso 
    public function update()
    {
        $courseId = $_POST['id'] ?? null;

        if (!is_string($courseId) || !ctype_digit($courseId)) {
            redirect('courses', ['error' => 'invalid_course']);
        }

        $courseId = (int) $courseId;
        $courseModel = new Course($this->conn);

        try {
            if ($courseModel->find($courseId) === false) {
                redirect('courses', ['error' => 'course_not_found']);
            }

            $result = $this->validate();

            if (isset($result['error'])) {
                redirect('courses/edit', ['id' => $courseId, 'error' => $result['error']]);
            }

            $courseModel->update($courseId, $result['data']);
        } catch (PDOException $exception) {
            if ($exception->getCode() === '23000') {
                redirect('courses/edit', ['id' => $courseId, 'error' => 'course_code_taken']);
            }

            error_log('Update course database error: ' . $exception->getMessage());
            redirect('courses/edit', ['id' => $courseId, 'error' => 'server_error']);
        }

        redirect('courses', ['success' => 'course_updated']);
    }

    // Elimina un curso. El index.php rechaza cualquier otro método
    public function delete()
    {
        $courseId = $_POST['id'] ?? null;

        if (!is_string($courseId) || !ctype_digit($courseId)) {
            redirect('courses', ['error' => 'invalid_course']);
        }

        try {
            $courseModel = new Course($this->conn);
            $deleted = $courseModel->delete((int) $courseId);
        } catch (PDOException $exception) {
            error_log('Delete course database error: ' . $exception->getMessage());
            redirect('courses', ['error' => 'server_error']);
        }

        if ($deleted === 0) {
            redirect('courses', ['error' => 'course_not_found']);
        }

        redirect('courses', ['success' => 'course_deleted']);
    }

    // Revisa y limpia los datos del formulario.
    // Devuelve ['data' => [...]] si todo está bien, o ['error' => 'codigo'] si no.
    private function validate()
    {
        $name = $_POST['name'] ?? null;
        $code = $_POST['code'] ?? null;
        $careerId = $_POST['career_id'] ?? null;
        $credits = $_POST['credits'] ?? null;
        $description = $_POST['description'] ?? '';

        if (
            !is_string($name)
            || !is_string($code)
            || !is_string($careerId)
            || !is_string($credits)
            || !is_string($description)
        ) {
            return ['error' => 'invalid_course_input'];
        }

        $name = trim($name);
        $code = mb_strtoupper(trim($code));
        $description = trim($description);

        if (
            $name === ''
            || mb_strlen($name) > 100
            || $code === ''
            || mb_strlen($code) > 20
            || mb_strlen($description) > 1000
            || !ctype_digit($credits)
            || (int) $credits < 1
            || (int) $credits > 20
        ) {
            return ['error' => 'invalid_course_input'];
        }

        $careerModel = new Career($this->conn);
        if (!ctype_digit($careerId) || $careerModel->find((int) $careerId) === false) {
            return ['error' => 'invalid_career'];
        }

        return [
            'data' => [
                'name' => $name,
                'code' => $code,
                'career_id' => (int) $careerId,
                'credits' => (int) $credits,
                'description' => $description === '' ? null : $description,
            ],
        ];
    }
}