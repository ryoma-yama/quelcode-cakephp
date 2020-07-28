<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Bidinfo Entity
 *
 * @property int $id
 * @property int $biditem_id
 * @property int $user_id
 * @property int $price
 * @property \Cake\I18n\Time $created
 *
 * @property \App\Model\Entity\Biditem $biditem
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Bidmessage[] $bidmessages
 */
class Bidinfo extends Entity
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
        'biditem_id' => true,
        'user_id' => true,
        'price' => true,
        'created' => true,
        'modified' => true,
        'receiver_name' => true,
        'receiver_address' => true,
        'receiver_phone_number' => true,
        'is_shipped' => true,
        'is_received' => true,
        'biditem' => true,
        'user' => true,
        'bidmessages' => true,
    ];
}
