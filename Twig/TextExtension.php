<?php
namespace Fontai\Bundle\TextBundle\Twig;

use App\Model\LanguageQuery;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;


class TextExtension extends AbstractExtension
{
  public function getFunctions()
  {
    return [
      new TwigFunction(
        'text_languages',
        [$this, 'getLanguages']
      )
    ];
  }

  public function getLanguages()
  {
    return LanguageQuery::create()
    ->orderByPriority('DESC')
    ->find();
  }

  public function getName()
  {
    return 'text';
  }
}
