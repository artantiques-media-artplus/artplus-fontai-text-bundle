<?php
namespace Fontai\Bundle\TextBundle\Model;

use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;


abstract class BaseTextGroupQuery extends ModelCriteria
{
  protected function preSelect(ConnectionInterface $con)
  {
    $this
    ->orderByPriority(Criteria::DESC)
    ->orderByName();
  }
}
