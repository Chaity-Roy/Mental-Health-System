<?php
/**
 * Resource Controller
 * Handles public resource viewing
 */

class ResourceController extends Controller
{
    private $resourceModel;

    public function __construct()
    {
        $this->resourceModel = $this->model('Resource');
    }

    /**
     * View all published resources
     */
    public function index()
    {
        $resources = $this->resourceModel->getPublished();

        $data = [
            'title' => 'Mental Health Resources',
            'resources' => $resources
        ];

        $this->view('resource/index', $data);
    }

    /**
     * View single resource
     */
    public function viewResource($resource_id)
    {
        $resource = $this->resourceModel->getById($resource_id);

        if (!$resource || $resource['status'] !== 'published') {
            $this->flash('error', 'Resource not found', 'danger');
            $this->redirect('resource/index');
            return;
        }

        $data = [
            'title' => $resource['title'],
            'resource' => $resource
        ];

        $this->view('resource/view', $data);
    }
}
?>