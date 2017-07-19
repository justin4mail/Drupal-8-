<?php
namespace Drupal\mydemomodule\Form\Multistep;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;


class PaymentForm extends MultistepFormBase {

  /**
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'payment_form';
  }

  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $previousStepData = array(
        'community' => $this->store->get('community'),
        'country'   => $this->store->get('country'),
        'attention_to' => $this->store->get('attention_to'),
        'company'      => $this->store->get('company'),
        'address'   => $this->store->get('address'),
        'city'  => $this->store->get('city'),
        'state' => $this->store->get('state'),
        'promocode' => $this->store->get('promocode'),
        'is_student' => $this->store->get('is_student'),
    );
    $form = parent::buildForm($form, $form_state);

    $form['payment_type'] = array(
      '#title'        => $this->t(''),
      '#type'         => 'radios',
      '#options'       => array(
          'credit' =>t('Credit Card'),
          'check' =>t('Check')
      ),
      '#default_value' => $this->store->get('payment_type') ? $this->store->get('payment_type') : 'credit',
      '#required'    => false,
    );

    $form['name_card'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Name on card'),
      '#attributes'  => ['size' => 25],
      '#default_value' => $this->store->get('name_card') ? $this->store->get('name_card') : '',
    );
      $form['card_number'] = array(
          '#type' => 'textfield',
          '#title' => $this->t('Card Number'),
          '#attributes'  => ['size' => 25],
          '#default_value' => $this->store->get('card_number') ? $this->store->get('card_number') : '',
      );

      $form['code'] = array(
          '#type' => 'number',
          '#title' => $this->t('Security Code'),
          '#default_value' => $this->store->get('code') ? $this->store->get('code') : '',
      );

      $month = array();
      $month['01'] = '01';
      $month['02'] = '02';
      $month['03'] = '03';
      $month['04'] = '04';
      $month['05'] = '05';
      $month['06'] = '06';
      $month['07'] = '07';
      $month['08'] = '08';
      $month['09'] = '09';
      $month['10'] = '10';
      $month['11'] = '11';
      $month['12'] = '12';


      $form['expirymonth'] = array(
          '#type' => 'select',
          '#title' => t(''),
          '#options' => $month,
          '#default_value' => date("m"),
      );

      for( $j = date('Y',time()); $j < date('Y',time())+10; ++$j ){
          $years[$j]=$j;
      }

      $form['expiryyear'] = array(
          '#type' => 'select',
          '#title' => t(''),
          '#options' => $years,
          '#default_value' => date("Y"),
      );




      $form['actions']['previous'] = array(
      '#type' => 'link',
      '#title' => $this->t('Previous'),
      '#attributes' => array(
        'class' => array('button'),
      ),
      '#weight' => 0,
      '#url' => Url::fromRoute('mydemomodule.community'),
    );
      $form['preview'] = array(
          '#markup' => $previousStepData,
      );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->store->set('payment_type', $form_state->getValue('payment_type'));
    $this->store->set('name_card', $form_state->getValue('name_card'));
    $this->store->set('card_number', $form_state->getValue('card_number'));

    // Save the data
    parent::saveData();
    drupal_set_message(t('Form Submitted.'));
  }
}