<?php

namespace Wtl\HioTypo3Connector\Reaction;

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use TYPO3\CMS\Reactions\Model\ReactionInstruction;
use TYPO3\CMS\Reactions\Reaction\ReactionInterface;
use Wtl\HioTypo3Connector\Domain\Dto\DoctoralProgramDto;
use Wtl\HioTypo3Connector\Event\ReceiveHioDoctoralProgramEvent;

class ReceiveHioDoctoralProgramsReaction implements ReactionInterface
{
    public function __construct(
        private readonly ResponseFactoryInterface   $responseFactory,
        private readonly StreamFactoryInterface     $streamFactory,
        protected readonly EventDispatcherInterface $eventDispatcher
    )
    {
    }

    public static function getType(): string
    {
        return 'receive-hio-doctoral-programs';
    }

    public static function getDescription(): string
    {
        return 'LLL:EXT:hio_typo3_connector/Resources/Private/Language/doctoralProgram.xlf:receive-hio-doctoral-programs_reaction';
    }

    public static function getIconIdentifier(): string
    {
        return 'tx-hio_typo3_connector-doctoral-programs';
    }

    public function react(
        ServerRequestInterface $request,
        array                  $payload,
        ReactionInstruction    $reaction
    ): ResponseInterface
    {

        if (is_array($payload['data'] ?? false)) {
            $storagePid = (int)($reaction->toArray()['storage_pid'] ?? 0);
            foreach ($payload['data'] as $value) {
                $this->eventDispatcher->dispatch(
                    new ReceiveHioDoctoralProgramEvent(
                        DoctoralProgramDto::fromArray($value),
                        $storagePid
                    )
                );
            }
        }
        return $this->createJsonResponse(['status' => 'Doctoral programs imported']);
    }

    private function createJsonResponse(array $data, int $statusCode = 201): ResponseInterface
    {
        return $this->responseFactory
            ->createResponse($statusCode)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->streamFactory->createStream(json_encode($data, JSON_THROW_ON_ERROR)));
    }
}
