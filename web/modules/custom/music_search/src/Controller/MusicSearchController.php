<?php

namespace Drupal\music_search\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Form\FormBuilderInterface;

/**
 * Class MusicSearchController.
 */

class MusicSearchController extends ControllerBase {
    /**
     * @var FormBuilderInterface;
     */
    protected $formBuilder;

  /**
   * @param FormBuilderInterface $form_builder
   * the form builder service
   */

    public function __construct(FormBuilderInterface $form_builder) {
      $this->formBuilder = $form_builder;
  }


  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): self {
    return new static(
      $container->get('form_builder')
    );
  }

  /**
   * Returns the search page
   *
   * @return array
   */

  public function searchPage()
  {
    $form = $this->formBuilder->getForm('Drupal\music_search\Form\MusicSearchForm');
    return $form;

  }
}
