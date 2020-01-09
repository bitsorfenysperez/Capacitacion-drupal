<?php

namespace Drupal\bits_users\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\block\BlockInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Database\Connection;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Access\AccessResult;

/**
* Provides a Simple example block.
*
* @Block(
* id = "bits_users_simple_block",
* admin_label = @Translation("Bits Simple Block")
* )
*/

class UserBlock extends BlockBase implements ContainerFactoryPluginInterface{

    protected $database;
    protected $currentUser;
  
    public function __construct(array $configuration, $plugin_id,
    $plugin_definition, AccountInterface $current_user, Connection $database) {
      parent::__construct($configuration, $plugin_id, $plugin_definition);
      $this->currentUser = $current_user;
      $this->database = $database;
    }
  
    public static function create(ContainerInterface $container,
    array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_user'),
      $container->get('database'
      )
    );
    }

    protected function blockAccess(AccountInterface $account) {
        return AccessResult::allowedIfHasPermission($account, 'access user block');
        }

    public function build(){
       // return[  '#markup' => '<span>' . $this->t('Block Simple') . '</span>' ];
       
    $list[] = $this->t("Id: @id",
                    array('@id' => $this->currentUser->id()));
    $list[] = $this->t("Username: @username",
                    array('@username' => $this->currentUser->getAccountName()));
    $list[] = $this->t("Email: @email",
                    array('@email' => $this->currentUser->getEmail()));
    $list[] = $this->t("Roles: @roles",
                    array('@roles' => implode(' , ',$this->currentUser->getRoles())));
    $list[] = $this->t("Last accessed time: @lastaccess",
                    array('@lastaccess'=> \Drupal::service('date.formatter')->format($this->currentUser->getLastAccessedTime(),'short')));
    $output['bits_pages_user'] = array(
      '#theme'=>'item_list',
      '#items'=>$list,
    );
    return $output;
    }
    
}
