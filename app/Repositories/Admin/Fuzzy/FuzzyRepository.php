<?php

namespace App\Repositories\Admin\Fuzzy;

use App\Repositories\Admin\Core\Fuzzy\FuzzyRepositoryInterface;
use App\Models\Fuzzy;

class FuzzyRepository implements FuzzyRepositoryInterface
{ 

    protected $fuzzy;

    public function __contruct(
        fuzzy $fuzzy
    ) {
        $this->fuzzy = $fuzzy;
    }

    public function storeFuzzy($request)
    {
        Fuzzy::create([
            'name' => $request->name,
            'fuzzy_set' => $request->fuzzy_set,
            'type' => $request->type,
            'a' => $request->a,
            'b' => $request->b,
            'c' => $request->c,
            'd' => $request->d,
        ]);
    }

    public function updateFuzzy($request, $id)
    {
        $fuzzy = Fuzzy::find($id);
        $fuzzy->update([
            'name' => $request->name,
            'fuzzy_set' => $request->fuzzy_set,
            'type' => $request->type,
            'a' => $request->a,
            'b' => $request->b,
            'c' => $request->c,
            'd' => $request->d,
        ]);
    }
    public function destroyFuzzy($id)
    {
        try {
            $fuzzy = Fuzzy::find($id);
            $fuzzy->delete();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}