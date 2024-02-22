<?php

declare(strict_types=1);

namespace Domain\PathFinding\Services;

use SplPriorityQueue;
use Domain\PathFinding\Models\Node;
use Domain\PathFinding\Models\IntegerIdGraph;
use Domain\PathFinding\Models\StringIdGraph;
use Domain\PathFinding\DataTransferObjects\Path;



final class PathFinding
{
    /**
     * @return array<Path>
     */
    public function shortestPath(IntegerIdGraph|StringIdGraph $graph, Node $start, Node $end, int $numberOfPaths = 1): array
    {
        $start = ($graph instanceof StringIdGraph) ? $start->getIndentifier() : $start->id;
        $end = ($graph instanceof StringIdGraph) ? $end->getIndentifier() : $end->id;

        if ($numberOfPaths == 1)
        {
            return [$this->lazyDijkstra($graph, $start, $end)];
        }

        return $this->yenKSP($graph, $start, $end, $numberOfPaths);
    }

    /**
     * @param array<int, array<int, int|float>>|array<string, array<string, int|float>>|IntegerIdGraph|StringIdGraph $graph
     */
    private function lazyDijkstra(array|IntegerIdGraph|StringIdGraph $graph, int|string $start, int|string $end): Path
    {
        $adjacencyListGraph = ($graph instanceof IntegerIdGraph || $graph instanceof StringIdGraph) ? $graph->getAdjacencyList() : $graph;

        // initialize
        // distances from start to each node
        $distances = []; // array<int $nodeId => int|float $distance>

        //visited node list
        $visited = []; // array<bool>

        $previous = [];

        $priorityQueue = new SplPriorityQueue();
        $priorityQueue->insert($start, 0);

        foreach (array_keys($adjacencyListGraph) as $key){
            $distances[$key] = ($key == $start) ? 0 : INF; // set up "inf" distances
        }

        //the algorithm
        while(!$priorityQueue->isEmpty()){
            $current = $priorityQueue->extract();

            if(in_array($current, $visited)){
                continue;
            }

            array_push($visited, $current);

            foreach ($adjacencyListGraph[$current] as $neighbor => $cost){
                $newDistance = $distances[$current] + $cost;
                if ($newDistance < $distances[$neighbor] ){
                    $distances[$neighbor] = $newDistance;
                    $priorityQueue->insert($neighbor, -$newDistance);
                    $previous[$neighbor] = $current;
                }
            }
        }

        //no path found
        if(sizeof($visited)<=1 || !isset($previous[$end])){
            return new Path(sequence: [], cost: INF);
        }

        //format result
        $resultFormatter = function(int|string $start, int|string $end, array $previous, array $distances): Path
        {
            $result = [];
            $node = $end;

            while ($node != $start){
                array_push($result, $node);
                $node = $previous[$node];
            }

            array_push($result, $start);

            return new Path(sequence: array_reverse($result), cost: $distances[$end]);
        };

        return $resultFormatter($start, $end, $previous, $distances);
    }

    /**
     * @param array<int, array<int, int|float>>|array<string, array<string, int|float>>|IntegerIdGraph|StringIdGraph $graph
     * @param array<int|string> $goals
     */
    private function aStar(array|IntegerIdGraph|StringIdGraph $graph, int|string $start, array $goals = []): Path
    {
        //initialize
        $adjacencyListGraph = ($graph instanceof IntegerIdGraph || $graph instanceof StringIdGraph) ? $graph->getAdjacencyList() : $graph;

        $frontier = new SplPriorityQueue();
        $frontier->insert($start, 0);

        $previous = [];
        $previous[$start] = null;

        $costs = [];
        $costs[$start] = 0;

        $finalPath = null;

        $goal = null;

        //the algorithm
        while (!$frontier->isEmpty()){
            $state = $frontier->extract();
            if (in_array($state, $goals)){
                $cost = $costs[$state];
                $goal = $state;
                $finalPath = (function() use ($goal, $start, $previous) {
                    $current = $goal;
                    $path = [];
                    while ($current != $start){
                        array_push($path, $current);
                        $current = $previous[$current];
                    }
                    array_push($path, $start);

                    return array_reverse($path);
                })();
                return new Path(sequence: $finalPath, cost: $cost);
            }

            foreach ($adjacencyListGraph[$state] as $nextState => $cost){
                $newCost = $costs[$state] + $cost;
                if ( !array_key_exists($nextState, $costs) || $newCost < $costs[$nextState]){
                    $costs[$nextState] = $newCost;
                    $priority = -$newCost;

                    $frontier->insert($nextState, $priority);
                    $previous[$nextState] = $state;
                }
            }
        }

        //no path found
        return new Path(sequence: [], cost: INF);
    }

    /**
     * @param array<int, array<int, int|float>>|array<string, array<string, int|float>>|IntegerIdGraph|StringIdGraph $graph
     * @return array<Path>
     */
    private function yenKSP(array|IntegerIdGraph|StringIdGraph $graph, int|string $start, int|string $end, int $number = 1): array
    {
        $adjacencyListGraph = $adjacencyListGraph = ($graph instanceof IntegerIdGraph || $graph instanceof StringIdGraph) ? $graph->getAdjacencyList() : $graph;

        $shortestPath = $this->lazyDijkstra($graph, $start, $end);

        $resultPaths = [$shortestPath];

        $candidatePaths = [];

        for ($k = 1; $k < $number; $k++){
            for ($i = 0; $i < sizeof(end($resultPaths)->sequence)-1; $i++){
                $graphClone = $adjacencyListGraph;

                $lastpath = end($resultPaths)->sequence;

                $spurNode = $lastpath[$i];
                $rootPath = array_slice($lastpath, 0, $i+1);

                foreach ($resultPaths as $path) {
                    $sequence = $path->sequence;
                    if (sizeof($sequence) > $i && $rootPath == array_slice($sequence, 0, $i+1)){
                        if(array_key_exists($sequence[$i+1], $graphClone[$sequence[$i]])){
                            unset($graphClone[$sequence[$i]][$sequence[$i+1]]);
                        }
                    }
                }

                $result = $this->aStar($graphClone, $spurNode, [$end]);
                $spurPath = $result->sequence;
                $totalPath = array_merge( array_slice($rootPath, 0, sizeof($rootPath)-1), $spurPath);
                // $spurCost = $this->aStar($graphClone, $start, [$spurNode])->cost;
                $spurCost = $graph->getCost($rootPath);

                $newResultPath = new Path(sequence: $totalPath, cost: $result->cost + $spurCost);
                if (!in_array($newResultPath, $candidatePaths)){
                    array_push($candidatePaths, new Path(sequence: $totalPath, cost: $result->cost + $spurCost));
                }
            }

            if (sizeof($candidatePaths) == 0){
                break;
            }

            uasort($candidatePaths, function(mixed $a, mixed $b){
                return ($a->cost == $b->cost) ? 0 : (($a->cost < $b->cost) ? -1 : 1);
            });

            $bestCandidate = array_shift($candidatePaths);

            if ($bestCandidate->cost < INF){
                array_push($resultPaths, $bestCandidate);
            }
        }

        return $resultPaths;
    }
}
