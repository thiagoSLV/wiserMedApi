<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Pacient;

/**
 * Class PacientTransformer.
 *
 * @package namespace App\Transformers;
 */
class PacientTransformer extends TransformerAbstract
{
    /**
     * Transform the Pacient entity.
     *
     * @param \App\Models\Pacient $model
     *
     * @return array
     */
    public function transform(Pacient $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
