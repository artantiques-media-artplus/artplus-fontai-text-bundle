<?php
namespace Fontai\Bundle\TextBundle\EventSubscriber;

use App\Model;
use Fontai\Propel\Behavior\EventDispatcher\Event\PropelEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Filesystem\Filesystem;


class TranslationReloadSubscriber implements EventSubscriberInterface
{
  protected $filesystem;
  protected $cacheDir;
  protected $translationsDir;

  public function __construct(
    Filesystem $filesystem,
    string $cacheDir,
    string $translationsDir
  )
  {
    $this->filesystem = $filesystem;
    $this->cacheDir = $cacheDir;
    $this->translationsDir = $translationsDir;
  }

  public function onTextPostSave(PropelEvent $event)
  {
    $text = $event->getObject();
    
    if (
      $text->wasColumnModified(Model\Map\TextTableMap::COL_TID)
      || $text->getCurrentTranslation()->wasColumnModified(Model\Map\TextI18nTableMap::COL_VALUE)
    )
    {
      $this->filesystem->remove($this->cacheDir);
    }
  }

  public function onTextGroupPostInsert(PropelEvent $event)
  {
    foreach ($this->getLanguages() as $language)
    {
      $path = sprintf(
        '%s/%s.%s.pdo',
        $this->translationsDir,
        $event->getObject()->getDomain(),
        $language->getCode()
      );

      $this->filesystem->dumpFile($path, '');
    }
  }

  public function onTextGroupPostDelete(PropelEvent $event)
  {
    $domain = $event->getObject()->getDomain();

    $sameDomainCount = Model\TextGroupQuery::create()
    ->filterByDomain($domain)
    ->count();

    if ($sameDomainCount > 0)
    {
      return;
    }

    foreach ($this->getLanguages() as $language)
    {
      $path = sprintf(
        '%s/%s.%s.pdo',
        $this->translationsDir,
        $domain,
        $language->getCode()
      );

      $this->filesystem->remove($path);
    }
  }

  protected function getLanguages()
  {
    return Model\LanguageQuery::create()
    ->find();
  }

  public static function getSubscribedEvents()
  {
    return class_exists(Model\Text::class) && class_exists(Model\TextGroup::class)
    ? [
      Model\Text::EVENT_POST_SAVE => 'onTextPostSave',
      Model\TextGroup::EVENT_POST_INSERT => 'onTextGroupPostInsert',
      Model\TextGroup::EVENT_POST_DELETE => 'onTextGroupPostDelete'
    ]
    : [];
  }
}