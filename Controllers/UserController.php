<?php
require_once ROOT_PATH.'Controllers/Controller.php';
require_once ROOT_PATH.'Models/User.php';
class UserController extends Controller
{
    public function logIn(){
        if(is_numeric($this->getAuth())){
            // ログイン中の場合はトップページへリダイレクト
            header('Location: /');
        }

        $this->view('user/login');
    }

    public function signUp(){
        if(is_numeric($this->getAuth())){
            // ログイン中の場合はトップページへリダイレクト
            header('Location: /');
        }

        $this->view('user/signup');
    }

    public function create(){
        $errorMessages = [];

        if(empty($_POST['name'])){
            $errorMessages['name'] = '氏名を入力してください。';
        }

        if(empty($_POST['kana'])){
            $errorMessages['kana'] = 'ふりがなを入力してください。';
        }

        if(empty($_POST['email'])){
            $errorMessages['email'] = 'メールアドレスを入力してください。';
        }

        if(empty($_POST['password'])){
            $errorMessages['password'] = 'パスワードを入力してください';
        }

        if($_POST['password'] !== $_POST['password-confirmation']){
            $errorMessages['password-confirmation'] = '確認用パスワードが正しくありません。';
        }

        if(!empty($errorMessages)){
            // バリデーション失敗
            $this->view('user/signup', ['post' => $_POST, 'errorMessages' => $errorMessages]);
        }else{
            //登録処理
            $user = new User;
            $result = $user->createUser(
                $_POST['name'],
                $_POST['kana'],
                $_POST['email'],
                $_POST['password']
            );

            if(is_numeric($result)){
                session_start();
                $_SESSION['auth'] = $result;

                $this->view('user/create-complete', ['auth' => $result]);
            }else{
                $errorMessages['email'] = 'メールアドレスが既に使用されています。';
                $this->view('user/signup', ['post' => $_POST, 'errorMessages' => $errorMessages]);
            }
        }
    }

    public function certification(){
        $errorMessages = [];
        if(empty($_POST['email'])){
            $errorMessages['email'] = 'メールアドレスを入力してください。';
        }

        if(empty($_POST['password'])){
            $errorMessages['password'] = 'パスワードを入力してください';
        }

        if(!empty($errorMessages)){
            // バリデーション失敗
            $this->view('user/login', ['post' => $_POST, 'errorMessages' => $errorMessages]);
        }else{
            //登録処理
            $user = new User;
            $result = $user->certification(
                $_POST['email'],
                $_POST['password']
            );

            if(is_array($result)){
                session_start();
                $_SESSION['auth'] = $result['id'];
                header("Location: /");
            }else{
                $errorMessages['auth'] = 'メールアドレスまたはパスワードが誤っています。';
                $this->view('user/login', ['post' => $_POST, 'errorMessages' => $errorMessages]);
            }
        }
    }

    public function logOut(){
        session_start();
        $_SESSION['auth'] = false;
        header('Location: /');
    }

    public function myPage(){
        session_start();
        $userId = $_SESSION['auth'] ?? false;
        if($userId === false){
            header('Location: /');
        }


        $user = new User;
        $result = $user->getMyPage($userId);
        error_log(json_encode($result));
        $this->view('user/mypage', ['data' => $result, 'auth' => $userId]);
    }

    public function edit(){
        session_start();
        $userId = $_SESSION['auth'] ?? false;
        if($userId === false){
            header('Location: /');
        }

        $user = new User;
        $result = $user->getMyPage($userId);
        $this->view('user/edit', ['data' => $result, 'auth' => $userId]);
    }

    public function update(){
        $errorMessages = [];

        $userId = $this->getAuth();
        if($userId === false){
            // ログイン中の場合はトップページへリダイレクト
            header('Location: /');
        }

        if(empty($_POST['name'])){
            $errorMessages['name'] = '氏名を入力してください。';
        }

        if(empty($_POST['kana'])){
            $errorMessages['kana'] = 'ふりがなを入力してください。';
        }

        if(empty($_POST['email'])){
            $errorMessages['email'] = 'メールアドレスを入力してください。';
        }

        if(empty($_POST['password'])) {
            // passwordが空の場合はpasswordを更新しないためバリデーションをチェックしない
        }else{
            if($_POST['password'] !== $_POST['password-confirmation']){
                $errorMessages['password-confirmation'] = '確認用パスワードが正しくありません。';
            }
        }

        if(!empty($errorMessages)){
            // バリデーション失敗
            $this->view('user/edit', ['post' => $_POST, 'errorMessages' => $errorMessages]);
        }else{
            // 更新処理
            $user = new User;
            $result = $user->updateUser(
                $userId,
                $_POST['name'],
                $_POST['kana'],
                $_POST['email'],
                $_POST['password']
            );

            if($result === true){
                header('Location: /user/my-page');
            }else{
                $errorMessages['email'] = 'メールアドレスが既に使用されています。';
                $this->view('user/edit', ['post' => $_POST, 'errorMessages' => $errorMessages, 'auth' => $userId]);
            }
        }
    }

    public function delete(){
        session_start();
        $userId = $_SESSION['auth'] ?? false;
        if($userId === false){
            header('Location: /');
        }
        $user = new User;
        $user->deleteUserAccount($userId);
        $_SESSION['auth'] = false;
        header('Location: /');
    }

    /**
     * ログイン状態を取得する
     * @return string|false ログイン状態の場合はuserId  未ログイン状態の場合はfalseを返却する
     */
    public function getAuth(){
        session_start();
        return $_SESSION['auth'] ?? false;
    }
}