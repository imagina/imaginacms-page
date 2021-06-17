<?php

namespace Modules\Page\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Page\Entities\Component;
use Modules\Page\Http\Requests\CreateComponentRequest;
use Modules\Page\Http\Requests\UpdateComponentRequest;
use Modules\Page\Repositories\ComponentRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class ComponentController extends AdminBaseController
{
    /**
     * @var ComponentRepository
     */
    private $component;

    public function __construct(ComponentRepository $component)
    {
        parent::__construct();

        $this->component = $component;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$components = $this->component->all();

        return view('page::admin.components.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('page::admin.components.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateComponentRequest $request
     * @return Response
     */
    public function store(CreateComponentRequest $request)
    {
        $this->component->create($request->all());

        return redirect()->route('admin.page.component.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('page::components.title.components')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Component $component
     * @return Response
     */
    public function edit(Component $component)
    {
        return view('page::admin.components.edit', compact('component'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Component $component
     * @param  UpdateComponentRequest $request
     * @return Response
     */
    public function update(Component $component, UpdateComponentRequest $request)
    {
        $this->component->update($component, $request->all());

        return redirect()->route('admin.page.component.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('page::components.title.components')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Component $component
     * @return Response
     */
    public function destroy(Component $component)
    {
        $this->component->destroy($component);

        return redirect()->route('admin.page.component.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('page::components.title.components')]));
    }
}
