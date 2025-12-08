<?php
class AdminController
{
    public function index()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
            redirect('/');
            exit;
        }

        return view('admin/index');
    }
}