<?php

namespace Modules\Page\Http\Controllers\Admin;

use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Page\Entities\Page;
use Modules\Page\Http\Requests\CreatePageRequest;
use Modules\Page\Http\Requests\UpdatePageRequest;
use Modules\Page\Repositories\PageRepository;

class PageController extends AdminBaseController
{
    /**
     * @var PageRepository
     */
    private $page;

    public function __construct(PageRepository $page)
    {
        parent::__construct();

        $this->page = $page;
    }

    public function index()
    {
        return view('page::admin.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return view('page::admin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePageRequest $request): Response
    {
        $this->page->create($request->all());

        return redirect()->route('admin.page.page.index')
            ->withSuccess(trans('page::messages.page created'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page): Response
    {
        return view('page::admin.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Page $page, UpdatePageRequest $request): Response
    {
        $this->page->update($page, $request->all());

        if ($request->get('button') === 'index') {
            return redirect()->route('admin.page.page.index')
                ->withSuccess(trans('page::messages.page updated'));
        }

        return redirect()->back()
            ->withSuccess(trans('page::messages.page updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page): Response
    {
        $this->page->destroy($page);

        return redirect()->route('admin.page.page.index')
            ->withSuccess(trans('page::messages.page deleted'));
    }
}
