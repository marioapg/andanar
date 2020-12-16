<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BudgetItem extends Model
{
    protected $fillable = [
    	'budget_id',
        'part',
        'material',
        'small',
        'medium',
        'big',
        'paint',
        'small_vds',
        'medium_vds',
        'big_vds',
        'paint_vds',
        'total_vds',
        'total_money',
    ];

    public function Budget()
    {
    	return $this->belongsTo('App\Budget');
    }

    public function pieceName($piece = '')
    {
        if ($piece == '') {
            return '';
        }
        switch ($piece) {
            case 'CAPOT':
                return 'CAPÓ';
                break;

            case 'TECHO':
                return 'TECHO';
                break;
            
            case 'MALETERO':
                return 'MALETERO';
                break;
            
            case 'ADI':
                return 'ALETA DELANTERA IZQUIERDA';
                break;
            
            case 'PDI':
                return 'PUERTA DELANTERA IZQUIERDA';
                break;
            
            case 'PTI':
                return 'PUERTA TRASERA IZQUIERDA';
                break;
            
            case 'MI':
                return 'MONTANTE IZQUIERDA';
                break;
            
            case 'ATI':
                return 'ALETA TRASERA IZQUIERDA';
                break;
            
            case 'ADD':
                return 'ALETA DELANTERA DERECHA';
                break;
            
            case 'PDD':
                return 'PUERTA DELANTERA DERECHA';
                break;
            
            case 'PTD':
                return 'PUERTA TRASERA DERECHA';
                break;
            
            case 'MD':
                return 'MONTANTE DERECHA';
                break;
            
            case 'ATD':
                return 'ALETA TRASERA DERECHA';
                break;
            
            default:
                # code...
                break;
        }
    }
}