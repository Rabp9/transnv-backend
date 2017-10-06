<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ControllerRoles Model
 *
 * @property \App\Model\Table\ControllersTable|\Cake\ORM\Association\BelongsTo $Controllers
 * @property \App\Model\Table\RolesTable|\Cake\ORM\Association\BelongsTo $Roles
 *
 * @method \App\Model\Entity\ControllerRole get($primaryKey, $options = [])
 * @method \App\Model\Entity\ControllerRole newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ControllerRole[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ControllerRole|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ControllerRole patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ControllerRole[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ControllerRole findOrCreate($search, callable $callback = null, $options = [])
 */
class ControllerRolesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('controller_roles');
        $this->setDisplayField('id');
        $this->setPrimaryKey(['id', 'controller_id', 'rol_id']);

        $this->belongsTo('Controllers', [
            'foreignKey' => 'controller_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Roles', [
            'foreignKey' => 'rol_id',
            'joinType' => 'INNER'
        ]);
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
            ->boolean('permiso')
            ->allowEmpty('permiso');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['controller_id'], 'Controllers'));
        $rules->add($rules->existsIn(['rol_id'], 'Roles'));

        return $rules;
    }
}
