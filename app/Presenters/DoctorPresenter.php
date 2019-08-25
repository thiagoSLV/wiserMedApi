<?php

namespace App\Presenters;

use App\Transformers\DoctorTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class DoctorPresenter.
 *
 * @package namespace App\Presenters;
 */
class DoctorPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new DoctorTransformer();
    }
}
