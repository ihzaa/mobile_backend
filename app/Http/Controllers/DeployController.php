<?php
namespace App\Http\Controllers;

use Symfony\Component\Process\Process;

class DeployController extends Controller
{
    public function deploy()
    {
        $process = Process::fromShellCommandline('cd ' . base_path() . '; chmod +x deploy.sh; ./deploy.sh');
        $process->run(function ($type, $buffer) {
            echo $buffer;
        });
    }
}