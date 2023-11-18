<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $guarded = [
        'tmp_name','error'
    ];
    
    public function binario()
    {
	if($_FILES['pic']['tmp_name'] != '')
	{
	    $local = $_FILES['pic']['tmp_name'];
	    $tamanho = $_FILES['pic']['size'];

	    $fp = fopen($local, 'rb');
	    $conteudo = fread($fp, $tamanho);
            fclose($fp);
	    
	    return $conteudo;
	}
        
        return '';
    }
}
