<?php

namespace Drupal\music_search\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a Music Search Form.
 */
class MusicSearchForm extends FormBase {

  /**
   * Messenger service.
   *
   * @var MessengerInterface
   */
  protected $messenger;

  /**
   * Constructs a MusicSearchForm object.
   *
   * @param MessengerInterface $messenger
   *   The messenger service.
   */
  public function __construct(MessengerInterface $messenger) {
    $this->messenger = $messenger;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): static {
    return new static(
      $container->get('messenger')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'music_search_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $form['search_type'] = [
      '#type' => 'radios',
      '#title' => $this->t('Search Type'),
      '#description' => $this->t('Choose the type to search for.'),
      '#options' => [
        'artist' => $this->t('Artist'),
        'song' => $this->t('Song'),
        'album' => $this->t('Album'),
      ],
      '#default_value' => 'artist',
      '#required' => TRUE,
    ];

    $form['search_term'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Search Term'),
      '#description' => $this->t('Enter the term to search for.'),
      '#required' => TRUE,
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Search'),
    ];

    $form['search_results'] = [
      '#markup' => '<div id="search-results">' . $this->t('Search results will appear here after you submit the form.') . '</div>',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $search_type = $form_state->getValue('search_type');
    $search_term = $form_state->getValue('search_term');

    // Add messages to verify form submission.
    $this->messenger->addMessage($this->t('Form submitted successfully!'));
    $this->messenger->addMessage($this->t('Search Type: @type', ['@type' => $search_type]));
    $this->messenger->addMessage($this->t('Search Term: @term', ['@term' => $search_term]));
  }
}

