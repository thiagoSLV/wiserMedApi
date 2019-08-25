<?php

namespace App\Presenters;

use App\Transformers\PacientTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class PacientPresenter.
 *
 * @package namespace App\Presenters;
 */
class PacientPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new PacientTransformer();
    }
}
