<?php

declare(strict_types=1);

namespace Domain\PathFinding\Models;

use Illuminate\Support\Collection;
use InvalidArgumentException;

final class StringIdGraph
{
    /** @var Collection<string, Collection<string, int|float>> */
    private Collection $adjacencyList;

    /** @var Collection<Node> */
    private Collection $nodes;

    /**
     * @param  Collection<Node>  $nodes
     */
    public function __construct(Collection $nodes = new Collection())
    {
        $this->nodes = $nodes;

        $adjacencyList = new Collection();

        foreach ($nodes as $node) {
            $adjacencyList->put(
                key: $node->getIndentifier(),
                value: new Collection(), //each node will have a List of Adjacency Node
            );
        }

        $this->adjacencyList = $adjacencyList;
    }

    public function addEdge(string|Node $start, string|Node $end, int|float $cost, bool $isBidirection = false): void
    {
        if ( ! $this->contains([$start, $end])) {
            throw new InvalidArgumentException("one of the inputted node doesn't exist in the instantiated nodes");
        }

        $this->adjacencyList->get(
            ($start instanceof Node) ? $start->getIndentifier() : $start
        )->put(
            key: ($end instanceof Node) ? $end->getIndentifier() : $end,
            value: $cost
        );

        if ($isBidirection) {
            $this->addEdge($end, $start, $cost);
        }
    }

    /**
     * @return Collection<string, Collection<string, int|float>>
     */
    public function getAdjacencyListCollection(): Collection
    {
        return $this->adjacencyList;
    }

    /**
     * @return array<string, array<string, int|float>>
     */
    public function getAdjacencyList(): array
    {
        return $this->adjacencyList->toArray();
    }

    /**
     * @param  array<string>|Collection<string>  $nodeSequence
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
     * @param  string|Node|array<string|Node>|Collection<string|Node>  $values
     */
    public function contains(string|Node|array|Collection $values): bool
    {
        $mapper = fn (Node|string $value) => ($value instanceof Node) ? $value->getIndentifier() : $value;

        $identifiers = match (true) {
            $values instanceof Collection => $values->map($mapper)->toArray(),
            is_array($values) => array_map($mapper, $values),
            $values instanceof Node => [$values->getIndentifier()],
            default => [$values],
        };

        $result = true;

        foreach ($identifiers as $identifier) {
            $result = $result && $this->nodes->contains(fn (Node $value, int $key) => $value->getIndentifier() === $identifier);
        }

        return $result;
    }
}
