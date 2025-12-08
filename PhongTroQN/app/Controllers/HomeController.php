<?php
// app/Controllers/HomeController.php

class HomeController
{
    public function index()
    {
        $postModel = new Post();
        
        $posts      = $postModel->getActivePosts();
        $totalPosts = $postModel->countActivePosts();

        // Gửi dữ liệu sang View
        view('home/index', [
            'posts'      => $posts,
            'totalPosts' => $totalPosts
        ]);
    }
}