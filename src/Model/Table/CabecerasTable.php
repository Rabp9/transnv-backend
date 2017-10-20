<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Cabeceras Model
 *
 * @method \App\Model\Entity\Cabecera get($primaryKey, $options = [])
 * @method \App\Model\Entity\Cabecera newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Cabecera[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Cabecera|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Cabecera patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Cabecera[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Cabecera findOrCreate($search, callable $callback = null, $options = [])
 */
class CabecerasTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->setTable('cabeceras');
        $this->setDisplayField('descripcion');
        $this->setPrimaryKey('id');
        $this->addBehavior('Burzum/Imagine.Imagine');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        return $validator;
    }
    
    public function afterSave($event, $entity, $options) {
        $imageOperationsLarge = [
            'thumbnail' => [
                'height' => 800,
                'width' => 800
            ],
        ];
        $imageOperationsSmall = [
            'thumbnail' => [
                'height' => 400,
                'width' => 400
            ],
        ];
        
        $path = WWW_ROOT . "img". DS . 'cabeceras' . DS;
        
        if ($entity->imagen) {
            $ext = pathinfo($entity->imagen, PATHINFO_EXTENSION);
            $filename_base = basename($entity->imagen, '.' . $ext);
            if (file_exists($path . $entity->imagen)) {
                $this->processImage($path . $entity->imagen,
                    $path . $filename_base . '_large.' . $ext,
                    [],
                    $imageOperationsLarge
                );
                $this->processImage($path . $entity->imagen,
                    $path . $filename_base . '_small.' . $ext,
                    [],
                    $imageOperationsSmall
                );
            }
        }
    }
}
