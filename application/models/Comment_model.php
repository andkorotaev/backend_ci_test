<?php

/**
 * Created by PhpStorm.
 * User: mr.incognito
 * Date: 27.01.2020
 * Time: 10:10
 */
class Comment_model extends CI_Emerald_Model
{
    const CLASS_TABLE = 'comment';


    /** @var int */
    protected $user_id;
    /** @var int */
    protected $assing_id;
    /** @var int|NULL */
    protected $reply_id;
    /** @var string */
    protected $text;

    /** @var string */
    protected $time_created;
    /** @var string */
    protected $time_updated;

    // generated
    protected $comments = [];
    protected $user;


    /**
     * @return int
     */
    public function get_user_id(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     *
     * @return bool
     */
    public function set_user_id(int $user_id)
    {
        $this->user_id = $user_id;
        return $this->save('user_id', $user_id);
    }

    /**
     * @return int
     */
    public function get_assing_id(): int
    {
        return $this->assing_id;
    }

    /**
     * @param int $assing_id
     *
     * @return bool
     */
    public function set_assing_id(int $assing_id)
    {
        $this->assing_id = $assing_id;
        return $this->save('assing_id', $assing_id);
    }

    /**
     * @return int|NULL
     */
    public function get_reply_id()
    {
        return $this->reply_id;
    }

    /**
     * @param int|null $reply_id
     *
     * @return bool
     */
    public function set_reply_id($reply_id)
    {
        $this->reply_id = $reply_id;
        return $this->save('reply_id', $reply_id);
    }


    /**
     * @return int
     */
    public function get_likes(): int
    {
        return Like_model::get_count_by_id($this->get_id(), 'comment');
    }

    /**
     * @return string
     */
    public function get_text(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     *
     * @return bool
     */
    public function set_text(string $text)
    {
        $this->text = $text;
        return $this->save('text', $text);
    }


    /**
     * @return string
     */
    public function get_time_created(): string
    {
        return $this->time_created;
    }

    /**
     * @param string $time_created
     *
     * @return bool
     */
    public function set_time_created(string $time_created)
    {
        $this->time_created = $time_created;
        return $this->save('time_created', $time_created);
    }

    /**
     * @return string
     */
    public function get_time_updated(): string
    {
        return $this->time_updated;
    }

    /**
     * @param string $time_updated
     *
     * @return bool
     */
    public function set_time_updated(int $time_updated)
    {
        $this->time_updated = $time_updated;
        return $this->save('time_updated', $time_updated);
    }

    // generated

    /**
     * @return mixed
     */
    public function get_comments()
    {
        return $this->comments;
    }

    /**
     * @param array $comments
     */
    public function set_comments(array $comments)
    {
        $this->comments = $comments;
    }

    /**
     * @return User_model
     */
    public function get_user():User_model
    {
        if (empty($this->user))
        {
            try {
                $this->user = new User_model($this->get_user_id());
            } catch (Exception $exception)
            {
                $this->user = new User_model();
            }
        }
        return $this->user;
    }

    function __construct($id = NULL)
    {
        parent::__construct();

        App::get_ci()->load->model('User_model');
        App::get_ci()->load->model('Like_model');


        $this->set_id($id);
    }

    public function reload(bool $for_update = FALSE)
    {
        parent::reload($for_update);

        return $this;
    }

    public static function create(array $data)
    {
        App::get_ci()->s->from(self::CLASS_TABLE)->insert($data)->execute();
        return new static(App::get_ci()->s->get_insert_id());
    }

    public function delete()
    {
        $this->is_loaded(TRUE);
        App::get_ci()->s->from(self::CLASS_TABLE)->where(['id' => $this->get_id()])->delete()->execute();
        return (App::get_ci()->s->get_affected_rows() > 0);
    }

    /**
     * @param int $assting_id
     * @return self[]
     * @throws Exception
     */
    public static function get_all_by_assign_id(int $assting_id)
    {

        $data = App::get_ci()->s->from(self::CLASS_TABLE)->where(['assign_id' => $assting_id])->orderBy('time_created','ASC')->many();

        return self::comment_tree($data);
    }

    /**
     * Рекурсивная функция, которая получает массив коментариев,
     * которые надо превратить в дерево на основании поля reply_id
     *
     * @param array $data Comments info
     * @param null $reply_id
     * @return array Tree of comments
     */
    protected static function comment_tree(array $data, $reply_id = null)
    {
        $result = [];
        $keys = array_keys(array_column($data, 'reply_id'), $reply_id);

        foreach ($keys as $key) {
            $el = (new self())->set($data[$key]);
            $el->set_comments(self::comment_tree($data, $el->get_id()));
            $result[] = $el;
        }

        return $result;
    }

    /**
     * @param self|self[] $data
     * @param string $preparation
     * @return stdClass|stdClass[]
     * @throws Exception
     */
    public static function preparation($data, $preparation = 'default')
    {
        switch ($preparation)
        {
            case 'full_info':
                return self::_preparation_full_info($data);
            default:
                throw new Exception('undefined preparation type');
        }
    }


    /**
     * @param self[] $data
     * @return stdClass[]
     */
    private static function _preparation_full_info($data)
    {
        $ret = [];

        foreach ($data as $d){
            $o = new stdClass();

            $o->id = $d->get_id();
            $o->text = $d->get_text();
            $o->reply_id = $d->get_reply_id();
            $o->likes = $d->get_likes();

            // Рекурсивная preparation для коментов
            $o->comments = ($comments = $d->get_comments()) ? self::_preparation_full_info($comments) : [];

            $o->time_created = $d->get_time_created();
            $o->time_updated = $d->get_time_updated();

            $o->user = User_model::preparation($d->get_user(),'main_page');

            $ret[] = $o;
        }


        return $ret;
    }



}
