<?php
/**
 * Home Controller
 * Handles home page and public pages
 */

class HomeController extends Controller
{

    /**
     * Show home page
     */
    public function index()
    {
        $data = [
            'title' => 'Home'
        ];

        $this->view('home/index', $data);
    }

    /**
     * About page
     */
    public function about()
    {
        $data = [
            'title' => 'About Us'
        ];

        $this->view('home/about', $data);
    }
}
?>