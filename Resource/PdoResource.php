<?php
namespace Fontai\Bundle\TextBundle\Resource;

use Symfony\Component\Config\Resource\SelfCheckingResourceInterface;


class PdoResource implements SelfCheckingResourceInterface, \Serializable
{
  private $resource;
  protected $reloaded = FALSE;

  public function __construct($resource)
  {
    $this->resource = $resource;
  }

  public function __toString()
  {
    return __CLASS__;
  }

  public function getResource()
  {
    return $this->resource;
  }

  public function isFresh($timestamp)
  {
    return FALSE;
  }

  public function serialize()
  {
    return serialize($this->resource);
  }

  public function unserialize($serialized)
  {
    $this->resource = unserialize($serialized);
  }
}
