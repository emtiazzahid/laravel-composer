<?php

namespace EmtiazZahid\LaravelComposer;

use cebe\markdown\GithubMarkdown;
use EmtiazZahid\LaravelComposer\LaravelComposerParser;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\Process\Process;

/**
 * Class GitLogLaravelController
 * @package EmtiazZahid\GitLogLaravel
 */
class LaravelComposerController extends Controller
{
    public $laravelComposerParser;
    /**
     * @var string
     */
    protected $view_log = 'laravel-composer::index';

    public function __construct(LaravelComposerParser $laravelComposerParser)
    {
        $this->laravelComposerParser = $laravelComposerParser;
    }

    /**
     * @param Request $request
     * @return array|mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function index(Request $request)
    {
        if (!session('laravel-composer-data')) {
            $data = [
                'packages' => $this->laravelComposerParser->installedPackages()
            ];

            session(['laravel-composer-data' => $data]);
        }

        $data = [
            'tab' => 'home',
            'data' => session('laravel-composer-data')
        ];

        return app('view')->make($this->view_log, $data);
    }

    public function packageDownload($name, $version)
    {
        $fileName = str_replace("_","/",$name);

        $this->laravelComposerParser->processRun(['composer', 'archive',$fileName,$version,'--format=zip','--file='.$name]);

        return response()->download(base_path($name.'.zip'))->deleteFileAfterSend(true);
    }

    public function packageRemove($name)
    {
        $fileName = str_replace("_","/",$name);

        try {
            $result = $this->laravelComposerParser->processRun(['composer', 'remove', $fileName, '--dev']);
        }catch (\Exception $exception) {
            $result = $exception->getMessage();
        }

        session()->flash('laravel-composer-data');

        $data = [
            'tab' => 'home',
            'data' => session('laravel-composer-data')
        ];

        return redirect()->back()->with(['result' => $data]);
    }

    public function packageDetails($name, Request $request)
    {
        $fileName = str_replace("_","/",$name);

        try {
            $result = $this->laravelComposerParser->processRun(['composer', 'show', $fileName, '--format=json']);
        }catch (\Exception $exception) {
            $result = $exception->getMessage();
        }

        $request->session()->flash('result', $result);

        $data = [
            'tab' => 'home',
            'data' => session('laravel-composer-data'),
            'result' => $result
        ];

        return \Redirect()->back()->with($data);
    }

    public function getPackageList(Request $request)
    {
        $data = [
            'result_type' => 'list',
            'tab' => 'search',
            'packages' => $this->laravelComposerParser->packageList($request->vendor, $request->list_type),
            'data' => session('laravel-composer-data')
        ];

        return view('laravel-composer::index', $data);
    }

    public function searchPackage(Request $request)
    {
        $data = [
            'result_type' => 'search',
            'tab' => 'search',
            'output' => $this->laravelComposerParser->searchPackage($request->q, $request->tags,  $request->search_type),
            'data' => session('laravel-composer-data')
        ];

        return view('laravel-composer::index', $data);
    }

    public function readmeView(Request $request)
    {
        $parser = new GithubMarkdown();
        $html = $parser->parse(file_get_contents('https://raw.githubusercontent.com/'.$request->name.'/master/README.md'));

        return $html;
    }

}
