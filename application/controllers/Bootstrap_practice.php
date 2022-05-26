<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bootstrap_practice extends CI_Controller
{

    public function index()
    {
        $this->load->view('bootstrapPractice');
    }
}
