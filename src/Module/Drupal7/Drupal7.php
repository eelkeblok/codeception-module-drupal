<?php namespace Codeception\Module\Drupal7;

use Codeception\Exception\DrupalNotFoundException;
use Codeception\Module;
use Codeception\Module\Drupal7\Submodules\EntityTrait;
use Codeception\Module\Drupal7\Submodules\FieldTrait;
use Codeception\Module\Drupal7\Submodules\SystemTrait;
use Codeception\Module\DrupalBaseModule;
use Codeception\Module\DrupalModuleInterface;
use Codeception\Util\Shared\Asserts;

/**
 * Class Drupal
 * @package Codeception\Module
 */
class Drupal7 extends DrupalBaseModule implements DrupalModuleInterface
{

    use Asserts;
    use SystemTrait;
    use EntityTrait;
    use FieldTrait;

    /**
     * { @inheritdoc }
     */
    public function _initialize()
    {

        $this->bootstrapDrupal();

    }

    /**
     * { @inheritdoc }
     */
    public function bootstrapDrupal()
    {
        $this->config['root'] = $this->getDrupalRoot();
        $this->validateDrupalRoot($this->config['root']);

        // Do a Drush-style bootstrap.
        define('DRUPAL_ROOT', $this->config['root']);

        require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
        drupal_override_server_variables();

        // Bootstrap Drupal.
        drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
    }

    /**
     * { @inheritdoc }
     */
    public function validateDrupalRoot($root)
    {
        if (!file_exists($root . '/includes/bootstrap.inc')) {
            throw new DrupalNotFoundException('Drupal not found at ' . $root . '.');
        }

        return true;
    }
}
