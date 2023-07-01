<?php

namespace App\Traits;

trait TriggersActivity
{

    protected static $baseModel = 'project';

    protected static function boot()
    {
        parent::boot();

        foreach(static::getModelEventsToRecord() as $event) {
            static::$event(function($model) use($event) {
                if(static::isBaseModel($model)) {
                    $model->recordActivity(
                        $model->formatActivityDescription($event, $model)
                    );
                } else {
                    $model->{static::$baseModel}->recordActivity(
                        $model->formatActivityDescription($event, $model)
                    );
                }

            });
        }
    }
    protected static function getModelEventsToRecord()
    {
        // if(isset(static::$modelEventsToRecord)) {
        //     return static::$modelEventsToRecord;
        // }

        return ['created', 'updated', 'deleted'];
    }

    protected static function formatActivityDescription($event, $model)
    {
        return $event .  (static::isBaseModel($model) ? '' : '_'. strtolower(class_basename($model)));
    }

    protected static function isBaseModel($model) {
        return strtolower(class_basename($model)) === static::$baseModel;
    }
}