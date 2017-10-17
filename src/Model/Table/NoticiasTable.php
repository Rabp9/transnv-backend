<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Noticias Model
 *
 * @method \App\Model\Entity\Noticia get($primaryKey, $options = [])
 * @method \App\Model\Entity\Noticia newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Noticia[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Noticia|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Noticia patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Noticia[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Noticia findOrCreate($search, callable $callback = null, $options = [])
 */
class NoticiasTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->setTable('noticias');
        $this->setDisplayField('titulo');
        $this->setPrimaryKey('id');
        $this->addBehavior('Burzum/Imagine.Imagine');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('titulo')
            ->requirePresence('titulo', 'create')
            ->notEmpty('titulo');

        $validator
            ->scalar('resumen')
            ->allowEmpty('resumen');

        $validator
            ->scalar('contenido')
            ->allowEmpty('contenido');

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
        
        $path = WWW_ROOT . "img". DS . 'noticias' . DS;
        
        if ($entity->portada) {
            $ext = pathinfo($entity->portada, PATHINFO_EXTENSION);
            $filename_base = basename($entity->portada, '.' . $ext);
            if (file_exists($path . $entity->portada)) {
                $this->processImage($path . $entity->portada,
                    $path . $filename_base . '_large.' . $ext,
                    [],
                    $imageOperationsLarge
                );
                $this->processImage($path . $entity->portada,
                    $path . $filename_base . '_small.' . $ext,
                    [],
                    $imageOperationsSmall
                );
            }
        }
    }
}
