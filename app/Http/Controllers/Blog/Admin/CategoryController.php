<?php

namespace App\Http\Controllers\Blog\Admin;
//namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCategoryCreateRequest;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Models\BlogCategory;
use App\Repositories\BlogCategoryRepository;
use Doctrine\DBAL\Event\SchemaAlterTableRemoveColumnEventArgs;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use phpDocumentor\Reflection\DocBlock\Tags\Method;
use Illuminate\Support\Str;

/**
 * Управление категориями блога
 *
 * Class CategoryController
 * @package App\Http\Controllers\Blog\Admin
 */
class CategoryController extends BaseController
{
    /**
     * @var BlogCategoryRepository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $blogCategoryRepository;

    /**
     * CategoryController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->blogCategoryRepository = app(BlogCategoryRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    public function index()
    {
       // $paginator = BlogCategory::paginate(15);
        $paginator = $this->blogCategoryRepository->getAllWithPaginate(5);


        return view('blog.admin.categories.index', compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $item = new BlogCategory();
        //$categoryList = BlogCategory::all();
        $categoryList  = $this->blogCategoryRepository->getForComboBox($item->parent_id);

        return view('blog.admin.categories.edit',
            compact('item', 'categoryList'));

    }

    /**
     * @param BlogCategoryCreateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BlogCategoryCreateRequest $request)
    {
        $data = $request->input();

        if (empty($data['slug'])){
            $data['slug'] = Str::of($data['title'])->slug();
        }

        //Создаст обьект но не добавит в базу данных
       /* $item = new BlogCategory($data);
        $item->save();*/

        $item = (new BlogCategory())->create($data);

        if ($item){
            return redirect()->route('blog.admin.categories.edit', [$item->id])
                ->with(['success' => 'Успешно сохранено']);
        } else{
            return back()->withErrors(['msg'=>'Ошибка сохранения'])
                ->withInput();


              }
    }


    /**
     * @param $id
     * @param BlogCategoryRepository $categoryRepository
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id, BlogCategoryRepository  $categoryRepository)
    {
        /*$item = BlogCategory::findOrFail($id);
        $categoryList = BlogCategory::all();*/

        $item = $this->blogCategoryRepository->getEdit($id);
        if (empty($item)){
            abort(404);
        }
        $categoryList = $this->blogCategoryRepository->getForComboBox();
        return view('blog.admin.categories.edit',
            compact('item', 'categoryList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BlogCategoryUpdateRequest $request, $id)
    {
       /* $rules = [
            'title'         => 'required|min:5|max:200',
            'slug'          => 'max:200',
            'description'   => 'string|max:500|min:3',
            'parent_id'     => 'required|integer|exists:blog_categories, id',
        ];
        $validateData = $this->validate($request, $rules);
        dd( $validateData);*/

        $item = $this->blogCategoryRepository->getEdit($id);
        //$item = BlogCategory::find($id);

        if (empty($item)){
            return back()
                ->withErrors(['msg' => "Запись id=[{$id}] не найдена"])
                ->withInput();
        }

        $data = $request->all();
        if (empty($data['slug'])){
            $data['slug'] = Str::of($data['title'])->slug();
        }
        /*$result = $item
            ->fill($data)
            ->save();*/
          $result = $item->update($data);

        if ($result){
            return redirect()
                ->route('blog.admin.categories.edit', $item->id)
                ->with(['success' => 'Успешно сохранено']);
        } else{
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }



}
