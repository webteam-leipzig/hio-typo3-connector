<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Backend\Attribute\AsController;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Core\Pagination\SlidingWindowPagination;
use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;
use TYPO3\CMS\Extbase\Property\PropertyMapper;
use Wtl\HioTypo3Connector\Domain\Dto\FilterDto;
use Wtl\HioTypo3Connector\Domain\Model\Publication;
use Wtl\HioTypo3Connector\Domain\Repository\PublicationRepository;

#[AsController]
class PublicationController extends BaseController
{
    protected int $pageUid;

    public function __construct(
        protected readonly ModuleTemplateFactory $moduleTemplateFactory,
        protected readonly PublicationRepository $publicationRepository,
        protected readonly PropertyMapper $propertyMapper,
        protected readonly LoggerInterface $logger,
    )
    {}

    public function initializeIndexAction(): void
    {
        $filter = new FilterDto();
        if ($this->request->hasArgument('filter')) {
            $filter = $this->request->getArgument('filter');
            if (! $filter instanceof FilterDto) {
                try {
                    $filter = FilterDto::fromRequest($this->request);
                }
                catch (\Throwable $e) {
                    $this->logger->error(
                        'Failed to parse filter from request: ' . $e->getMessage(),
                        ['exception' => $e]
                    );
                    $filter = new FilterDto();
                }
            }
        }

        $this->request->withArgument('filter',  $filter);
    }

    public function indexAction(FilterDto $filter, int $currentPage = 1): ResponseInterface
    {
        if ($this->request->getMethod() === 'POST') {
            return $this->redirect(
                actionName: 'index',
                arguments: [
                    'currentPage' => $currentPage,
                    'filter' => $filter->toArray(),
                    'searchTerm' => $this->request->getParsedBody()['searchTerm'] ?? '',
                ]
            );
        }
        $orderBy = $this->settings['orderBy'] ?? '';
        $publications = [];
        if ($orderBy !== '') {
            [$propertyName, $order] = explode(':', $orderBy);
            if (in_array($propertyName, ['title', 'type', 'releaseYear'])) {
                $publications = $this->publicationRepository->getPublications([$propertyName => $order]);
            }
        } else {
            $publications = $this->publicationRepository->findAll();
        }
        $paginator = $this->getPaginator(
            $publications,
        );

        $this->view->assignMultiple([
            'paginator' => $paginator,
            'pagination' => new SlidingWindowPagination($paginator, 12),
            'searchTerm' => $this->getSearchTermFromRequest(),
        ]);

        return $this->htmlResponse();
    }

    public function searchAction(int $currentPage = 1, string $searchTerm = ''): ResponseInterface
    {
        $paginator = $this->getPaginator(
            $this->publicationRepository->findBySearchTerm($searchTerm),
        );
        $this->view->assignMultiple([
            'paginator' => $paginator,
            'pagination' => new SlidingWindowPagination($paginator, 12),
            'searchTerm' => $this->getSearchTermFromRequest(),
        ]);

        return $this->htmlResponse();
    }

    public function showAction(Publication $publication, string $listAction = 'index'): ResponseInterface
    {
        $this->view->assignMultiple(
            [
                'publication' => $publication,
                'currentPageNumber' => $this->getCurrentPageNumberFromRequest(),
                'searchTerm' => $this->getSearchTermFromRequest(),
                'listAction' => $listAction,
            ]
        );
        return $this->htmlResponse();
    }
}
