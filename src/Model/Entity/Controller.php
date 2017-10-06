<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Controller Entity
 *
 * @property int $id
 * @property string $descripcion
 * @property string $controller_name
 *
 * @property \App\Model\Entity\ControllerRole[] $controller_roles
 */
class Controller extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'descripcion' => true,
        'controller_name' => true,
        'controller_roles' => true
    ];
}
