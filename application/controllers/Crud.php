<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Crud extends CI_Controller
{

    public function index()
    {
        $this->load->view('crud');
    }
}