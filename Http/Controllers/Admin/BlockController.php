<?php

namespace Modules\Page\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Page\Entities\Block;
use Modules\Page\Http\Requests\CreateBlockRequest;
use Modules\Page\Http\Requests\UpdateBlockRequest;
use Modules\Page\Repositories\BlockRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class BlockController extends AdminBaseController
{
    /**
     * @var BlockRepository
     */
    private $block;

    public function __construct(BlockRepository $block)
    {
        parent::__construct();

        $this->block = $block;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$blocks = $this->block->all();

        return view('page::admin.blocks.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('page::admin.blocks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateBlockRequest $request
     * @return Response
     */
    public function store(CreateBlockRequest $request)
    {
        $this->block->create($request->all());

        return redirect()->route('admin.page.block.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('page::blocks.title.blocks')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Block $block
     * @return Response
     */
    public function edit(Block $block)
    {
        return view('page::admin.blocks.edit', compact('block'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Block $block
     * @param  UpdateBlockRequest $request
     * @return Response
     */
    public function update(Block $block, UpdateBlockRequest $request)
    {
        $this->block->update($block, $request->all());

        return redirect()->route('admin.page.block.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('page::blocks.title.blocks')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Block $block
     * @return Response
     */
    public function destroy(Block $block)
    {
        $this->block->destroy($block);

        return redirect()->route('admin.page.block.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('page::blocks.title.blocks')]));
    }
}
