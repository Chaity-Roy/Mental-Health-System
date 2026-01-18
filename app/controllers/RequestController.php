<?php
/**
 * Request Controller
 * Handles counseling request operations
 */

class RequestController extends Controller
{
    private $requestModel;
    private $notificationModel;

    public function __construct()
    {
        $this->requestModel = $this->model('Request');
        $this->notificationModel = $this->model('Notification');
    }

    /**
     * Default index - redirect to create
     */
    public function index()
    {
        $this->redirect('request/create');
    }

    /**
     * Create new request
     */
    public function create()
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $subject = trim($_POST['subject']);
            $description = trim($_POST['description']);
            $is_anonymous = isset($_POST['is_anonymous']) ? 'yes' : 'no';

            $errors = [];

            if (empty($subject)) {
                $errors['subject'] = 'Subject is required';
            }

            if (empty($description)) {
                $errors['description'] = 'Description is required';
            }

            if (empty($errors)) {
                $data = [
                    'user_id' => $_SESSION['user_id'],
                    'subject' => $subject,
                    'description' => $description,
                    'is_anonymous' => $is_anonymous
                ];

                if ($this->requestModel->create($data)) {
                    $this->flash('request_success', 'Request submitted successfully!', 'success');
                    $this->redirect('request/my-requests');
                } else {
                    $errors['create'] = 'Failed to submit request. Please try again.';
                }
            }

            $data = [
                'title' => 'Submit Request',
                'subject' => $subject,
                'description' => $description,
                'is_anonymous' => $is_anonymous,
                'errors' => $errors
            ];
        } else {
            $data = [
                'title' => 'Submit Request',
                'subject' => '',
                'description' => '',
                'is_anonymous' => 'no',
                'errors' => []
            ];
        }

        $this->view('request/create', $data);
    }

    /**
     * View user's requests
     */
    public function myRequests()
    {
        $this->requireLogin();

        $user_id = $_SESSION['user_id'];
        $requests = $this->requestModel->getUserRequests($user_id);

        $data = [
            'title' => 'My Requests',
            'requests' => $requests
        ];

        $this->view('request/my-requests', $data);
    }

    /**
     * View single request
     */
    public function viewRequest($request_id)
    {
        $this->requireLogin();

        $request = $this->requestModel->getById($request_id);

        if (!$request) {
            $this->flash('error', 'Request not found', 'danger');
            $this->redirect('request/my-requests');
            return;
        }

        // Check authorization
        if (!$this->isAdmin() && $request['user_id'] != $_SESSION['user_id']) {
            $this->flash('error', 'Unauthorized access', 'danger');
            $this->redirect('request/my-requests');
            return;
        }

        $data = [
            'title' => 'View Request',
            'request' => $request
        ];

        $this->view('request/view', $data);
    }
}
?>