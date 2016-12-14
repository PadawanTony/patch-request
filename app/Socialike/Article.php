<?php declare(strict_types = 1);
/**
 * User: antony
 * Date: 12/14/16
 * Time: 7:52 PM
 */

namespace App\Socialike;


use App\Socialike\Model\Model;

class Article extends Model
{
    const TABLE = 'articles';
    public $title;
    public $summary;
    public $body;

    /**
     * Get the columns of the table.
     *
     * @return mixed
     */
    public static function columns ()
    {
        return [
            'title',
            'summary',
            'body'
        ];
    }

    public function body ()
    {
        return $this->body;
    }

    public function title ()
    {
        return $this->title;
    }

    public function summary ()
    {
        return $this->summary;
    }
}