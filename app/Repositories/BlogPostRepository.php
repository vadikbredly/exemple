<?php


namespace App\Repositories;

use App\Models\BlogPost as Model;
use Illuminate\Database\Eloquent\Collection;
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

    /** Получить модель для редактирования в админке
     *
     * @param int $id
     *
     * @return Model
     */
    public function getEdit(int $id){
        return $this->startConditions()->find($id);
    }

    /**
     * Получить список категорий для вывода в выподающем списке
     *
     * @return Collection
     *
     */
    public function getForComboBox(){
       // return $this->startConditions()->all();
        $colums = implode(',',[
            'id',
            'CONCAT (id, ". ", title) AS id_title',
        ]);
      /*  $result[] = $this->startConditions()->all();
          $result[] = $this
            ->startConditions()
            ->select(DB::raw('blog_categories.*, CONCAT (id, ". ", title) AS title_id '))
            ->toBase()
            ->get();*/
        $result = $this
            ->startConditions()
            ->selectRaw($colums)
            ->toBase()
            ->get();

  //      dd($result->first());
        return $result;
    }

    /**
     * @param null $perPage
     * @return mixed
     */
    public function getAllWithPaginate($perPage = null){

        $fields = ['id', 'title', 'parent_id'];

        $result = $this
            ->startConditions()
            ->select($fields)
            ->paginate($perPage);

        return $result;
    }


}
