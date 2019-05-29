<?php

require_once("util.php");

/**
 * Template Method
 */

/**
 * ゲーム抽象クラス
 *
 * Class Abstract_Game
 */
abstract class Abstract_Game
{
    const GAME_STATUS_DEFAULT = 0;
    const GAME_STATUS_PLAYING = 1;
    const GAME_STATUS_CLEAR   = 2;
    const GAME_STATUS_OVER    = 3;

    private $game_status;

    public function __construct()
    {
        $this->game_status = self::GAME_STATUS_DEFAULT;
    }

    /**
     * 実行
     */
    public function execute()
    {
        // 初期化
        $this->initialize();
        while ($this->game_status === self::GAME_STATUS_PLAYING) {
            // 更新
            $this->update();
            // 描画
            $this->draw();
        }
        // 後処理
        $this->finalize();
    }

    protected function set_game_status(int $game_status)
    {
        $this->game_status = $game_status;
    }

    protected function get_game_status()
    {
        return $this->game_status;
    }

    protected abstract function initialize();

    protected abstract function update();

    protected abstract function draw();

    protected abstract function finalize();

}


/**
 * ゲーム1クラス(10回ループ)
 *
 * Class Game1
 */
class Game1 extends Abstract_Game
{
    private $loop_count;
    private $current_loop_count;

    protected function initialize()
    {
        // ゲーム開始設定
        $this->set_game_status(parent::GAME_STATUS_PLAYING);

        // ループ回数
        $this->loop_count = 10;
        // 現在のループ回数
        $this->current_loop_count = 0;

        Util::echo(Util::color(__FUNCTION__, Util::PURPLE));
    }

    protected function update()
    {
        $this->current_loop_count++;

        //Util::echo(Util::color(__FUNCTION__, Util::LIGHT_GREEN));
    }

    protected function draw()
    {
        //Util::echo(Util::color(__FUNCTION__, Util::YELLOW));

        // 現在のループ回数表示
        Util::echo($this->current_loop_count);

        if ($this->current_loop_count >= $this->loop_count) {
            $this->set_game_status(parent::GAME_STATUS_CLEAR);
        }
    }

    protected function finalize()
    {
        Util::echo(Util::color(__FUNCTION__, Util::CYAN));
    }

}


/**
 * ゲーム2クラス([a~g]→g, [1~3]→2 がヒットするまでループ)
 *
 * Class Game2
 */
class Game2 extends Abstract_Game
{
    private $alphabet_array;
    private $number_array;
    private $string;

    protected function initialize()
    {
        // ゲーム開始設定
        $this->set_game_status(parent::GAME_STATUS_PLAYING);

        // [ a, b, c, d, e, f, g ]
        $this->alphabet_array = range('a', 'g');
        // [ 1, 2, 3 ]
        $this->number_array = range(1, 3);
        $this->string = '';

        Util::echo(Util::color(__FUNCTION__, Util::PURPLE));
    }

    protected function update()
    {
        $alphabet_key = array_rand($this->alphabet_array);
        $number_key = array_rand($this->number_array);
        $this->string = $this->alphabet_array[ $alphabet_key ] . $this->number_array[ $number_key ];

        //Util::echo(Util::color(__FUNCTION__, Util::LIGHT_GREEN));
    }

    protected function draw()
    {
        // 文字列表示
        Util::echo(Util::color($this->string, Util::LIGHT_GREEN));

        //Util::echo(Util::color(__FUNCTION__, Util::YELLOW));

        if ($this->string === 'g2') {
            $this->set_game_status(parent::GAME_STATUS_CLEAR);
        }
    }

    protected function finalize()
    {
        Util::echo(Util::color(__FUNCTION__, Util::CYAN));
    }

}


// 呼び出し
$game = new Game1();
$game1 = new Game2();

$game->execute();
$game1->execute();