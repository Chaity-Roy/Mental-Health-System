<?php
/**
 * Feedback Controller
 * Handles user feedback operations
 */

class FeedbackController extends Controller
{
    private $feedbackModel;

    public function __construct()
    {
        $this->feedbackModel = $this->model('Feedback');
    }

    /**
     * Create feedback
     */
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $message = trim($_POST['message']);
            $is_anonymous = isset($_POST['is_anonymous']) ? true : false;

            $errors = [];

            if (empty($message)) {
                $errors['message'] = 'Message is required';
            }

            if (empty($errors)) {
                $data = [
                    'user_id' => ($is_anonymous || !$this->isLoggedIn()) ? null : $_SESSION['user_id'],
                    'message' => $message
                ];

                if ($this->feedbackModel->create($data)) {
                    $this->flash('feedback_success', 'Thank you for your feedback!', 'success');
                    if ($this->isLoggedIn()) {
                        $this->redirect('user/dashboard');
                    } else {
                        $this->redirect('');
                    }
                } else {
                    $errors['create'] = 'Failed to submit feedback. Please try again.';
                }
            }

            $data = [
                'title' => 'Submit Feedback',
                'message' => $message,
                'errors' => $errors
            ];
        } else {
            $data = [
                'title' => 'Submit Feedback',
                'message' => '',
                'errors' => []
            ];
        }

        $this->view('feedback/create', $data);
    }
}
?>