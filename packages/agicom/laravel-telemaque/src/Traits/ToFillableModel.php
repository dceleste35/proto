<?php

namespace Agicom\Telemaque\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

trait ToFillableModel
{
    public function toFillableModel(string $model): Model
    {
        // get model fillable attributes
        $fillable = (new $model)->getFillable();

        // filter the dto to retreive only fillable attributes
        $data = Arr::only($this->toArray(), $fillable);

        // create the model with filtered array
        return $model::make($data);
    }
}
