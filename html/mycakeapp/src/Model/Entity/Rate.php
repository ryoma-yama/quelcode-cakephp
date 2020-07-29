<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Rate Entity
 *
 * @property int $id
 * @property int $rater_id
 * @property int $ratee_id
 * @property int $bidinfo_id
 * @property int $rate_value
 * @property string $rate_comment
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Rater $rater
 * @property \App\Model\Entity\Ratee $ratee
 * @property \App\Model\Entity\Bidinfo $bidinfo
 */
class Rate extends Entity
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
        'rater_id' => true,
        'ratee_id' => true,
        'bidinfo_id' => true,
        'rate_value' => true,
        'rate_comment' => true,
        'created' => true,
        'modified' => true,
        'rater' => true,
        'ratee' => true,
        'bidinfo' => true,
    ];
}
