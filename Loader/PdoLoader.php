<?php
namespace Fontai\Bundle\TextBundle\Loader;

use App\Model;
use Fontai\Bundle\TextBundle\Resource\PdoResource;
use Symfony\Component\Translation\Loader\ArrayLoader;


class PdoLoader extends ArrayLoader
{
  public function load(
    $resource,
    $locale,
    $domain = 'messages'
  )
  {
    $messages = [];

    $texts = $this->getTexts($locale, $domain);

    foreach ($texts as $text)
    {
      $messages[$text->getTid()] = $text->getValue() ? $text->getValue() : ' ';
    }

    $catalogue = parent::load($messages, $locale, $domain);
    $catalogue->addResource(new PdoResource($messages));

    return $catalogue;
  }

  protected function getTexts(
    string $culture,
    string $domain
  )
  {
    return Model\TextQuery::create()
    ->joinWithI18n($culture)
    ->useTextGroupQuery()
      ->filterByDomain($domain)
    ->endUse()
    ->find();
  }
}