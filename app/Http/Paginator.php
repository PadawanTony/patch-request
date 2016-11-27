<?php
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since  11/18/16
 */

namespace App\Http;

use App\Socialike\Model\Collection;
use App\Socialike\Model\Model;
use Core\Request;
use Core\Route;

/**
 * Class Paginator
 * @package App\Http
 */
class Paginator extends Collection
{
    protected $totalPages;
    protected $page;

    /**
     * Paginator constructor.
     *
     * @param Model  $model
     * @param int    $perPage
     * @param array  $columns
     * @param string $pageName
     * @param int    $page
     */
    public function __construct (Model $model, $perPage = 10, $columns = ['*'], $pageName = 'page', $page = 0)
    {
        $perPage = ($perPage > 100 || $perPage < 1) ? 10 : $perPage;

        $this->page = (int)$page < 1 ? 1 : (int)$page;

        $offset = (int)(($this->page - 1) * $perPage);

        $totalRows = $model->count();

        $this->totalPages = ceil($totalRows / $perPage) + 1;

        parent::__construct(
            $model
                ->limit($perPage)->offset($offset)->all($columns)
                ->all()
        );
    }

    /**
     * @return string
     */
    public function paginationLinks ()
    {
        $links = '<div class="row">';

        $links .= '<ul class="pagination pull-right">';

        $currentUrl = Request::uri();

        for ($index = 1; $index < $this->totalPages; $index++)
        {
            $links .= $this->page == $index ? "<li class='active'>" : "<li>";

            $links .= "<a href='{$currentUrl}?page={$index}'>{$index}</a></li>";
        }

        $links .= '</ul>';

        return $links . '</div>';
    }
}