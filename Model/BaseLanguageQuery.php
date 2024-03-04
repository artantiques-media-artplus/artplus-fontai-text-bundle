<?php
namespace Fontai\Bundle\TextBundle\Model;

use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;


abstract class BaseLanguageQuery extends ModelCriteria
{
  protected function preSelect(ConnectionInterface $con)
  {
    $this
    ->orderByIsDefault(Criteria::DESC)
    ->orderByPriority(Criteria::DESC);
  }
}
