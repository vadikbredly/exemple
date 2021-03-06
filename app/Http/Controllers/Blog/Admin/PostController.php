<?php

namespace App\Http\Controllers\Blog\Admin;


use App\Http\Requests\BlogPostUpdateRequest;
use App\Repositories\BlogCategoryRepository;
use App\Repositories\BlogPostRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PostController extends BaseController
{
    /**
     * @var BlogPostRepository
     */
    private $blogPostRepository;

    /**
     * @var BlogCategoryRepository
     */
    private $blogCategoryRepository;


    public function __construct()
    {
        parent::__construct();

        $this->blogPostRepository = app(BlogPostRepository::class);
        $this->blogCategoryRepository = app(BlogCategoryRepository::class);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $paginator = $this->blogPostRepository->getAllWithPaginate();

        return view('blog.admin.posts.index', compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd(__METHOD__);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $item = $this->blogPostRepository->getEdit($id);
        if (empty($item)){
            abort(404);
        }
        $categoryList = $this->blogCategoryRepository->getForComboBox();
        return view('blog.admin.posts.edit',
            compact('item', 'categoryList'));
    }

    /**
     * @param BlogPostUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BlogPostUpdateRequest $request, $id)
    {
       $item = $this->blogPostRepository->getEdit($id);

       if (empty($item)){
           return back()
               ->withErrors(['msg' => "???????????? id=[{$id}] ???? ??????????????"])
               ->withInput();
       }
        $data = $request->all();
       if (empty($data['slug'])){
            $data['slug'] =\Str::of($data['title'])->slug();
       }
       if (empty($item->published_at) && $data['is_published']){
           $data['published_at'] = Carbon::now();
       }

       $result = $item->update($data);

       if ($result){
           return redirect()
               ->route('blog.admin.posts.edit', $item->id)
               ->with(['success' => '?????????????? ??????????????????']);
       }else{
           return back()
               ->withErrors(['msg' => '???????????? ????????????????????'])
               ->withInput();
       }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd(__METHOD__, $id, \request()->all());
    }
}
