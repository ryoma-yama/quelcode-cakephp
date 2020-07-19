<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Biditem Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property bool $finished
 * @property \Cake\I18n\Time $endtime
 * @property \Cake\I18n\Time $created
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Bidinfo[] $bidinfo
 * @property \App\Model\Entity\Bidrequest[] $bidrequests
 */
class Biditem extends Entity
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
        'user_id' => true,
        'name' => true,
        'finished' => true,
        'endtime' => true,
        'created' => true,
        'user' => true,
        'bidinfo' => true,
        'bidrequests' => true,
        'description' => true,
        'img_path' => true,
    ];
}
