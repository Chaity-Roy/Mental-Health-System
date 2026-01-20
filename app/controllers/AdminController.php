<?php
/**
 * Admin Controller
 * Handles admin dashboard and management
 */

class AdminController extends Controller
{
    private $userModel;
    private $requestModel;
    private $resourceModel;
    private $feedbackModel;
    private $notificationModel;

    public function __construct()
    {
        $this->userModel = $this->model('User');
        $this->requestModel = $this->model('Request');
        $this->resourceModel = $this->model('Resource');
        $this->feedbackModel = $this->model('Feedback');
        $this->notificationModel = $this->model('Notification');
    }

    /**
     * Admin Dashboard
     */
    public function dashboard()
    {
        $this->requireAdmin();

        // Get statistics
        $userStats = $this->userModel->getUserStats();
        $requestStats = $this->requestModel->getRequestStats();
        $resourceCount = $this->resourceModel->getCount('published');
        $feedbackCount = $this->feedbackModel->getCount();

        // Get recent data
        $recentRequests = $this->requestModel->getAllRequests(null, 5);
        $recentUsers = $this->userModel->getAllUsers('user');
        $recentUsers = array_slice($recentUsers, 0, 5);

        $data = [
            'title' => 'Admin Dashboard',
            'userStats' => $userStats,
            'requestStats' => $requestStats,
            'resourceCount' => $resourceCount,
            'feedbackCount' => $feedbackCount,
            'recentRequests' => $recentRequests,
            'recentUsers' => $recentUsers
        ];

        $this->view('admin/dashboard', $data);
    }

    /**
     * Manage Users
     */
    public function users()
    {
        $this->requireAdmin();

        $users = $this->userModel->getAllUsers('user');

        $data = [
            'title' => 'Manage Users',
            'users' => $users
        ];

        $this->view('admin/users', $data);
    }

    /**
     * Block user
     */
    public function blockUser($user_id)
    {
        $this->requireAdmin();

        if ($this->userModel->updateStatus($user_id, 'blocked')) {
            $this->flash('success', 'User blocked successfully', 'success');
        } else {
            $this->flash('success', 'Failed to block user', 'danger');
        }
        
        $this->redirect('admin/users');
    }

    /**
     * Activate user
     */
    public function activateUser($user_id)
    {
        $this->requireAdmin();

        if ($this->userModel->updateStatus($user_id, 'active')) {
            $this->flash('success', 'User activated successfully', 'success');
        } else {
            $this->flash('success', 'Failed to activate user', 'danger');
        }
        
        $this->redirect('admin/users');
    }

    /**
     * Toggle user status (AJAX)
     */
    public function toggleUserStatus($user_id)
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user = $this->userModel->findById($user_id);

            if ($user) {
                $newStatus = $user['status'] === 'active' ? 'blocked' : 'active';

                if ($this->userModel->updateStatus($user_id, $newStatus)) {
                    echo json_encode(['success' => true, 'status' => $newStatus]);
                } else {
                    echo json_encode(['success' => false]);
                }
            } else {
                echo json_encode(['success' => false]);
            }
            exit;
        }
    }

    /**
     * Manage Requests
     */
    public function requests()
    {
        $this->requireAdmin();

        $status = isset($_GET['status']) ? $_GET['status'] : null;
        $requests = $this->requestModel->getAllRequests($status);

        $data = [
            'title' => 'Manage Requests',
            'requests' => $requests,
            'currentStatus' => $status
        ];

        $this->view('admin/requests', $data);
    }

    /**
     * View and respond to request
     */
    public function viewRequest($request_id)
    {
        $this->requireAdmin();

        $request = $this->requestModel->getById($request_id);

        if (!$request) {
            $this->flash('error', 'Request not found', 'danger');
            $this->redirect('admin/requests');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $status = $_POST['status'];
            $admin_response = trim($_POST['admin_response']);

            if ($this->requestModel->updateStatus($request_id, $status, $admin_response)) {
                // Send notification to user
                if ($request['user_id']) {
                    $notificationData = [
                        'user_id' => $request['user_id'],
                        'title' => 'Request Updated',
                        'message' => "Your request '{$request['subject']}' has been updated to: " . ucfirst($status)
                    ];
                    $this->notificationModel->create($notificationData);
                }

                $this->flash('request_success', 'Request updated successfully', 'success');
                $this->redirect('admin/requests');
            } else {
                $data['error'] = 'Failed to update request';
            }
        }

        $data = [
            'title' => 'View Request',
            'request' => $request
        ];

        $this->view('admin/view-request', $data);
    }

    /**
     * Manage Resources
     */
    public function resources()
    {
        $this->requireAdmin();

        $resources = $this->resourceModel->getAll();

        $data = [
            'title' => 'Manage Resources',
            'resources' => $resources
        ];

        $this->view('admin/resources', $data);
    }

    /**
     * Create Resource
     */
    public function createResource()
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = trim($_POST['title']);
            $content = trim($_POST['content']);
            $category = trim($_POST['category']);
            $status = $_POST['status'];

            $errors = [];

            if (empty($title)) {
                $errors['title'] = 'Title is required';
            }

            if (empty($content)) {
                $errors['content'] = 'Content is required';
            }

            if (empty($category)) {
                $errors['category'] = 'Category is required';
            }

            if (empty($errors)) {
                $data = [
                    'title' => $title,
                    'content' => $content,
                    'category' => $category,
                    'created_by' => $_SESSION['user_id'],
                    'status' => $status
                ];

                if ($this->resourceModel->create($data)) {
                    $this->flash('resource_success', 'Resource created successfully', 'success');
                    $this->redirect('admin/resources');
                } else {
                    $errors['create'] = 'Failed to create resource';
                }
            }

            $data = [
                'title' => 'Create Resource',
                'resource_title' => $title,
                'content' => $content,
                'category' => $category,
                'status' => $status,
                'errors' => $errors
            ];
        } else {
            $data = [
                'title' => 'Create Resource',
                'resource_title' => '',
                'content' => '',
                'category' => '',
                'status' => 'draft',
                'errors' => []
            ];
        }

        $this->view('admin/create-resource', $data);
    }

    /**
     * Delete Resource
     */
    public function deleteResource($resource_id)
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->resourceModel->delete($resource_id)) {
                $this->flash('resource_success', 'Resource deleted successfully', 'success');
            } else {
                $this->flash('error', 'Failed to delete resource', 'danger');
            }
            $this->redirect('admin/resources');
        }
    }

    /**
     * View Feedback
     */
    public function feedback()
    {
        $this->requireAdmin();

        $feedbacks = $this->feedbackModel->getAll();

        $data = [
            'title' => 'User Feedback',
            'feedbacks' => $feedbacks
        ];

        $this->view('admin/feedback', $data);
    }
}
?>