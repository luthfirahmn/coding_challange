<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Payout extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Payout_model');
        $this->load->library('form_validation');
        $this->session->set_flashdata('segment', explode('/', $this->uri->uri_string()));
    }

    public function index()
    {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        } else {
            $all_data = $this->Payout_model->get_all();
            $data = array(
                'judul'         => "Payout",
                'deskripsi'     => "Page",
                'all_data'      => $all_data
            );
        }

        $this->template->load('templates', 'Payout/index', $data);
    }

    public function create()
    {
        if (!$this->ion_auth->logged_in()) {
            // redirect to the login page if not logged in
            redirect('auth/login', 'refresh');
        } elseif (!$this->ion_auth->is_admin()) {
            // redirect to the access error page if not admin
            $data = array(
                'judul' => 'Error',
                'deskripsi' => 'Access'
            );
            $this->template->load('template', 'errors/html/error_access', $data);
        } else {
            $data = array(
                'judul' => 'Payout',
                'deskripsi' => 'Create',
            );
        }
        $this->template->load('template', 'payout/form', $data);
    }


    public function create_action()
    {
        $create_data = $this->Payout_model->create_data($_POST);

        if ($create_data) {
            echo json_encode(['error' => false, 'message' => 'Success Create Data']);
        } else {
            echo json_encode(['error' => true, 'message' => 'Error Create Data']);
        }
    }

    public function update($id)
    {
        if (!$this->ion_auth->logged_in()) {
            // redirect to the login page if not logged in
            redirect('auth/login', 'refresh');
        } elseif (!$this->ion_auth->is_admin()) {
            // redirect to the access error page if not admin
            $data = array(
                'judul' => 'Error',
                'deskripsi' => 'Access'
            );
            $this->template->load('template', 'errors/html/error_access', $data);
        } else {

            $all_data = $this->Payout_model->get_by_id($id);
            $data = array(
                'judul' => 'Payout',
                'deskripsi' => 'Edit',
                'all_data'  => $all_data
            );
        }
        $this->template->load('template', 'payout/form_edit', $data);
    }


    public function get_detail_by_id($id)
    {
        $detail = $this->Payout_model->get_detail_by_id($id);
        echo json_encode(['data' => $detail]);
    }


    public function edit_action()
    {
        $id = $_POST['id'];
        $edit = $this->Payout_model->edit_data($_POST, $id);

        if ($edit) {
            echo json_encode(['error' => false, 'message' => 'Success Edit Data']);
        } else {
            echo json_encode(['error' => true, 'message' => 'Error Edit Data']);
        }
    }


    public function view($id)
    {
        if (!$this->ion_auth->logged_in()) {
            // redirect to the login page if not logged in
            redirect('auth/login', 'refresh');
        } elseif (!$this->ion_auth->is_admin()) {
            // redirect to the access error page if not admin
            $data = array(
                'judul' => 'Error',
                'deskripsi' => 'Access'
            );
            $this->template->load('template', 'errors/html/error_access', $data);
        } else {

            $all_data = $this->Payout_model->get_by_id($id);
            $data = array(
                'judul' => 'Payout',
                'deskripsi' => 'View',
                'all_data'  => $all_data
            );
        }
        $this->template->load('template', 'payout/form_view', $data);
    }

    public function delete($id)
    {

        $delete = $this->Payout_model->delete_data($id);

        if ($delete) {
            $this->session->set_flashdata('message', 'Delete Record Success');
            $this->session->set_flashdata('type', 'success');
            redirect(site_url('payout'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            $this->session->set_flashdata('type', 'error');
            redirect(site_url('payout'));
        }
    }
}