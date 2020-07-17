<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\LeadModel;

class User extends BaseController
{
    public function index()
    {
        $page = 'home';

        $session = session();
        if (!$session->username) {
            return redirect()->to('/login');
        }

        if (!is_file(APPPATH . '/Views/pages/' . $page . '.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
        }

        if ($this->request->getMethod() === 'post') {

            if ($this->validate([
                'search' => 'required'
            ])) {
                $session->setFlashdata('db_message', "");
                $data['search'] = esc($this->request->getVar('search'));

                $model = new LeadModel();
                $result = $model->getLead($data['search']);

                if ($result['status']) {
                    $data['result'] = $result['data'];
                } else {
                    $data['result'] = [];
                }
            }
        }

        $data['title'] = ucfirst($page);

        echo view('templates/header', $data);
        echo view('templates/navbar', $data);
        echo view('pages/' . $page, $data);
        echo view('templates/footer', $data);
    }

    public function login()
    {
        $page = 'login';
        $data['title'] = ucfirst($page);
        $session = session();

        if ($session->username) {
            return redirect()->to('/');
        }

        if (!is_file(APPPATH . '/Views/pages/' . $page . '.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
        }

        if ($this->request->getMethod() === 'post') {
            $session->setFlashdata('db_message', "");
            $data['username'] = esc($this->request->getVar('username'));
            $data['password'] = esc($this->request->getVar('password'));

            if ($this->validate([
                'username' => 'required',
                'password' => 'required'
            ])) {

                $model = new UserModel();
                $result = $model->verifyUser($data['username'], $data['password']);

                if ($result['status']) {
                    $row = $result['data'];
                    $session->set(['username' => $row['username'], 'role' => $row['role']]);
                    return redirect()->to('/');
                } else {
                    $session->setFlashdata('db_message', $result['message']);
                }
            }
        }

        echo view('templates/header', $data);
        echo view('pages/' . $page, $data);
        echo view('templates/footer', $data);
    }

    public function register()
    {
        $page = 'register';
        $data['title'] = ucfirst($page);
        $session = session();

        if ($session->username) {
            return redirect()->to('/');
        }

        if (!is_file(APPPATH . '/Views/pages/' . $page . '.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
        }

        if ($this->request->getMethod() === 'post') {
            $session->setFlashdata('db_message', "");
            $data['username'] = esc($this->request->getVar('username'));
            $data['password'] = esc($this->request->getVar('password'));
            $data['cpassword'] = esc($this->request->getVar('cpassword'));
            $data['role'] = 'general';

            if ($this->validate([
                'username' => 'required',
                'password' => 'required'
            ])) {

                if ($data['password'] === $data['cpassword']) {
                    $model = new UserModel();
                    $result = $model->registerUser(['username' => $data['username'], 'password' => $data['password'], 'role' => $data['role']]);

                    if ($result) {
                        $session->set(['username' => $data['username'], 'role' => $data['role']]);
                        return redirect()->to('/');
                    } else {
                        $session->setFlashdata('db_message', "Something went wrong. Please try again.");
                    }
                } else {
                    $session->setFlashdata('db_message', "Password does not match.");
                }

            }
        }

        echo view('templates/header', $data);
        echo view('pages/' . $page, $data);
        echo view('templates/footer', $data);
    }

    public function logout()
    {
        $session = session();

        $session->destroy();

        return redirect('/');
    }

    public function upload()
    {
        $page = 'upload';
        $data['title'] = ucfirst($page);
        $session = session();

        if ($session->role !== 'admin') {
            return redirect()->to('/');
        }

        if (!is_file(APPPATH . '/Views/pages/' . $page . '.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
        }

        if ($this->request->getMethod() === 'post') {
            $session->setFlashdata('db_message', '');
            $file = $this->request->getFile('file');
            $ext = $file->getClientExtension();
            $tmp = $file->getTempName();

            if (empty($file->getBasename())) {
                $session->setFlashdata('db_message', '<div class="p-2 mb-2 bg-danger text-white">Please upload a CSV file.</div>');
            } else {
                if ($ext !== 'csv') {
                    $session->setFlashdata('db_message', '<div class="p-2 mb-2 bg-danger text-white">Only CSV files are allowed.</div>');
                } else {
                    $file = new \CodeIgniter\Files\File($tmp);

                    $csv = fopen($file, "r");
                    $flag = true;

                    $timestamp = date("Y-m-d H:i:s");
                    $model = new LeadModel();

                    while (($row = fgetcsv($csv)) !== FALSE) {
                        if ($flag) {
                            $flag = false;
                            continue;
                        }
                        if (count($row) < 5) {
                            $row[4] = "";
                        }

                        $model->saveLead($row, $timestamp);
                    }

                    $session->setFlashdata('db_message', '<div class="p-2 mb-2 bg-success text-white">Data saved successfully.</div>');
                }
            }

        }

        echo view('templates/header', $data);
        echo view('templates/navbar', $data);
        echo view('pages/' . $page, $data);
        echo view('templates/footer', $data);
    }
}
