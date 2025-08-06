<?php

namespace Wtl\HioTypo3Connector\Domain\Dto;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Extbase\Mvc\Request as ExtbaseRequest;

class FilterDto
{
    public function __construct(
        protected bool $showFilterForm = true,
        protected ?string $searchTerm = null,
    )
    {}

    public function shouldShowFilterForm(): bool
    {
        return $this->showFilterForm;
    }

    public function showFilterForm(): self
    {
        $clone = clone $this;
        $this->showFilterForm = true;
        return $clone;
    }

    public function hideFilterForm(): self
    {
        $clone = clone $this;
        $this->showFilterForm = false;
        return $clone;
    }

    public function withSearchTerm(?string $searchTerm): self
    {
        $clone = clone $this;
        $clone->searchTerm = $searchTerm;
        return $clone;
    }

    public function getSearchTerm(): ?string
    {
        return $this->searchTerm;
    }

    public function toArray(): array
    {
        return [
            'showFilterForm' => $this->shouldShowFilterForm(),
            'searchTerm' => $this->getSearchTerm(),
        ];
    }

    public static function fromArray(array $filter, ?self $origin = null): self
    {
        $instance = $origin instanceof self ? clone $origin : new self();

        if (isset($filter['showFilterForm'])) {
            $instance->showFilterForm = (bool)$filter['showFilterForm'];
        }
        if (isset($filter['searchTerm'])) {
            $instance->searchTerm = (string)$filter['searchTerm'];
        }
        return $instance;
    }

    public static function fromRequest(ServerRequestInterface $request, ?self $origin = null): self
    {
        $data = $request instanceof ExtbaseRequest
            ? $request->getArguments()
            : array_merge_recursive($request->getQueryParams(), (array)($request->getParsedBody() ?? []));

        if (isset($data['filter']) && is_array($data['filter'])) {
            $filter = $data['filter'];
            return self::fromArray($filter, $origin);
        }

        return new self();
    }
}
