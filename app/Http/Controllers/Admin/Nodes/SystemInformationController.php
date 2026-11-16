<?php

namespace Pterodactyl\Http\Controllers\Admin\Nodes;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Pterodactyl\Models\Node;
use Illuminate\Http\JsonResponse;
use Pterodactyl\Http\Controllers\Controller;
use Pterodactyl\Repositories\Wings\DaemonConfigurationRepository;

class SystemInformationController extends Controller
{
    /**
     * SystemInformationController constructor.
     */
    public function __construct(private DaemonConfigurationRepository $repository)
    {
    }

    /**
     * Returns system information from the Daemon.
     */
    public function __invoke(Request $request, Node $node): JsonResponse
    {
        $start = microtime(true);
        try {
            $data = $this->repository->setNode($node)->getSystemInformation();
            $latency = round((microtime(true) - $start) * 1000);

            return new JsonResponse([
                'status' => 'online',
                'latency' => $latency . 'ms',
                'version' => $data['version'] ?? 'Unknown',
                'system' => [
                    'type' => Str::title($data['os'] ?? 'Linux'),
                    'arch' => $data['architecture'] ?? '--',
                    'release' => $data['kernel_version'] ?? '--',
                    'cpus' => (int) ($data['cpu_count'] ?? 0),
                ],
            ]);
        } catch (\Throwable $exception) {
            return new JsonResponse([
                'status' => 'offline',
                'latency' => '--',
                'version' => 'Offline',
                'system' => [
                    'type' => 'Node Unreachable',
                    'arch' => '--',
                    'release' => 'Connection timed out or Wings stopped',
                    'cpus' => 0,
                ],
                'error' => $exception->getMessage(),
            ]);
        }
    }
}
