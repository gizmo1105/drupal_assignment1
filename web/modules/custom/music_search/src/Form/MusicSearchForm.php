<?php

namespace Drupal\music_search\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class MusicSearchForm extends FormBase {

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
      '#description' => $this->t('Choose what you want to search for.'),
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
    // Retrieve form values
    $search_type = $form_state->getValue('search_type');
    $search_term = $form_state->getValue('search_term');

    // Display the search type and term
    drupal_set_message($this->t('You searched for a @type with the term: @term', [
      '@type' => $search_type,
      '@term' => $search_term,
    ]));

    // (Optional) Update the results section dynamically (useful in AJAX scenarios)
    $form['search_results']['#markup'] = $this->t('<p>Search Type: @type</p><p>Search Term: @term</p>', [
      '@type' => $search_type,
      '@term' => $search_term,
    ]);
  }
}
