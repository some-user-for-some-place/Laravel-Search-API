<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Homes;
use App\Http\Resources\V1\HomesResource;
use App\Http\Resources\V1\HomesCollection;
use Illuminate\Http\Request;
use App\Services\V1\HomesQuery;

class HomesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new HomesQuery();
        $queryItems = $filter->transform($request);

        $homes = Homes::query();

        foreach($queryItems as $item) {
            $homes->where(...$item);
        }

        $homes = $homes->paginate($request->input('per_page', 15));

        return new HomesCollection(HomesResource::collection($homes));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Homes $custom)
    {
        return new HomesResource($custom);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Homes $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Homes $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Homes $customer)
    {
        //
    }
}
?>
