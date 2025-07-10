<?php

class UserController
{
    public function index()
    {
        header('Location: index.php?c=ProdukController&m=index');
        exit;
    }

    public function login()
    {
        if (isset($_SESSION['user'])) {
            header('Location: index.php?c=ProdukController&m=index');
            exit;
        }

        include 'views/template/header.php';
        include 'views/user/login.php';
        include 'views/template/footer.php';
    }

    public function register()
    {
        include 'views/template/header.php';
        include 'views/user/register.php';
        include 'views/template/footer.php';
    }

    public function doRegister()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once 'models/User.php';

            $username = trim(strip_tags($_POST['username']));
            $nama     = trim(strip_tags($_POST['nama']));
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $role     = 'user';

            $userModel = new User();

            if ($userModel->getByUsername($username)) {
                $_SESSION['error'] = "Username sudah digunakan!";
                header('Location: index.php?c=UserController&m=register');
                exit;
            }

            $userModel->create($username, $nama, $password, $role);

            $_SESSION['success'] = "Registrasi berhasil, silakan login.";
            header('Location: index.php?c=UserController&m=login');
            exit;
        }
    }

    public function doLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once 'models/User.php';

            $username = trim(strip_tags($_POST['username']));
            $password = trim($_POST['password']);

            $userModel = new User();
            $user = $userModel->getByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                session_regenerate_id(true);
                $_SESSION['user'] = [
                    'iduser' => $user['iduser'],
                    'username' => $user['username'],
                    'nama' => $user['nama'],
                    'role' => $user['role']
                ];

                header('Location: index.php?c=ProdukController&m=index');
                exit;
            } else {
                $_SESSION['error'] = "Username atau password salah!";
                header('Location: index.php?c=UserController&m=login');
                exit;
            }
        }
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header('Location: index.php?c=UserController&m=login');
        exit;
    }
}
