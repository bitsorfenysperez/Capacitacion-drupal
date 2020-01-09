<?php
/**
* @file
* Contiene \Drupal\bits_pages\Controller\BitsPagesController. */
namespace Drupal\bits_pages\Controller;
use Drupal\Core\Controller\ControllerBase;

use Drupal\Core\Url;
use Drupal\Core\Link;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\user\UserInterface;

use Drupal\Core\Datetime\DateFormatterInterface;

/**
* Controlador para devolver el contenido de las páginas definidas */
class BitsPagesController extends ControllerBase {

    protected $currentUser;
    protected $dateFormatter;

//Servicio current_user
    public function __construct(AccountInterface $current_user, DateFormatterInterface $date_formatter) {
        $this->currentUser = $current_user;
        $this->dateFormatter = $date_formatter;
    }

    public static function create(ContainerInterface $container){
        return new static(
            $container->get('current_user'),
            $container->get('date.formatter')
        );
    }

	public function simple() 
	{ 
		return array(
		'#markup' => '<p>' . $this->t('Página con mensaje simple') . '</p>',
		); 
	}

    public function calculator($num1, $num2) {

         //Comprobar que los valores sean numericos 
         if (!is_numeric($num1) || !is_numeric($num2)){
            throw new BadRequestHttpException(t('No hay argumentos numéricos especificados.'));
        }

        $list[] = $this->t("Esta página contiene una calculadora");

        //Los resultados se mostrarán en formato lista HTML (ul).
        //Cada elemento de la lista se añade a un array
        $list[] = $this->t("@num1 + @num2 = @sum",
                        array('@num1' => $num1,
                        '@num2' => $num2,
                        '@sum' => $num1 + $num2));
        $list[] = $this->t("@num1 - @num2 = @diferencia",
                        array('@num1' => $num1,
                        '@num2' => $num2,
                        '@diferencia' => $num1 - $num2));
        $list[] = $this->t("@num1 * @num2 = @producto",
                        array('@num1' => $num1,
                        '@num2' => $num2,
                        '@producto' => $num1 * $num2));

        //Evitar error de división por cero
        if ($num2 != 0)
        $list[] = $this->t("@num1 / @num2 = @division", 
                        array('@num1' => $num1, 
                        '@num2' =>$num2,
                        '@division' => $num1 / $num2));

        else
        $list[] = $this->t("@num1 / @num2 = undefined (division por cero)", 
                        array('@num1' => $num1, '@num2' =>$num2));

        //Servicio current_user
        if($this->currentUser->hasPermission('administer nodes'))
        $list[] = $this->t("Este texto adicional solo se muestra si el usuario actual puede administrar nodos");
        
       
        //Se trasnforma el array $list en una lista HTML (ul)
        $output['bits_pages_calculator'] = array(
            '#theme' => 'item_list',
            '#items' => $list,
            '#title' => $this->t('Operaciones:'),
        );

        //Devuelve el array renderizable con la salida.
        return $output;
        
    
    }

    public function links(){
        //link de Administración de bloques
        $url1 = Url::fromRoute('block.admin_display');
        $link1 = Link::fromTextAndUrl(t('Ir a la página de administración de bloques'), $url1);

        $list[] = $link1;

        //link de Administración de contenidos
        $url2 = Url::fromRoute('system.admin_content');
        $link2 = Link::fromTextAndUrl(t('Ir a la página Administración de contenidos'), $url2);

        $list[] = $link2;

         //link de Administración de usuarios
         $url3 = Url::fromRoute('entity.user.collection');
         $link3 = Link::fromTextAndUrl(t('Ir a la página Administración de usuarios'), $url3);
 
         $list[] = $link3;

        //Enlace a la portada del sitio 
        $url2 = Url::fromRoute('<front>');
        $link2 = Link::fromTextAndUrl(t('Ir a la portada del sitio'), $url2);

        $list[] = $link2;

        //Enlace al nodo con id 1
        $url3 = Url::fromRoute('entity.node.canonical', ['node' => 1]);
        $link3 = Link::fromTextAndUrl(t('ir al nodo con id 1'), $url3);
        $list[] = $link3;

        //Enlace a la edición del nodo con id 1
        $url4 = Url::fromRoute('entity.node.edit_form', ['node' => 1]);
        $link4 = Link::fromTextAndUrl(t('Ir a la edición del nodo con id 1'), $url4);
        $list[] = $link4;

        //Ir a https://www.google.com en una pestaña nueva 
        $url5 = Url::fromUri('https://www.google.com');
        $link_options = array(
            'attributes' => array(
                'class' => array(
                    'external-link',
                    'list'
                ),
                'target' => '_blank',
                'title' => 'Ir a www.google.com',
            ),
        );
        $url5->setOptions($link_options);
        $link5 = Link::fromTextAndUrl(t('Ir a www.google.com'), $url5);
        $list[] = $link5;
        
        //Servicio date.formatter
        $list[] = $this->dateFormatter->format(time(), "custom", 'Y:m:d');

        $output['bits_pages_links'] = array(
            '#theme' => 'item_list',
            '#items' => $list,
            '#title' => $this->t('Links'),
        );
    
        return $output;

    }



}

