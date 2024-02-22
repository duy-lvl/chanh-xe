<?php

declare(strict_types=1);

namespace Domain\PathFinding\Models;

use Illuminate\Support\Collection;
use InvalidArgumentException;

final class IntegerIdGraph
{
    /** @var Collection<int, Collection<int, int|float>> */
    private Collection $adjacencyList;

    /** @var Collection<Node> */
    private Collection $nodes;

    /**
     * @param  Collection<Node>  $nodes
     */
    public function __construct(Collection $nodes = new Collection())
    {
        $this->nodes = $nodes;

        $adjacencyList = collect();

        foreach ($nodes as $node) {
            $adjacencyList->put(
                key: $node->id,
                value: collect(), //each node will have a List of adjacency node, which itself is a Map of {nodeId => weight}
            );
        }

        $this->adjacencyList = $adjacencyList;
    }

    public function addEdge(int|Node $start, int|Node $end, int|float $cost, bool $isBidirection = false): void
    {
        if ( ! $this->contains([$start, $end])) {
            throw new InvalidArgumentException("one of the inputted node doesn't exist in the instantiated nodes");
        }

        $this->adjacencyList->get(
            ($start instanceof Node) ? $start->id : $start
        )->put(
            key: ($end instanceof Node) ? $end->id : $end,
            value: $cost
        );

        if ($isBidirection) {
            $this->addEdge($end, $start, $cost);
        }
    }

    /**
     * @return Collection<int, Collection<int, int|float>>
     */
    public function getAdjacencyListCollection(): Collection
    {
        return $this->adjacencyList;
    }

    /**
     * @return array<int, array<int, int|float>>
     */
    public function getAdjacencyList(): array
    {
        return $this->adjacencyList->toArray();
    }

    /**
     * @param  array<int>|Collection<int>  $nodeSequence
     */
    public function getCost(array|Collection $nodeSequence): int|float
    {
        $result = 0;

        $nodeSequence = ($nodeSequence instanceof Collection) ? $nodeSequence : collect($nodeSequence);

        $current = $nodeSequence->shift();
        while ( ! $nodeSequence->isEmpty()) {
            $node = $this->adjacencyList->get($current);

            $current = $nodeSequence->shift();

            $cost = $node->get($current);
            if (null === $cost) {
                return INF;
            }

            $result += $cost;
        }

        return $result;
    }

    /**
     * @param  int|Node|array<int|Node>|Collection<int|Node>  $values
     */
    public function contains(int|Node|array|Collection $values): bool
    {
        $mapper = fn (Node|string $value) => ($value instanceof Node) ? $value->id : $value;

        $identifiers = match (true) {
            $values instanceof Collection => $values->map($mapper)->toArray(),
            is_array($values) => array_map($mapper, $values),
            $values instanceof Node => [$values->id],
            default => [$values],
        };

        $result = true;

        foreach ($identifiers as $identifier) {
            $result = $result && $this->nodes->contains(fn (Node $value, int $key) => $value->id === $identifier);
        }

        return $result;
    }
}
