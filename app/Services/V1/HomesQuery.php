<?php

namespace App\Services\V1;

use Illuminate\Http\Request;

class HomesQuery{
    protected $safeParms = [
        'name' => ['like'],
        'price' => ['range'],
        'bedrooms' => ['eq'],
        'bathrooms'=> ['eq'],
        'storeys'=> ['eq'],
        'garages'=> ['eq']
    ];

    protected $columnMap = [

    ];

    public function transform(Request $request)
    {
        $eloQuery = [];

        foreach ($this->safeParms as $parm => $operators) {
            $query = $request->query($parm);

            if (!isset($query)) {
                continue;
            }

            $column = $this->columnMap[$parm] ?? $parm;

            foreach ($operators as $operator) {
                if (isset($query[$operator])) {
                    $value = $query[$operator];

                    if ($operator === 'like') {
                        $value = "%$value%";
                        $eloQuery[] = [$column, 'like', $value];
                    } elseif ($operator === 'range') {
                        $range = explode(',', $value);
                        $min = $range[0] ?? '';
                        $max = $range[1] ?? '';
                        if ($min !== '') {
                            $eloQuery[] = [$column, '>=', $min];
                        }
                        if ($max !== '') {
                            $eloQuery[] = [$column, '<=', $max];
                        }
                    } elseif ($operator === 'eq') {
                        $eloQuery[] = [$column, '=', $value];
                    }
                }
            }
        }

        $price_min = $request->input('price_min');
        $price_max = $request->input('price_max');

        if ($price_min && $price_max) {
            $eloQuery[] = ['price', '>=', $price_min];
            $eloQuery[] = ['price', '<=', $price_max];
        }
        elseif ($price_min) {
            $eloQuery[] = ['price', '>=', $price_min];
        }
        elseif ($price_max) {
            $eloQuery[] = ['price', '<=', $price_max];
        }

        return $eloQuery;
    }
}

?>
