<?php

namespace App\Http\Controllers;

use App\Acme\Transformers\TagTransformer;
use App\Tag;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;

class TagController extends ApiController
{
    protected $tagTranformer;

    function __construct(TagTransformer $tagTransformer)
    {
        $this->tagTranformer = $tagTransformer;

        // TODO: Post test not working with auth middlerare
        //$this->middleware('auth.basic', ['only' => 'store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 1. No es retorna tot: paginació
        //return Tag::all();

        $tags = Tag::all();
        return $this->respond($this->tagTranformer->transformCollection($tags))->setStatusCode(200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        if (!Input::get('title'))
        {
            return $this->setStatusCode(422)->respondWithError('Parameters failed validation for a task');
        }

        Tag::create(Input::all());

        return $this->respondCreated('Tag successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tag = Tag::find($id);

        if (!$tag)
        {
            return $this->respondNotFound('Tag does not exist');
        }

        return $this->respond($this->tagTranformer->transform($tag))->setStatusCode(200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tag = Tag::find($id);

        if (!$tag)
        {
            return $this->respondNotFound('Tag does not exist!!');
        }

        $tag->title = $request->title;
        $tag->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Tag::destroy($id);
    }
}
