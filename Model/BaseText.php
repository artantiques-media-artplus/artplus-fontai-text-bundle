<?php
namespace Fontai\Bundle\TextBundle\Model;

use App\Model;


abstract class BaseText
{
  protected static $defaultCulture;

  public function __construct()
  {
  }

  public function getValueBase()
  {
    return (clone $this)
    ->getTranslation($this->getDefaultCulture())
    ->getValue();
  }

  protected function getDefaultCulture()
  {
    if (!self::$defaultCulture)
    {
      self::$defaultCulture = Model\LanguageQuery::create()
      ->findOneByIsDefault(TRUE)
      ->getCode();
    }

    return self::$defaultCulture;
  }

  public function getIsDefault()
  {
    return $this->getCulture() == $this->getDefaultCulture();
  }
}
