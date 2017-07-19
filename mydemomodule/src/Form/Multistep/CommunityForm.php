<?php

namespace Drupal\mydemomodule\Form\Multistep;

use Drupal\Core\Form\FormStateInterface;

class CommunityForm extends MultistepFormBase {

  /**
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'community_form';
  }

  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form = parent::buildForm($form, $form_state);
    $countries = \Drupal::service('country_manager')->getList();
    $form['community'] = array(
      '#type' => 'select',
      '#title' => $this->t('Community name'),
      '#options' => array(
          'select' => 'Select your community',
          'USGBC Northern Callifornia' => 'USGBC Northern Callifornia',
          'USGBC Mississippi' => 'USGBC Mississippi'
      ),
      '#default_value' => $this->store->get('community') ? $this->store->get('community') : '1',
    );
    $form['country'] = array(
        '#type' => 'select',
        '#title' => $this->t('Country'),
        '#options' => $countries,
        '#default_value' => $this->store->get('country') ? $this->store->get('country') : 'US',
    );
    $form['attention_to'] = array(
      '#title'       => $this->t('Attention to (optional)'),
      '#placeholder' => $this->t('Attention to'),
      '#type'        => 'textfield',
      '#default_value' => $this->store->get('attention_to') ? $this->store->get('attention_to') : '',
      '#attributes'  => ['size' => 25],
      '#required'    => false,
      '#prefix'      => '<div class="form-group">',
      '#suffix'      => '</div>',
    );

    $form['company'] = array(
      '#title'       => $this->t('Company (optional)'),
      '#placeholder' => $this->t('Company'),
      '#type'        => 'textfield',
      '#default_value' => $this->store->get('company') ? $this->store->get('company') : '',
      '#attributes'  => ['size' => 25],
      '#required'    => false,
      '#prefix'      => '<div class="form-group">',
      '#suffix'      => '</div>',
    );

    $form['address'] = array(
      '#title'       => $this->t('Address'),
      '#placeholder' => $this->t('Address'),
      '#type'        => 'textfield',
      '#default_value' => $this->store->get('address') ? $this->store->get('address') : '',
      '#required'    => false,
      '#prefix'      => '<div class="form-group">',
      '#suffix'      => '</div>',
    );
    $form['city'] = array(
      '#title'       => $this->t('City'),
      '#placeholder' => $this->t('City'),
      '#type'        => 'textfield',
      '#default_value' => $this->store->get('city') ? $this->store->get('city') : '',
      '#required'    => false,
      '#prefix'      => '<div class="form-group">',
      '#suffix'      => '</div>',
      );
    $form['state'] = array(
      '#title'        => $this->t('State/Province'),
      '#placeholder'  => $this->t('State'),
      '#type'         => 'textfield',
      '#default_value' => $this->store->get('state') ? $this->store->get('state') : '',
      '#required'    => false,
      '#prefix'      => '<div class="form-group">',
      '#suffix'      => '</div>',
    );

    $form['promocode'] = array(
      '#title'        => $this->t('Code'),
      '#placeholder'  => $this->t('Code'),
      '#type'         => 'textfield',
      '#default_value' => $this->store->get('promocode') ? $this->store->get('promocode') : '',
      '#required'    => false,
      '#prefix'      => '<div class="form-group">',
      '#suffix'      => '</div>',
    );
    $form['is_student'] = array(
      '#title'        => $this->t(''),
      '#type'         => 'radios',
      '#options'       => array(
          'Yes' =>t('Yes'),
          'No' =>t('No')
      ),
      '#default_value' => $this->store->get('is_student') ? $this->store->get('is_student') : 'No',
      '#required'    => false,
    );



    $form['actions']['submit']['#value'] = $this->t('Continue');

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->store->set('community',$form_state->getValue('community'));
    $this->store->set('country', $form_state->getValue('country'));
    $this->store->set('attention_to', $form_state->getValue('attention_to'));
    $this->store->set('company', $form_state->getValue('company'));
    $this->store->set('address', $form_state->getValue('address'));
    $this->store->set('city', $form_state->getValue('city'));
    $this->store->set('state', $form_state->getValue('state'));
    $this->store->set('promocode', $form_state->getValue('promocode'));
    $this->store->set('is_student', $form_state->getValue('is_student'));
    $form_state->setRedirect('mydemomodule.payment');
  }

  public function validateForm(array &$form, FormStateInterface $form_state)
  {
      if (!$form_state->getValue('address') || empty($form_state->getValue('address'))) {
          $form_state->setErrorByName('address', $this->t('Address cannot be empty.'));
      }

      if (!$form_state->getValue('city') || empty($form_state->getValue('city'))) {
          $form_state->setErrorByName('city', $this->t('City cannot be empty.'));
      }

      if (!$form_state->getValue('state') || empty($form_state->getValue('state'))) {
          $form_state->setErrorByName('state', $this->t('State cannot be empty.'));
      }
  }
}