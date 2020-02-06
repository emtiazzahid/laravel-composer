<?php

namespace EmtiazZahid\LaravelComposer;

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
                'packages' => $this->laravelComposerParser->installedPackages($this->processRun(['composer', 'show','-l','--direct','--format=json']))
            ];

            session(['laravel-composer-data' => $data]);
        }

        return app('view')->make($this->view_log, session('laravel-composer-data'));
    }

    public function processRun($commands)
    {
        $process = new Process($commands, null, ['COMPOSER_HOME' => '$HOME/.config/composer']);
        $process->setWorkingDirectory(base_path());
        $process->setTimeout(120);
        $process->run();



        if (!$process->isSuccessful()) {
            throw new \Symfony\Component\Process\Exception\ProcessFailedException($process);
        }

        return $process->getOutput();
    }

    public function packageDownload($name, $version)
    {
        $fileName = str_replace("_","/",$name);

        $this->processRun(['composer', 'archive',$fileName,$version,'--format=zip','--file='.$name]);

        return response()->download(base_path($name.'.zip'))->deleteFileAfterSend(true);
    }

    public function packageRemove($name)
    {
        $fileName = str_replace("_","/",$name);

        try {
            $result = $this->processRun(['composer', 'remove', $fileName, '--dev']);
        }catch (\Exception $exception) {
            $result = $exception->getMessage();
        }

        session()->flash('laravel-composer-data');

        return redirect()->back()->with(['result' => $result]);
    }

    public function packageDetails($name, Request $request)
    {
        $fileName = str_replace("_","/",$name);

        try {
            $result = $this->processRun(['composer', 'show', $fileName, '--format=json']);
        }catch (\Exception $exception) {
            $result = $exception->getMessage();
        }

        $request->session()->flash('result', $result);

        return \Redirect()->back()->with('result' , $result);
    }


}
