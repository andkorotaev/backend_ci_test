<?php

/**
 * Created by PhpStorm.
 * User: mr.incognito
 * Date: 10.11.2018
 * Time: 21:36
 */
class Main_page extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        App::get_ci()->load->model('User_model');
        App::get_ci()->load->model('Login_model');
        App::get_ci()->load->model('Post_model');
        App::get_ci()->load->model('Like_model');
        App::get_ci()->load->model('Transaction_model');

        if (is_prod())
        {
            die('In production it will be hard to debug! Run as development environment!');
        }
    }

    public function index()
    {
        $user = User_model::get_user();

        App::get_ci()->load->view('main_page', ['user' => User_model::preparation($user, 'default')]);
    }

    public function get_all_posts()
    {
        $posts =  Post_model::preparation(Post_model::get_all(), 'main_page');
        return $this->response_success(['posts' => $posts]);
    }

    public function get_post($post_id){ // or can be $this->input->post('news_id') , but better for GET REQUEST USE THIS

        $post_id = intval($post_id);

        if (empty($post_id)){
            return $this->response_error(CI_Core::RESPONSE_GENERIC_WRONG_PARAMS);
        }

        try
        {
            $post = new Post_model($post_id);
        } catch (EmeraldModelNoDataException $ex){
            return $this->response_error(CI_Core::RESPONSE_GENERIC_NO_DATA);
        }


        $posts =  Post_model::preparation($post, 'full_info');
        return $this->response_success(['post' => $posts]);
    }


    public function comment()
    {
        $post_id = App::get_ci()->input->post('post_id');
        $message = App::get_ci()->input->post('message');
        $reply_id = intval(App::get_ci()->input->post('reply_id'));

        if (!User_model::is_logged()){
            return $this->response_error(CI_Core::RESPONSE_GENERIC_NEED_AUTH);
        }

        $post_id = intval($post_id);

        if (empty($post_id) || empty($message)){
            return $this->response_error(CI_Core::RESPONSE_GENERIC_WRONG_PARAMS);
        }

        try
        {
            $post = new Post_model($post_id);
        } catch (EmeraldModelNoDataException $ex){
            return $this->response_error(CI_Core::RESPONSE_GENERIC_NO_DATA);
        }

        $data = [
            'user_id' => User_model::get_user()->get_id(),
            'assign_id' => $post->get_id(),
            'text'      => $message
        ];

        if ($reply_id) {
            $data['reply_id'] = $reply_id;
        }

        try
        {
            Comment_model::create($data);
        } catch (EmeraldModelNoDataException $ex){
            return $this->response_error(CI_Core::RESPONSE_GENERIC_NO_DATA);
        }

        $posts =  Post_model::preparation($post, 'full_info');
        return $this->response_success(['post' => $posts]);
    }


    public function login()
    {
        $email = $this->input->post('login');
        $password = $this->input->post('password');

        $user = User_model::get_user_by_email_and_password($email, $password);

        if (empty($user)){
            return $this->response_error(CI_Core::RESPONSE_GENERIC_WRONG_PARAMS);
        }

        Login_model::start_session($user['id']);

        return $this->response_success(['user' => $user['id']]);
    }


    public function logout()
    {
        Login_model::logout();
        redirect(site_url('/'));
    }

    public function add_money(){
        $sum = $this->input->post('sum');

        if (!$sum){
            return $this->response_error(CI_Core::RESPONSE_GENERIC_WRONG_PARAMS);
        }

        $user =  null;
        if (!User_model::is_logged()){
            return $this->response_error(CI_Core::RESPONSE_GENERIC_NEED_AUTH);
        } else {
            $user = User_model::get_user();
        }

        try
        {
            Transaction_model::create([
                'user_id' => $user->get_id(),
                'amount' => $sum,
                'type'  => 'add_money'
            ]);
        } catch (EmeraldModelNoDataException $ex){
            return $this->response_error(CI_Core::RESPONSE_GENERIC_NO_DATA);
        }

        $wallet_balance = $user->get_wallet_balance();
        $wallet_total_refilled = $user->get_wallet_total_refilled();

        $user->set_wallet_balance(round($wallet_balance + $sum, 2));
        $user->set_wallet_total_refilled(round($wallet_total_refilled + $sum, 2));

        return $this->response_success(['amount' => $user->get_wallet_balance()]);
    }

    public function buy_boosterpack(){
        // todo: add money to user logic
        return $this->response_success(['amount' => rand(1,55)]);
    }


    /**
     * Постарался сильно не привязывать лайки к сущностям, вдруг что-то еще в будущем можно будет лайкать :)
     *
     * @return object|string|void
     */
    public function like(){

        $assign_id = $this->input->post('assign_id');
        $type = $this->input->post('type');

        $user =  null;
        if (!User_model::is_logged()){
            return $this->response_error(CI_Core::RESPONSE_GENERIC_NEED_AUTH);
        } else {
            $user = User_model::get_user();
        }

        if (!$user->get_likes()) {
            return $this->response_error(CI_Core::RESPONSE_GENERIC_WRONG_PARAMS);
        }

        if ($class = $this->get_class_by_type($type)) {
            try
            {
                $assign = new $class($assign_id);
            } catch (EmeraldModelNoDataException $ex){
                return $this->response_error(CI_Core::RESPONSE_GENERIC_NO_DATA);
            }
        } else {
            return $this->response_error(CI_Core::RESPONSE_GENERIC_WRONG_PARAMS);
        }

        try
        {
            Like_model::create([
                'user_id' => $user->get_id(),
                'assign_id' => $assign_id,
                'type'  => $type
            ]);
        } catch (EmeraldModelNoDataException $ex){
            return $this->response_error(CI_Core::RESPONSE_GENERIC_NO_DATA);
        }

        $likes = $user->get_likes();
        $user->set_likes(--$likes);

        return $this->response_success([
            'likes' => $assign->get_likes(),
            'type'  => $type,
            'assign_id' => $assign_id
        ]);
    }

    protected function get_class_by_type(string $type)
    {
        switch ($type){
            case 'post':
                return 'Post_model';
            case 'comment':
                return 'Comment_model';
            default:
                return null;
        }
    }

}
