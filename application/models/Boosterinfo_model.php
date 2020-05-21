<?php

class Boosterinfo_model extends CI_Emerald_Model
{
    const CLASS_TABLE = 'boosterinfo';

    /** @var int */
    protected $user_id;
    /** @var int */
    protected $boosterpack_id;

    /** @var float */
    protected $price;
    /** @var int */
    protected $likes;

    /** @var string */
    protected $time_created;
    /** @var string */
    protected $time_updated;

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
    public function get_boosterpack_id(): int
    {
        return $this->boosterpack_id;
    }

    /**
     * @param int $boosterpack_id
     *
     * @return bool
     */
    public function set_boosterpack_id(int $boosterpack_id)
    {
        $this->boosterpack_id = $boosterpack_id;
        return $this->save('boosterpack_id', $boosterpack_id);
    }

    /**
     * @return int
     */
    public function get_likes(): int
    {
        return $this->likes;
    }

    /**
     * @param int $likes
     *
     * @return bool
     */
    public function set_likes(int $likes)
    {
        $this->likes = $likes;
        return $this->save('likes', $likes);
    }

    /**
     * @return float
     */
    public function get_price(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     *
     * @return bool
     */
    public function set_price(float $price)
    {
        $this->price = $price;
        return $this->save('price', $price);
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
    public function set_time_updated(string $time_updated)
    {
        $this->time_updated = $time_updated;
        return $this->save('time_updated', $time_updated);
    }

    public static function create(array $data)
    {
        App::get_ci()->s->from(self::CLASS_TABLE)->insert($data)->execute();
        return new static(App::get_ci()->s->get_insert_id());
    }

    public static function get_for_user($user_id)
    {
        return App::get_ci()
            ->s
            ->from(self::CLASS_TABLE)
            ->where([
                'user_id' => $user_id
            ])
            ->orderBy('time_created','DESC')
            ->many();
    }
}