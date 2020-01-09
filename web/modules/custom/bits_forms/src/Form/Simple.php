<?php

namespace Drupal\bits_forms\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Session\AccountInterface;
use Egulias\EmailValidator\EmailValidator;
use Drupal\Core\Database\Connection;

//Implementa el controlador de formulario simple
class Simple extends FormBase {

    protected $currentUser;
    protected $emailValidator;
    protected $database;

    public function __construct(AccountInterface $current_user, EmailValidator $email_validator, Connection $database) {
        $this->currentUser = $current_user;
        $this->emailValidator = $email_validator;
        $this->database = $database;
    }

    public static function create(ContainerInterface $container){
        return new static(
            $container->get('current_user'),
            $container->get('email.validator'),
            $container->get('database')
        );
    }
//Construye un array renderizable con la estructura y elementos del formulario 
    public function buildForm(array $form, FormStateInterface $form_state) {

        //Campo de entrada de texto 
        $form['title'] = [
            '#type' => 'textfield',
            '#title' => $this->t('title'),
            '#description' => $this->t('El título debe tener al menos 5 caracteres de largo.'),
            '#required' => TRUE,
        ];

        $form['username'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Username'),
            '#description' => $this->t('Su nombre de usuario.'),
            '#default_value' => $this->currentUser->getAccountName(),
            '#required' => TRUE,
        ];

        $form['user_email'] = [
            '#type' => 'email',
            '#title' => $this->t('Email'),
            '#description' => $this->t('Su correo electrónico.'),
            '#default_value' => $this->currentUser->getEmail(),
            '#required' => TRUE,
        ];

        $form['actions'] = [
            '#type' => 'actions',
        ];
        //Botón de envío  
        $form['actions']['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Submit'),
        ];

        return $form;
    }
//Devuelve el ID único del formulario 
    public function getFormId(){
        return 'bits_forms_simple';
    }
// permite añadir validación adicional a los campos del formulario
    public function validateForm(array &$form, FormStateInterface $form_state) {

        $title = $form_state->getValue('title');
        if (strlen($title) < 5 OR strlen($title) > 30){
            $form_state->setErrorByName('title', $this->t('El título debe tener al menos 5 caracteres de largo.'));
        }
       
        if(ctype_upper(substr($title,0,1)) != 1){
            $form_state->setErrorByName('title', $this->t('El titulo debe iniciar con mayuscula.'));
          }
        
          $email = $form_state->getValue('user_email');

          if(!$this->emailValidator->isValid($email)) {
              $form_state->setErrorByName('user_email', 
              $this->t('%email la dirección de correo electrónico no es valida.', ['%email' => $email]));
          }
    }
//es llamado una vez se envía el formulario y éste pasa la validación de todos sus elementos
    public function submitForm(array &$form, FormStateInterface $form_state) {

        $this->database->insert('bits_forms_simple') ->fields([
            'title' => $form_state->getValue('title'),
            'username' => $form_state->getValue('username'),
            'email' => $form_state->getValue('user_email'),
            'uid' => $this->currentUser->id(),
            'ip' => \Drupal::request()->getClientIP(),
            'timestamp' => REQUEST_TIME, ])->execute();

            drupal_set_message($this->t('Usuario %username ingresado con éxito',
            [
                '%username' => $form_state->getValue('username')
            ]));

            \Drupal::logger('bits_forms')->notice('Nueva entrada de formulario simple con uid %uid del usuario %username insertado: %title.',
                [
                    '%uid' => $this->currentUser->id(),
                    '%username' => $form_state->getValue('username'),
                    '%title' => $form_state->getValue('title'),
                ]);
            
                $form_state->setRedirect('bits_pages.simple');
    }
}