<?php

class Like_model extends CI_Emerald_Model
{
    const CLASS_TABLE = 'likes';

    /** @var int */
    protected $user_id;
    /** @var int */
    protected $assing_id;
    /** @var string */
    protected $type;

    /** @var string */
    protected $time_created;
    /** @var string */
    protected $time_updated;

    public static $types = ['post', 'comment'];

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
     * @return string
     */
    public function get_type(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return bool
     */
    public function set_type(string $type)
    {
        $this->type = $type;
        return $this->save('type', $type);
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

    public static function create(array $data)
    {
        App::get_ci()->s->from(self::CLASS_TABLE)->insert($data)->execute();
        return new static(App::get_ci()->s->get_insert_id());
    }

    public static function get_count_by_id(int $id, string $type)
    {
        $likes = App::get_ci()
            ->s
            ->from(self::CLASS_TABLE)
            ->where([
               'assign_id' => $id,
               'type'   => $type
            ])
            ->many();

        return count($likes);
    }
}