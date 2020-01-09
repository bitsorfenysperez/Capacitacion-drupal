<?php
/**
* @file
* Contains \Drupal\raining_drupal_8\Controller\TrainingDrupal8Controller. */
namespace Drupal\training_drupal_8\Controller; 
use Drupal\Core\Controller\ControllerBase;
/**
* Controlador para devolver el contenido de las páginas definidas */
class TrainingDrupal8Controller extends ControllerBase {
	public function hello() 
	{ 
		return array(
		'#markup' => '<p>' . $this->t('Hola, Training! Este es mi primer módulo en Drupal 8!') . '</p>',
		); 
	}
}