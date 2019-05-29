<?php

require_once("util.php");

/**
 * Iterator
 */

/**
 * 集合体インターフェース
 *
 * Interface IAggregater
 */
interface IAggregater
{
    public function order_iterator();

    public function reverse_iterator();
}


/**
 * アルファベット
 *
 * Class Alphabet
 */
class Alphabet
{
    private $alphabet;

    public function __construct(string $alphabet)
    {
        $this->alphabet = $alphabet;
    }

    public function get_alphabet()
    {
        return $this->alphabet;
    }
}


/**
 * アルファベットリスト
 *
 * Class Alphabet_List
 */
class Alphabet_List implements IAggregater
{
    private $alphabet_list = [];

    /**
     * アルファベット追加
     *
     * @param Alphabet $alphabet
     */
    public function add_list(Alphabet $alphabet)
    {
        $this->alphabet_list[] = $alphabet;
    }

    /**
     * リストからアルファベット取得
     *
     * @param $index
     *
     * @return mixed
     */
    public function get_alphabet_by_index($index)
    {
        return $this->alphabet_list[ $index ];
    }

    /**
     * リストの長さ取得
     *
     * @return int
     */
    public function get_list_length()
    {
        return count($this->alphabet_list);
    }

    /**
     * 順走イテレータ生成
     *
     * @return Order_Iterator
     */
    public function order_iterator()
    {
        return new Order_Iterator($this);
    }

    /**
     * 逆走イテレータ生成
     *
     * @return Reverse_Iterator
     */
    public function reverse_iterator()
    {
        return new Reverse_Iterator($this);
    }
}


/**
 * イテレータインターフェース
 *
 * Interface IIterator
 */
interface IIterator
{
    public function hasNext();

    public function next();
}


/**
 * 順走イテレータ
 *
 * Class Order_Iterator
 */
class Order_Iterator implements IIterator
{
    private $aggregate;
    private $index = 0;

    public function __construct($aggregate)
    {
        $this->aggregate = $aggregate;
    }

    public function hasNext()
    {
        if ($this->index < $this->aggregate->get_list_length()) {
            return true;
        }

        return false;
    }

    public function next()
    {
        $alphabet = $this->aggregate->get_alphabet_by_index($this->index);
        $this->index++;

        return $alphabet;
    }
}

/**
 * 逆走イテレータ
 *
 * Class Reverse_Iterator
 */
class Reverse_Iterator implements IIterator
{
    private $aggregate;
    private $index = 0;

    public function __construct($aggregate)
    {
        $this->aggregate = $aggregate;
        $this->index = $this->aggregate->get_list_length() - 1;
    }

    public function hasNext()
    {
        return ($this->index >= 0);
    }

    public function next()
    {
        $alphabet = $this->aggregate->get_alphabet_by_index($this->index);
        $this->index--;

        return $alphabet;
    }
}


// テストデータ挿入[A->G]
$alphabet_list = new Alphabet_List();
$alphabet_data = range('A', 'G');
foreach ($alphabet_data as $alphabet) {
    $alphabet_list->add_list(new Alphabet($alphabet));
}

Util::echo('[順走イテレータ]');
$order_iterator = $alphabet_list->order_iterator();
while ($order_iterator->hasNext()) {
    Util::echo(Util::color($order_iterator->next()->get_alphabet(), Util::CYAN));
}

Util::echo();

Util::echo('[逆走イテレータ]');
$reverse_iterator = $alphabet_list->reverse_iterator();
while ($reverse_iterator->hasNext()) {
    Util::echo(Util::color($reverse_iterator->next()->get_alphabet(), Util::YELLOW));
}