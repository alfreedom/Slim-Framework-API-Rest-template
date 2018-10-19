<?php
namespace AppModel;

use Illuminate\Database\Eloquent\Model;


class ExampleModel extends Model
{
    protected $table = 'ejemplo';
    protected $fillable = ['nombre', 'edad', 'genero'];
    protected $guarded = ['id'];
    public $timestamps = false;

}