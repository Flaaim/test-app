<?php


namespace App\Modules\Admin\Sources\Controllers;

use Illuminate\Http\Request;
use App\Modules\Admin\Sources\Models\Source;
use App\Http\Controllers\Controller;
use App\Modules\Admin\Sources\Services\SourcesService;
use App\Modules\Admin\Dashboard\Classes\Base;
use App\Modules\Admin\Sources\Requests\SourceRequest;
use App\Modules\Admin\Sources\Controllers\Role;

class SourceController extends Base {
    protected $service;

    public function __construct(SourcesService $service){
        parent::__construct();
        $this->service = $service;
    }

    public function index(){
      
        $this->authorize('view', Source::class);
        $sources = Source::all();
        $title = 'Sources';
        $this->content = view('Admin::Sources.index')->with(['sources'=>$sources, 'title'=>$title])->render();
        
        return $this->renderOutput();
    }

    public function create(){
        $title = 'Source Create';
       $this->content = view('Admin::Sources.create')->with(['title'=>$title])->render();
       
       return $this->renderOutput();
    }   

    public function store(SourceRequest $request, Source $source)
    {   
        $source = $this->service->save($request, new Source());
        return redirect()->route('sources.index');
    }

    public function edit(Source $source){
        $title = "Edit Source";
        $this->content = view('Admin::Sources.edit')->with(['source'=>$source, 'title'=>$title])->render();

        return $this->renderOutput();
    }

    public function update(SourceRequest $request, Source $source)
    {
        $source = $this->service->save($request, $source);
        return redirect()->route('sources.index');
    }
    public function destroy(Source $source){
        $source->delete();
        return redirect()->back();
    }
    public function show(){
        
    }
}

