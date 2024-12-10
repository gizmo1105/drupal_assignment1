<?php

namespace Drupal\music_search\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class MusicSearchForm extends FormBase {
  public function getFormId(): string
  {
    return 'music_search_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state): array
  {
    $form['query'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Search Music'),
      '#required' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Search'),
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state): void
  {
    $query = $form_state->getValue('query');

  // Call the music search service.
    $musicSearchService = \Drupal::service('music_search.service');
    $results = $musicSearchService->search($query);

  // Store results for rendering.
    $form_state->set('results', $results);
    $form_state->setRebuild();
  }

  public function buildResults(array &$form, FormStateInterface $form_state): array
  {
    if ($results = $form_state->get('results')) {
    $form['results'] = [
      '#theme' => 'music_search_results',
      '#results' => $results,
    ];
  }
  return $form;
  }
}
