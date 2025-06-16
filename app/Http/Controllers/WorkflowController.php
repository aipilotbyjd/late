<?php

namespace App\Http\Controllers;

use App\Models\Workflow;
use App\Models\Node;
use App\Models\WorkflowRun;
use App\Models\NodeRun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WorkflowController extends Controller
{
    public function index(Request $request)
    {
        return Workflow::with('nodes')->where('user_id', $request->user()->id)->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'nodes' => 'array'
        ]);

        $workflow = Workflow::create([
            'user_id' => $request->user()->id,
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
        ]);

        foreach ($data['nodes'] ?? [] as $nodeData) {
            $workflow->nodes()->create($nodeData);
        }

        return response()->json($workflow->load('nodes'));
    }

    public function update(Request $request, Workflow $workflow)
    {
        $this->authorize('update', $workflow);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'nodes' => 'array',
        ]);

        $workflow->update([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
        ]);

        // Optional: Sync/update nodes

        return response()->json($workflow->load('nodes'));
    }

    public function destroy(Workflow $workflow)
    {
        $this->authorize('delete', $workflow);
        $workflow->delete();
        return response()->json(['message' => 'Workflow deleted.']);
    }

    public function run(Workflow $workflow)
    {
        $workflowRun = WorkflowRun::create([
            'workflow_id' => $workflow->id,
            'status' => 'running',
            'started_at' => now(),
        ]);

        try {
            foreach ($workflow->nodes()->orderBy('id')->get() as $node) {
                $start = now();
                $output = null;
                $status = 'success';
                $error = null;

                try {
                    $output = $this->executeNode($node);
                } catch (\Exception $e) {
                    $status = 'failed';
                    $error = $e->getMessage();
                    $workflowRun->update(['status' => 'failed']);
                    break;
                }

                NodeRun::create([
                    'workflow_run_id' => $workflowRun->id,
                    'node_id' => $node->id,
                    'status' => $status,
                    'output' => $output,
                    'error_message' => $error,
                    'started_at' => $start,
                    'ended_at' => now(),
                ]);
            }

            if ($workflowRun->status === 'running') {
                $workflowRun->update([
                    'status' => 'success',
                    'ended_at' => now(),
                ]);
            }

        } catch (\Throwable $t) {
            Log::error('Workflow run error', ['error' => $t]);
            $workflowRun->update(['status' => 'failed', 'ended_at' => now()]);
        }

        return response()->json($workflowRun->load('nodeRuns'));
    }

    protected function executeNode(Node $node)
    {
        // Simulated execution logic — real system would dynamically load integration code
        return [
            'node_name' => $node->name,
            'status' => 'executed',
            'timestamp' => now(),
        ];
    }
}
