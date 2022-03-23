<?php


namespace App\Repositories;

use App\Models\BlogPost as Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

/** class BlogPostRepository
 *
 * @package App\Repositories
 *
 *
 */


class BlogPostRepository extends CoreRepository
{
    /**
     * @return string
     */

    protected function getModelClass()   //: string
    {
        return Model::class;
    }


    /**
     * @return LengthAwarePaginator
     */
    public function getAllWithPaginate()//: LengthAwarePaginator
    {

        $columns = [
            'id',
            'title',
            'slug',
            'is_published',
            'published_at',
            'user_id',
            'category_id',
        ];

        $result = $this->startConditions()
            ->select($columns)
            ->orderBy('id', 'desc')
           // ->with(['category', 'user'])
               ->with([
            //можно так
                'category' => function ($query){
                   $query->select(['id', 'title']);
                },
               //или так
               'user:id,name',
               ])
            ->paginate(25);

        return $result;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getEdit(int $id){
        return $this->startConditions()->find($id);
    }
}
