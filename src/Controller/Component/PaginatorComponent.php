<?php

namespace App\Controller\Component;

use Cake\Controller\Component\PaginatorComponent as CorePaginatorComponent;
use Cake\Datasource\QueryInterface;
use Cake\Http\Exception\NotFoundException;
use Cake\Datasource\ResultSetInterface;
use Cake\Routing\Exception\RedirectException;
use Cake\Routing\Router;

class PaginatorComponent extends CorePaginatorComponent {

	/**
	 * Overwrite to always redirect from out of bounds to last page of paginated collection.
	 * If pageCount not available, then use first page.
	 *
	 * @param \Cake\Datasource\RepositoryInterface|\Cake\Datasource\QueryInterface $object The table or query to paginate.
	 * @param array $settings The settings/configuration used for pagination.
	 *
	 * @throws \Cake\Http\Exception\NotFoundException
	 * @throws \Cake\Routing\Exception\RedirectException
	 *
	 * @return \Cake\Datasource\ResultSetInterface Query results
	 */
    public function paginate(object $object, array $settings = []): ResultSetInterface {
        try {
            $resultSet = parent::paginate($object, $settings);
        } catch (NotFoundException $exception) {
            $query = null;
            if ($object instanceof QueryInterface) {
                $query = $object;
                $object = $query->getRepository();
            }
            $alias = $object->getAlias();
            $pageCount = $this->getController()->getRequest()->getAttribute('paging')[$alias]['pageCount'];
            $lastPage = $pageCount > 1 ? $pageCount : null;
            $url = Router::url(['?' => ['page' => $lastPage] + $this->getController()->getRequest()->getQuery()], true);

			throw new RedirectException($url);
        }

        return $resultSet;
    }
}
