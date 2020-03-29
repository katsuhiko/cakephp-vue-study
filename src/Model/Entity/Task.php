<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cas\Domain\Model\Task as TaskModel;
use Cas\Domain\Model\TaskId;

/**
 * Task Entity
 *
 * @property string $id
 * @property string $description
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class Task extends Entity
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
        'description' => true,
    ];

    /**
     * @return \Cas\Domain\Model\Task
     */
    public function toModel(): TaskModel
    {
        return new TaskModel(
            TaskId::of($this->id),
            $this->description,
        );
    }
}
