<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CopyTasks Model
 *
 * @method \App\Model\Entity\CopyTask newEmptyEntity()
 * @method \App\Model\Entity\CopyTask newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\CopyTask[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CopyTask get($primaryKey, $options = [])
 * @method \App\Model\Entity\CopyTask findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\CopyTask patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CopyTask[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CopyTask|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CopyTask saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CopyTask[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CopyTask[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\CopyTask[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CopyTask[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CopyTasksTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('copy_tasks');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->uuid('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('description')
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->boolean('copied')
            ->requirePresence('copied', 'create')
            ->notEmptyString('copied');

        return $validator;
    }
}
