<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
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
        $filter = $this->getFilterFromRequest();
        $this->request = $this->request->withArgument('filter',  $filter);
    }

    public function indexAction(FilterDto $filter, int $currentPageNumber = 1): ResponseInterface
    {
        if ($this->request->getMethod() === 'POST') {
            if ($filter->shouldReset()) {
                $filter = $filter->resetFilter();
            }
            return $this->redirect(
                actionName: 'index',
                arguments: [
                    'currentPageNumber' => $currentPageNumber,
                    'filter' => $filter->toArray(),
                ]
            );
        }
        $orderBy = $this->settings['orderBy'] ?? '';
        $publications = [];
        if ($orderBy !== '') {
            [$propertyName, $order] = explode(':', $orderBy);
            if (in_array($propertyName, ['title', 'type', 'releaseYear'])) {
                $publications = $this->publicationRepository->findByFilter($filter, [$propertyName => $order]);
            }
        } else {
            $publications = $this->publicationRepository->findByFilter($filter);
        }
        $paginator = $this->getPaginator(
            $publications,
        );

        $this->view->assignMultiple([
            'paginator' => $paginator,
            'pagination' => new SlidingWindowPagination($paginator, 12),
            'filter' => $filter,
        ]);

        return $this->htmlResponse();
    }

    public function initializeShowAction(): void
    {
        $filter = $this->getFilterFromRequest();
        $this->request = $this->request->withArgument('filter',  $filter);
    }
    public function showAction(Publication $publication, string $listAction = 'index'): ResponseInterface
    {
        $this->view->assignMultiple(
            [
                'publication' => $publication,
                'currentPageNumber' => $this->getCurrentPageNumberFromRequest(),
                'filter' => $this->getFilterFromRequest(),
            ]
        );
        return $this->htmlResponse();
    }
}
